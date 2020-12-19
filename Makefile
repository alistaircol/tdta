.PHONY: help

# https://gist.github.com/rsperl/d2dfe88a520968fbc1f49db0a29345b9
# define standard colors
BLACK        := $(shell tput -Txterm setaf 0)
RED          := $(shell tput -Txterm setaf 1)
GREEN        := $(shell tput -Txterm setaf 2)
YELLOW       := $(shell tput -Txterm setaf 3)
LIGHTPURPLE  := $(shell tput -Txterm setaf 4)
PURPLE       := $(shell tput -Txterm setaf 5)
BLUE         := $(shell tput -Txterm setaf 6)
WHITE        := $(shell tput -Txterm setaf 7)
RESET        := $(shell tput -Txterm sgr0)

help:
	@echo -e 'This is a PHP 7.4 application. If you have it (and ${WHITE}composer${RESET}) installed locally, then simply run:'
	@echo -e '${GREEN}composer install${RESET}'
	@echo -e '${GREEN}composer test${RESET}'
	@echo -e ''
	@echo -e 'This Makefile has some options to run the application in ${WHITE}docker${RESET} if you do not have 7.4 locally.'
	@echo -e 'The ${WHITE}docker${RESET} image is ${LIGHTPURPLE}webdevops/php-dev:7.4${RESET}'
	@echo -e ''
	@echo -e 'Usage: make [${BLUE}subcommand${RESET}]'
	@echo -e 'subcommands:'
	@echo -e '  ${GREEN}ci${RESET}   Mounts current ${WHITE}pwd${RESET} and run ${WHITE}composer install${RESET} in a ${WHITE}docker${RESET} image'
	@echo -e '  ${GREEN}test${RESET} Mounts current ${WHITE}pwd${RESET} and run ${WHITE}composer test${RESET} in a ${WHITE}docker${RESET} image'
	@echo -e '  ${GREEN}dev${RESET}  Mounts current ${WHITE}pwd${RESET} and run ${WHITE}composer test${RESET} (with xDebug 3 enabled) in a ${WHITE}docker${RESET} image'

ephemeral_docker_args = --rm \
	--tty \
	--interactive \
	--user=$$(id -u)

docker_php = docker run \
	${ephemeral_docker_args} \
	--volume="$$(pwd):/src" \
	--workdir=/src \
	--env COMPOSER_VERSION=1 \
	webdevops/php-dev:7.4

# optional qa tools
# not used for this small test but I would use this
docker_qa = docker run \
	${ephemeral_docker_args} \
	--volume="$$(pwd):/project" \
	--workdir /project \
	jakzal/phpqa:php7.4

ci:
	@${docker_php} composer install

test:
	@${docker_php} composer test

# some duplication here sadly
# using phpunit directly to add extra options/args to it such as filter, and testdox, coverage reports
# make dev args=--filter=testSuperStudent
dev:
	docker run \
		${ephemeral_docker_args} \
		--volume="$$(pwd):/src" \
		--workdir=/src \
		--env COMPOSER_VERSION=1 \
		--env PHP_DEBUGGER="xdebug" \
		--env XDEBUG_MODE="develop,debug" \
		--env XDEBUG_CLIENT_HOST="192.168.1.6" \
		--env XDEBUG_CLIENT_PORT="9003" \
		--env XDEBUG_IDE_KEY="phpstorm" \
		--env XDEBUG_SESSION="phpstorm" \
		--env XDEBUG_START_WITH_REQUEST="yes" \
		webdevops/php-dev:7.4 \
		./vendor/bin/phpunit \
		$(args)

colors: ## debugging show all the colors
	@echo "${BLACK}BLACK${RESET}"
	@echo "${RED}RED${RESET}"
	@echo "${GREEN}GREEN${RESET}"
	@echo "${YELLOW}YELLOW${RESET}"
	@echo "${LIGHTPURPLE}LIGHTPURPLE${RESET}"
	@echo "${PURPLE}PURPLE${RESET}"
	@echo "${BLUE}BLUE${RESET}"
	@echo "${WHITE}WHITE${RESET}"
