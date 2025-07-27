<?php
require_once __DIR__ . "/config/session.php";
require_once $_SESSION["ROOT_PATH"] . "/config/db.php";
// require_once $_SESSION["ROOT_PATH"] . "/includes/auth.php";

// Si ya hay sesión activa, redirige
if (isset($_SESSION['usuario'])) {
    header("Location: index.php");
    exit();
}

require_once "config/db.php";
$error = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usuario  = trim($_POST['usuario'] ?? '');
    $password = $_POST['password'] ?? '';

    // Consulta preparada
    $stmt = $conn->prepare("SELECT id, usuario, password, rol, nombre, apellidos, validado FROM usuarios WHERE usuario = ?");
    $stmt->bind_param("s", $usuario);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result && $result->num_rows === 1) {
        $row = $result->fetch_assoc();

        if (password_verify($password, $row['password'])) {
            // Guardar datos en sesión, sin bloquear por validado
            $_SESSION['id_usuario'] = $row['id'];
            $_SESSION['usuario']    = $row['usuario'];
            $_SESSION['rol']        = $row['rol'];
            $_SESSION['nombre']     = $row['nombre'];
            $_SESSION['apellidos']  = $row['apellidos'];
            $_SESSION['validado']   = $row['validado'];

            header("Location: index.php");
            exit();
        } else {
            $error = "Contraseña incorrecta.";
        }
    } else {
        $error = "Usuario no encontrado.";
    }

    $stmt->close();
    $conn->close();
}
?>


<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Acceso</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">
    <div class="container mt-5">
        <div class="mx-auto" style="max-width: 400px;">
            <div class="bg-white p-4 rounded shadow">
                <h3 class="mb-4">🔐 Iniciar Sesión</h3>

                <?php if ($error): ?>
                    <div class="alert alert-danger"><?= $error ?></div>
                <?php endif; ?>

                <form method="POST">
                    <div class="mb-3">
                        <label class="form-label">Usuario</label>
                        <input type="text" name="usuario" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Contraseña</label>
                        <input type="password" name="password" class="form-control" autocomplete="current-password" required>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Entrar</button>
                    <p class="mt-3 text-center">
                        ¿No tienes cuenta? <a href="registro.php">Regístrate aquí</a>
                    </p>
                </form>
            </div>
        </div>
    </div>
</body>

</html>