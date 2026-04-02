<?php
class Course {
    private $code;
    private $name;
    private $description;
    private $credits;

    public function __construct($code, $name, $description, $credits) {
        $this->code = $code;
        $this->name = $name;
        $this->description = $description;
        $this->credits = $credits;
    }

    public function getCode() {
        return $this->code;
    }

    public function getName() {
        return $this->name;
    }

    public function getDescription() {
        return $this->description;
    }

    public function getCredits() {
        return $this->credits;
    }

    public function setCode($code) {
        $this->code = $code;
    }

    public function setName($name) {
        $this->name = $name;
    }

    public function setDescription($description) {
        $this->description = $description;
    }

    public function setCredits($credits) {
        $this->credits = $credits;
    }

    public static function listCourses() {
        global $database;

        $query = 'SELECT * FROM course WHERE 1 = :one';
        $statement = $database->prepare($query);

        $statement->bindValue(':one', 1, PDO::PARAM_INT);

        $statement->execute();
        $records = $statement->fetchAll(PDO::FETCH_ASSOC);
        $statement->closeCursor();

        $coursesArray = [];
        foreach ($records as $record) {
            $coursesArray[] = new Course(
                $record['code'],
                $record['name'],
                $record['description'],
                $record['credits']
            );
        }
        return $coursesArray;
    }
}