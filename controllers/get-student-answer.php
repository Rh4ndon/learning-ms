<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once '../../models/functions.php';

if (!isset($_GET['id'])) {
    echo '<script>window.location.href="teacher-exams.php";</script>';
}

$quiz_id = $_GET['id'];
$student_id = $_GET['student_id'];

$exam = getRecord('quizzes', 'quiz_id = ' . $quiz_id);
$student = getRecord('users', 'user_id = ' . $student_id);
?>

<div class="card-header pe-theme-card-header d-flex justify-content-between align-items-center">
    <h5 class="mb-0">Exam: <?php echo $exam['title']; ?>, Subject: <?php echo $exam['subject']; ?>, Student: <?php echo $student['first_name'] . ' ' . $student['last_name']; ?> <i class="fas fa-clipboard-question"></i></h5>
</div>
<form id="gradeForm" method="post" action="../../controllers/submit-grade.php">
    <input type="hidden" name="quiz_id" value="<?php echo $quiz_id; ?>">
    <input type="hidden" name="student_id" value="<?php echo $student_id; ?>">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover pe-theme-table" id="exam">
                <thead>
                    <tr>
                        <th>Question</th>
                        <th>Type</th>
                        <th>Points</th>
                        <th>Options</th>
                        <th>Correct Answer</th>
                        <th>Points Earned</th>
                    </tr>
                </thead>

                <tbody>
                    <?php
                    try {
                        $records = getAllRecords('questions', 'WHERE quiz_id = ' . $quiz_id);
                        if (!empty($records)) {
                            foreach ($records as $questions) {
                                $options = getAllRecords('question_options', 'WHERE question_id = ' . $questions['question_id']);
                                $student_answer = getAllRecords('student_answers', 'WHERE question_id = ' . $questions['question_id'] . ' AND student_id = ' . $student_id);

                    ?>
                                <tr>
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

                                    <td>

                                        <?php
                                        $student_answer = getAllRecords('student_answers', 'WHERE question_id = ' . $questions['question_id'] . ' AND student_id = ' . $student_id);
                                        if ($questions['question_type'] == 'short_text' && $student_answer[0]['points_earned'] == 0) {
                                            echo "<input type='number' class='form-control pe-theme-input' name='points_earned" . $questions['question_id'] . "'  min='0' max='" . $questions['points'] . "' required>";
                                        } else {
                                            echo intval($student_answer[0]['points_earned']) . ' / ' . $questions['points'];
                                        }

                                        ?>

                                    </td>
                                </tr>


                            <?php
                            } ?>
                            <tr class="table-secondary">
                                <td><strong>Total Points Earned:</strong></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td>
                                    <strong>
                                        <?php
                                        $total_points = 0;
                                        foreach ($records as $record) {
                                            $student_answer = getAllRecords('student_answers', 'WHERE question_id = ' . $record['question_id'] . ' AND student_id = ' . $student_id);
                                            $total_points += intval($student_answer[0]['points_earned']);
                                        }
                                        echo $total_points . ' / ' . array_sum(array_column($records, 'points'));
                                        ?>
                                    </strong>
                                </td>
                            </tr>

                    <?php        } else {
                            echo '<tr><td colspan="5" class="text-center">No records found</td></tr>';
                        }
                    } catch (Exception $e) {
                        echo '<tr><td colspan="5" class="text-center text-danger">Error: ' . $e->getMessage() . '</td></tr>';
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>

    <div class="card-footer bg-white dont-print">
        <div class="d-flex justify-content-between">
            <button type="button" class="btn pe-theme-btn-outline" onclick="window.history.back()">
                <i class="fas fa-arrow-left mr-2"></i>Back
            </button>
            <?php
            $student_records = getAllRecords('student_answers', 'WHERE quiz_id = ' . $quiz_id . ' AND student_id = ' . $student_id);
            if ($student_records[0]['is_graded'] == 0) {
            ?>
                <button type="submit" name="submit-exam" class="btn pe-theme-btn">
                    <i class="fas fa-paper-plane mr-2"></i> Submit Grade
                </button>
            <?php
            } else { ?>
                <div>
                    <button type="button" id="printExam" class="btn pe-theme-btn">
                        <i class="fas fa-print mr-2"></i> Print Exam
                    </button>
                    <button type="button" id="downloadExcel" class="btn pe-theme-btn-alt">
                        <i class="fas fa-download mr-2"></i> Download Exam
                    </button>
                </div>


            <?php } ?>
        </div>
    </div>
</form>