<?php
require_once __DIR__ . "/../../config/session.php";
require_once $_SESSION["ROOT_PATH"] . "/config/db.php";
require_once $_SESSION["ROOT_PATH"] . "/includes/auth.php";

// Recoger datos del formulario
$id      = $_POST["id"];
$rol     = $_POST["rol"];
$recurso = $_POST["recurso"];
$acceso  = $_POST["acceso"];
$valid   = $_POST["requiere_validacion"];

// Actualizar el permiso
$stmt = $conn->prepare("UPDATE permisos SET rol = ?, recurso = ?, acceso = ?, requiere_validacion = ? WHERE id = ?");
$stmt->bind_param("sssii", $rol, $recurso, $acceso, $valid, $id);
$stmt->execute();

echo "✅ Permiso actualizado correctamente";
