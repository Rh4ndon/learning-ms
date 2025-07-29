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
        $question_id = $question['question_id'];
        $points_earned = 0; // Default to 0 points

        if ($question['question_type'] == 'multiple_choice' || $question['question_type'] == 'true_false') {
            // Get the selected answer for this question
            if (isset($_POST['answer'][$question_id])) {
                $answer_text = $_POST['answer'][$question_id];

                // Find the corresponding option and check if it's correct
                $options = getAllRecords('question_options', 'WHERE question_id = ' . $question_id);
                $option_id = null;
                foreach ($options as $option) {
                    if ($option['option_text'] == $answer_text) {
                        $option_id = $option['option_id'];
                        // If this option is marked as correct, award full points
                        if (isset($option['is_correct']) && $option['is_correct'] == 1) {
                            $points_earned = $question['points'];
                        }
                        break;
                    }
                }

                $record = insertRecord('student_answers', [
                    'quiz_id' => $quiz_id,
                    'student_id' => $student_id,
                    'question_id' => $question_id,
                    'option_id' => $option_id,
                    'answer_text' => $answer_text,
                    'points_earned' => $points_earned
                ]);
            }
        } else {
            // For text answers - teacher will grade manually
            $answer_text = $_POST['answer_text_' . $question_id];
            $record = insertRecord('student_answers', [
                'quiz_id' => $quiz_id,
                'student_id' => $student_id,
                'question_id' => $question_id,
                'answer_text' => $answer_text,
                'points_earned' => 0 // Set to 0 for manual grading
            ]);
        }
    }

    if ($record) {
        header("Location: ../view/student/student-exams.php?id=$quiz_id&msg=Answers+submitted+successfully");
        exit();
    } else {
        header("Location: ../view/student/student-exams.php?id=$quiz_id&error=Failed+to+submit+answers");
        exit();
    }
} else {
    header("Location: ../view/student/student-exams.php?id=$quiz_id&error=Invalid+Request");
    exit();
}
