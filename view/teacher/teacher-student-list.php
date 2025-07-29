<!-- Session Check -->
<?php include '../../controllers/sessions.php'; ?>

<!-- Header -->
<?php include 'header.php'; ?>

<!-- Sidebar -->
<?php include 'sidebar.php'; ?>

<style>
    /* Scoped gamification styles */
    .exam-creation-container .creation-card {
        transition: all 0.3s ease;
        border-radius: 10px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        background: linear-gradient(135deg, #f8f9fa, #ffffff);
    }

    .exam-creation-container .creation-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
    }

    .exam-creation-container .creation-header {
        background: linear-gradient(135deg, #2E7D32, #43A047);
        color: white;
        border-radius: 10px 10px 0 0 !important;
    }

    .exam-creation-container .creation-badge {
        position: absolute;
        top: -10px;
        right: 20px;
        background: gold;
        color: #333;
        padding: 5px 15px;
        border-radius: 20px;
        font-weight: bold;
        box-shadow: 0 3px 10px rgba(0, 0, 0, 0.2);
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

    .exam-creation-container .create-btn {
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }

    .exam-creation-container .create-btn:hover {
        transform: scale(1.05);
    }

    .exam-creation-container .create-btn::after {
        content: '';
        position: absolute;
        top: -50%;
        left: -50%;
        width: 200%;
        height: 200%;
        background: rgba(255, 255, 255, 0.2);
        transform: rotate(30deg);
        transition: all 0.5s ease;
    }

    .exam-creation-container .create-btn:hover::after {
        left: 100%;
    }

    /* Exam cards */
    .exam-creation-container .exam-card {
        transition: all 0.3s ease;
        border-left: 4px solid #2E7D32;
    }

    .exam-creation-container .exam-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
    }

    /* Progress indicator */
    .creation-progress {
        height: 8px;
        background: #e9ecef;
        border-radius: 4px;
        margin: 15px 0;
        overflow: hidden;
    }

    .creation-progress-bar {
        height: 100%;
        background: linear-gradient(90deg, #2E7D32, #43A047);
        width: 0%;
        transition: width 1s ease;
    }
</style>

<!-- Main Content -->
<div class="main-content exam-creation-container">
    <!-- Top Navbar -->
    <?php include 'top-navbar.php'; ?>

    <!-- Dashboard Content -->
    <div class="container-fluid animate__animated animate__fadeIn">
        <!-- Breadcrumb -->
        <div class="row mb-4">

        </div>

        <!-- Student List Section -->
        <div class="row mt-4">
            <div class="col-md-12">
                <div class="card pe-theme-card">
                    <div class="card-header pe-theme-card-header">
                        <h5 class="mb-0">Student List <i class="fas fa-graduation-cap"></i></h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover pe-theme-table">
                                <thead>
                                    <tr>
                                        <th>Last Name</th>
                                        <th>First Name</th>
                                        <th>Email</th>
                                        <th>Section</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php include '../../controllers/get-students.php'; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>


                    </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
</div>

<?php // Second loop: Output all modals AFTER the table
foreach ($records as $student) {
?>
    <!-- Modal placed outside the table -->
    <div class="modal fade" id="deleteModal<?php echo $student['user_id']; ?>" tabindex="-1" aria-labelledby="deleteModalLabel<?php echo $student['user_id']; ?>" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel<?php echo $student['user_id']; ?>">Confirm Delete</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Are you sure you want to delete this student?
                    <br>
                    <strong><?php echo $student['first_name'] . ' ' . $student['last_name']; ?></strong>
                    <br>
                    All data associated with this student will be permanently deleted.
                    <br>
                    <strong>This action cannot be undone.</strong>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn pe-theme-btn-outline" data-bs-dismiss="modal">Cancel</button>
                    <a href="../../controllers/delete-student.php?id=<?php echo $student['user_id']; ?>" class="btn pe-theme-btn-alt-warning">Delete</a>
                </div>
            </div>
        </div>
    </div>
<?php
}
?>

<!-- Footer -->
<?php include 'footer.php'; ?>