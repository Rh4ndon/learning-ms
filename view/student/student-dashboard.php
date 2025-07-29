<?php include '../../controllers/sessions.php'; ?>

<!-- Header -->
<?php include 'header.php'; ?>

<!-- Sidebar -->
<?php include 'sidebar.php'; ?>

<style>
    /* PE Theme Styles */
    .pe-card {
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }

    .pe-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
    }

    .card-icon {
        font-size: 2.5rem;
        opacity: 0.3;
        transition: all 0.3s ease;
    }

    .pe-card:hover .card-icon {
        opacity: 0.5;
        transform: scale(1.1);
    }

    /* XP Progress Bar */
    .xp-progress {
        height: 6px;
        background: #e9ecef;
        border-radius: 3px;
        margin-top: 10px;
        overflow: hidden;
    }

    .xp-progress-bar {
        height: 100%;
        background: linear-gradient(90deg, var(--pe-badge), var(--pe-badge-alt));
        width: 0%;
        transition: width 1s ease;
    }

    /* Table Animations */
    tr {
        transition: all 0.3s ease;
    }

    tr:hover {
        background-color: rgba(0, 0, 0, 0.02);
    }

    /* Level Indicator */
    .level-indicator-container {
        margin-bottom: 20px;
        background: linear-gradient(135deg, var(--pe-primary), var(--pe-secondary));
        color: white;
        padding: 10px 15px;
        border-radius: 8px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }

    .level-display {
        font-weight: bold;
        font-size: 1.1rem;
    }

    .xp-display {
        font-size: 0.9rem;
        opacity: 0.9;
    }

    @media screen and (max-width: 768px) {
        .quest-indicator {
            font-size: 0.8rem;
            width: 50%;
        }
    }
</style>

<!-- Main Content -->
<div class="main-content">
    <!-- Top Navbar -->
    <?php include 'top-navbar.php'; ?>

    <!-- Dashboard Content -->
    <?php include '../../controllers/student-dashboard-controller.php'; ?>

    <div class="container-fluid">
        <div class="row mb-4"></div>
        <!-- Stats Cards with PE Theme -->
        <div class="row">
            <div class="col-md-4 mb-4">
                <div class="card pe-card pe-theme-card-alt h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <div class="card-value"><?php echo $active_exams; ?></div>
                                <div class="card-title pe-theme-text">Active Exams</div>
                                <div class="xp-progress">
                                    <div class="xp-progress-bar" style="width: <?php echo min(100, $active_exams * 25); ?>%"></div>
                                </div>
                            </div>
                            <i class="fas fa-running card-icon pe-theme-icon-alt"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4 mb-4">
                <div class="card pe-card pe-theme-card-alt h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <div class="card-value"><?php echo $submissions_today; ?></div>
                                <div class="card-title pe-theme-text">My Submissions</div>
                                <div class="xp-progress">
                                    <div class="xp-progress-bar" style="width: <?php echo min(100, $submissions_today * 25); ?>%"></div>
                                </div>
                            </div>
                            <i class="fas fa-dumbbell card-icon pe-theme-icon-alt"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4 mb-4">
                <div class="card pe-card pe-theme-card-alt h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <div class="card-value"><?php echo $pending_grading; ?></div>
                                <div class="card-title pe-theme-text">Pending Grading</div>
                                <div class="xp-progress">
                                    <div class="xp-progress-bar" style="width: <?php echo min(100, $pending_grading * 25); ?>%"></div>
                                </div>
                            </div>
                            <i class="fas fa-clipboard-check card-icon pe-theme-icon-alt"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mb-4">
            <div class="col-md-12">
                <div class="card pe-theme-card">
                    <div class="card-header pe-theme-card-header">
                        <h5 class="mb-0">Lectures</h5>

                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover pe-theme-table">
                                <thead>
                                    <tr>
                                        <th>Title</th>
                                        <th>Description</th>
                                        <th>Section</th>
                                        <th>File</th>
                                        <th>Upload Date</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $lectures = getAllRecords('lectures', "WHERE section_id =" . $_SESSION['section'] . " ORDER BY created_at, section_id DESC");
                                    foreach ($lectures as $lecture): ?>
                                        <tr>
                                            <td><?php echo $lecture['title']; ?></td>
                                            <td><?php echo $lecture['description']; ?></td>
                                            <td><?php
                                                $section = getRecord('sections', $lecture['section_id']);
                                                echo $section['section_name']; ?>
                                            </td>
                                            <td>
                                                <?php
                                                $file = $lecture['file_location'];
                                                $ext = strtolower(pathinfo($file, PATHINFO_EXTENSION));
                                                $file_url = "../../uploads/lectures/" . $file;

                                                // For images
                                                if (in_array($ext, ['png', 'jpg', 'jpeg'])) {
                                                    echo '<a href="' . $file_url . '" target="_blank"><img src="' . $file_url . '" alt="Lecture Image" style="max-width:80px;max-height:80px;border-radius:4px;" /></a>';
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
                                                ?>
                                            </td>
                                            <td><?php echo date('F j, Y', strtotime($lecture['created_at'])); ?></td>
                                            <td>
                                                <a href="../../controllers/download.php?path=../uploads/lectures/<?php echo $lecture['file_location']; ?>" class="btn pe-theme-btn-outline"><i class="fas fa-download"></i> <?php echo $lecture['file_location']; ?></a>

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

        <!-- Level Indicator -->
        <div class="row">
            <div class="col-md-3 mb-4">
                <div class="card creation-card pe-theme-card">
                    <div class="card-header creation-header">
                        <h5 class="mb-0">Submit Assignment <i class="fas fa-pencil-alt"></i></h5>
                    </div>
                    <div class="card-body">
                        <form action="../../controllers/submit-assignment.php" method="POST" id="examCreationForm" enctype="multipart/form-data">
                            <div class="form-group mb-3">
                                <label for="title">Title</label>
                                <select name="assignment_id" class="form-control pe-theme-input" required>
                                    <option value="" disabled selected>Select Assignment</option>
                                    <?php
                                    $assignments = getAllRecords('assignments', "WHERE section_id = " . $_SESSION['section'] . " ORDER BY created_at DESC");
                                    foreach ($assignments as $assignment): ?>
                                        <option value="<?php echo $assignment['assignment_id']; ?>"><?php echo $assignment['title']; ?>, Due:<?php echo date('F j, Y', strtotime($assignment['due_date'])); ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="form-group mb-3">
                                <label for="file">File</label>
                                <input type="file" name="document" class="form-control pe-theme-input" id="assignmentFile" accept=".pdf,.docx,.pptx,.png,.jpg,.jpeg" required>
                                <small class="text-danger" id="fileError" style="display:none;">Invalid file type. Allowed: PDF, DOCX, PPTX, PNG, JPG, JPEG.</small>
                            </div>
                            <script>
                                document.getElementById('assignmentFile').addEventListener('change', function(e) {
                                    const allowed = ['pdf', 'docx', 'pptx', 'png', 'jpg', 'jpeg'];
                                    const file = e.target.files[0];
                                    const error = document.getElementById('fileError');
                                    if (file) {
                                        const ext = file.name.split('.').pop().toLowerCase();
                                        if (!allowed.includes(ext)) {
                                            error.style.display = 'block';
                                            e.target.value = '';
                                        } else {
                                            error.style.display = 'none';
                                        }
                                    } else {
                                        error.style.display = 'none';
                                    }
                                });
                            </script>

                            <div class="form-group mb-3">
                                <label for="description">Description</label>
                                <textarea name="description" class="form-control pe-theme-input" placeholder="Enter Description" required></textarea>
                            </div>


                            <div class="form-group mb-3">
                                <input type="submit" name="submit-assignment" class="btn pe-theme-btn create-btn" value="Submit Assignment">
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-md-9">
                <div class="card pe-theme-card">
                    <div class="card-header pe-theme-card-header">
                        <h5 class="mb-0">Assignments</h5>

                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover pe-theme-table">
                                <thead>
                                    <tr>
                                        <th>Title</th>
                                        <th>Description</th>
                                        <th>Section</th>
                                        <th>File</th>
                                        <th>Upload Date</th>
                                        <th>Score</th>
                                        <th>Due Date</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $assignments = getAllRecords('assignments', "WHERE section_id = " . $_SESSION['section'] . " ORDER BY created_at, section_id DESC");
                                    foreach ($assignments as $assignment): ?>
                                        <tr>
                                            <td><?php echo $assignment['title']; ?></td>
                                            <td><?php echo $assignment['description']; ?></td>
                                            <td><?php
                                                $section = getRecord('sections', 'section_id=' . $assignment['section_id']);
                                                echo $section['section_name']; ?>
                                            </td>
                                            <td>
                                                <?php
                                                $file = $assignment['file_location'];
                                                $ext = strtolower(pathinfo($file, PATHINFO_EXTENSION));
                                                $file_url = "../../uploads/assignments/" . $file;

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
                                                ?>
                                            </td>
                                            <td><?php echo date('F j, Y', strtotime($assignment['created_at'])); ?></td>
                                            <td>
                                                <?php
                                                $get_assignment = getAllRecords('student_assignments', "WHERE assignment_id = {$assignment['assignment_id']} AND student_id = {$_SESSION['user_id']}");
                                                if ($get_assignment) {
                                                    $student_assignment = $get_assignment[0];
                                                    echo $student_assignment['score'] ? $student_assignment['score'] . '/' . $assignment['score'] : 'Submitted Not Yet Graded';
                                                } else {
                                                    echo 'Not Submitted';
                                                }
                                                ?>
                                            </td>
                                            <td><?php echo date('F j, Y', strtotime($assignment['due_date'])); ?></td>
                                            <td><?php
                                                $get_assignment = getAllRecords('student_assignments', "WHERE assignment_id = {$assignment['assignment_id']} AND student_id = {$_SESSION['user_id']}");
                                                if ($get_assignment) { ?>
                                                    <a href="../../controllers/download.php?path=../uploads/student-assignments/<?php echo $get_assignment[0]['file_location']; ?>" class="btn pe-theme-btn-outline"><i class="fas fa-download"></i>Your Assignment: <?php echo $get_assignment[0]['file_location']; ?></a>
                                                <?php }
                                                ?>

                                                <a href="../../controllers/download.php?path=../uploads/assignments/<?php echo $assignment['file_location']; ?>" class="btn pe-theme-btn-outline"><i class="fas fa-download"></i> <?php echo $assignment['file_location']; ?></a>

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
        <!-- Recent Exam Submissions -->
        <div class="row mt-4">
            <div class="col-md-12">
                <div class="card pe-theme-card">
                    <div class="card-header pe-theme-card-header">
                        <h5 class="mb-0">Recent Exam Submissions</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table pe-theme-table">
                                <thead>
                                    <tr>
                                        <th>Student ID</th>
                                        <th>Name</th>
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
                                        <tr class="animate__animated animate__fadeInUp">
                                            <td>#<?php echo $submission['student_id']; ?></td>
                                            <td><?php echo "{$student['first_name']} {$student['last_name']}"; ?></td>
                                            <td><?php echo $quiz['title']; ?></td>
                                            <td><?php echo date('F j, Y H:i', strtotime($submission['taken_at'])); ?></td>
                                            <td><span class="badge <?php echo $status_class; ?>"><?php echo $status_text; ?></span></td>
                                            <td><?php echo intval($student_grade); ?> / <?php echo intval($total_points); ?></td>
                                            <td>
                                                <a href="student-review-exam.php?student_id=<?php echo $submission['student_id']; ?>&id=<?php echo $submission['quiz_id']; ?>" class="btn btn-sm pe-theme-btn-alt-outline">Review</a>
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

<!-- Footer -->
<?php include 'footer.php'; ?>

<script>
    // Add animation to table rows
    document.addEventListener('DOMContentLoaded', function() {
        const rows = document.querySelectorAll('tbody tr');
        rows.forEach((row, index) => {
            row.style.animationDelay = `${index * 0.1}s`;
        });
    });
</script>