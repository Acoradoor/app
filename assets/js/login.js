$(document).ready(function() {
    $('#loginForm').submit(function(e) {
        e.preventDefault();
        
        const btn = $(this).find('button[type="submit"]');
        const originalText = btn.html();
        
        btn.prop('disabled', true).html(`
            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
            Procesando...
        `);
        
        $.ajax({
            url: 'includes/auth.php',
            type: 'POST',
            data: {
                action: 'login',
                usuario: $('#usuario').val(),
                password: $('#password').val()
            },
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    window.location.href = 'admin/';
                } else {
                    $('#loginMessage').text(response.error || 'Credenciales incorrectas').removeClass('d-none');
                }
            },
            error: function() {
                $('#loginMessage').text('Error de conexión').removeClass('d-none');
            },
            complete: function() {
                btn.prop('disabled', false).html(originalText);
            }
        });
    });
});