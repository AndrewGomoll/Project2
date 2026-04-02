<?php

class Student {
    private $id;
    private $name;
    private $major;

    public function __construct($id, $name, $major) {
        $this->id = $id;
        $this->name = $name;
        $this->major = $major;
    }

    public function getId() {
        return $this->id;
    }

    public function getName() {
        return $this->name;
    }

    public function getMajor() {
        return $this->major;
    }

    public static function listStudents() {
        global $database;

        $query = 'SELECT * FROM students';
        $statement = $database->prepare($query);
        $statement->execute();
        $records = $statement->fetchAll(PDO::FETCH_ASSOC);
        $statement->closeCursor();

        $studentsArray = [];
        foreach ($records as $record) {
            $studentsArray[] = new Student(
                $record['id'],
                $record['name'],
                $record['major']
            );
        }

        return $studentsArray;
    }

    public static function getStudentById($id) {
        global $database;

        $query = 'SELECT * FROM students WHERE id = :id';
        $statement = $database->prepare($query);
        $statement->bindValue(':id', $id, PDO::PARAM_INT);
        $statement->execute();

        $record = $statement->fetch(PDO::FETCH_ASSOC);
        $statement->closeCursor();

        if ($record) {
            return new Student(
                $record['id'],
                $record['name'],
                $record['major']
            );
        }

        return null;
    }
}