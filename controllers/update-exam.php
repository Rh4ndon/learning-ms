<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once '../models/functions.php';

if (isset($_POST['update-exam'])) {
    $id = $_GET['id'];
    $title = $_POST['title'];
    $subject = $_POST['subject'];
    $time = $_POST['time'];
    $description = $_POST['description'];
    $record = editRecord('quizzes', ['title' => $title, 'subject' => $subject, 'description' => $description, 'time_limit' => $time], 'quiz_id = ' . $id);

    if ($record) {
        header("Location: ../view/teacher/teacher-exams.php?msg=Exam Updated Successfully");
    } else {
        header("Location: ../view/teacher/teacher-exams.php?error=Failed to Update Exam");
    }
} else {
    header("Location: ../view/teacher/teacher-exams.php?error=Invalid Request");
}
