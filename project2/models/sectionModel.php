<?php
class Section {
    private $id, $course_code, $faculty_id, $semester;

    public function __construct($id, $course_code, $faculty_id, $semester) {
        $this->id = $id;
        $this->course_code = $course_code;
        $this->faculty_id = $faculty_id;
        $this->semester = $semester;
    }

    public function getId() {
        return $this->id;
    }

    public function getCourseCode() {
        return $this->course_code;
    }

    public function getFacultyId() {
        return $this->faculty_id;
    }

    public function getSemester() {
        return $this->semester;
    }

    public static function listSections() {
        global $database;

        $statement = $database->prepare("SELECT * FROM section WHERE 1 = :one");
        $statement->bindValue(':one', 1, PDO::PARAM_INT);

        $statement->execute();
        $records = $statement->fetchAll(PDO::FETCH_ASSOC);

        $sections = [];
        foreach($records as $record) {
            $sections[] = new Section(
                $record['id'],
                htmlspecialchars($record['course_code']),
                $record['faculty_id'],
                htmlspecialchars($record['semester'])
            );
        }
        return $sections;
    }
}