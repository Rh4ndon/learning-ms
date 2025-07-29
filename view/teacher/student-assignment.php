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
    <?php include '../../controllers/assignment-submission-controller.php'; ?>

    <div class="container-fluid animate__animated animate__fadeIn">
        <!-- Breadcrumb -->
        <div class="row mb-4">

        </div>

        <div class="row mt-4">
            <div class="col-md-12">
                <div class="card pe-theme-card">
                    <div class="card-header pe-theme-card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Assignment Submissions</h5>
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
                                        <th>Assignment</th>
                                        <th>File</th>
                                        <th>Submission Time</th>

                                        <th>Score</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($recent_submissions as $submission):

                                        $student_assignment = getAllRecords('student_assignments', "WHERE assignment_id = {$submission['assignment_id']} AND student_id = {$submission['student_id']}");
                                        $total_score = $student_assignment[0]['score'];
                                        $student_file = $student_assignment[0]['file_location'];
                                    ?>
                                        <tr>
                                            <td>#<?php echo $submission['student_id']; ?></td>
                                            <td><?php echo "{$submission['first_name']} {$submission['last_name']}"; ?></td>
                                            <td><?php echo $submission['section_name']; ?></td>
                                            <td><?php echo $submission['title']; ?></td>
                                            <td> <?php
                                                    $file = $student_file;
                                                    $ext = strtolower(pathinfo($file, PATHINFO_EXTENSION));
                                                    $file_url = "../../uploads/student-assignments/" . $file;

                                                    // For images
                                                    if (in_array($ext, ['png', 'jpg', 'jpeg'])) {
                                                        echo '<a href="' . $file_url . '" target="_blank"><img src="' . $file_url . '" alt="Assignment Image" style="max-width:80px;max-height:80px;border-radius:4px;" /></a>';
                                                    }
                                                    // For PDF
                                                    elseif ($ext === 'pdf') {
                                                        echo '<a href="' . $file_url . '" target="_blank"><i class="fas fa-file-pdf"></i> View PDF</a>';
                                                    }
                                                    // For DOCX, PPTX
                                                    elseif (in_array($ext, ['docx', 'pptx'])) {
                                                        echo '<a href="https://view.officeapps.live.com/op/embed.aspx?src=' . urlencode('http://' . $_SERVER['HTTP_HOST'] . '/learning_ms/uploads/' . $file) . '" target="_blank"><i class="fas fa-file-alt"></i> View ' . strtoupper($ext) . '</a>';
                                                    } else {
                                                        echo '<span class="text-muted">Unsupported file</span>';
                                                    }
                                                    ?></td>
                                            <td><?php echo date('F j, Y H:i', strtotime($submission['created_at'])); ?></td>

                                            <td><?php echo $total_score; ?> / <?php echo $submission['score']; ?></td>
                                            <td><a href="../../controllers/download.php?path=../uploads/student-assignments/<?php echo $student_file; ?>" class="btn pe-theme-btn-outline"><i class="fas fa-download"></i><?php echo $student_file; ?></a>
                                                <!-- Grade/Review Button -->
                                                <a href="#" class="btn btn-sm pe-theme-btn-outline" data-bs-toggle="modal" data-bs-target="#gradeModal<?php echo $submission['student_id'] . '_' . $submission['assignment_id']; ?>">
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

<?php foreach ($recent_submissions as $submission): ?>
    <!-- Grade Modal -->
    <div class="modal fade" id="gradeModal<?php echo $submission['student_id'] . '_' . $submission['assignment_id']; ?>" tabindex="-1" aria-labelledby="gradeModalLabel<?php echo $submission['student_id'] . '_' . $submission['assignment_id']; ?>" aria-hidden="true">
        <div class="modal-dialog">
            <form method="post" action="../../controllers/grade-assignment.php">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="gradeModalLabel<?php echo $submission['student_id'] . '_' . $submission['assignment_id']; ?>">Grade Assignment</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="student_id" value="<?php echo $submission['student_id']; ?>">
                        <input type="hidden" name="assignment_id" value="<?php echo $submission['assignment_id']; ?>">
                        <div class="mb-3">
                            <label for="scoreInput<?php echo $submission['student_id'] . '_' . $submission['assignment_id']; ?>" class="form-label">Score (Max: <?php echo $submission['score']; ?>)</label>
                            <input type="number" name="score" class="form-control" id="scoreInput<?php echo $submission['student_id'] . '_' . $submission['assignment_id']; ?>" name="score" min="0" max="<?php echo $submission['score']; ?>" required value="<?php echo $total_score; ?>">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" name="submit_grade" class="btn pe-theme-btn">Submit</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
<?php endforeach; ?>

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