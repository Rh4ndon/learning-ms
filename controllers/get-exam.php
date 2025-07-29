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
?>
            <tr class="exam-card">
                <td><?php echo $exams['title']; ?></td>
                <td><?php echo $exams['subject']; ?></td>
                <td><?php echo $exams['description']; ?></td>
                <td><?php echo $exams['time_limit']; ?></td>
                <td><?php echo $exams['created_at']; ?></td>
                <td>
                    <a href="teacher-view-exam.php?id=<?php echo $exams['quiz_id']; ?>" class="btn btn-sm pe-theme-btn-outline">View</a>
                    <?php
                    $student_answer = getAllRecords('student_answers', "WHERE quiz_id = {$exams['quiz_id']}");
                    if (empty($student_answer)) {
                        echo '<a href="teacher-edit-exam.php?id=' . $exams['quiz_id'] . '" class="btn btn-sm pe-theme-btn-alt-outline">Edit</a>';
                    }
                    ?>
                    <!-- Delete Confirmation Modal -->
                    <button type="button" class="btn btn-sm pe-theme-btn-alt-warning" data-bs-toggle="modal" data-bs-target="#deleteModal<?php echo $exams['quiz_id']; ?>">
                        Delete
                    </button>
                </td>
            </tr>

            <div class="modal fade" id="deleteModal<?php echo $exams['quiz_id']; ?>" tabindex="-1" aria-labelledby="deleteModalLabel<?php echo $exams['quiz_id']; ?>" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="deleteModalLabel<?php echo $exams['quiz_id']; ?>">Confirm Delete</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            Are you sure you want to delete this exam?
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn pe-theme-btn-outline" data-bs-dismiss="modal">Cancel</button>
                            <a href="../../controllers/delete-exam.php?id=<?php echo $exams['quiz_id']; ?>" class="btn pe-theme-btn-alt-warning">Delete</a>
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