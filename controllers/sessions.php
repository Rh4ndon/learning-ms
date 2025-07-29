<?php
//include '../models/functions.php';
session_start();

// Check if the user is logged in
if (isset($_SESSION['is_logged_in'])) {
    // User is logged in, do nothing
} else {
    // User is not logged in, redirect to the login page
    header('Location: ../../index.php');
    exit();
}
