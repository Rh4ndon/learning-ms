<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once '../models/functions.php';

if (isset($_POST['update-section'])) {
    $id = $_GET['id'];
    $section_name = $_POST['section_name'];
    $record = editRecord('sections', ['section_name' => $section_name], 'section_id = ' . $id);

    if ($record) {
        header("Location: ../view/teacher/teacher-sections.php?msg=Exam Updated Successfully");
    } else {
        header("Location: ../view/teacher/teacher-sections.php?error=Failed to Update Exam");
    }
} else {
    header("Location: ../view/teacher/teacher-sections.php?error=Invalid Request");
}
