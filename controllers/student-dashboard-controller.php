<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


// Get current user ID (assuming teacher is logged in)

// Get stats data

$active_exams = countAllRecords('quizzes', "is_published = 1 AND created_by = 1");
$submissions_today = countAllRecords(
    "(SELECT DISTINCT student_id, quiz_id FROM student_answers WHERE student_id = " . $_SESSION['user_id'] . ") AS distinct_submissions"
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
    "WHERE sa.student_id = " . $_SESSION['user_id'] . " GROUP BY sa.student_id , sa.quiz_id ORDER BY sa.taken_at"
);

// Get system alerts/activities
$activities = [
    [
        'type' => 'Exam Started',
        'time' => '2 min ago',
        'details' => 'Midterm Exam - CS101'
    ],
    [
        'type' => 'New Submission',
        'time' => '15 min ago',
        'details' => 'Student: John Smith (ID: 12345)'
    ],
    [
        'type' => 'System Warning',
        'time' => '1 hour ago',
        'details' => 'Storage at 85% capacity'
    ],
    [
        'type' => 'New User Registered',
        'time' => '3 hours ago',
        'details' => 'Professor: Dr. Emily Johnson'
    ]
];
