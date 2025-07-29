<select class="form-select" name="section" id="section" required>
    <option value="" disabled <?php echo (empty($currentSectionId)) ? 'selected' : ''; ?>>Select your section</option>
    <?php
    // Include the database connection and functions
    require_once '../../models/functions.php';

    // Fetch sections from the database
    $sections = getAllRecords('sections', 'ORDER BY section_name ASC');

    // Assume $currentSectionId holds the ID of the current section
    $currentSectionId = isset($_SESSION['section']) ? $_SESSION['section'] : null;

    foreach ($sections as $section) {
        $selected = ($section['section_id'] == $currentSectionId) ? 'selected' : '';
        echo '<option value="' . $section['section_id'] . '" ' . $selected . '>' . $section['section_name'] . '</option>';
    }
    ?>
</select>