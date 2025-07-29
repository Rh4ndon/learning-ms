<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
require_once '../models/functions.php';

if (isset($_POST['create-question'])) {
    $quiz_id = $_POST['quiz_id'];
    $question_text = $_POST['question'];
    $question_type = $_POST['question_type'];
    $points = $_POST['points'];




    $record = insertRecord('questions', [
        'quiz_id' => $quiz_id,
        'question_text' => addslashes($question_text),
        'question_type' => addslashes($question_type),
        'points' => $points
    ]);

    $question = getRecord('questions', 'quiz_id = ' . $quiz_id . ' AND question_text = "' . $question_text . '" AND question_type = "' . $question_type . '" AND points = ' . $points);

    if ($question_type == 'multiple_choice') {
        $options = [
            'option_a' => $_POST['option_a'],
            'option_b' => $_POST['option_b'],
            'option_c' => $_POST['option_c'],
            'option_d' => $_POST['option_d']
        ];

        $correct_answer = $_POST['correct_answer'];
        foreach ($options as $option) {

            if ($correct_answer == 'a' && $option == $_POST['option_a']) {
                $is_correct = 1;
            } elseif ($correct_answer == 'b' && $option == $_POST['option_b']) {
                $is_correct = 1;
            } elseif ($correct_answer == 'c' && $option == $_POST['option_c']) {
                $is_correct = 1;
            } elseif ($correct_answer == 'd' && $option == $_POST['option_d']) {
                $is_correct = 1;
            } else {
                $is_correct = 0;
            }

            static $order = 1;
            $record_options = insertRecord('question_options', [
                'question_id' => $question['question_id'],
                'option_text' => addslashes($option),
                'is_correct' => $is_correct,
                'display_order' => $order++
            ]);

            if (!$record_options) {
                header("Location: ../view/teacher/teacher-view-exam.php?id=$quiz_id&error=Failed to Create Exam");
                exit();
            }
        }
    } elseif ($question_type == 'true_false') {
        $options = ['true', 'false'];
        $correct_answer = $_POST['correct_answer'];
        foreach ($options as $option) {
            if ($correct_answer == 'true' && $option == 'true') {
                $is_correct = 1;
            } elseif ($correct_answer == 'false' && $option == 'false') {
                $is_correct = 1;
            } else {
                $is_correct = 0;
            }
            static $order = 1;
            $record_options = insertRecord('question_options', [
                'question_id' => $question['question_id'],
                'option_text' => $option,
                'is_correct' => $is_correct,
                'display_order' => $order++
            ]);
            if (!$record_options) {
                header("Location: ../view/teacher/teacher-view-exam.php?id=$quiz_id&error=Failed to Create Exam");
                exit();
            }
        }
    }

    if ($record) {
        header("Location: ../view/teacher/teacher-view-exam.php?id=$quiz_id&msg=Exam Created Successfully");
    } else {
        header("Location: ../view/teacher/teacher-view-exam.php?id=$quiz_id&error=Failed to Create Exam");
    }
}
