<?php
include '../models/functions.php';

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if (isset($_POST['update'])) {
    // Basic input validation
    $id = filter_var($_POST['id'], FILTER_VALIDATE_INT);
    $role = filter_var($_POST['role'], FILTER_VALIDATE_INT);
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $password = $_POST['password']; // Will be hashed
    $first_name = htmlspecialchars($_POST['first_name']);
    $last_name = htmlspecialchars($_POST['last_name']);
    $section = $_POST['section'];

    if (!$id) {
        header('Location: ../index.php?error=Invalid user ID');
        exit();
    }

    // Prepare data - consider adding more validation
    $data = [
        'email' => $email,
        'first_name' => $first_name,
        'last_name' => $last_name,
        'section_id' => $section
    ];

    // Only update password if it's provided (not empty)
    if (!empty($password)) {
        $data['password'] = password_hash($password, PASSWORD_BCRYPT);
    }

    // Debugging - consider using error_log instead
    error_log("Updating user $id: " . print_r($data, true));

    if (updateRecord('users', $data, "user_id = $id")) {
        // Update session variables
        session_start();
        $_SESSION['first_name'] = $first_name;
        $_SESSION['last_name'] = $last_name;
        $_SESSION['email'] = $email;
        $_SESSION['section'] = $section;
        $redirect = ($role == 1) ? '../view/teacher/teacher-dashboard.php' : '../view/student/student-dashboard.php';
        header("Location: $redirect?msg=Profile updated successfully.");
        exit();
    } else {
        // Add error information for debugging
        error_log("Database error: " . mysqli_error($conn));
        header('Location: ../index.php?error=Failed to update profile');
        exit();
    }
}
