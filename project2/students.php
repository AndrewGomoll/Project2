<?php

include 'models/database.php';
include 'models/studentModel.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['deleteStudent'])) {
    $studentId = $_POST['deleteStudent'];
    $query = 'DELETE FROM students WHERE id = :id';
    $statement = $database->prepare($query);
    $statement->bindValue(':id', $studentId);
    $statement->execute();
    $statement->closeCursor();

    header('Location: students.php');
    exit;
}

$editingStudent = null;
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['editStudent'])) {
    $studentId = $_POST['updateStudent'];
    $editingStudent = Student::getStudentById($studentId);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['saveStudent'])) {
    $name = $_POST['name'];
    $major = $_POST['major'];

    if (!empty($_POST['id'])) {
        $id = $_POST['id'];
        $query = 'UPDATE students SET name = :name, major = :major WHERE id = :id';
        $statement = $database->prepare($query);
        $statement->bindValue(':name', $name);
        $statement->bindValue(':major', $major);
        $statement->bindValue(':id', $id);
        $statement->execute();
        $statement->closeCursor();
    }
    else {
        $query = 'INSERT INTO students (name, major) VALUES (:name, :major)';
        $statement = $database->prepare($query);
        $statement->bindValue(':name', $name);
        $statement->bindValue(':major', $major);
        $statement->execute();
        $statement->closeCursor();
    }

    header('Location: students.php');
    exit;
}

$students = Student::listStudents();

include 'views/studentsView.php';
?>