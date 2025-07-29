<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();
require_once '../models/functions.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    // Delete quiz options if they exist
    $sections = getAllRecords('sections', 'WHERE section_id = ' . $id);
    if (!empty($sections)) {
        foreach ($sections as $section) {


            // Update user with that section
            updateRecord('users', ['section_id' => 'NULL'], 'section_id = ' . $id); // Pass 'NULL' as a string
        }
    }

    $record = deleteRecord('sections', 'section_id = ' . $id);
    if ($record) {
        header("Location: ../view/teacher/teacher-sections.php?msg=Exam Deleted Successfully");
    } else {
        header("Location: ../view/teacher/teacher-sections.php?error=Failed to Delete Exam");
    }
} else {
    header("Location: ../view/teacher/teacher-sections.php?error=Invalid Request");
}
