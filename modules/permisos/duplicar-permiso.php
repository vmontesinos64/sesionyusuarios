<?php
require_once __DIR__ . "/../../config/session.php";
require_once $_SESSION["ROOT_PATH"] . "/config/db.php";
require_once $_SESSION["ROOT_PATH"] . "/includes/auth.php";

$id = $_POST["id"];

// Obtener el permiso original
$result = $conn->query("SELECT * FROM permisos WHERE id = $id");
$perm = $result->fetch_assoc();

// Insertar copia exacta
$stmt = $conn->prepare("INSERT INTO permisos (rol, recurso, acceso, requiere_validacion) VALUES (?, ?, ?, ?)");
$stmt->bind_param("sssi", $perm["rol"], $perm["recurso"], $perm["acceso"], $perm["requiere_validacion"]);
$stmt->execute();

header("Location: admin-permisos.php");
exit();
