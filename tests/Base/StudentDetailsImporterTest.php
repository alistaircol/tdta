<?php declare(strict_types=1);

namespace Base;

use PHPUnit\Framework\TestCase;
use StudentDetails\Student;
use StudentDetails\StudentDetailsImporter;

class StudentDetailsImporterTest extends TestCase
{
    /**
     * @var StudentDetailsImporter
     */
    private $studentDetailsImporter;

    protected function setUp(): void
    {
        parent::setUp();
        $this->studentDetailsImporter = new StudentDetailsImporter();
    }

    public function testRecordCount(): void
    {
        $this->studentDetailsImporter->getData();

        $this->assertCount(6, $this->studentDetailsImporter->getStudentList());
    }

    public function testHeadersCount(): void
    {
        $this->studentDetailsImporter->getData();

        $this->assertCount(6, $this->studentDetailsImporter->getHeaders());
    }

    public function testStudentAge(): void
    {
        $this->studentDetailsImporter->getData();

        $this->assertEquals(17, $this->studentDetailsImporter->getStudentList()[0]->getAge());
    }

    public function testAvgScoreSum(): void
    {
        $this->studentDetailsImporter->getData();

        $sum = 0;
        foreach ($this->studentDetailsImporter->getStudentList() as $student) {
            $sum += $student->getAverageScore();
        }

        $this->assertEquals(498.3, $sum);
    }

    public function testSuperStudent(): void
    {
        $this->studentDetailsImporter->getData();
        $superStudent = $this->studentDetailsImporter->getSuperStudent();

        $this->assertInstanceOf(Student::class, $superStudent);
        $this->assertEquals('yohan doe', $superStudent->getName());
    }

    public function testAttendance(): void
    {
        $this->studentDetailsImporter->getData();
        $this->studentDetailsImporter->getAttendance();

        $this->assertEquals(13, $this->studentDetailsImporter->getStudentList()[0]->getAttendance());
    }
}
