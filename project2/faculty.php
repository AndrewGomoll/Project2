<?php

include 'models/database.php';
include 'models/facultyModel.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['deleteFaculty'])) {
    $facultyId = $_POST['deleteFaculty'];

    try {
        $query = 'DELETE FROM faculty WHERE id = :id';
        $statement = $database->prepare($query);
        $statement->bindValue(':id', $facultyId);
        $statement->execute();
        $statement->closeCursor();
    }
    catch (PDOException $e) {
            $message = "Database error";
    }
}

$editingFaculty = null;
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['editFaculty'])) {
    $facultyId = $_POST['updateFaculty'];

    $query = 'SELECT * FROM faculty WHERE id = :id';
    $statement = $database->prepare($query);
    $statement->bindValue(':id', $facultyId);
    $statement->execute();
    $record = $statement->fetch();
    $statement->closeCursor();

    if ($record) {
        $editingFaculty = $record;
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['addFaculty'])) {
    $name = $_POST['name'] ?? '';
    $email = $_POST['email'] ?? '';


    if (!empty($_POST['originalId'])) {
        $originalId = $_POST['originalId'];
        $query = 'UPDATE faculty SET name = :name, email = :email WHERE id = :id';
        $statement = $database->prepare($query);
        $statement->bindValue(':name', $name);
        $statement->bindValue(':email', $email);
        $statement->bindValue(':id', $originalId);
        $statement->execute();
        $statement->closeCursor();
    }
    else {
        $query = 'INSERT INTO faculty (name, email) VALUES (:name, :email)';
        $statement = $database->prepare($query);
        $statement->bindValue(':name', $name);
        $statement->bindValue(':email', $email);
        $statement->execute();
        $statement->closeCursor();
    }
}

$faculties = Faculty::listFaculty();

include 'views/facultyView.php';