document.addEventListener('DOMContentLoaded', function() {
    // Sidebar toggle for all pages
    $('#sidebarCollapse').on('click', function() {
        $('#sidebar').toggleClass('active');
        $('#content').toggleClass('active');
    });
    
    // Login form submission
    $('#loginForm').on('submit', function(e) {
        e.preventDefault();
        const schoolId = $('#email').val();
        const password = $('#password').val();
        
        // Simple validation
        if (schoolId && password) {
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
                    if (schoolId === 'teacher') {
                        window.location.href = 'teacher.html';
                    } else {
                        window.location.href = 'student.html';
                    }
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
    
    // Initialize tooltips
    $('[data-bs-toggle="tooltip"]').tooltip();
    
    // Initialize popovers
    $('[data-bs-toggle="popover"]').popover();
    
    // Add animation to cards on scroll
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
    
    // Add pulse animation to notification bell
    setInterval(function() {
        $('.fa-bell').toggleClass('animate__animated animate__swing');
    }, 5000);
    
    // Teacher dashboard specific functionality
    if (window.location.pathname.includes('teacher.html')) {
        // Handle file upload form
        $('#uploadForm').on('submit', function(e) {
            e.preventDefault();
            // Here you would handle the actual file upload via AJAX
            $('#uploadModal').modal('hide');
            
            // Show success message
            const successAlert = `
                <div class="alert alert-success alert-dismissible fade show animate__animated animate__fadeInUp">
                    <i class="fas fa-check-circle me-2"></i> 
                    PE material uploaded successfully!
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            `;
            $('#content').prepend(successAlert);
        });
        
        // Handle quiz creation form
        $('#quizForm').on('submit', function(e) {
            e.preventDefault();
            // Here you would handle the quiz creation via AJAX
            $('#quizModal').modal('hide');
            
            // Show success message
            const successAlert = `
                <div class="alert alert-success alert-dismissible fade show animate__animated animate__fadeInUp">
                    <i class="fas fa-check-circle me-2"></i> 
                    Quiz created successfully!
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            `;
            $('#content').prepend(successAlert);
        });
    }
    
    // Student dashboard specific functionality
    if (window.location.pathname.includes('student.html')) {
        // Handle quiz taking
        $('.btn-pe-theme-btn-alt-warning').on('click', function() {
            // Here you would redirect to quiz page or show quiz modal
            const quizAlert = `
                <div class="alert alert-info alert-dismissible fade show animate__animated animate__fadeInUp">
                    <i class="fas fa-info-circle me-2"></i> 
                    Redirecting to Basketball Rules Quiz...
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            `;
            $('#content').prepend(quizAlert);
        });
    }
    
    // Add active class to current nav item
    $('.components li a').on('click', function() {
        $('.components li').removeClass('active');
        $(this).parent().addClass('active');
    });
});