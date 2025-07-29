    <!-- Sidebar Overlay for Mobile -->
    <div class="sidebar-overlay" id="sidebarOverlay"></div>

    <!-- Sidebar -->
    <nav id="sidebar" class="pe-theme-sidebar">
        <div class="sidebar-header p-3 text-center">
            <img src="https://img.icons8.com/color/96/000000/coach.png" alt="Coach" class="img-fluid rounded-circle mb-2">
            <h5>PE Teacher Panel</h5>
            <p class="pe-theme-text-light small"><?php echo $_SESSION['first_name'] . ' ' . $_SESSION['last_name']; ?></p>
            <button class="btn btn-sm btn-light toggle-sidebar-btn" id="closeSidebar" type="button">
                <i class="fas fa-times"></i>
            </button>
        </div>

        <ul class="list-unstyled components">
            <li class="<?php echo in_array(basename($_SERVER['PHP_SELF']), ['teacher-dashboard.php', 'teacher-exam-submission.php', 'teacher-check-exam.php']) ? 'active' : ''; ?>">
                <a href="teacher-dashboard.php"><i class="fas fa-tachometer-alt me-2"></i> Dashboard</a>
            </li>
            <li class="<?php echo basename($_SERVER['PHP_SELF']) == 'teacher-student-list.php' ? 'active' : ''; ?>">
                <a href="teacher-student-list.php"><i class="fas fa-users me-2"></i> Students</a>
            </li>
            <li class="<?php echo in_array(basename($_SERVER['PHP_SELF']), ['teacher-exams.php', 'teacher-edit-exam.php', 'teacher-view-exam.php', 'teacher-edit-question.php', 'teacher-edit-question.php']) ? 'active' : ''; ?>">
                <a href="teacher-exams.php"><i class="fas fa-file-alt me-2"></i> Exams</a>
            </li>
            <li class="<?php echo in_array(basename($_SERVER['PHP_SELF']), ['teacher-sections.php', 'teacher-edit-section.php', 'teacher-section-records.php']) ? 'active' : ''; ?>">
                <a href="teacher-sections.php"><i class="fas fa-layer-group me-2"></i> Sections</a>
            </li>
            <li>
                <a href="settings.php"><i class="fas fa-cog me-2"></i> Settings</a>
            </li>
            <li>
                <a href="../../controllers/logout.php"><i class="fas fa-sign-out-alt me-2"></i> Logout</a>
            </li>
        </ul>
    </nav>