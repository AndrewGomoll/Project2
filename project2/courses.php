<?php

include 'models/database.php';
include 'models/courseModel.php';

$errorMessage = null;
$editingCourse = null;


if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['deleteCourse'])) {
    $courseCode = $_POST['deleteCourse'];

    try {
        $query = 'DELETE FROM course WHERE code = :code';
        $statement = $database->prepare($query);
        $statement->bindValue(':code', $courseCode);
        $statement->execute();
        $statement->closeCursor();
    }
    catch (PDOException $e) {
        $errorMessage = 'Cannot delete course. It may be used in a section.';
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['editCourse'])) {
    $courseCode = $_POST['updateCourse'];

    $query = 'SELECT * FROM course WHERE code = :code';
    $statement = $database->prepare($query);
    $statement->bindValue(':code', $courseCode);
    $statement->execute();
    $editingCourse = $statement->fetch(PDO::FETCH_ASSOC);
    $statement->closeCursor();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['saveCourse'])) {
    $code = $_POST['code'] ?? '';
    $name = $_POST['name'] ?? '';
    $description = $_POST['description'] ?? '';
    $credits = (int)($_POST['credits'] ?? 0);
    $originalCode = $_POST['originalCode'] ?? null;

    if (empty($code) || empty($name)) {
        $errorMessage = 'Course code and name are required.';
    }
    else {
        try {
            if (!empty($originalCode)) {
                $query = 'UPDATE course SET code = :code, name = :name, description = :description, credits = :credits WHERE code = :originalCode';
                $statement = $database->prepare($query);
                $statement->bindValue(':code', $code);
                $statement->bindValue(':name', $name);
                $statement->bindValue(':description', $description);
                $statement->bindValue(':credits', $credits);
                $statement->bindValue(':originalCode', $originalCode);
                $statement->execute();
                $statement->closeCursor();
            }
            else {
                $query = 'INSERT INTO course (code, name, description, credits) VALUES (:code, :name, :description, :credits)';
                $statement = $database->prepare($query);
                $statement->bindValue(':code', $code);
                $statement->bindValue(':name', $name);
                $statement->bindValue(':description', $description);
                $statement->bindValue(':credits', $credits);
                $statement->execute();
                $statement->closeCursor();
            }
        }
        catch (PDOException $e) {
            $errorMessage = 'Database error';
        }
    }
}

$courses = Course::listCourses();

include 'views/coursesView.php';