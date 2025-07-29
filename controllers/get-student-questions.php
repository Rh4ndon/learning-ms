<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once '../../models/functions.php';

if (!isset($_GET['id'])) {
    echo '<script>window.location.href="student-exams.php";</script>';
}

$quiz_id = $_GET['id'];
$exam = getRecord('quizzes', 'quiz_id = ' . $quiz_id);

?>

<style>
    /* Animation styles */
    @keyframes questionAppear {
        0% {
            transform: translateY(20px);
            opacity: 0;
        }

        100% {
            transform: translateY(0);
            opacity: 1;
        }
    }

    .question-row {
        animation: questionAppear 0.5s ease forwards;
        opacity: 0;
    }

    /* Answer selection effects */
    .form-check-input:checked+.form-check-label {
        font-weight: bold;
        color: #4b6cb7;
    }

    .form-check-input:checked {
        transform: scale(1.1);
    }

    /* Submit button animation */
    .pulse {
        animation: pulse 1.5s infinite;
    }

    @keyframes pulse {
        0% {
            box-shadow: 0 0 0 0 rgba(40, 167, 69, 0.7);
        }

        70% {
            box-shadow: 0 0 0 10px rgba(40, 167, 69, 0);
        }

        100% {
            box-shadow: 0 0 0 0 rgba(40, 167, 69, 0);
        }
    }

    /* Gamification elements */
    .gamification-row {
        background-color: #f8f9fa;
        font-weight: bold;
    }

    .progress-container {
        height: 8px;
        background: #e0e0e0;
        border-radius: 4px;
        margin-bottom: 10px;
    }

    .progress-bar {
        height: 100%;
        background: linear-gradient(90deg, #4b6cb7, #182848);
        width: 0%;
        transition: width 0.3s ease;
        border-radius: 4px;
    }

    .xp-counter,
    .streak-counter,
    .timer-container {
        display: inline-flex;
        align-items: center;
        background: rgba(0, 0, 0, 0.05);
        color: #495057;
        padding: 5px 10px;
        border-radius: 20px;
        font-size: 0.9rem;
        margin-right: 10px;
    }

    .xp-counter i {
        color: gold;
        margin-right: 5px;
    }

    .streak-counter i {
        color: #ff6b6b;
        margin-right: 5px;
    }

    .timer-container i {
        margin-right: 5px;
    }

    .gamification-stats {
        display: flex;
        flex-wrap: wrap;
        margin-bottom: 10px;
    }

    /* Difficulty indicator */
    .difficulty-indicator {
        display: inline-block;
        margin-left: 10px;
        font-size: 0.8em;
    }

    .difficulty-easy {
        color: #28a745;
    }

    .difficulty-medium {
        color: #ffc107;
    }

    .difficulty-hard {
        color: #dc3545;
    }

    /* Floating feedback */
    .floating-feedback {
        position: fixed;
        bottom: 20px;
        right: 20px;
        background: rgba(0, 0, 0, 0.8);
        color: white;
        padding: 10px 15px;
        border-radius: 5px;
        z-index: 1000;
        transform: translateY(100px);
        transition: transform 0.3s ease;
    }

    .floating-feedback.show {
        transform: translateY(0);
    }
</style>

<div class="card shadow-sm">
    <div class="card-header bg-primary text-white">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h4 class="mb-0"><i class="fas fa-clipboard-list mr-2"></i> <?php echo htmlspecialchars($exam['title']); ?></h4>
                <small class="d-block mt-1">Subject: <?php echo htmlspecialchars($exam['subject']); ?></small>
            </div>
        </div>
    </div>

    <form id="examForm" method="post" action="../../controllers/submit-exam.php">
        <input type="hidden" name="quiz_id" value="<?php echo $quiz_id; ?>">
        <input type="hidden" name="student_id" value="<?php echo $_SESSION['user_id']; ?>">

        <div class="card-body">
            <div class="alert alert-info">
                <i class="fas fa-info-circle mr-2"></i> Read each question carefully and select the best answer. Earn XP for correct answers!
            </div>

            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead class="thead-light">
                        <tr>
                            <th style="width: 5%">#</th>
                            <th style="width: 45%">Question</th>
                            <th style="width: 10%">Points</th>
                            <th style="width: 30%">Your Answer</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Gamification Status Row -->
                        <tr class="gamification-row">
                            <td colspan="4">
                                <div class="gamification-stats">
                                    <div class="xp-counter">
                                        <i class="fas fa-star"></i>
                                        <span id="xpCount">0</span> XP
                                    </div>
                                    <div class="streak-counter">
                                        <i class="fas fa-fire"></i>
                                        <span id="streakCount">0</span> Day Streak
                                    </div>
                                    <div class="timer-container">
                                        <i class="fas fa-clock"></i>
                                        <span id="examTimer">30:00</span>
                                    </div>
                                </div>
                                <div class="progress-container">
                                    <div class="progress-bar" id="progressBar"></div>
                                </div>
                            </td>
                        </tr>

                        <?php
                        try {
                            $questions = getAllRecords('questions', 'WHERE quiz_id = ' . $quiz_id);
                            shuffle($questions); // Shuffle questions for randomness
                            if (!empty($questions)) {
                                $questionNumber = 1;
                                foreach ($questions as $question) {
                                    $options = getAllRecords('question_options', 'WHERE question_id = ' . $question['question_id']);
                                    // Add random difficulty for gamification
                                    $difficulties = ['easy', 'medium', 'hard'];
                                    $difficulty = $difficulties[array_rand($difficulties)];
                        ?>
                                    <tr class="question-row" style="animation-delay: <?php echo $questionNumber * 0.1; ?>s" data-difficulty="<?php echo $difficulty; ?>">
                                        <td class="text-center font-weight-bold"><?php echo $questionNumber; ?></td>
                                        <td>
                                            <?php echo htmlspecialchars($question['question_text']); ?>
                                            <span class="difficulty-indicator difficulty-<?php echo $difficulty; ?>">
                                                <i class="fas fa-<?php
                                                                    echo $difficulty == 'easy' ? 'smile' : ($difficulty == 'medium' ? 'meh' : 'frown');
                                                                    ?>"></i>
                                                <?php echo ucfirst($difficulty); ?>
                                            </span>
                                        </td>

                                        <td class="text-center"><?php echo $question['points']; ?></td>
                                        <td>
                                            <?php
                                            if ($question['question_type'] == 'multiple_choice') {
                                                shuffle($options); // Shuffle options for randomness
                                                foreach ($options as $option) {
                                                    echo '<div class="form-check mb-2">';
                                                    echo '<input class="form-check-input" type="radio" 
                                                          name="answer[' . $question['question_id'] . ']" 
                                                          id="option_' . $option['option_id'] . '" 
                                                          value="' . $option['option_text'] . '" required
                                                          onchange="playSelectionSound()">';
                                                    echo '<input type="hidden" name="question_id_' . $question['question_id'] . '" value="' . $question['question_id'] . '">';
                                                    echo '<input type="hidden" name="option_id_' . $option['option_id'] . '" value="' . $option['option_id'] . '">';
                                                    echo '<label class="form-check-label" for="option_' . $option['option_id'] . '">';
                                                    echo htmlspecialchars($option['option_text']);
                                                    echo '</label>';
                                                    echo '</div>';
                                                }
                                            } elseif ($question['question_type'] == 'true_false') {
                                                foreach ($options as $option) {
                                                    echo '<div class="form-check mb-2">';
                                                    echo '<input class="form-check-input" type="radio" 
                                                          name="answer[' . $question['question_id'] . ']" 
                                                          id="option_' . $option['option_id'] . '" 
                                                          value="' . $option['option_text'] . '" required
                                                          onchange="playSelectionSound()">';
                                                    echo '<input type="hidden" name="question_id_' . $question['question_id'] . '" value="' . $question['question_id'] . '">';
                                                    echo '<input type="hidden" name="option_id_' . $option['option_id'] . '" value="' . $option['option_id'] . '">';
                                                    echo '<label class="form-check-label" for="option_' . $option['option_id'] . '">';
                                                    echo htmlspecialchars($option['option_text']);
                                                    echo '</label>';
                                                    echo '</div>';
                                                }
                                            } else {
                                                echo '<textarea class="form-control" name="answer_text_' . $question['question_id'] . '" 
                                                      rows="2" placeholder="Type your answer here..." required></textarea>';
                                                echo '<input type="hidden" name="question_id_' . $question['question_id'] . '" value="' . $question['question_id'] . '">';
                                            }
                                            ?>
                                        </td>
                                    </tr>
                        <?php
                                    $questionNumber++;
                                }
                            } else {
                                echo '<tr><td colspan="5" class="text-center text-muted py-4">No questions found for this exam</td></tr>';
                            }
                        } catch (Exception $e) {
                            echo '<tr><td colspan="5" class="text-center text-danger py-4">Error: ' . htmlspecialchars($e->getMessage()) . '</td></tr>';
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="card-footer bg-white">
            <div class="d-flex justify-content-between">
                <button type="button" class="btn btn-outline-secondary" onclick="window.history.back()">
                    <i class="fas fa-arrow-left mr-2"></i>Back
                </button>
                <button type="submit" name="submit-exam" class="btn btn-success px-4 pulse">
                    <i class="fas fa-paper-plane mr-2"></i> Submit Exam
                </button>
            </div>
        </div>
    </form>
</div>