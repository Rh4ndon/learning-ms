<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
require_once '../models/functions.php';

if (isset($_POST['submit_grade'])) {
    $assignment_id = $_POST['assignment_id'];
    $student_id = $_POST['student_id'];
    $score = $_POST['score'];

    $student_assignments = getAllRecords('student_assignments', 'WHERE assignment_id = ' . $assignment_id . ' AND student_id = ' . $student_id);

    $update = editRecord('student_assignments', ['is_graded' => 1, 'score' => $score], 'assignment_id = ' . $assignment_id . ' AND student_id = ' . $student_id);
    if ($update) {
        header('Location: ../view/teacher/student-assignment.php?id=' . $assignment_id . '&msg=Student+graded+successfully');
    }
} else {
    echo 'Invalid request';
}
