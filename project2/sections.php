<?php

include 'models/database.php';
include 'models/sectionModel.php';
include 'models/courseModel.php';
include 'models/facultyModel.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['deleteSection'])) {
    $sectionId = $_POST['deleteSection'];

    try {
        $query = 'DELETE FROM section WHERE id = :id';
        $statement = $database->prepare($query);
        $statement->bindValue(':id', $sectionId);
        $statement->execute();
        $statement->closeCursor();
    } catch (PDOException $e) {
        $message = "Cannot delete";
    }
}

$editingSection = null;
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['editSection'])) {
    $sectionId = $_POST['updateSection'];
    $query = 'SELECT * FROM section WHERE id = :id';
    $statement = $database->prepare($query);
    $statement->bindValue(':id', $sectionId);
    $statement->execute();
    $editingSection = $statement->fetch();
    $statement->closeCursor();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['addSection'])) {
    $id = $_POST['originalId'] ?? null;
    $course_code = $_POST['course_code'] ?? '';
    $faculty_id = $_POST['faculty_id'] ?? '';
    $semester = $_POST['semester'] ?? '';

    if ($id) {
        $query = 'UPDATE section SET course_code = :course_code, faculty_id = :faculty_id, semester = :semester WHERE id = :id';
        $statement = $database->prepare($query);
        $statement->bindValue(':course_code', $course_code);
        $statement->bindValue(':faculty_id', $faculty_id);
        $statement->bindValue(':semester', $semester);
        $statement->bindValue(':id', $id);
        $statement->execute();
        $statement->closeCursor();
    }
    else {
        $query = 'INSERT INTO section (course_code, faculty_id, semester) VALUES (:course_code, :faculty_id, :semester)';
        $statement = $database->prepare($query);
        $statement->bindValue(':course_code', $course_code);
        $statement->bindValue(':faculty_id', $faculty_id);
        $statement->bindValue(':semester', $semester);
        $statement->execute();
        $statement->closeCursor();
    }

    header('Location: sections.php');
    exit;
}

$sections = Section::listSections();
$courses = Course::listCourses();
$faculties = Faculty::listFaculty();

include 'views/sectionsView.php';