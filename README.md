# Student Details Application

This task evaluates the candidate's skills in `PHP7`.

## Introduction

The idea of this project is to keep students’ details in a file and fetch them from the file when necessary. 

## Problem Statement

1. Please do *NOT* modify any tests unless specifically told to do so.
2. Make tests pass by implementing missing features in the production code. The application is dependency-free.

### Task 1

Implement the `getData()` method in the `StudentDetailsImporter` class. It should read student records from a given CSV file. Map the records to the `Student` class and add them to the `StudentDetailsImporter->studentList`. The first row contains the headers, which means that you need to assign them to `StudentDetailsImporter->headers` variable. Please note that the order of the students on the list should be the same as in the CSV file.

### Task 2

Implement the `getSuperStudent()` method in the `StudentDetailsImporter` class. It should return the *super student*, i.e., the student who has the highest `average_score`. When looking for such students, the average score is modified according to the following rules:

 * add _5_ points, if the student is studying `computer science`,
 * add _10_ points, if the student is studying `maths`,
 * add _15_ points, if the student’s name starts with `y` (case-sensitive),
 * add _20_ points, if the student’s `id` can be divided by two,
 * add _25_ points, if the student has an `A+` grade.

### Task 3

Implement the `getAttendance()` method in the `StudentDetailsImporter` class. It should read data from a CSV file, specified by the `attendance_file_name` argument, and use it to calculate the attendance for every student.

The input CSV file has two columns:

 * student ID,
 * information indicating if the student attended a class:
    * `Y` means that the student attended a class, so you should increase the `Student->attendance` attribute.
    * `N` means that the student did not attend a class, so the `Student->attendance` attribute stays the same.

---

## Running the Application

Run locally, or `make` commands described below. 

```text
This is a PHP 7.4 application. If you have it (and composer) installed locally, then simply run:
composer install
composer test

This Makefile has some options to run the application in docker if you do not have 7.4 locally.
The docker image is webdevops/php-dev:7.4

Usage: make [subcommand]
subcommands:
  ci   Mounts current pwd and run composer install in a docker image
  test Mounts current pwd and run composer test in a docker image
  dev  Mounts current pwd and run composer test (with xDebug 3 enabled) in a docker image
```
