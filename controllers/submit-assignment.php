<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
require_once '../models/functions.php';

if (isset($_POST['submit-assignment'])) {
    $assignment_id = $_POST['assignment_id'];

    //Check if the assignment is already submitted
    $existing_assignment = getRecord('student_assignments', "assignment_id = $assignment_id AND student_id = {$_SESSION['user_id']} AND is_submitted = 1");
    if ($existing_assignment) {
        header("Location: ../view/student/student-dashboard.php?error=Assignment already submitted.");
        exit;
    }


    $student_id = $_SESSION['user_id'];
    $student = getRecord('users', 'user_id = ' . $student_id);
    $student_name = $student['last_name'] . ' ' . $student['first_name'];

    $assignment = getRecord('assignments', 'assignment_id = ' . $assignment_id);
    if (!$assignment) {
        header("Location: ../view/student/student-dashboard.php?error=Assignment not found.");
        exit;
    }

    $title = $assignment['title'];
    $description = $_POST['description'];
    $section = $assignment['section_id'];
    $score = 0; // Default score, can be updated later
    $is_graded = 0; // Default to not graded
    $is_submitted = 1; // Mark as submitted





    $allowedExtensions = ['pdf', 'docx', 'xlsx', 'xls', 'png', 'jpg', 'jpeg'];
    $targetDirectory = '../uploads/student-assignments/'; // Specify your desired directory

    $uploadedFile = $_FILES['document']['tmp_name'];
    $fileName = $_FILES['document']['name'];
    $fileExtension = strtolower(pathinfo($_FILES['document']['name'], PATHINFO_EXTENSION));

    // Verify that the uploaded file is valid and owned by the current user
    if (is_uploaded_file($uploadedFile)) {
        if (in_array($fileExtension, $allowedExtensions)) {

            // Rename the file here
            $file_path = $student_name . '-' . $fileName;

            move_uploaded_file($_FILES["document"]["tmp_name"], "../uploads/student-assignments/" . $file_path);

            $record = insertRecord('student_assignments', ['title' => addslashes($title), 'description' => addslashes($description), 'file_location' => $file_path, 'score' => $score, 'section_id' => $section, 'student_id' => $student_id, 'assignment_id' => $assignment_id, 'is_graded' => $is_graded, 'is_submitted' => $is_submitted]);


            header("Location: ../view/student/student-dashboard.php?msg=Assignment Submitted Successfully");
            exit;
        } else {
            header("Location: ../view/student/student-dashboard.php?error=Invalid File Type, only IMAGE, PDF, and DOCX files are allowed.");
            exit;
        }
    } else {
        header("Location: ../view/student/student-dashboard.php?error=Failed to Submit Assignment, please try again.");
        exit;
    }
}
