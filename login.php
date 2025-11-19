<?php
session_start();

// Check if user is already logged in
if (isset($_SESSION['user_id'])) {
    // Verificar si el usuario ya tiene la sesión de administrador establecida
    $stmt = $pdo->prepare("SELECT admin_id FROM admins WHERE user_id = ?");
    $stmt->execute([$_SESSION['user_id']]);
    $admin = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($admin) {
        $_SESSION['is_admin'] = true;
        header("Location: admin.php");
    } else {
        $_SESSION['is_admin'] = false;
        $redirect = isset($_GET['redirect']) ? $_GET['redirect'] : 'index.php';
        header("Location: $redirect");
    }
    exit;
}

// Database connection
include 'conexion.php';

$errors = [];
$success = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $password = $_POST['password'];

    // Validate inputs
    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Email inválido";
    }
    if (empty($password)) {
        $errors[] = "La contraseña es obligatoria";
    }

    // If no validation errors, proceed with login
    if (empty($errors)) {
        $stmt = $pdo->prepare("SELECT user_id, username, password_hash FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            // Depuración: Verificar el hash almacenado
            error_log("Hash almacenado para $email: " . $user['password_hash']);

            if (password_verify($password, $user['password_hash'])) {
                $_SESSION['user_id'] = $user['user_id'];
                $_SESSION['username'] = $user['username'];

                // Verificar si el usuario es administrador
                $stmt = $pdo->prepare("SELECT admin_id FROM admins WHERE user_id = ?");
                $stmt->execute([$user['user_id']]);
                $admin = $stmt->fetch(PDO::FETCH_ASSOC);

                if ($admin) {
                    $_SESSION['is_admin'] = true;
                    header("Location: admin.php");
                } else {
                    $_SESSION['is_admin'] = false;
                    $redirect = isset($_GET['redirect']) ? $_GET['redirect'] : 'index.php';
                    header("Location: $redirect");
                }
                exit;
            } else {
                $errors[] = "Email o contraseña incorrectos (verificación fallida)";
                error_log("Contraseña ingresada: $password no coincide con el hash.");
            }
        } else {
            $errors[] = "Email o contraseña incorrectos (usuario no encontrado)";
            error_log("Usuario no encontrado para email: $email");
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión - LibreriaOnline</title>
    <link rel="stylesheet" href="styles/login.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
    <script defer src="../scripts/login.js"></script>
</head>
<body>
    <header>
        <div class="container header-container">
            <div class="logo">
                <i class="fas fa-book"></i>
                <span>LibreriaOnline</span>
            </div>
            <nav>
                <ul>
                    <li><a href="index.php">Inicio</a></li>
                    <li><a href="catalogo.php">Catálogo</a></li>
                    <li><a href="register.php">Registrarse</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <section class="login-section">
        <div class="container">
            <h2 class="section-title">Iniciar Sesión</h2>
            <?php if (!empty($errors)): ?>
                <div class="error-messages">
                    <?php foreach ($errors as $error): ?>
                        <p><?php echo htmlspecialchars($error); ?></p>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
            <form id="login-form" method="POST" action="login.php<?php echo isset($_GET['redirect']) ? '?redirect=' . urlencode($_GET['redirect']) : ''; ?>">
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" required>
                </div>
                <div class="form-group">
                    <label for="password">Contraseña</label>
                    <input type="password" id="password" name="password" required>
                </div>
                <button type="submit" class="btn submit-btn">Iniciar Sesión</button>
            </form>
            <p>¿No tienes cuenta? <a href="register.php">Regístrate aquí</a></p>
        </div>
    </section>
</body>
</html>