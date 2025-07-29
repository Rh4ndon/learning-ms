<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();
require_once '../models/functions.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $file = getRecord('lectures', 'lecture_id = ' . $id);

    // Delete the file associated with the lecture
    if (!empty($file['file_location'])) {
        $filePath = '../uploads/lectures/' . $file['file_location'];
        if (file_exists($filePath)) {
            unlink($filePath);
            // delete all answers associated with the question
            deleteRecord('lectures', 'lecture_id = ' . $id);
            header("Location: ../view/teacher/teacher-dashboard.php?msg=Dashboard Deleted Successfully");
            exit;
        }
    }
    header("Location: ../view/teacher/teacher-dashboard.php?error=Failed to Delete Lecture");
} else {
    header("Location: ../view/teacher/teacher-dashboard.php?error=Invalid Request");
}
