$(document).ready(function() {
    // Toggle password visibility
    $('#togglePassword').click(function() {
        const passwordInput = $('#password');
        const type = passwordInput.attr('type') === 'password' ? 'text' : 'password';
        passwordInput.attr('type', type);
        $(this).find('i').toggleClass('fa-eye fa-eye-slash');
    });
    
    // Handle form submission
    $('#loginForm').on('submit', function(e) {
        e.preventDefault();
        
        // Show loading spinner
        $('#loginSpinner').removeClass('d-none');
        $('#loginButton').prop('disabled', true);
        $('#loginMessage').addClass('d-none');
        
        // Get form data
        const formData = $(this).serialize();
        
        // Send AJAX request
        $.ajax({
            url: 'includes/auth.php',
            type: 'POST',
            data: formData + '&action=login',
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    window.location.href = response.redirect || 'admin/';
                } else {
                    $('#loginMessage').removeClass('d-none').html('<i class="fas fa-exclamation-circle me-2"></i>' + response.error);
                }
            },
            error: function(xhr, status, error) {
                $('#loginMessage').removeClass('d-none').html('<i class="fas fa-exclamation-circle me-2"></i>Error de conexión. Intente nuevamente.');
                console.log('Error AJAX:', error);
            },
            complete: function() {
                $('#loginSpinner').addClass('d-none');
                $('#loginButton').prop('disabled', false);
            }
        });
    });
    
    // Clear error message when typing
    $('#usuario, #password').on('input', function() {
        $('#loginMessage').addClass('d-none');
    });
});
