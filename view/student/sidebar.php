    <!-- Sidebar Overlay for Mobile -->
    <div class="sidebar-overlay" id="sidebarOverlay"></div>

    <!-- Sidebar -->
    <nav id="sidebar" class="pe-theme-sidebar">
        <div class="sidebar-header p-3 text-center">
            <img src="https://img.icons8.com/color/96/000000/student-male.png" alt="Student" class="img-fluid rounded-circle mb-2">
            <h5 class="pe-theme-text-light">Student Panel</h5>
            <p class="pe-theme-text-light small"><?php echo $_SESSION['first_name'] . ' ' . $_SESSION['last_name'] . ' - ' . $student_section['section_name']; ?></p>
            <button class="btn btn-sm pe-theme-btn-alt toggle-sidebar-btn" id="closeSidebar" type="button">
                <i class="fas fa-times"></i>
            </button>
        </div>

        <ul class="list-unstyled components">
            <li class="<?php echo in_array(basename($_SERVER['PHP_SELF']), ['student-dashboard.php', 'student-review-exam.php']) ? 'active' : ''; ?>">
                <a href="student-dashboard.php"><i class="fas fa-tachometer-alt me-2"></i> Dashboard</a>
            </li>
            <li class="<?php echo in_array(basename($_SERVER['PHP_SELF']), ['student-exams.php', 'student-take-exam.php']) ? 'active' : ''; ?>">
                <a href="student-exams.php"><i class="fas fa-file-alt me-2"></i> Quizzes</a>
            </li>
            <li>
                <a href="settings.php"><i class="fas fa-cog me-2"></i> Settings</a>
            </li>
            <li>
                <a href="../../controllers/logout.php"><i class="fas fa-sign-out-alt me-2"></i> Logout</a>
            </li>
        </ul>
    </nav>