<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once '../../models/functions.php';
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $record = getRecord('quizzes', 'quiz_id = ' . $id);
    if ($record) {
?>
        <form action="../../controllers/update-exam.php?id=<?php echo $id; ?>" method="POST">
            <div class="form-group mb-3">
                <label for="title">Title</label>
                <input type="text" name="title" class="form-control" placeholder="Enter Title" value="<?php echo $record['title']; ?>" required>
            </div>
            <div class="form-group mb-3">
                <label for="subject">Subject</label>
                <input type="text" name="subject" class="form-control" placeholder="Enter Subject" value="<?php echo $record['subject']; ?>" required>
            </div>
            <div class="form-group mb-3">
                <label for="time">Time</label>
                <input type="number" name="time" class="form-control" placeholder="Enter time in minutes" value="<?php echo $record['time_limit']; ?>" min="1" max="120" required>
            </div>
            <div class="form-group mb-3">
                <label for="description">Description</label>
                <textarea name="description" class="form-control" placeholder="Enter Description" required><?php echo $record['description']; ?></textarea>
            </div>
            <div class="form-group mb-3">
                <input type="submit" name="update-exam" class="btn btn-primary" value="Update">
                <a href="teacher-exams.php" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
<?php
    } else {
        echo '<div class="alert alert-danger">Exam not found.</div>';
    }
} else {
    echo '<div class="alert alert-danger">Invalid request.</div>';
}
?>