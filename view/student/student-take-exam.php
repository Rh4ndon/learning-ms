<!-- Session Check -->
<?php include '../../controllers/sessions.php'; ?>

<!-- Header -->
<?php include 'header.php'; ?>

<!-- Sidebar -->
<?php include 'sidebar.php'; ?>

<!-- Main Content -->
<div class="main-content">
    <!-- Top Navbar -->
    <?php include 'top-navbar.php'; ?>

    <!-- Dashboard Content -->
    <div class="container-fluid">
        <!-- Exams Table -->
        <div class="row mt-4">
            <div class="col-md-12">
                <div class="card pe-theme-card">
                    <div class="card-header pe-theme-card-header">
                        <h5 class="mb-0">Take Exam</h5>
                    </div>
                    <div class="card-body">
                        <?php include '../../controllers/get-student-questions.php'; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal for confirmation -->
    <div class="modal fade" id="submitConfirmationModal" tabindex="-1" aria-labelledby="submitConfirmationModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="submitConfirmationModalLabel">Confirm Submission</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Are you sure you want to submit your answers? You cannot change them after submission.
                    <div class="mt-3">
                        <p>You've earned <span id="modalXpCount">0</span> XP in this exam!</p>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-success" id="confirmSubmit">Submit</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Floating feedback -->
    <div class="floating-feedback" id="floatingFeedback">
        <i class="fas fa-check-circle mr-2"></i>
        <span id="feedbackText">Great job! +10 XP</span>
    </div>


    <script>
        // Gamification variables
        let xp = 0;
        let streak = localStorage.getItem('examStreak') ? parseInt(localStorage.getItem('examStreak')) : 0;
        let answeredQuestions = 0;
        const totalQuestions = document.querySelectorAll('.question-row').length;
        // Track which questions have been answered to prevent double-counting
        const answeredQuestionIds = new Set();

        // Timer variables
        let timeLeft = <?php echo $exam['time_limit']; ?> * 60; // Convert minutes to seconds
        let timerInterval;

        // DOM elements
        const xpCountElement = document.getElementById('xpCount');
        const streakCountElement = document.getElementById('streakCount');
        const progressBar = document.getElementById('progressBar');
        const examTimer = document.getElementById('examTimer');
        const floatingFeedback = document.getElementById('floatingFeedback');
        const feedbackText = document.getElementById('feedbackText');
        const modalXpCount = document.getElementById('modalXpCount');

        // Initialize the page
        document.addEventListener('DOMContentLoaded', () => {
            // Initialize XP and streak
            updateXpCounter();
            updateStreakCounter();

            // Start timer
            startTimer();

            // Set up form submission
            const form = document.getElementById('examForm');
            const modal = new bootstrap.Modal('#submitConfirmationModal');

            form.addEventListener('submit', (e) => {
                e.preventDefault();
                // Calculate estimated XP based on answered questions
                const estimatedXp = Math.floor((answeredQuestions / totalQuestions) * 100);
                modalXpCount.textContent = estimatedXp;
                modal.show();
            });

            document.getElementById('confirmSubmit').addEventListener('click', () => {
                // Update streak when submitting
                updateStreak();
                form.submit();
            });

            // Set up radio button change events
            document.querySelectorAll('input[type="radio"]').forEach(radio => {
                radio.addEventListener('change', function() {
                    const questionId = this.name.match(/\[(\d+)\]/)[1];

                    // Only count if this question wasn't answered before
                    if (!answeredQuestionIds.has(questionId)) {
                        answeredQuestions++;
                        answeredQuestionIds.add(questionId);
                        updateProgressBar();

                        // Simulate XP gain
                        const questionRow = this.closest('.question-row');
                        const difficulty = questionRow.dataset.difficulty;

                        let xpGain = 0;
                        switch (difficulty) {
                            case 'easy':
                                xpGain = 10;
                                break;
                            case 'medium':
                                xpGain = 20;
                                break;
                            case 'hard':
                                xpGain = 30;
                                break;
                        }

                        xp += xpGain;
                        updateXpCounter();

                        // Show floating feedback
                        showFeedback(`Great job! +${xpGain} XP`);
                    }

                    // Play sound regardless of whether it's new or changed answer
                    playSelectionSound();
                });
            });

            // Set up textarea change events
            document.querySelectorAll('textarea').forEach(textarea => {
                textarea.addEventListener('input', function() {
                    const questionId = this.name.match(/_(\d+)/)[1];

                    // Only count if this question wasn't answered before and has content
                    if (!answeredQuestionIds.has(questionId) && this.value.trim() !== '') {
                        answeredQuestions++;
                        answeredQuestionIds.add(questionId);
                        updateProgressBar();

                        // Simulate XP gain
                        const questionRow = this.closest('.question-row');
                        const difficulty = questionRow.dataset.difficulty;

                        let xpGain = 0;
                        switch (difficulty) {
                            case 'easy':
                                xpGain = 10;
                                break;
                            case 'medium':
                                xpGain = 20;
                                break;
                            case 'hard':
                                xpGain = 30;
                                break;
                        }

                        xp += xpGain;
                        updateXpCounter();

                        // Show floating feedback
                        showFeedback(`Great job! +${xpGain} XP`);
                    }

                    // If textarea is cleared, remove from answered questions
                    if (this.value.trim() === '' && answeredQuestionIds.has(questionId)) {
                        answeredQuestions--;
                        answeredQuestionIds.delete(questionId);
                        updateProgressBar();
                    }
                });
            });
        });

        function updateXpCounter() {
            xpCountElement.textContent = xp;
        }

        function updateStreakCounter() {
            streakCountElement.textContent = streak;
        }

        function updateStreak() {
            streak++;
            localStorage.setItem('examStreak', streak);
            updateStreakCounter();
        }

        function updateProgressBar() {
            const progress = (answeredQuestions / totalQuestions) * 100;
            progressBar.style.width = `${progress}%`;
        }

        function startTimer() {
            updateTimerDisplay();
            timerInterval = setInterval(() => {
                timeLeft--;
                updateTimerDisplay();

                if (timeLeft <= 0) {
                    clearInterval(timerInterval);
                    // Auto-submit the form when time is up
                    document.getElementById('examForm').submit();
                }
            }, 1000);
        }

        function updateTimerDisplay() {
            const minutes = Math.floor(timeLeft / 60);
            const seconds = timeLeft % 60;
            examTimer.textContent = `${minutes}:${seconds < 10 ? '0' : ''}${seconds}`;

            // Change color when time is running low
            if (timeLeft <= 5 * 60) { // 5 minutes left
                examTimer.style.color = '#ff6b6b';
            }
        }

        function showFeedback(message) {
            feedbackText.textContent = message;
            floatingFeedback.classList.add('show');

            setTimeout(() => {
                floatingFeedback.classList.remove('show');
            }, 3000);
        }

        function playSelectionSound() {
            new Audio('../assets/sounds/small-win.mp3').play().catch(e => {
                console.log("Audio playback failed:", e);
            });
        }
    </script>
</div>

<!-- Footer -->
<?php include 'footer.php'; ?>