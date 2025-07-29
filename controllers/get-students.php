<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once '../../models/functions.php';
try {
    $records = getAllRecords('users', 'WHERE is_admin = 0 ORDER BY last_name ASC');
    if (!empty($records)) {
        // First loop: Output all table rows
        foreach ($records as $student) {
            $student['created_at'] = date('F j, Y', strtotime($student['created_at']));
            if ($student['section_id'] == null) {
                $student['section_id'] = 0;
            }
            $section = getAllRecords('sections', 'WHERE section_id = ' . $student['section_id']);
?>
            <tr class="exam-card">
                <td><?php echo $student['last_name']; ?></td>
                <td><?php echo $student['first_name']; ?></td>
                <td><?php echo $student['email']; ?></td>
                <td>
                    <?php
                    if (!empty($section)) {
                        echo $section[0]['section_name'];
                    } else {
                        echo 'No Section';
                    }
                    ?>
                </td>
                <td>
                    <!-- Delete button with data attributes -->
                    <button type="button" class="btn btn-sm pe-theme-btn-alt-warning" data-bs-toggle="modal" data-bs-target="#deleteModal<?php echo $student['user_id']; ?>">
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