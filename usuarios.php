<?php
require_once __DIR__ . "/config/db.php";
require_once __DIR__ . "/config/session.php";
require_once __DIR__ . "/includes/auth.php";
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Gestión de Usuarios</title>

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- jQuery -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
  <!-- Bootstrap JS Bundle -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body class="bg-light">

  <div class="container mt-5">
    <h2 class="mb-4">👥 Gestión de Usuarios</h2>

    <!-- Formulario -->
    <form id="formUsuario" class="mb-4 bg-white p-4 rounded shadow-sm">
      <div class="mb-3">
        <label class="form-label">Nombre</label>
        <input type="text" name="nombre" class="form-control" required>
      </div>
      <div class="mb-3">
        <label class="form-label">Correo</label>
        <input type="email" name="correo" class="form-control" required>
      </div>
      <button type="submit" class="btn btn-success">Guardar Usuario</button>
    </form>

    <!-- Tabla -->
    <table class="table table-hover bg-white rounded shadow-sm">
      <thead class="table-dark">
        <tr><th>Nombre</th><th>Correo</th><th>Acciones</th></tr>
      </thead>
      <tbody id="tablaUsuarios">
        <!-- Filas dinámicas -->
      </tbody>
    </table>
  </div>

  <!-- Toast -->
  <div class="toast bg-success text-white position-fixed bottom-0 end-0 m-3" id="toastOK" role="alert">
    <div class="toast-header bg-success text-white">
      <strong class="me-auto">✔ Usuario guardado</strong>
      <button type="button" class="btn-close" data-bs-dismiss="toast"></button>
    </div>
    <div class="toast-body">
      El usuario ha sido registrado con éxito.
    </div>
  </div>

  <!-- JS personalizado -->
  <script src="assets/main.js"></script>
</body>
</html>
