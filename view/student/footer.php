<!-- Bootstrap 5 JS Bundle with Popper -->
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
        const openSidebarBtn = document.getElementById('openSidebar');
        const closeSidebarBtn = document.getElementById('closeSidebar');
        const sidebarOverlay = document.getElementById('sidebarOverlay');
        const sidebar = document.getElementById('sidebar');

        function toggleSidebar() {
            sidebar.classList.toggle('active');
            sidebarOverlay.classList.toggle('active');

            // Prevent scrolling when sidebar is open
            if (sidebar.classList.contains('active')) {
                document.body.style.overflow = 'hidden';
            } else {
                document.body.style.overflow = '';
            }
        }

        // Open sidebar
        openSidebarBtn.addEventListener('click', toggleSidebar);

        // Close sidebar
        closeSidebarBtn.addEventListener('click', toggleSidebar);

        // Close when clicking overlay
        sidebarOverlay.addEventListener('click', toggleSidebar);

        // Close when clicking a menu item (optional)
        const menuItems = document.querySelectorAll('.sidebar-menu a');
        menuItems.forEach(item => {
            item.addEventListener('click', function() {
                if (window.innerWidth <= 768) {
                    toggleSidebar();
                }
            });
        });

        // Close sidebar when window is resized to desktop size
        window.addEventListener('resize', function() {
            if (window.innerWidth > 768) {
                sidebar.classList.remove('active');
                sidebarOverlay.classList.remove('active');
                document.body.style.overflow = '';
            }
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