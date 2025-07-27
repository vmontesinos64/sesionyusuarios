<?php
// Comprobar si hay sesión iniciada
if (!isset($_SESSION['usuario']) || !isset($_SESSION['rol'])) {
  header("Location: ./login.php");
  exit;
}


$recurso = str_replace($_SESSION["ROOT_PATH"] . DIRECTORY_SEPARATOR, '', realpath($_SERVER['SCRIPT_FILENAME']));
$recurso = str_replace('\\', '/', $recurso); // normalizar para Windows

// Consulta de permisos para este rol y esta página
$stmt = $conn->prepare("SELECT acceso, requiere_validacion FROM permisos WHERE rol = ? AND recurso = ?");
$stmt->bind_param("ss", $_SESSION['rol'], $recurso);
$stmt->execute();
$result = $stmt->get_result();

// Si no hay permisos definidos, se deniega por defecto
if ($result->num_rows === 0) {
  die("❌ No tienes permisos definidos para acceder a esta página.");
}

$permiso = $result->fetch_assoc();

// Validación de acceso
if ($permiso['acceso'] !== 'permitido') {
  die("🚫 Acceso no autorizado a este módulo.");
}

if ($permiso['requiere_validacion'] && $_SESSION['validado'] != 1) {
  die("🔒 Tu cuenta aún no ha sido validada para acceder a este módulo.");
}

$stmt->close();
// $conn->close();
?>
