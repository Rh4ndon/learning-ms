<!-- Bootstrap 5 JS Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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
    /*
    if (window.location.search) {
        window.history.replaceState({}, document.title, window.location.pathname);
    }
    */
    const params = new URLSearchParams(window.location.search);
    params.delete('msg');
    params.delete('error');
    params.delete('warning');
    const newQuery = params.toString();
    const newUrl = newQuery ? `${window.location.pathname}?${newQuery}` : window.location.pathname;
    window.history.replaceState({}, document.title, newUrl);

    document.addEventListener('DOMContentLoaded', function() {
        // Sidebar toggle for all pages
        $('#openSidebar').on('click', function() {
            $('#sidebar').toggleClass('active');
            $('.sidebar-overlay').toggleClass('active');

            // Prevent scrolling when sidebar is open
            if ($('#sidebar').hasClass('active')) {
                $('body').css('overflow', 'hidden');
            } else {
                $('body').css('overflow', '');
            }
        });

        // Close sidebar
        $('#closeSidebar').on('click', function() {
            $('#sidebar').removeClass('active');
            $('.sidebar-overlay').removeClass('active');
            $('body').css('overflow', '');
        });

        // Close when clicking overlay
        $('.sidebar-overlay').on('click', function() {
            $('#sidebar').removeClass('active');
            $('.sidebar-overlay').removeClass('active');
            $('body').css('overflow', '');
        });

        // Close sidebar when window is resized to desktop size
        $(window).on('resize', function() {
            if ($(window).width() > 768) {
                $('#sidebar').removeClass('active');
                $('.sidebar-overlay').removeClass('active');
                $('body').css('overflow', '');
            }
        });

        // Add active class to current nav item
        $('.components li a').on('click', function() {
            $('.components li').removeClass('active');
            $(this).parent().addClass('active');
        });
    });
</script>
<?php
if (isset($_GET['msg'])) {
    echo "<script>showAlert('{$_GET['msg']}')</script>";
}
if (isset($_GET['error'])) {
    echo "<script>showAlert('{$_GET['error']}', 'danger')</script>";
}
if (isset($_GET['warning'])) {
    echo "<script>showAlert('{$_GET['warning']}', 'warning')</script>";
}
?>
</body>

</html>