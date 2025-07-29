<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();
require_once '../models/functions.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $file = getRecord('assignments', 'assignment_id = ' . $id);
    $student_file = getRecord('student_assignments', 'assignment_id = ' . $id);

    if (!empty($student_file['file_location'])) {
        $studentfilePath = '../uploads/student-assignments/' . $student_file['file_location'];
        if (file_exists($studentfilePath)) {
            unlink($studentfilePath);
            // delete all answers associated with the assignment
            deleteRecord('student_assignments', 'assignment_id = ' . $id);
        }
    }
    // Delete the file associated with the assignment
    if (!empty($file['file_location'])) {
        $filePath = '../uploads/assignments/' . $file['file_location'];
        if (file_exists($filePath)) {
            unlink($filePath);
            // delete all answers associated with the assignment
            deleteRecord('assignments', 'assignment_id = ' . $id);
            header("Location: ../view/teacher/teacher-dashboard.php?msg=Assignment Deleted Successfully");
            exit;
        }
    }
    header("Location: ../view/teacher/teacher-dashboard.php?error=Failed to Delete Assignment");
} else {
    header("Location: ../view/teacher/teacher-dashboard.php?error=Invalid Request");
}
