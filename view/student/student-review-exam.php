<?php include '../../controllers/sessions.php'; ?>

<!-- Header -->
<?php include 'header.php'; ?>

<!-- Sidebar -->
<?php include 'sidebar.php'; ?>

<style>
    /* PE Theme styles for exam review */
    .exam-review-container .card {
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    }

    .exam-review-container .card-header {
        position: relative;
        background: linear-gradient(135deg, var(--pe-primary), var(--pe-secondary));
        color: white;
    }

    .exam-review-container .performance-badge {
        position: absolute;
        top: -10px;
        right: 20px;
        background: var(--pe-accent);
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

    .exam-review-container .table {
        border-collapse: separate;
        border-spacing: 0 10px;
    }

    .exam-review-container tr {
        transition: all 0.3s ease;
        background: white;
        border-radius: 8px;
        overflow: hidden;
    }

    .exam-review-container tr:hover {
        transform: translateY(-3px);
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
    }

    .exam-review-container .correct-answer {
        background-color: rgba(40, 167, 69, 0.1);
        border-left: 4px solid #28a745;
    }

    .exam-review-container .incorrect-answer {
        background-color: rgba(220, 53, 69, 0.1);
        border-left: 4px solid #dc3545;
    }

    .exam-review-container .points-earned {
        font-weight: bold;
        font-size: 1.1rem;
    }

    .exam-review-container .total-points {
        background: linear-gradient(135deg, #f8f9fa, #e9ecef);
        font-size: 1.2rem;
    }

    /* Progress indicator */
    .exam-progress {
        height: 8px;
        background: #e9ecef;
        border-radius: 4px;
        margin: 15px 0;
        overflow: hidden;
    }

    .exam-progress-bar {
        height: 100%;
        background: linear-gradient(90deg, var(--pe-primary), var(--pe-secondary));
        width: 0%;
        transition: width 1s ease;
    }

    /* Feedback ribbon */
    .feedback-ribbon {
        position: fixed;
        bottom: 20px;
        left: 50%;
        transform: translateX(-50%);
        background: rgba(0, 0, 0, 0.8);
        color: white;
        padding: 10px 25px;
        border-radius: 5px;
        z-index: 1000;
        opacity: 0;
        transition: opacity 0.5s ease;
    }

    .feedback-ribbon.show {
        opacity: 1;
    }
</style>

<!-- Main Content -->
<div class="main-content exam-review-container">
    <!-- Top Navbar -->
    <?php include 'top-navbar.php'; ?>

    <!-- Dashboard Content -->
    <div class="container-fluid">
        <!-- Exams Table -->
        <div class="row mt-4">
            <div class="col-md-12">
                <div class="card pe-theme-card">
                    <div class="card-header pe-theme-card-header">
                        <h5 class="mb-0">Exam Review</h5>
                    </div>
                    <div class="card-body">
                        <?php include '../../controllers/get-review-answer.php'; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Footer -->
<?php include 'footer.php'; ?>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        // Initialize modal
        const form = document.getElementById('gradeForm');
        const modal = new bootstrap.Modal('#submitConfirmationModal');
        const feedbackRibbon = document.getElementById('feedbackRibbon');
        const showFeedbackBtn = document.getElementById('showFeedbackBtn');

        // Form submission handling
        form.addEventListener('submit', (e) => {
            e.preventDefault();
            modal.show();
        });

        document.getElementById('confirmSubmit').addEventListener('click', () => {
            form.submit();
        });

        // Show feedback ribbon
        showFeedbackBtn.addEventListener('click', () => {
            const percentage = <?php echo $percentage; ?>;
            let message = '';

            if (percentage >= 90) {
                message = 'Excellent work! You aced this exam with ' + percentage + '%';
            } else if (percentage >= 70) {
                message = 'Good job! You scored ' + percentage + '% - well done!';
            } else if (percentage >= 50) {
                message = 'You passed with ' + percentage + '% - keep improving!';
            } else {
                message = 'You got ' + percentage + '% - review the materials to improve!';
            }

            document.getElementById('feedbackMessage').textContent = message;
            feedbackRibbon.classList.add('show');

            setTimeout(() => {
                feedbackRibbon.classList.remove('show');
            }, 5000);
        });

        // Animate progress bar on load
        setTimeout(() => {
            document.getElementById('examProgressBar').style.width = '<?php echo $percentage; ?>%';
        }, 500);
    });
</script>