<?php
require_once __DIR__ . "/config/session.php";
require_once $_SESSION["ROOT_PATH"] . "/config/db.php";
require_once $_SESSION["ROOT_PATH"] . "/includes/auth.php";
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Mi Plataforma</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- jQuery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body>
    <!-- Barras de menú -->
    <?php
    require_once $_SESSION["ROOT_PATH"] . "/includes/navbar.php";
    require_once $_SESSION["ROOT_PATH"] . "/includes/sidebar.php";
    ?>

    <!-- Contenido principal -->
    <div class="container mt-5">
        <div class="p-5 bg-light rounded shadow-sm">
            <h1 class="mb-4">Bienvenido, <?= $_SESSION['usuario'] ?? 'usuario' ?> 👋</h1>
            <p>Esta es tu página principal. Desde aquí puedes gestionar módulos, usuarios y más.</p>
        </div>
    </div>



    <!-- Modulo footer (toast). Se llama a la función JS "mostrarToast(titulo, tiempo, mensaje, clasefondo)"-->
    <?php include "includes/toast.php"; ?>
    <script>
        mostrarToast(
            '¡Hola, <?= $_SESSION["usuario"] ?? "usuario" ?>!',
            'Justo ahora',
            'Tu sesión fue exitosa',
            'bg-primary'
        );
    </script>
    <!-- scripts de bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- script del menu sidebar -->
    <script src="assets/menu.js"></script>
</body>

</html>