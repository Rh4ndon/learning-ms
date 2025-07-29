<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
require_once '../models/functions.php';

if (isset($_POST['quiz_id'])) {
    $quiz_id = $_POST['quiz_id'];
    $student_id = $_POST['student_id'];

    $questions = getAllRecords('questions', 'WHERE quiz_id = ' . $quiz_id);
    foreach ($questions as $question) {
        if ($question['question_type'] == 'short_text') {

            $student_records = getAllRecords('student_answers', 'WHERE question_id = ' . $question['question_id'] . ' AND student_id = ' . $student_id);
            foreach ($student_records as $student_record) {

                $question_id = $student_record['question_id'];
                $points_earned = $_POST['points_earned' . $question_id];

                // Update the student's grade in the database
                editRecord('student_answers', ['points_earned' => $points_earned], 'question_id = ' . $question_id . ' AND student_id = ' . $student_id);
            }
        }
    }


    $update = editRecord('student_answers', ['is_graded' => 1], 'quiz_id = ' . $quiz_id . ' AND student_id = ' . $student_id);
    if ($update) {
        header('Location: ../view/teacher/teacher-exam-submission.php?msg=Student+graded+successfully');
    }
} else {
    echo 'Invalid request';
}
