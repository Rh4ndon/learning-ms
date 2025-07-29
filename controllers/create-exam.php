<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
require_once '../models/functions.php';

if (isset($_POST['create-exam'])) {
    $title = $_POST['title'];
    $subject = $_POST['subject'];
    $time = $_POST['time'];
    $description = $_POST['description'];
    $is_published = 1;

    $record = insertRecord('quizzes', ['title' => addslashes($title), 'subject' => addslashes($subject), 'description' => addslashes($description), 'time_limit' => $time, 'is_published' => $is_published, 'created_by' => $_SESSION['user_id']]);

    if ($record) {
        header("Location: ../view/teacher/teacher-exams.php?msg=Exam Created Successfully");
    } else {
        header("Location: ../view/teacher/teacher-exams.php?error=Failed to Create Exam");
    }
}
