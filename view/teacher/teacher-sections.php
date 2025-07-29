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
            <div class="col-12">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb pe-theme-breadcrumb">
                        <li class="breadcrumb-item"><a href="teacher-dashboard.php" class="pe-theme-link">Dashboard</a></li>
                        <li class="breadcrumb-item active">Sections</li>
                    </ol>
                </nav>
            </div>
        </div>

        <!-- Creation Section -->
        <div class="row mt-4">
            <div class="col-md-3 mb-4">
                <div class="card creation-card pe-theme-card">
                    <div class="card-header creation-header">
                        <h5 class="mb-0">Create Section<i class="fas fa-pencil-alt"></i></h5>
                        <div class="creation-badge">New</div>
                    </div>
                    <div class="card-body">
                        <form action="../../controllers/create-section.php" method="POST" id="examCreationForm">
                            <div class="form-group mb-3">
                                <label for="section_name">Section Name</label>
                                <input type="text" name="section_name" class="form-control pe-theme-input" placeholder="Enter Section Name" required>
                            </div>

                            <div class="creation-progress">
                                <div class="creation-progress-bar" id="creationProgress"></div>
                            </div>
                            <div class="form-group mb-3">
                                <input type="submit" name="create-section" class="btn pe-theme-btn create-btn" value="Create Section">
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-md-9">
                <div class="card pe-theme-card">
                    <div class="card-header pe-theme-card-header">
                        <h5 class="mb-0">Sections <i class="fas fa-folder"></i></h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover pe-theme-table">
                                <thead>
                                    <tr>
                                        <th>Section Name</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php include '../../controllers/get-section.php'; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
foreach ($records as $section) { ?>
    <div class="modal fade" id="deleteModal<?php echo $section['section_id']; ?>" tabindex="-1" aria-labelledby="deleteModalLabel<?php echo $section['section_id']; ?>" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel<?php echo $section['section_id']; ?>">Confirm Delete</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Are you sure you want to delete this section?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn pe-theme-btn-outline" data-bs-dismiss="modal">Cancel</button>
                    <a href="../../controllers/delete-section.php?id=<?php echo $section['section_id']; ?>" class="btn pe-theme-btn-alt-warning">Delete</a>
                </div>
            </div>
        </div>
    </div>

<?php } ?>

<script>
    // Initialize
    document.addEventListener('DOMContentLoaded', function() {
        // Set up form progress
        setupFormProgress();
    });

    // Set up form progress tracking
    function setupFormProgress() {
        const formInputs = document.querySelectorAll('#examCreationForm input');
        const progressBar = document.getElementById('creationProgress');

        formInputs.forEach(input => {
            input.addEventListener('input', () => {
                let filledFields = 0;
                formInputs.forEach(field => {
                    if (field.value.trim() !== '') {
                        filledFields++;
                    }
                });

                const progress = (filledFields / formInputs.length) * 100;
                progressBar.style.width = `${progress}%`;
            });
        });
    }
</script>

<!-- Footer -->
<?php include 'footer.php'; ?>