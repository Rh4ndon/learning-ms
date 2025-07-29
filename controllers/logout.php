<?php
include '../models/functions.php';
session_start();
// Check if the user is logged in
if (isset($_SESSION['is_logged_in'])) {
    // Unset all session variables
    $_SESSION = array();

    // Destroy the session
    session_destroy();

    // Redirect to the login page with a logout message
    header('Location: ../index.php?msg=You have been logged out successfully.');
} else {
    // If the user is not logged in, redirect to the login page
    header('Location: ../index.php');
    exit();
}
