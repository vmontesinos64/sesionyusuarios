<?php
require_once __DIR__ . "/../../config/session.php";
require_once $_SESSION["ROOT_PATH"] . "/config/db.php";
require_once $_SESSION["ROOT_PATH"] . "/includes/auth.php";

$id = $_POST["id"];

// Eliminar permiso
$stmt = $conn->prepare("DELETE FROM permisos WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();

header("Location: admin-permisos.php");
exit();
