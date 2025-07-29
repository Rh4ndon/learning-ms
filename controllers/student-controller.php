<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include '../../models/functions.php';

// Get current user ID 
$current_user_id = $_SESSION['user_id'];

// Get stats data
$student_section = getRecord('sections', "section_id = " . $_SESSION['section']);
