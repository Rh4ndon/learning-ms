<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once '../../models/functions.php';
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $record = getRecord('sections', 'section_id = ' . $id);
    if ($record) {
?>
        <form action="../../controllers/update-section.php?id=<?php echo $id; ?>" method="POST">
            <div class="form-group mb-3">
                <label for="section_name">Section Name</label>
                <input type="text" name="section_name" class="form-control" placeholder="Enter Section Name" value="<?php echo $record['section_name']; ?>" required>
            </div>

            <div class="form-group mb-3">
                <input type="submit" name="update-section" class="btn btn-primary" value="Update">
                <a href="teacher-sections.php" class="btn btn-secondary">Cancel</a>
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