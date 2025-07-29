<?php
require_once '../../models/functions.php';
$student_answer = getAllRecords('student_answers', "WHERE quiz_id = " . $_GET['id']);
if (empty($student_answer)) {
    echo '<input type="submit" name="create-question" class="btn btn-primary create-btn" value="Create">';
} else {
    echo '<input type="submit" name="create-question" class="btn btn-primary create-btn" value="Create" disabled>';
}
