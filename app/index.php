<?php
require 'includes/auth.php';

// Protección contra ataques de fuerza bruta
if (!isset($_SESSION['login_attempts'])) {
    $_SESSION['login_attempts'] = 0;
    $_SESSION['last_login_attempt'] = 0;
}

// Si hay más de 5 intentos en los últimos 15 minutos, bloquear temporalmente
if ($_SESSION['login_attempts'] >= 5 && (time() - $_SESSION['last_login_attempt']) < 900) {
    $remaining_time = 900 - (time() - $_SESSION['last_login_attempt']);
    $remaining_minutes = ceil($remaining_time / 60);
    $error_message = "Demasiados intentos fallidos. Por favor, espere $remaining_minutes minutos antes de intentar nuevamente.";
    $blocked = true;
} else if (isLoggedIn()) {
    header("Location: admin/");
    exit();
} else {
    $blocked = false;
}

// Generar token CSRF
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Gestión Empresarial</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="assets/css/main.css" rel="stylesheet">
</head>
<body class="login-page">
    <div class="login-box">
        <div class="card login-card">
            <div class="card-header login-card-header text-white">
                <div class="login-logo">
                    <i class="fas fa-building"></i>
                </div>
                <h4>Gestión Empresarial</h4>
                <p class="mb-0">Sistema de administración</p>
            </div>
            <div class="card-body login-card-body">
                <?php if (isset($blocked) && $blocked): ?>
                    <div class="alert alert-warning" role="alert">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        <?php echo htmlspecialchars($error_message, ENT_QUOTES, 'UTF-8'); ?>
                    </div>
                <?php else: ?>
                    <form id="loginForm">
                        <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($_SESSION['csrf_token'], ENT_QUOTES, 'UTF-8'); ?>">
                        <input type="hidden" name="action" value="login">
                        <div class="mb-3">
                            <label for="usuario" class="form-label">Usuario</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-user"></i></span>
                                <input type="text" class="form-control" id="usuario" name="usuario" required autofocus placeholder="Ingrese su usuario" maxlength="50">
                            </div>
                        </div>
                        <div class="mb-4">
                            <label for="password" class="form-label">Contraseña</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                <input type="password" class="form-control" id="password" name="password" required placeholder="Ingrese su contraseña" minlength="5" maxlength="100">
                                <button type="button" class="btn password-toggle" id="togglePassword">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
                        </div>
                        <div class="mb-3 form-check">
                            <input type="checkbox" class="form-check-input" id="remember" name="remember">
                            <label class="form-check-label" for="remember">Recordar mis datos</label>
                        </div>
                        <button type="submit" class="btn btn-login text-white w-100" id="loginButton">
                            <span class="spinner d-none" id="loginSpinner"></span>
                            <span>Iniciar Sesión</span>
                        </button>
                    </form>
                    <div id="loginMessage" class="alert alert-danger mt-3 d-none"></div>
                    <div class="login-footer">
                        <a href="#"><i class="fas fa-question-circle me-1"></i> ¿Olvidó su contraseña?</a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="assets/js/login.js"></script>
</body>
</html>
