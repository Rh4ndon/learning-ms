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


<div class="card shadow-sm">
    <div class="card-header bg-primary text-white">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h4 class="mb-0"><i class="fas fa-clipboard-list mr-2"></i> <?php echo htmlspecialchars($exam['title']); ?></h4>
                <small class="d-block mt-1">Subject: <?php echo htmlspecialchars($exam['subject']); ?></small>
            </div>
            <!--div class="badge badge-light py-2 px-3">
                <i class="fas fa-clock mr-1"></i> Time: 30 mins
            </!--div-->
        </div>
    </div>

    <form id="examForm" method="post" action="../../controllers/submit-exam.php">
        <input type="hidden" name="quiz_id" value="<?php echo $quiz_id; ?>">
        <input type="hidden" name="student_id" value="<?php echo $_SESSION['user_id']; ?>">

        <div class="card-body">
            <div class="alert alert-info">
                <i class="fas fa-info-circle mr-2"></i> Read each question carefully and select the best answer.
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
                        <?php
                        try {
                            $questions = getAllRecords('questions', 'WHERE quiz_id = ' . $quiz_id);
                            shuffle($questions); // Shuffle questions for randomness
                            if (!empty($questions)) {
                                $questionNumber = 1;
                                foreach ($questions as $question) {
                                    $options = getAllRecords('question_options', 'WHERE question_id = ' . $question['question_id']);
                        ?>
                                    <tr>
                                        <td class="text-center font-weight-bold"><?php echo $questionNumber; ?></td>
                                        <td><?php echo htmlspecialchars($question['question_text']); ?></td>

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
                                                          value="' . $option['option_text'] . '" required>';
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
                                                          value="' . $option['option_text'] . '" required>';
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
                <button type="submit" name="submit-exam" class="btn btn-success px-4">
                    <i class="fas fa-paper-plane mr-2"></i> Submit Exam
                </button>
            </div>
        </div>
    </form>

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
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-success" id="confirmSubmit">Submit</button>
            </div>
        </div>
    </div>
</div>

<script>
    // Pure JavaScript solution for Bootstrap 5
    document.addEventListener('DOMContentLoaded', () => {
        const form = document.getElementById('examForm');
        const modal = new bootstrap.Modal('#submitConfirmationModal');

        form.addEventListener('submit', (e) => {
            e.preventDefault();
            modal.show();
        });

        document.getElementById('confirmSubmit').addEventListener('click', () => {
            form.submit();
        });
    });
</script>