<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
require_once '../models/functions.php';

if (isset($_POST['upload-lecture'])) {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $section_id = $_POST['section'];

    $allowedExtensions = ['pdf', 'docx', 'xlsx', 'xls', 'png', 'jpg', 'jpeg'];
    $targetDirectory = '../uploads/lectures/'; // Specify your desired directory

    $uploadedFile = $_FILES['document']['tmp_name'];
    $fileName = $_FILES['document']['name'];
    $fileExtension = strtolower(pathinfo($_FILES['document']['name'], PATHINFO_EXTENSION));

    // Verify that the uploaded file is valid and owned by the current user
    if (is_uploaded_file($uploadedFile)) {
        if (in_array($fileExtension, $allowedExtensions)) {

            // Rename the file here
            $file_path = $fileName;

            move_uploaded_file($_FILES["document"]["tmp_name"], "../uploads/lectures/" . $file_path);

            $record = insertRecord('lectures', ['title' => addslashes($title), 'description' => addslashes($description), 'file_location' => $file_path, 'section_id' => $section_id]);


            header("Location: ../view/teacher/teacher-dashboard.php?msg=Lecture Uploaded Successfully");
            exit;
        } else {
            header("Location: ../view/teacher/teacher-dashboard.php?error=Invalid File Type, only IMAGE, PDF, and DOCX files are allowed.");
            exit;
        }
    } else {
        header("Location: ../view/teacher/teacher-dashboard.php?error=Failed to Upload Lecture, please try again.");
        exit;
    }
}
