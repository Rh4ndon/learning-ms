<!-- Session Check -->
<?php include '../../controllers/sessions.php'; ?>

<!-- Header -->
<?php include 'header.php'; ?>

<!-- Sidebar -->
<?php include 'sidebar.php'; ?>

<style>
    /* Scoped gamification styles to prevent interference */
    .teacher-dashboard .stat-card {
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .teacher-dashboard .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.15);
    }

    .teacher-dashboard .card-icon {
        font-size: 2.5rem;
        opacity: 0.3;
        transition: all 0.3s ease;
    }

    .teacher-dashboard .stat-card:hover .card-icon {
        opacity: 0.5;
        transform: scale(1.1);
    }

    .teacher-dashboard .achievement-badge {
        position: absolute;
        top: -10px;
        right: -10px;
        width: 30px;
        height: 30px;
        background: gold;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #333;
        font-weight: bold;
        box-shadow: 0 3px 6px rgba(0, 0, 0, 0.16);
        animation: bounce 2s infinite;
    }

    @keyframes bounce {

        0%,
        100% {
            transform: translateY(0);
        }

        50% {
            transform: translateY(-5px);
        }
    }

    .teacher-dashboard .progress-container {
        height: 6px;
        background: #e9ecef;
        border-radius: 3px;
        margin-top: 10px;
        overflow: hidden;
    }

    .teacher-dashboard .progress-bar {
        height: 100%;
        background: linear-gradient(90deg, #4b6cb7, #182848);
        width: 0%;
        transition: width 1s ease;
    }

    /* Table Enhancements */
    .teacher-dashboard tr {
        transition: all 0.3s ease;
    }

    .teacher-dashboard tr:hover {
        background-color: rgba(0, 0, 0, 0.02);
    }

    .teacher-dashboard .graded-row {
        border-left: 4px solid #28a745;
    }

    .teacher-dashboard .pending-row {
        border-left: 4px solid #ffc107;
    }

    @media screen and (max-width: 768px) {
        .teacher-dashboard .progress-container {
            display: none;
        }

        .grading-indicator {
            display: none;
        }

    }
</style>

<!-- Main Content -->
<div class="main-content teacher-dashboard">
    <!-- Top Navbar -->
    <?php include 'top-navbar.php'; ?>

    <!-- Dashboard Content -->
    <?php include '../../controllers/submission-controller.php'; ?>

    <div class="container-fluid animate__animated animate__fadeIn">
        <!-- Breadcrumb -->
        <div class="row mb-4">

        </div>

        <div class="row mt-4">
            <div class="col-md-12">
                <div class="card pe-theme-card">
                    <div class="card-header pe-theme-card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Exam Submissions</h5>
                        <div class="d-flex align-items-center">


                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover pe-theme-table">
                                <thead>
                                    <tr>
                                        <th>Student ID</th>
                                        <th>Name</th>
                                        <th>Section</th>
                                        <th>Exam</th>
                                        <th>Submission Time</th>
                                        <th>Status</th>
                                        <th>Score</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($recent_submissions as $submission):
                                        $student = getRecord('users', "user_id = {$submission['student_id']}");
                                        $quiz = getRecord('quizzes', "quiz_id = {$submission['quiz_id']}");
                                        $question = getAllRecords('questions', "WHERE quiz_id = {$submission['quiz_id']}");
                                        $student_answers = getAllRecords('student_answers', "WHERE quiz_id = {$submission['quiz_id']} AND student_id = {$submission['student_id']}");
                                        if ($student['section_id'] != null) {
                                            $student_section = getRecord('sections', "section_id = {$student['section_id']}");
                                        } else {
                                            $student_section = ['section_name' => 'N/A'];
                                        }
                                        $student_grade = 0;
                                        foreach ($student_answers as $answer) {
                                            $student_grade += $answer['points_earned'];
                                        }
                                        $total_points = 0;
                                        foreach ($question as $q) {
                                            $total_points += $q['points'];
                                        }
                                        $status_class = $submission['is_graded'] ? 'pe-theme-badge-success' : 'pe-theme-badge-warning';
                                        $status_text = $submission['is_graded'] ? 'Graded' : 'Pending';
                                    ?>
                                        <tr>
                                            <td>#<?php echo $submission['student_id']; ?></td>
                                            <td><?php echo "{$student['first_name']} {$student['last_name']}"; ?></td>
                                            <td><?php echo $student_section['section_name']; ?></td>
                                            <td><?php echo $quiz['title']; ?></td>
                                            <td><?php echo date('F j, Y H:i', strtotime($submission['taken_at'])); ?></td>
                                            <td><span class="badge <?php echo $status_class; ?>"><?php echo $status_text; ?></span></td>
                                            <td><?php echo intval($student_grade); ?> / <?php echo intval($total_points); ?></td>
                                            <td>
                                                <a href="teacher-check-exam.php?student_id=<?php echo $submission['student_id']; ?>&id=<?php echo $submission['quiz_id']; ?>" class="btn btn-sm pe-theme-btn-outline">
                                                    <?php echo $submission['is_graded'] ? 'Review' : 'Grade'; ?>
                                                </a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Initialize
    document.addEventListener('DOMContentLoaded', function() {
        // Update UI
        updateTeacherGameUI();
    });

    // Update game UI
    function updateTeacherGameUI() {
        // Update progress bars
        document.getElementById('gradingQuestProgress').style.width =
            `${(<?php echo count($recent_submissions); ?> / 5) * 100}%`;
    }
</script>

<!-- Footer -->
<?php include 'footer.php'; ?>