<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
require_once '../models/functions.php';

if (isset($_POST['create-section'])) {
    $section_name = $_POST['section_name'];


    $record = insertRecord('sections', ['section_name' => addslashes($section_name)]);

    if ($record) {
        header("Location: ../view/teacher/teacher-sections.php?msg=Exam Created Successfully");
    } else {
        header("Location: ../view/teacher/teacher-sections.php?error=Failed to Create Exam");
    }
}
