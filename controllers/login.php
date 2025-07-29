<?php
include '../models/functions.php';

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if (isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $user = getRecord('users', 'email = "' . $email . '"');

    if ($user && password_verify($password, $user['password'])) {
        if ($user['is_admin'] == 1) {
            session_start();
            $_SESSION['user_id'] = $user['user_id'];
            $_SESSION['is_admin'] = $user['is_admin'];
            $_SESSION['first_name'] = $user['first_name'];
            $_SESSION['last_name'] = $user['last_name'];
            $_SESSION['email'] = $user['email'];
            $_SESSION['is_logged_in'] = true;
            $_SESSION['login_time'] = time();
            $_SESSION['section'] = $user['section_id'];
            header('Location: ../view/teacher/teacher-dashboard.php');
            exit();
        } else {
            session_start();
            $_SESSION['user_id'] = $user['user_id'];
            $_SESSION['is_admin'] = $user['is_admin'];
            $_SESSION['first_name'] = $user['first_name'];
            $_SESSION['last_name'] = $user['last_name'];
            $_SESSION['email'] = $user['email'];
            $_SESSION['is_logged_in'] = true;
            $_SESSION['login_time'] = time();
            $_SESSION['section'] = $user['section_id'];
            header('Location: ../view/student/student-dashboard.php');
            exit();
        }
    } else if ($user && !password_verify($password, $user['password'])) {
        header('Location: ../index.php?error=Invalid password.');
        exit();
    } else if (!$user) {
        header('Location: ../index.php?error=Invalid email');
        exit();
    }
}
