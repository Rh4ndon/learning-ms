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
        background: linear-gradient(135deg, #6e8efb, #a777e3);
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

    /* Sound Controls */
    .creation-sound-control {
        position: fixed;
        bottom: 20px;
        right: 20px;
        z-index: 1000;
        background: rgba(0, 0, 0, 0.7);
        color: white;
        border-radius: 50%;
        width: 50px;
        height: 50px;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    }

    /* Achievement Notification */
    .creation-achievement-notification {
        position: fixed;
        bottom: 80px;
        right: 20px;
        background: linear-gradient(135deg, #6e8efb, #a777e3);
        color: white;
        padding: 15px 20px;
        border-radius: 8px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
        z-index: 1000;
        transform: translateX(200%);
        transition: transform 0.5s ease;
        display: flex;
        align-items: center;
        max-width: 300px;
    }

    .creation-achievement-notification.show {
        transform: translateX(0);
    }

    /* Exam cards */
    .exam-creation-container .exam-card {
        transition: all 0.3s ease;
        border-left: 4px solid #6e8efb;
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
        background: linear-gradient(90deg, #4b6cb7, #182848);
        width: 0%;
        transition: width 1s ease;
    }
</style>
<!-- Main Content -->
<div class="main-content exam-creation-container">
    <!-- Top Navbar -->
    <?php include 'top-navbar.php'; ?>

    <!-- Dashboard Content -->
    <div class="container-fluid">




        <!-- Exams Table -->
        <div class="row mt-4">

            <div class="col-md-3 mb-4">
                <div class="card creation-card">
                    <div class="card-header creation-header">
                        <h5 class="mb-0">Edit Section <i class="fas fa-pencil-alt"></i></h5>
                        <div class="creation-badge">Update</div>
                    </div>
                    <div class="card-body">
                        <?php include '../../controllers/get-edit-section.php'; ?>

                    </div>
                </div>
            </div>


        </div>


    </div>
</div>


<!-- Footer -->
<?php include 'footer.php'; ?>