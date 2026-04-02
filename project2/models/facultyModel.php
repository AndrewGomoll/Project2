<?php
class Faculty {
    private $id, $name, $email;

    public function __construct($id, $name, $email) {
        $this->id = $id;
        $this->name = $name;
        $this->email = $email;
    }

    public function getId() {
        return $this->id;
    }

    public function getName() {
        return $this->name;
    }
    public function getEmail() {
        return $this->email;
    }

    public static function listFaculty() {
        global $database;

        $statement = $database->prepare("SELECT * FROM faculty WHERE 1 = :one");
        $statement->bindValue(':one', 1, PDO::PARAM_INT);

        $statement->execute();
        $records = $statement->fetchAll(PDO::FETCH_ASSOC);

        $faculty = [];
        foreach($records as $record) {
            $faculty[] = new Faculty($record['id'], $record['name'], $record['email']);
        }
        return $faculty;
    }
}