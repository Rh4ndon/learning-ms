<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once '../../models/functions.php';
try {
    $records = getAllRecords('quizzes', 'ORDER BY created_at DESC');
    if (!empty($records)) {
        foreach ($records as $exams) {
            $exams['created_at'] = date('F j, Y', strtotime($exams['created_at']));
            $answers = getAllRecords('student_answers', 'WHERE quiz_id = ' . $exams['quiz_id'] . ' AND student_id = ' . $_SESSION['user_id']);
            $difficulty = ['easy', 'medium', 'hard'][array_rand([0, 1, 2])];
?>
            <div class="col-md-2 mb-4">
                <div class="card exam-card" data-difficulty="<?php echo $difficulty; ?>">
                    <div class="card-header bg-secondary d-flex justify-content-between align-items-center">
                        <h5 class="mb-0"><?php echo $exams['title']; ?> <i class="fas fa-paperclip"></i></h5>
                        <div class="exam-badge" style="animation: examCardBounce 2s infinite;"><?php echo strtoupper(substr($difficulty, 0, 1)); ?></div>
                    </div>
                    <div class="card-body">
                        <div class="mb-2">
                            <small class="text-muted">Subject:</small><br>
                            <?php echo $exams['subject']; ?>
                        </div>
                        <div class="mb-2">
                            <small class="text-muted">Description:</small><br>
                            <?php echo $exams['description']; ?>
                        </div>
                        <div class="mt-3">
                            <?php
                            if (!empty($answers) && $answers[0]['is_graded'] == 0) {
                                echo '<span class="btn btn-secondary mt-2">Pending for grading</span>';
                            } elseif (!empty($answers) && $answers[0]['is_graded'] == 1) {
                                $totalPoints = 0;
                                foreach ($answers as $answer) {
                                    $totalPoints += $answer['points_earned'];
                                }
                                echo '<span class="btn btn-success mt-2">Score: ' . $totalPoints . ' pts</span>';
                            } else { ?>
                                <a href="student-take-exam.php?id=<?php echo $exams['quiz_id']; ?>"
                                    class="btn btn-primary mt-2 take-exam-btn"
                                    onclick="playExamClickSound()">
                                    Take Exam
                                </a>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
<?php
        }
    } else {
        echo '<div class="col-12"><div class="alert alert-warning text-center">No exams found</div></div>';
    }
} catch (Exception $e) {
    echo '<div class="col-12"><div class="alert alert-danger text-center">Error: ' . $e->getMessage() . '</div></div>';
}
?>