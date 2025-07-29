<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require '../../models/functions.php';

// Get current user ID (assuming teacher is logged in)
$teacher_id = $_SESSION['user_id']; // You should replace this with your actual session variable

// Get stats data
$total_students = countAllRecords('users', "is_admin = 0");
$active_exams = countAllRecords('quizzes', "is_published = 1 AND created_by = $teacher_id");
$submissions_today = countAllRecords(
    "(SELECT DISTINCT student_id, quiz_id FROM student_answers WHERE DATE(taken_at) = CURDATE()) AS distinct_submissions"
);
$pending_grading = countAllRecords(
    "(SELECT DISTINCT quiz_id, student_id FROM student_answers WHERE is_graded = 0) AS distinct_pending"
);

// Get recent submissions
$recent_submissions = getAllRecords(
    "student_answers sa 
    JOIN users u ON sa.student_id = u.user_id 
    JOIN quizzes q ON sa.quiz_id = q.quiz_id 
    JOIN questions qu ON sa.question_id = qu.question_id",
    "GROUP BY sa.student_id , sa.quiz_id ORDER BY sa.taken_at, u.section_id"
);
