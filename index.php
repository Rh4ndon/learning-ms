<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PE LMS - Login</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <!-- Animate.css -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Condensed:wght@700&family=Open+Sans&display=swap" rel="stylesheet">
    <!-- Custom CSS -->
    <style>
        /* PE Theme Colors */
        :root {
            --pe-primary: #2E7D32;
            /* Dark green */
            --pe-secondary: #43A047;
            /* Medium green */
            --pe-accent: #FFC107;
            /* Gold/yellow */
            --pe-light: #E8F5E9;
            /* Light green */
            --pe-dark: #1B5E20;
            /* Very dark green */
            --pe-text: #2E7D32;
            --pe-text-light: #E8F5E9;
            --pe-badge: #43A047;
            --pe-badge-alt: #00796B;
            /* Teal */
        }

        /* General Styles */
        body {
            font-family: 'Open Sans', sans-serif;
            background-color: #f8f9fa;
            overflow-x: hidden;
        }

        h1,
        h2,
        h3,
        h4,
        h5,
        h6 {
            font-family: 'Roboto Condensed', sans-serif;
        }

        .min-vh-100 {
            min-height: 100vh;
        }

        /* PE Theme Background */
        .pe-theme-bg {
            background-color: var(--pe-light);
            background-image: linear-gradient(rgba(232, 245, 233, 0.9), rgba(232, 245, 233, 0.9)),
                url('view/assets/images/vecteezy_empty-school-gym-with-sports-equipment_16265476.jpg');
            background-size: cover;
            background-attachment: fixed;
            background-position: center;
        }

        /* PE Theme Text */
        .pe-theme-text {
            color: var(--pe-primary);
        }

        .pe-theme-text-light {
            color: var(--pe-text-light);
        }

        .pe-theme-text-warning {
            color: #FF8F00;
            /* Darker yellow */
        }

        /* PE Theme Cards */
        .pe-theme-card {
            background-color: white;
            border: none;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(46, 125, 50, 0.1);
            transition: all 0.3s;
        }

        .pe-theme-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(46, 125, 50, 0.15);
        }

        /* PE Theme Buttons */
        .pe-theme-btn {
            background-color: var(--pe-primary);
            color: white;
            border: none;
            transition: all 0.3s;
        }

        .pe-theme-btn:hover {
            background-color: var(--pe-dark);
            color: white;
            transform: translateY(-2px);
        }

        .pe-theme-btn-outline {
            background-color: transparent;
            color: var(--pe-primary);
            border: 1px solid var(--pe-primary);
            transition: all 0.3s;
        }

        .pe-theme-btn-outline:hover {
            background-color: var(--pe-primary);
            color: white;
        }

        /* PE Theme Inputs */
        .pe-theme-input {
            border: 1px solid var(--pe-primary);
            transition: all 0.3s;
        }

        .pe-theme-input:focus {
            border-color: var(--pe-dark);
            box-shadow: 0 0 0 0.25rem rgba(46, 125, 50, 0.25);
        }

        /* Custom Animations */
        @keyframes pulse {
            0% {
                transform: scale(1);
            }

            50% {
                transform: scale(1.05);
            }

            100% {
                transform: scale(1);
            }
        }

        .pulse-animation {
            animation: pulse 2s infinite;
        }
    </style>
</head>
<?php
session_start();
// Check if the user is logged in
if (isset($_SESSION['is_logged_in'])) {
    // User is logged in, do nothing
    if ($_SESSION['is_admin'] == 1) {
        header('Location: view/teacher/teacher-dashboard.php');
        exit();
    } else {
        header('Location: view/student/student-dashboard.php');
        exit();
    }
}
?>

<body class="pe-theme-bg">
    <div class="container">
        <div class="row justify-content-center align-items-center min-vh-100">
            <div class="col-md-6 col-lg-5 animate__animated animate__fadeIn">
                <div class="card shadow-lg pe-theme-card">
                    <div class="card-body p-5">
                        <div class="text-center mb-4">
                            <img src="https://img.icons8.com/color/96/000000/basketball.png" alt="PE Logo" class="img-fluid mb-3 animate__animated animate__bounceIn">
                            <h2 class="fw-bold pe-theme-text">Physical Education LMS</h2>
                            <p class="text-muted">Train your mind and body</p>
                        </div>

                        <form action="controllers/login.php" method="POST">
                            <div class="mb-3">
                                <label for="email" class="form-label">Email address</label>
                                <div class="input-group">
                                    <span class="input-group-text pe-theme-input"><i class="fas fa-envelope"></i></span>
                                    <input type="email" class="form-control pe-theme-input" name="email" id="email" placeholder="name@example.com" required>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <div class="input-group">
                                    <span class="input-group-text pe-theme-input"><i class="fas fa-lock"></i></span>
                                    <input type="password" class="form-control pe-theme-input" name="password" id="password" placeholder="Password" required>
                                    <button class="btn btn-outline-secondary pe-theme-input" type="button" id="togglePassword">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="d-grid gap-2">
                                <button type="submit" name="login" class="btn pe-theme-btn btn-lg animate__animated animate__pulse animate__infinite animate__slower">
                                    <i class="fas fa-sign-in-alt me-2"></i> Launch
                                </button>
                            </div>
                        </form>

                        <div class="login-options mt-4 pt-3 border-top">
                            <p class="text-center text-muted">New explorer?</p>
                            <div class="d-grid gap-2">
                                <a href="register.php" class="btn pe-theme-btn-outline btn-lg animate__animated animate__fadeInUp">
                                    <i class="fas fa-rocket me-2"></i>Begin Adventure
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Show alert
        function showAlert(message, type = 'success') {
            // Remove existing alert if any
            let existingAlert = document.querySelector('.floating-alert');
            if (existingAlert) {
                existingAlert.remove();
            }

            // Create the alert element
            let alertDiv = document.createElement('div');
            alertDiv.className = `alert alert-${type} alert-dismissible fade show floating-alert`;
            alertDiv.setAttribute('role', 'alert');
            alertDiv.innerHTML = `
                <strong>${type === 'success' ? 'Success!' : type === 'warning' ? 'Warning!' : 'Error!'}</strong> ${message}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            `;

            // Apply floating styles
            alertDiv.style.position = 'fixed';
            alertDiv.style.top = '20px';
            alertDiv.style.right = '20px';
            alertDiv.style.zIndex = '1050';

            // Append to body
            document.body.appendChild(alertDiv);

            // Auto remove after 5 seconds
            setTimeout(() => {
                alertDiv.classList.remove('show');
                setTimeout(() => alertDiv.remove(), 300);
            }, 7000);
        }

        // Remove ?msg or ?error from URL
        if (window.location.search) {
            window.history.replaceState({}, document.title, window.location.pathname);
        }

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

        <?php
        if (isset($_GET['msg'])) {
            echo "showAlert('{$_GET['msg']}')";
        }
        if (isset($_GET['error'])) {
            echo "showAlert('{$_GET['error']}', 'danger')";
        }
        if (isset($_GET['warning'])) {
            echo "showAlert('{$_GET['warning']}', 'warning')";
        }
        ?>
    </script>
</body>

</html>