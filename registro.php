<?php
require_once __DIR__ . "/config/session.php";
require_once $_SESSION["ROOT_PATH"] . "/config/db.php";
require_once $_SESSION["ROOT_PATH"] . "/includes/auth.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $usuario      = trim($_POST["usuario"]);
  $password     = password_hash($_POST["password"], PASSWORD_DEFAULT);
  $correo       = trim($_POST["correo"]);
  $nombre       = trim($_POST["nombre"]);
  $apellidos    = trim($_POST["apellidos"]);
  $presentacion = trim($_POST["presentacion"]);
  $centro       = trim($_POST["centro"]);
  $poblacion    = trim($_POST["poblacion"]);
  $pais         = trim($_POST["pais"]);
  $etapa        = $_POST["etapa"];

  $check = $conn->prepare("SELECT id FROM usuarios WHERE usuario = ? OR correo = ?");
  $check->bind_param("ss", $usuario, $correo);
  $check->execute();
  $check->store_result();

  if ($check->num_rows > 0) {
    echo "<script>alert('⚠️ El nombre de usuario o correo ya están registrados');</script>";
  } else {
    $check->close();

    $stmt = $conn->prepare("INSERT INTO usuarios (
      usuario, password, correo, nombre, apellidos, presentacion,
      rol, etapa, centro, poblacion, pais, validado
    ) VALUES (?, ?, ?, ?, ?, ?, 'profesor', ?, ?, ?, ?, FALSE)");

    $stmt->bind_param("ssssssssss", $usuario, $password, $correo, $nombre, $apellidos, $presentacion, $etapa, $centro, $poblacion, $pais);

    if ($stmt->execute()) {
      $admins = $conn->query("SELECT correo FROM usuarios WHERE rol='super-user' AND correo IS NOT NULL");
      $asunto = "Nuevo profesor pendiente de validación";
      $mensaje = "Se ha registrado el usuario '$usuario'. Valídalo desde el panel administrativo.";
      $remitente = "From: no-reply@tuapp.com";

      while ($admin = $admins->fetch_assoc()) {
        mail($admin['correo'], $asunto, $mensaje, $remitente);
      }

      header("Location: index.php");
      exit();
    } else {
      echo "<script>alert('❌ Error al registrar: " . $stmt->error . "');</script>";
    }

    $stmt->close();
  }

  $conn->close();
}
?>


<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <title>Registro de Profesor</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <style>
    .card {
      max-width: 600px;
      margin: 50px auto;
      padding: 30px;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
      border-radius: 10px;
    }

    label {
      font-weight: bold;
      margin-top: 10px;
    }

    small {
      display: block;
      margin-bottom: 8px;
    }
  </style>
</head>

<body>
  <div class="container">
    <div class="card">
      <h2 class="text-center mb-4">Registro de Profesor 👨‍🏫</h2>
      <form method="POST" action="">
        <label>Nombre de usuario:</label>
        <input type="text" name="usuario" id="usuario" class="form-control" required>
        <small id="estadoUsuario"></small>

        <label>Contraseña:</label>
        <input type="password" name="password" id="password" class="form-control" autocomplete="new-password " required>
        <progress id="barraSeguridad" value="0" max="5" class="w-100 mt-1 mb-2" style="height: 6px;"></progress>

        <label>Correo electrónico:</label>
        <input type="email" name="correo" id="correo" class="form-control" required>
        <small id="estadoCorreo"></small>
        <label>Nombre:</label>
        <input type="text" name="nombre" class="form-control" required>

        <label>Apellidos:</label>
        <input type="text" name="apellidos" class="form-control" required>

        <label>Carta de presentación / necesidades:</label>
        <textarea name="presentacion" class="form-control" rows="5" placeholder="Describe tu situación, necesidades, ideas..."></textarea>

        <label>Centro educativo:</label>
        <input type="text" name="centro" class="form-control" required>

        <label>Población:</label>
        <input type="text" name="poblacion" class="form-control">

        <label>País:</label>
        <input type="text" name="pais" class="form-control">

        <label>Etapa educativa:</label>
        <select name="etapa" class="form-select" required>
          <option value="">-- Selecciona etapa --</option>
          <option value="primaria">Primaria</option>
          <option value="secundaria">Secundaria</option>
          <option value="universidad">Universidad</option>
        </select>

        <button type="submit" id="botonSubmit" class="btn btn-primary w-100 mt-4">Registrarse</button>
        <div class="text-center mt-3">
          <a href="login.php">¿Ya tienes cuenta? Inicia sesión</a>
        </div>
      </form>
    </div>
  </div>

  <script>
    $(document).ready(function() {
      // Validación visual (requiere los scripts verificar-usuario.php y verificar-correo.php si se quieren activos)
      $('#password').on('input', function() {
        const val = $(this).val();
        let fuerza = (val.length > 5) + /[a-z]/.test(val) + /[A-Z]/.test(val) + /\d/.test(val) + /[^a-zA-Z0-9]/.test(val);
        $('#barraSeguridad').val(fuerza).css("accent-color", fuerza < 3 ? "red" : fuerza < 4 ? "orange" : "green");
      });
    });
  </script>
</body>

</html>