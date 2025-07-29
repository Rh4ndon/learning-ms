<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once '../../models/functions.php';
try {
    $records = getAllRecords('sections', 'ORDER BY section_name ASC');
    if (!empty($records)) {
        foreach ($records as $section) {

?>
            <tr class="exam-card">
                <td><?php echo $section['section_name']; ?></td>

                <td>

                    <!-- View Records -->
                    <a href="teacher-section-records.php?id=<?php echo $section['section_id']; ?>" class="btn btn-sm pe-theme-btn-outline">View Records</a>
                    <a href="teacher-edit-section.php?id=<?php echo $section['section_id']; ?>" class="btn btn-sm pe-theme-btn-alt-outline">Edit</a>


                    <!-- Delete Confirmation Modal -->
                    <button type="button" class="btn btn-sm pe-theme-btn-alt-warning" data-bs-toggle="modal" data-bs-target="#deleteModal<?php echo $section['section_id']; ?>">
                        Delete
                    </button>




                </td>
            </tr>


<?php
        }
    } else {
        echo '<tr><td colspan="5" class="text-center">No records found</td></tr>';
    }
} catch (Exception $e) {
    echo '<tr><td colspan="5" class="text-center text-danger">Error: ' . $e->getMessage() . '</td></tr>';
}
?>