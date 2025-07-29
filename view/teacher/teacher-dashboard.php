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
        top: 5px;
        right: 1px;
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
    <?php include '../../controllers/dashboard-controller.php'; ?>

    <div class="container-fluid animate__animated animate__fadeIn">
        <!-- Dashboard Header -->
        <div class="row mb-4">

        </div>

        <!-- PE Theme Stats Cards -->
        <div class="row">
            <div class="col-md-3 mb-3 animate__animated animate__fadeInLeft">
                <div class="card stat-card quest-pulse pe-theme-card" style="background: linear-gradient(135deg, #2b5876 0%, #4e4376 100%);" id="studentsCard">
                    <div class="achievement-badge" style="background-color: #FFD700; color: #333;">🏆</div>
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <div class="card-value text-white"><?php echo $total_students; ?></div>
                                <div class="card-title text-white">Active Students</div>
                                <div class="progress-container">
                                    <div class="progress-bar" id="studentsProgress" style="background-color: #FFD700;"></div>
                                </div>
                            </div>
                            <i class="fas fa-running card-icon text-white"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-3 mb-3 animate__animated animate__fadeInLeft animate__delay-1s">
                <div class="card stat-card pe-theme-card" style="background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);" id="examsCard">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <div class="card-value"><?php echo $active_exams; ?></div>
                                <div class="card-title text-white">Active Exams</div>
                                <div class="progress-container">
                                    <div class="progress-bar" id="examsProgress" style="background-color: #FF6B6B;"></div>
                                </div>
                            </div>
                            <i class="fas fa-stopwatch card-icon text-white"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-3 mb-3 animate__animated animate__fadeInRight animate__delay-1s">
                <div class="card stat-card pe-theme-card" style="background: linear-gradient(135deg, #e65c00 0%, #F9D423 100%);" id="submissionsCard">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <div class="card-value"><?php echo $submissions_today; ?></div>
                                <div class="card-title text-white">Submissions Today</div>
                                <div class="progress-container">
                                    <div class="progress-bar" id="submissionsProgress" style="background-color: #4ECDC4;"></div>
                                </div>
                            </div>
                            <i class="fas fa-dumbbell card-icon text-white"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-3 mb-3 animate__animated animate__fadeInRight">
                <div class="card stat-card pe-theme-card" style="background: linear-gradient(135deg, #4568DC 0%, #B06AB3 100%);" id="gradingCard">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <div class="card-value"><?php echo $pending_grading; ?></div>
                                <div class="card-title text-dark">Pending Grading</div>
                                <div class="progress-container">
                                    <div class="progress-bar" id="gradingProgress" style="background-color: #FFEE58;"></div>
                                </div>
                            </div>
                            <i class="fas fa-clipboard-check card-icon text-white"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-3 mb-4">
                <div class="card creation-card pe-theme-card">
                    <div class="card-header creation-header">
                        <h5 class="mb-0">Add Lectures <i class="fas fa-file-upload"></i></h5>
                    </div>
                    <div class="card-body">
                        <form action="../../controllers/upload-lecture.php" method="POST" id="examCreationForm" enctype="multipart/form-data">
                            <div class="form-group mb-3">
                                <label for="title">Title</label>
                                <input type="text" name="title" class="form-control pe-theme-input" placeholder="Enter Title" required>
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
                                <label for="section">Section</label>
                                <select name="section" class="form-control pe-theme-input" required>
                                    <option value="">Select Section</option>
                                    <?php
                                    $sections = getAllRecords('sections', "ORDER BY section_name ASC");
                                    foreach ($sections as $section): ?>
                                        <option value="<?php echo $section['section_id']; ?>"><?php echo $section['section_name']; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="form-group mb-3">
                                <label for="description">Description</label>
                                <textarea name="description" class="form-control pe-theme-input" placeholder="Enter Description" required></textarea>
                            </div>
                            <div class="form-group mb-3">
                                <input type="submit" name="upload-lecture" class="btn pe-theme-btn create-btn" value="Upload Lecture">
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-md-9">
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
                                    $lectures = getAllRecords('lectures', "ORDER BY created_at, section_id DESC");
                                    foreach ($lectures as $lecture): ?>
                                        <tr>
                                            <td><?php echo $lecture['title']; ?></td>
                                            <td><?php echo $lecture['description']; ?></td>
                                            <td><?php
                                                $section = getRecord('sections', 'section_id=' . $lecture['section_id']);
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
                                                <!-- Delete Lecture Button triggers modal -->
                                                <button type="button" class="btn pe-theme-btn-alt-warning" data-bs-toggle="modal" data-bs-target="#deleteLectureModal<?php echo $lecture['lecture_id']; ?>">
                                                    Delete
                                                </button>


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



        <div class="row">
            <div class="col-md-3 mb-4">
                <div class="card creation-card pe-theme-card">
                    <div class="card-header creation-header">
                        <h5 class="mb-0">Add Assignment <i class="fas fa-pencil-alt"></i></h5>
                    </div>
                    <div class="card-body">
                        <form action="../../controllers/upload-assignment.php" method="POST" id="examCreationForm" enctype="multipart/form-data">
                            <div class="form-group mb-3">
                                <label for="title">Title</label>
                                <input type="text" name="title" class="form-control pe-theme-input" placeholder="Enter Title" required>
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
                                <label for="section">Section</label>
                                <select name="section" class="form-control pe-theme-input" required>
                                    <option value="">Select Section</option>
                                    <?php
                                    $sections = getAllRecords('sections', "ORDER BY section_name ASC");
                                    foreach ($sections as $section): ?>
                                        <option value="<?php echo $section['section_id']; ?>"><?php echo $section['section_name']; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="form-group mb-3">
                                <label for="description">Description</label>
                                <textarea name="description" class="form-control pe-theme-input" placeholder="Enter Description" required></textarea>
                            </div>
                            <div class="form-group mb-3">
                                <label for="score">Score</label>
                                <input type="number" name="score" class="form-control pe-theme-input" placeholder="Enter Score" required>
                            </div>
                            <div class="form-group mb-3">
                                <label for="due_date">Due Date</label>
                                <input type="date" name="due_date" class="form-control pe-theme-input" placeholder="Enter Due Date" required>
                            </div>
                            <div class="form-group mb-3">
                                <input type="submit" name="upload-assignment" class="btn pe-theme-btn create-btn" value="Upload Assignment">
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
                                    $assignments = getAllRecords('assignments', "ORDER BY created_at, section_id DESC");
                                    foreach ($assignments as $assignment): ?>
                                        <tr>
                                            <td><?php echo $assignment['title']; ?></td>
                                            <td><?php echo $assignment['description']; ?></td>
                                            <td><?php
                                                $section = getRecord('sections', 'section_id = ' . $assignment['section_id']);
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
                                            <td><?php echo $assignment['score']; ?></td>
                                            <td><?php echo date('F j, Y', strtotime($assignment['due_date'])); ?></td>
                                            <td>
                                                <a href="student-assignment.php?id=<?php echo $assignment['assignment_id']; ?>" class="btn pe-theme-btn-outline">View Submission</a>
                                                <a href="../../controllers/download.php?path=../uploads/assignments/<?php echo $assignment['file_location']; ?>" class="btn pe-theme-btn-outline"><i class="fas fa-download"></i> <?php echo $assignment['file_location']; ?></a>
                                                <!-- Delete Assignment Button triggers modal -->
                                                <button type="button" class="btn pe-theme-btn-alt-warning" data-bs-toggle="modal" data-bs-target="#deleteAssignmentModal<?php echo $assignment['assignment_id']; ?>">
                                                    Delete
                                                </button>



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
        <div class="row">
            <div class="col-md-12">
                <div class="card pe-theme-card">
                    <div class="card-header pe-theme-card-header">
                        <h5 class="mb-0">Recent Exam Submissions</h5>
                        <a href="teacher-exam-submission.php" class="btn btn-sm pe-theme-btn">View All</a>
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
                                        $row_class = $submission['is_graded'] ? 'graded-row' : 'pending-row';
                                    ?>
                                        <tr class="<?php echo $row_class; ?>">
                                            <td>#<?php echo $submission['student_id']; ?></td>
                                            <td><?php echo "{$student['first_name']} {$student['last_name']}"; ?></td>
                                            <td><?php echo $student_section['section_name']; ?></td>
                                            <td><?php echo $quiz['title']; ?></td>
                                            <td><?php echo date('F j, Y H:i', strtotime($submission['taken_at'])); ?></td>
                                            <td><span class="badge <?php echo $status_class; ?>"><?php echo $status_text; ?></span></td>
                                            <td><?php echo intval($student_grade); ?> / <?php echo intval($total_points); ?></td>
                                            <td>
                                                <a href="teacher-check-exam.php?student_id=<?php echo $submission['student_id']; ?>&id=<?php echo $submission['quiz_id']; ?>"
                                                    class="btn btn-sm pe-theme-btn-outline">
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

<?php foreach ($lectures as $lecture): ?>
    <!-- Delete Confirmation Modal -->
    <div class="modal fade" id="deleteLectureModal<?php echo $lecture['lecture_id']; ?>" tabindex="-1" aria-labelledby="deleteLectureLabel<?php echo $lecture['lecture_id']; ?>" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteLectureLabel<?php echo $lecture['lecture_id']; ?>">Confirm Delete</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Are you sure you want to delete this lecture: <strong><?php echo htmlspecialchars($lecture['title']); ?></strong>?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn pe-theme-btn-outline" data-bs-dismiss="modal">Cancel</button>
                    <a href="../../controllers/delete-lecture.php?id=<?php echo $lecture['lecture_id']; ?>" class="btn pe-theme-btn-alt-warning">Delete</a>
                </div>
            </div>
        </div>
    </div>
<?php endforeach; ?>

<?php foreach ($assignments as $assignment): ?>
    <!-- Delete Confirmation Modal -->
    <div class="modal fade" id="deleteAssignmentModal<?php echo $assignment['assignment_id']; ?>" tabindex="-1" aria-labelledby="deleteAssignmentLabel<?php echo $assignment['assignment_id']; ?>" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteAssignmentLabel<?php echo $assignment['assignment_id']; ?>">Confirm Delete</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Are you sure you want to delete this assignment: <strong><?php echo htmlspecialchars($assignment['title']); ?></strong>?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn pe-theme-btn-outline" data-bs-dismiss="modal">Cancel</button>
                    <a href="../../controllers/delete-assignment.php?id=<?php echo $assignment['assignment_id']; ?>" class="btn pe-theme-btn-alt-warning">Delete</a>
                </div>
            </div>
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
        document.getElementById('studentsProgress').style.width =
            `${(<?php echo $total_students; ?> / 100) * 100}%`;
        document.getElementById('examsProgress').style.width =
            `${(<?php echo $active_exams; ?> / 50) * 100}%`; // Assuming max 50 active exams
        document.getElementById('submissionsProgress').style.width =
            `${(<?php echo $submissions_today; ?> / 50) * 100}%`; // Assuming max 50 submissions
        document.getElementById('gradingProgress').style.width =
            `${(<?php echo $pending_grading; ?> / 10) * 100}%`; // Assuming max 10 pending
    }
</script>

<!-- Footer -->
<?php include 'footer.php'; ?>