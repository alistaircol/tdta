<?php declare(strict_types=1);

namespace StudentDetails;

class Student
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var int
     */
    private $id;

    /**
     * @var int
     */
    private $age;

    /**
     * @var string[]
     */
    private $subjects;

    /**
     * @var string
     */
    private $grade;

    /**
     * @var float
     */
    private $averageScore;

    /**
     * @var int
     */
    private $attendance;

    /**
     * @param string   $name
     * @param int      $id
     * @param int      $age
     * @param string[] $subjects
     * @param string   $grade
     * @param float    $averageScore
     * @param int      $attendance
     */
    public function __construct(
        string $name,
        int $id,
        int $age,
        array $subjects,
        string $grade,
        float $averageScore,
        int $attendance = 0
    ) {
        $this->name = $name;
        $this->id = $id;
        $this->age = $age;
        $this->subjects = $subjects;
        $this->grade = $grade;
        $this->averageScore = $averageScore;
        $this->attendance = $attendance;
    }

    /**
     * @return float
     */
    public function calculateScore(): float
    {
        $points = $this->averageScore;
        if (in_array('maths', $this->subjects, true) && in_array('computer science', $this->subjects, true)) {
            $points += 10;
        }
        if (stripos($this->name, 'y') === 0) {
            $points += 15;
        }
        if ($this->id % 2 === 0) {
            $points += 20;
        }
        if ($this->grade) {
            $points += 25;
        }

        return $points;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return int
     */
    public function getAge(): int
    {
        return $this->age;
    }

    /**
     * @return string[]
     */
    public function getSubjects(): array
    {
        return $this->subjects;
    }

    /**
     * @return string
     */
    public function getGrade(): string
    {
        return $this->grade;
    }

    /**
     * @return float
     */
    public function getAverageScore(): float
    {
        return $this->averageScore;
    }

    /**
     * @return int
     */
    public function getAttendance(): int
    {
        return $this->attendance;
    }

    /**
     * @param int $attendance
     */
    public function setAttendance(int $attendance): void
    {
        $this->attendance = $attendance;
    }
}
