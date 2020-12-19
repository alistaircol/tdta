<?php declare(strict_types=1);

namespace StudentDetails;

class StudentDetailsImporter
{
    /**
     * @var string[]
     */
    private array $headers = [];

    /**
     * @var Student[]
     */
    private array $studentList = [];

    /**
     * @param string[] $row
     *
     * @return string[]
     */
    private static function cleanInput(array $row): array
    {
        /**
         * Clean and sanitize the input so that it does not contain leading and trailing spaces
         */
        return array_map('trim', $row);
    }

    /**
     * @param string[] $row
     *
     * @return Student
     */
    private static function mapCsvToClass(array $row): Student
    {
        /**
         * Convert the input row into a Student class
         */
        $subjects = self::cleanInput(
            explode(
                ',',
                strtolower($row['subjects'])
            )
        );

        return new Student(
            $row['name'],
            (int) $row['id'],
            (int) $row['age'],
            $subjects,
            $row['grade'],
            (float) $row['average_score']
        );
    }

    /**
     * @param string $fileName
     *
     * @return Student[]
     */
    public function getData(string $fileName = __DIR__ . '/data/student_details.csv'): array
    {
        /**
         * Fetch the data from the given csv file and construct the list of Student objects
         * set here $this->headers (first row)
         * set here $this->student_list consider using clean_input and map_csv_to_class
         */

        $rows = $this->getCsv($fileName);

        // Take first row and clean input - these will be the headers
        $this->headers = self::cleanInput($rows->current());

        // Move Generator ahead
        $rows->next();

        while ($rows->valid()) {
            // Set row to keys are $this->header's and clean the values
            // makes constructing student parameters more sane
            $row = self::cleanInput(
                array_combine(
                    $this->getHeaders(),
                    $rows->current()
                )
            );

            $student = self::mapCsvToClass($row);
            $this->studentList[] = $student;

            $rows->next();
        }

        return $this->studentList;
    }

    /**
     * @return Student|null
     */
    public function getSuperStudent(): ?Student
    {
        /**
         * Get super student
         */
        $superStudents = new \SplPriorityQueue();

        foreach ($this->studentList as $student) {
            $weight = $student->calculateScore();
            $superStudents->insert($student, $weight);
        }

        return $superStudents->top() ?? null;
    }

    /**
     * @param string $fileName
     */
    public function getAttendance(string $fileName = __DIR__ . '/data/attendance.csv'): void
    {
        /**
         * Fetch data from given csv file and update students attendance
         */
        $studentsAttendances = $this->getEmptyStudentsAttendancesMatrix();

        $rows = $this->getCsv($fileName);

        // build studentId -> attendances matrix
        foreach ($rows as $row) {
            $studentId = $row[0];
            $attendance = $row[1];

            if (!array_key_exists($studentId, $studentsAttendances)
                || stripos($attendance, 'y') !== 0
            ) {
                // unrecognised student id, or no attendance - nothing to do
                continue;
            }

            $studentsAttendances[$studentId]++;
        }

        // update students attendances
        foreach ($studentsAttendances as $studentId => $attendance) {
            $student = $this->getStudent($studentId);

            if ($student === null) {
                continue;
            }

            $student->setAttendance($attendance);
        }
    }

    /**
     * Return a matrix of studentIds with attendance set to 0.
     *
     * @return array
     */
    private function getEmptyStudentsAttendancesMatrix(): array
    {
        $studentIds = array_map(
            function ($student) {
                return $student->getId();
            },
            $this->getStudentList()
        );

        return array_fill_keys($studentIds, 0);
    }

    /**
     * @param int $studentId
     * @return Student|null
     */
    private function getStudent(int $studentId): ?Student
    {
        foreach ($this->getStudentList() as $student) {
            if ($student->getId() === $studentId) {
                return $student;
            }
        }

        return null;
    }

    /**
     * @return string[]
     */
    public function getHeaders(): array
    {
        return $this->headers;
    }

    /**
     * @return Student[]
     */
    public function getStudentList(): array
    {
        return $this->studentList;
    }

    /**
     * @param string $fileName
     *
     * @return \Generator
     */
    private function getCsv(string $fileName): ?\Generator
    {
        $handle = fopen($fileName, 'rb');
        while (!feof($handle)) {
            $data = fgetcsv($handle);
            if ($data) {
                yield $data;
            }
        }
        fclose($handle);
    }
}
