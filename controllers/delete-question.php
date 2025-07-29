<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();
require_once '../models/functions.php';

if (isset($_GET['id']) && isset($_GET['quiz_id'])) {
    $id = $_GET['id'];
    $quiz_id = $_GET['quiz_id'];

    try {
        // First delete all answers associated with the question
        deleteRecord('student_answers', 'question_id = ' . $id);

        // Then delete all options associated with the question
        deleteRecord('question_options', 'question_id = ' . $id);

        // Then delete the question
        $record = deleteRecord('questions', 'question_id = ' . $id);

        if ($record) {
            header("Location: ../view/teacher/teacher-view-exam.php?id=$quiz_id&msg=Question+Deleted+Successfully");
        } else {
            header("Location: ../view/teacher/teacher-view-exam.php?id=$quiz_id&error=Failed+to+Delete+Question");
        }
    } catch (Exception $e) {
        header("Location: ../view/teacher/teacher-view-exam.php?id=$quiz_id&error=Database+Error:+" . urlencode($e->getMessage()));
    }
} else {
    header("Location: ../view/teacher/teacher-view-exam.php?error=Invalid+Request");
}
