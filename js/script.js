document.addEventListener('DOMContentLoaded', function() {
    // Sidebar toggle
    $('#sidebarCollapse').on('click', function() {
        $('#sidebar').toggleClass('active');
        $('#content').toggleClass('active');
    });
    
    // Login form submission
    $('#loginForm').on('submit', function(e) {
        e.preventDefault();
        const email = $('#email').val();
        const password = $('#password').val();
        
        // Simple validation
        if (email && password) {
            // Show loading animation
            const btn = $(this).find('button[type="submit"]');
            btn.html('<i class="fas fa-spinner fa-spin me-2"></i> Authenticating...');
            btn.prop('disabled', true);
            
            // Simulate authentication
            setTimeout(function() {
                // This is just for demo - actual auth will be handled by backend
                btn.html('<i class="fas fa-sign-in-alt me-2"></i> Login');
                btn.prop('disabled', false);
                
                // Add animation to simulate successful login
                $('.card').addClass('animate__animated animate__fadeOut');
                setTimeout(function() {
                    // Redirect based on user type (demo only)
                    // In real app, backend would determine user role
                    window.location.href = 'student.html';
                }, 500);
            }, 1500);
        } else {
            // Add shake animation to form for validation error
            $('.card').addClass('animate__animated animate__headShake');
            setTimeout(function() {
                $('.card').removeClass('animate__animated animate__headShake');
            }, 1000);
        }
    });
    
    // Dashboard cards animation on scroll
    const animateOnScroll = function() {
        const windowTop = $(window).scrollTop() + $(window).height();
        
        $('.animate-on-scroll').each(function() {
            const elementTop = $(this).offset().top;
            
            if (elementTop < windowTop) {
                $(this).addClass('animate__animated animate__fadeInUp');
            }
        });
    };
    
    $(window).on('scroll', animateOnScroll);
    animateOnScroll();
    
    // Tooltip initialization
    $('[data-bs-toggle="tooltip"]').tooltip();
    
    // Popover initialization
    $('[data-bs-toggle="popover"]').popover();
    
    // Course card hover effect
    $('.course-card').hover(
        function() {
            $(this).addClass('shadow');
        },
        function() {
            $(this).removeClass('shadow');
        }
    );
    
    // Add pulse animation to notification bell
    setInterval(function() {
        $('.fa-bell').toggleClass('animate__animated animate__swing');
    }, 5000);
});