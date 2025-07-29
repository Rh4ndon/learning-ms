<?php
include '../models/functions.php';

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if (isset($_POST['register'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $section = $_POST['section'];

    $data = [
        'email' => $email,
        'password' => password_hash($password, PASSWORD_BCRYPT),
        'first_name' => $first_name,
        'last_name' => $last_name,
        'section_id' => $section,

    ];

    if (insertRecord('users', $data)) {
        header('Location: ../index.php?msg=Registration successful. Please login.');
        exit();
    } else {
        header('Location: ../register.php?error=Registration failed. Please try again.');
        exit();
    }
}
