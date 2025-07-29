<?php include '../../controllers/sessions.php'; ?>

<!-- Header -->
<?php include 'header.php'; ?>

<!-- Sidebar -->
<?php include 'sidebar.php'; ?>

<style>
    /* PE Theme styles for exam cards */
    .exam-list-container .exam-card {
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
        border-radius: 8px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        height: 100%;
    }

    .exam-list-container .exam-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 15px rgba(0, 0, 0, 0.1);
    }

    .exam-list-container .card-header {
        position: relative;
        padding: 0.75rem 1.25rem;
    }

    .exam-list-container .take-exam-btn {
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }

    .exam-list-container .take-exam-btn:hover {
        transform: scale(1.05);
    }

    /* Animation keyframes */
    @keyframes examCardBounce {

        0%,
        100% {
            transform: translateY(0);
        }

        50% {
            transform: translateY(-5px);
        }
    }

    @keyframes examPulse {
        0% {
            box-shadow: 0 0 0 0 rgba(0, 123, 255, 0.7);
        }

        70% {
            box-shadow: 0 0 0 10px rgba(0, 123, 255, 0);
        }

        100% {
            box-shadow: 0 0 0 0 rgba(0, 123, 255, 0);
        }
    }
</style>

<!-- Main Content -->
<div class="main-content">
    <!-- Top Navbar -->
    <?php include 'top-navbar.php'; ?>

    <!-- Dashboard Content -->
    <div class="container-fluid exam-list-container">
        <!-- Exams Table -->
        <div class="row mt-4">
            <?php include '../../controllers/get-student-exam.php'; ?>
        </div>
    </div>
</div>

<!-- Footer -->
<?php include 'footer.php'; ?>