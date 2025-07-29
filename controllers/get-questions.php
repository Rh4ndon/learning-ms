<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once '../../models/functions.php';

if (!isset($_GET['id'])) {
    echo '<script>window.location.href="teacher-exams.php";</script>';
}

$quiz_id = $_GET['id'];

$exam = getRecord('quizzes', 'quiz_id = ' . $quiz_id);

?>

<div class="card-header bg-white d-flex justify-content-between align-items-center">
    <h5 class="mb-0">Title: <?php echo $exam['title']; ?>, Subject: <?php echo $exam['subject']; ?> <i class="fas fa-clipboard-question"></i></h5>
    <!--a href="#" class="btn btn-sm btn-outline-primary">View All</!--a-->
</div>
<div class="card-body">
    <div class="table-responsive">
        <table class="table table-hover">
            <thead>
                <tr>

                    <th>Question</th>
                    <th>Type</th>
                    <th>Points</th>
                    <th>Options</th>
                    <th>Action</th>
                </tr>
            </thead>

            <tbody>
                <?php
                try {
                    $records = getAllRecords('questions', 'WHERE quiz_id = ' . $quiz_id);
                    if (!empty($records)) {
                        foreach ($records as $questions) {
                            $options = getAllRecords('question_options', 'WHERE question_id = ' . $questions['question_id']);

                ?>
                            <tr class="exam-card">
                                <td><?php echo $questions['question_text']; ?></td>
                                <td><?php echo $questions['question_type'] == 'multiple_choice' ? 'Multiple Choice' : ($questions['question_type'] == 'true_false' ? 'True/False' : 'Short Answer'); ?></td>
                                <td><?php echo $questions['points']; ?></td>
                                <td>
                                    <?php
                                    if ($questions['question_type'] == 'multiple_choice') {
                                        foreach ($options as $option) {
                                            echo '<div class="form-check">';
                                            if ($option['is_correct'] == 1) {
                                                echo '<input class="form-check-input" type="radio" name="options' . $option['option_id'] . '" id="option' . $option['option_id'] . '" value="' . $option['option_text'] . '" checked disabled>';
                                            } else {
                                                echo '<input class="form-check-input" type="radio" name="options' . $option['option_id'] . '" id="option' . $option['option_id'] . '" value="' . $option['option_text'] . '" disabled>';
                                            }

                                            echo '<label class="form-check-label" for="option' . $option['option_id'] . '">' . $option['option_text'] . '</label>';
                                            echo '</div>';
                                        }
                                    } elseif ($questions['question_type'] == 'true_false') {
                                        foreach ($options as $option) {
                                            echo '<div class="form-check">';
                                            if ($option['is_correct'] == 1) {
                                                echo '<input class="form-check-input" type="radio" name="options' . $option['option_id'] . '" id="option' . $option['option_id'] . '" value="' . $option['option_text'] . '" checked disabled>';
                                            } else {
                                                echo '<input class="form-check-input" type="radio" name="options' . $option['option_id'] . '" id="option' . $option['option_id'] . '" value="' . $option['option_text'] . '" disabled>';
                                            }
                                            echo '<label class="form-check-label" for="option' . $option['option_id'] . '">' . $option['option_text'] . '</label>';
                                            echo '</div>';
                                        }
                                    } else {
                                        echo 'N/A';
                                    }
                                    ?>
                                </td>
                                <td>
                                    <a href="teacher-edit-question.php?id=<?php echo $questions['question_id']; ?>" class="btn btn-sm btn-outline-primary">Edit</a>

                                    <!-- Delete Confirmation Modal -->
                                    <button type="button" class="btn btn-sm btn-outline-danger" data-bs-toggle="modal" data-bs-target="#deleteModal<?php echo $questions['question_id']; ?>">
                                        Delete
                                    </button>




                                </td>
                            </tr>

                            <div class="modal fade" id="deleteModal<?php echo $questions['question_id']; ?>" tabindex="-1" aria-labelledby="deleteModalLabel<?php echo $questions['question_id']; ?>" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="deleteModalLabel<?php echo $questions['question_id']; ?>">Confirm Delete</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            Are you sure you want to delete this exam question?
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                            <a href="../../controllers/delete-question.php?id=<?php echo $questions['question_id']; ?>&quiz_id=<?php echo $quiz_id; ?>" class="btn btn-danger">Delete</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                <?php
                        }
                    } else {
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