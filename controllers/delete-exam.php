<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();
require_once '../models/functions.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    // Delete quiz options if they exist
    $questions = getAllRecords('questions', 'WHERE quiz_id = ' . $id);
    if (!empty($questions)) {
        foreach ($questions as $question) {

            // First delete all answers associated with the question
            deleteRecord('student_answers', 'question_id = ' . $question['question_id']);

            // Then delete all options associated with the question
            deleteRecord('question_options', 'question_id = ' . $question['question_id']);

            // Then delete the question
            deleteRecord('questions', 'question_id = ' . $question['question_id']);
        }
    }

    $record = deleteRecord('quizzes', 'quiz_id = ' . $id);
    if ($record) {
        header("Location: ../view/teacher/teacher-exams.php?msg=Exam Deleted Successfully");
    } else {
        header("Location: ../view/teacher/teacher-exams.php?error=Failed to Delete Exam");
    }
} else {
    header("Location: ../view/teacher/teacher-exams.php?error=Invalid Request");
}
