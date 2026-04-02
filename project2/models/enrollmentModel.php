<?php
class Enrollment {
    private $id;
    private $student_id;
    private $section_id;
    private $grade;

    public function __construct($id, $student_id, $section_id, $grade) {
        $this->id = $id;
        $this->student_id = $student_id;
        $this->section_id = $section_id;
        $this->grade = $grade;
    }

    public function getId() {
        return $this->id;

    }

    public function getStudentId() {
        return $this->student_id;
    }

    public function getSectionId() {
        return $this->section_id;
    }

    public function getGrade() {
        return $this->grade;
    }

    public static function listEnrollments() {
        global $database;
        $query = 'SELECT * FROM enrollment';
        $statement = $database->prepare($query);
        $statement->execute();
        $records = $statement->fetchAll();
        $statement->closeCursor();

        $enrollments = [];
        foreach ($records as $record) {
            $enrollments[] = new Enrollment(
                $record['id'],
                $record['student_id'],
                $record['section_id'],
                $record['grade']
            );
        }
        return $enrollments;
    }

    public static function getEnrollmentById($id) {
        global $database;
        $query = 'SELECT * FROM enrollment WHERE id = :id';
        $statement = $database->prepare($query);
        $statement->bindValue(':id', $id, PDO::PARAM_INT);
        $statement->execute();
        $record = $statement->fetch();
        $statement->closeCursor();

        if ($record) {
            return new Enrollment(
                $record['id'],
                $record['student_id'],
                $record['section_id'],
                $record['grade']
            );
        }
        return null;
    }

    public static function saveEnrollment($id, $student_id, $section_id, $grade) {
        global $database;

        if ($id) {
            $query = 'UPDATE enrollment SET student_id = :student_id, section_id = :section_id, grade = :grade WHERE id = :id';
            $statement = $database->prepare($query);
            $statement->bindValue(':id', $id, PDO::PARAM_INT);
        }
        else {
            $query = 'INSERT INTO enrollment (student_id, section_id, grade) VALUES (:student_id, :section_id, :grade)';
            $statement = $database->prepare($query);
        }

        $statement->bindValue(':student_id', $student_id, PDO::PARAM_INT);
        $statement->bindValue(':section_id', $section_id, PDO::PARAM_INT);
        $statement->bindValue(':grade', $grade, PDO::PARAM_STR);
        $statement->execute();
        $statement->closeCursor();
    }

    public static function deleteEnrollment($id) {
        global $database;
        $query = 'DELETE FROM enrollment WHERE id = :id';
        $statement = $database->prepare($query);
        $statement->bindValue(':id', $id, PDO::PARAM_INT);
        $statement->execute();
        $statement->closeCursor();
    }
}