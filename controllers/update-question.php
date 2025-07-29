<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once '../models/functions.php';

if (isset($_POST['update-question'])) {
    $id = $_GET['id'];
    $quiz_id = $_POST['quiz_id'];
    $question = $_POST['question'];
    $points = $_POST['points'];
    //$question_type = $_POST['question_type'];

    //$record = editRecord('questions', ['question_text' => $question, 'question_type' => $question_type, 'points' => $points], 'question_id = ' . $id);
    $record = editRecord('questions', ['question_text' => $question, 'points' => $points], 'question_id = ' . $id);
    if ($record) {
        header("Location: ../view/teacher/teacher-view-exam.php?id=$quiz_id&msg=Question Updated Successfully");
    } else {
        header("Location: ../view/teacher/teacher-view-exams.php?id=$quiz_id&error=Failed to Update Question");
    }
} else {
    header("Location: ../view/teacher/teacher-exams.php?error=Invalid Request");
}
