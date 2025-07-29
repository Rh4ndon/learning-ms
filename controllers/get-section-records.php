<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once '../../models/functions.php';

$section_id = $_GET['id'] ?? 0;
$section_records = getAllRecords('sections', 'WHERE section_id = ' . $section_id);


?>

<div class="col-md-12">
    <div class="card">
        <div class="card-header bg-white d-flex justify-content-between align-items-center">
            <h5 class="mb-0"><?php echo $section_records[0]['section_name']; ?> Records <i class="fas fa-pencil"></i></h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Exam Name</th>
                            <th>Student Takes</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        try {
                            $records = getAllRecords('quizzes');
                            if (!empty($records)) {
                                foreach ($records as $record) {
                                    // Count distinct students who have any graded answers

                                    $student_answers = getAllRecords(
                                        'student_answers sa JOIN users u ON sa.student_id = u.user_id',
                                        "WHERE sa.quiz_id = {$record['quiz_id']} 
                                     AND sa.is_graded = '1' 
                                     AND u.section_id = {$section_id}
                                     AND u.is_admin = '0'
                                     GROUP BY sa.student_id"
                                    );
                                    $student_count = count($student_answers);

                                    $student_section_count = count(getAllRecords(
                                        'users',
                                        "WHERE section_id = {$section_id} AND is_admin = '0'"
                                    ));
                        ?>
                                    <tr class="exam-card">
                                        <td><?php echo $record['title']; ?></td>
                                        <td><?php echo $student_count; ?> / <?php echo $student_section_count; ?></td>
                                        <td>
                                            <?php if ($student_count == $student_section_count): ?>
                                                <a href="../../controllers/get_quiz_results.php?id=<?php echo $section_id ?>&export_excel=1&quiz_id=<?= $record['quiz_id'] ?>"
                                                    class="btn btn-sm btn-outline-info">
                                                    Download Records
                                                </a>
                                            <?php else: ?>
                                                Ensure all students have completed the exam before downloading.
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                        <?php
                                }
                            } else {
                                echo '<tr><td colspan="3" class="text-center">No records found</td></tr>';
                            }
                        } catch (Exception $e) {
                            echo '<tr><td colspan="3" class="text-center text-danger">Error: ' . $e->getMessage() . '</td></tr>';
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>