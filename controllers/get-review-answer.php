<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once '../../models/functions.php';

if (!isset($_GET['id'])) {
    echo '<script>window.location.href="student-exams.php";</script>';
}

$quiz_id = $_GET['id'];
$student_id = $_GET['student_id'];

$exam = getRecord('quizzes', 'quiz_id = ' . $quiz_id);
$student = getRecord('users', 'user_id = ' . $student_id);
?>

<div class="card-header bg-white d-flex justify-content-between align-items-center">
    <h5 class="mb-0">Exam: <?php echo $exam['title']; ?>, Subject: <?php echo $exam['subject']; ?>, Student: <?php echo $student['first_name'] . ' ' . $student['last_name']; ?> <i class="fas fa-clipboard-question"></i></h5>
    <?php
    $records = getAllRecords('questions', 'WHERE quiz_id = ' . $quiz_id);
    $total_possible = array_sum(array_column($records, 'points'));
    $total_earned = 0;
    foreach ($records as $record) {
        $student_answer = getAllRecords('student_answers', 'WHERE question_id = ' . $record['question_id'] . ' AND student_id = ' . $student_id);
        $total_earned += intval($student_answer[0]['points_earned']);
    }
    $percentage = round(($total_earned / $total_possible) * 100);
    ?>
    <div class="performance-badge">
        <?php echo $percentage; ?>% Score
    </div>
</div>

<!-- Progress bar -->
<div class="exam-progress mx-3">
    <div class="exam-progress-bar" id="examProgressBar" style="width: <?php echo $percentage; ?>%"></div>
</div>

<form id="gradeForm" method="post" action="../../controllers/submit-grade.php">
    <input type="hidden" name="quiz_id" value="<?php echo $quiz_id; ?>">
    <input type="hidden" name="student_id" value="<?php echo $student_id; ?>">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Question</th>
                        <th>Type</th>
                        <th>Points</th>
                        <th>Your Answers</th>
                        <th>Correct Answers</th>
                        <th>Points Earned</th>
                    </tr>
                </thead>

                <tbody>
                    <?php
                    try {
                        if (!empty($records)) {
                            foreach ($records as $questions) {
                                $options = getAllRecords('question_options', 'WHERE question_id = ' . $questions['question_id']);
                                $student_answer = getAllRecords('student_answers', 'WHERE question_id = ' . $questions['question_id'] . ' AND student_id = ' . $student_id);
                                $is_correct = ($student_answer[0]['points_earned'] == $questions['points']);
                    ?>
                                <tr class="<?php echo $is_correct ? 'correct-answer' : 'incorrect-answer'; ?>">
                                    <td><?php echo $questions['question_text']; ?></td>
                                    <td><?php echo $questions['question_type'] == 'multiple_choice' ? 'Multiple Choice' : ($questions['question_type'] == 'true_false' ? 'True/False' : 'Short Answer'); ?></td>
                                    <td><?php echo $questions['points']; ?></td>
                                    <td>
                                        <?php
                                        if ($questions['question_type'] == 'multiple_choice' || $questions['question_type'] == 'true_false') {
                                            foreach ($options as $option) {
                                                echo '<div class="form-check">';
                                                if ($option['option_id'] == $student_answer[0]['option_id']) {
                                                    echo '<input class="form-check-input" type="radio" checked disabled>';
                                                    echo '<label class="form-check-label">' . $option['option_text'] . '</label>';
                                                } else {
                                                    echo '<input class="form-check-input" type="radio" disabled>';
                                                    echo '<label class="form-check-label text-muted">' . $option['option_text'] . '</label>';
                                                }
                                                echo '</div>';
                                            }
                                        } else {
                                            echo $student_answer[0]['answer_text'];
                                        }
                                        ?>
                                    </td>
                                    <td>
                                        <?php
                                        if ($questions['question_type'] == 'multiple_choice' || $questions['question_type'] == 'true_false') {
                                            foreach ($options as $option) {
                                                if ($option['is_correct'] == 1) {
                                                    echo '<div class="form-check">';
                                                    echo '<input class="form-check-input" type="radio" checked disabled>';
                                                    echo '<label class="form-check-label font-weight-bold">' . $option['option_text'] . '</label>';
                                                    echo '</div>';
                                                }
                                            }
                                        } else {
                                            echo '<em>Manual grading required</em>';
                                        }
                                        ?>
                                    </td>
                                    <td class="points-earned">
                                        <?php
                                        if ($questions['question_type'] == 'short_text' && $student_answer[0]['points_earned'] == 0) {
                                            echo "Not yet graded";
                                        } else {
                                            echo intval($student_answer[0]['points_earned']) . ' / ' . $questions['points'];
                                        }
                                        ?>
                                    </td>
                                </tr>
                            <?php } ?>
                            <tr class="total-points">
                                <td><strong>Total Points Earned:</strong></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td>
                                    <strong>
                                        <?php echo $total_earned . ' / ' . $total_possible; ?>
                                    </strong>
                                </td>
                            </tr>
                    <?php } else {
                            echo '<tr><td colspan="6" class="text-center">No records found</td></tr>';
                        }
                    } catch (Exception $e) {
                        echo '<tr><td colspan="6" class="text-center text-danger">Error: ' . $e->getMessage() . '</td></tr>';
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
            <button type="button" class="btn btn-primary" id="showFeedbackBtn">
                <i class="fas fa-comment-alt mr-2"></i>Show Feedback
            </button>
        </div>
    </div>
</form>

<!-- Feedback Ribbon -->
<div class="feedback-ribbon" id="feedbackRibbon">
    <i class="fas fa-star mr-2"></i>
    <span id="feedbackMessage">Great job! You scored <?php echo $percentage; ?>%</span>
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
                Are you sure you want to submit student's Grade? You cannot change them after submission.
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-success" id="confirmSubmit">Submit</button>
            </div>
        </div>
    </div>
</div>