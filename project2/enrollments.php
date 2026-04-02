<?php

include 'models/database.php';
include 'models/enrollmentModel.php';
include 'models/studentModel.php';
include 'models/sectionModel.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['deleteEnrollment'])) {
    $id = $_POST['deleteEnrollment'];

    try {
        $query = 'DELETE FROM enrollment WHERE id = :id';
        $statement = $database->prepare($query);
        $statement->bindValue(':id', $id);
        $statement->execute();
        $statement->closeCursor();
    }
    catch (PDOException $e) {
        $deleteError = "Cannot delete this enrollment";
    }
    header('Location: enrollments.php');
    exit;
}

$editingEnrollment = null;
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['editEnrollment'])) {
    $id = $_POST['updateEnrollment'];
    $query = 'SELECT * FROM enrollment WHERE id = :id';
    $statement = $database->prepare($query);
    $statement->bindValue(':id', $id);
    $statement->execute();
    $editingEnrollment = $statement->fetch(PDO::FETCH_ASSOC);
    $statement->closeCursor();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['addEnrollment'])) {
    $student_id = $_POST['student_id'];
    $section_id = $_POST['section_id'];
    $grade = $_POST['grade'] ?? '';

    if (!empty($_POST['originalId'])) {
        $originalId = $_POST['originalId'];
        $query = 'UPDATE enrollment SET student_id = :student_id, section_id = :section_id, grade = :grade WHERE id = :id';
        $statement = $database->prepare($query);
        $statement->bindValue(':student_id', $student_id);
        $statement->bindValue(':section_id', $section_id);
        $statement->bindValue(':grade', $grade);
        $statement->bindValue(':id', $originalId);
        $statement->execute();
        $statement->closeCursor();
    }
    else {
        $query = 'INSERT INTO enrollment (student_id, section_id, grade) VALUES (:student_id, :section_id, :grade)';
        $statement = $database->prepare($query);
        $statement->bindValue(':student_id', $student_id);
        $statement->bindValue(':section_id', $section_id);
        $statement->bindValue(':grade', $grade);
        $statement->execute();
        $statement->closeCursor();
    }

    header('Location: enrollments.php');
    exit;
}

$enrollments = Enrollment::listEnrollments();
$students = Student::listStudents();
$sections = Section::listSections();

include 'views/enrollmentsView.php';