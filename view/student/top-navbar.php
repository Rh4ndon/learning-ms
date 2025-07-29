<nav class="navbar navbar-expand-lg navbar-light pe-theme-navbar shadow-sm">
    <div class="container-fluid">
        <button type="button" id="openSidebar" class="btn pe-theme-btn-alt">
            <i class="fas fa-bars"></i>
        </button>

        <?php
        $pageName = basename($_SERVER['PHP_SELF'], '.php');
        $formattedPageName = ucwords(str_replace('-', ' ', $pageName));
        ?>
        <h4 class="mb-0 page-name pe-theme-text">
            <?php echo $formattedPageName; ?>
        </h4>

        <div class="ms-auto d-flex align-items-center">
            <div class="dropdown">
                <button class="btn pe-theme-btn-outline-alt dropdown-toggle" type="button" id="userDropdown" data-bs-toggle="dropdown">
                    <i class="fas fa-user-circle me-1"></i> <?php echo $_SESSION['first_name'] . ' ' . $_SESSION['last_name']; ?>
                </button>
                <ul class="dropdown-menu dropdown-menu-end pe-theme-dropdown">
                    <li><a class="dropdown-item" href="settings.php"><i class="fas fa-cog me-2"></i> Settings</a></li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>
                    <li><a class="dropdown-item" href="../../controllers/logout.php"><i class="fas fa-sign-out-alt me-2"></i> Logout</a></li>
                </ul>
            </div>
        </div>
    </div>
</nav>