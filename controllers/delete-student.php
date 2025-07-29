<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();
require_once '../models/functions.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // First delete all answers associated with the question
    deleteRecord('student_answers', 'student_id = ' . $id);

    // Delete assignments
    $student_file = getRecord('student_assignments', 'student_id = ' . $id);

    if (!empty($student_file['file_location'])) {
        $studentfilePath = '../uploads/student-assignments/' . $student_file['file_location'];
        if (file_exists($studentfilePath)) {
            unlink($studentfilePath);
            // delete all answers associated with the assignment
            deleteRecord('student_assignments', 'student_id = ' . $id);
        }
    }


    $record = deleteRecord('users', 'user_id = ' . $id);
    if ($record) {
        header("Location: ../view/teacher/teacher-student-list.php?msg=Student Deleted Successfully");
    } else {
        header("Location: ../view/teacher/teacher-student-list.php?error=Failed to Delete Student");
    }
} else {
    header("Location: ../view/teacher/teacher-student-list.php?error=Invalid Request");
}
