<!-- Session Check -->
<?php include '../../controllers/sessions.php'; ?>

<!-- Header -->
<?php include 'header.php'; ?>

<!-- Sidebar -->
<?php include 'sidebar.php'; ?>

<!-- Main Content -->
<div class="main-content">
    <!-- Top Navbar -->
    <?php include 'top-navbar.php'; ?>

    <!-- Dashboard Content -->
    <div class="container-fluid">
        <!-- Main Content Row -->
        <div class="row mt-4 justify-content-center">
            <div class="col-md-8">
                <div class="card pe-theme-card">
                    <div class="card-header pe-theme-card-header">
                        <h5 class="mb-0">Account Settings</h5>
                    </div>
                    <div class="card-body">
                        <form action="../../controllers/update-user.php" method="POST">
                            <input type="hidden" name="id" value="<?php echo $_SESSION['user_id']; ?>">
                            <input type="hidden" name="role" value="<?php echo $_SESSION['is_admin']; ?>">
                            <div class="mb-3">
                                <label for="first_name" class="form-label">First Name</label>
                                <div class="input-group">
                                    <span class="input-group-text pe-theme-badge-alt"><i class="fas fa-user"></i></span>
                                    <input type="text" class="form-control pe-theme-input" name="first_name" id="first_name" placeholder="Enter your First_name" required value="<?php echo $_SESSION['first_name']; ?>">
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="last_name" class="form-label">Last Name</label>
                                <div class="input-group">
                                    <span class="input-group-text pe-theme-badge-alt"><i class="fas fa-user"></i></span>
                                    <input type="text" class="form-control pe-theme-input" name="last_name" id="last_name" placeholder="Enter your Last_name" required value="<?php echo $_SESSION['last_name']; ?>">
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">Email address</label>
                                <div class="input-group">
                                    <span class="input-group-text pe-theme-badge-alt"><i class="fas fa-envelope"></i></span>
                                    <input type="email" class="form-control pe-theme-input" name="email" id="email" placeholder="name@example.com" required value="<?php echo $_SESSION['email']; ?>">
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="section" class="form-label">Section</label>
                                <div class="input-group">
                                    <span class="input-group-text pe-theme-badge-alt"><i class="fas fa-book"></i></span>
                                    <?php include '../../controllers/get-section-settings.php'; ?>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <div class="input-group">
                                    <span class="input-group-text pe-theme-badge-alt"><i class="fas fa-lock"></i></span>
                                    <input type="password" class="form-control pe-theme-input" name="password" id="password" placeholder="Enter your password or your new password" required>
                                    <button class="btn pe-theme-btn-outline" type="button" id="togglePassword">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </div>
                            </div>

                            <div class="d-grid">
                                <button type="submit" name="update" class="btn pe-theme-btn">Save Changes</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Footer -->
<script>
    // Toggle password visibility
    document.getElementById('togglePassword').addEventListener('click', function() {
        const password = document.getElementById('password');
        const icon = this.querySelector('i');
        if (password.type === 'password') {
            password.type = 'text';
            icon.classList.remove('fa-eye');
            icon.classList.add('fa-eye-slash');
        } else {
            password.type = 'password';
            icon.classList.remove('fa-eye-slash');
            icon.classList.add('fa-eye');
        }
    });
</script>
<?php include 'footer.php'; ?>