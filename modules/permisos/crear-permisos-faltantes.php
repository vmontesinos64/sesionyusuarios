<?php
require_once __DIR__ . "/../../config/session.php";
require_once $_SESSION["ROOT_PATH"] . "/config/db.php";
require_once $_SESSION["ROOT_PATH"] . "/includes/auth.php";
// Ruta absoluta de la raíz del proyecto
define("ROOT_PATH", realpath("../../"));

// Roles para los que se desea crear permisos
$roles = ["super-user", "profesor", "alumno"];

// Buscar todos los archivos .php del proyecto con ruta relativa desde la raíz
function encontrarArchivosDesdeRaiz($root)
{
    $archivos = [];
    $iterador = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($root));

    foreach ($iterador as $archivo) {
        if ($archivo->isFile() && pathinfo($archivo, PATHINFO_EXTENSION) === 'php') {
            // Convertir ruta absoluta a relativa desde la raíz del proyecto
            $relativo = str_replace(ROOT_PATH . DIRECTORY_SEPARATOR, '', $archivo->getRealPath());
            $relativo = str_replace('\\', '/', $relativo); // Normalizar barras
            $archivos[] = $relativo;
        }
    }

    return $archivos;
}

// 1. Obtener todos los archivos PHP con ruta relativa desde la raíz
$archivosRelativos = encontrarArchivosDesdeRaiz(ROOT_PATH);

// 2. Obtener permisos existentes en la base de datos
$existentes = [];
$consulta = $conn->query("SELECT rol, recurso FROM permisos");
while ($row = $consulta->fetch_assoc()) {
    $clave = $row["rol"] . "|" . $row["recurso"];
    $existentes[$clave] = true;
}

// 3. Insertar permisos faltantes
$nuevosContador = 0;
foreach ($archivosRelativos as $recurso) {
    foreach ($roles as $rol) {
        $clave = $rol . "|" . $recurso;
        if (!isset($existentes[$clave])) {
            $stmt = $conn->prepare("INSERT INTO permisos (rol, recurso, acceso, requiere_validacion) VALUES (?, ?, 'denegado', 0)");
            $stmt->bind_param("ss", $rol, $recurso);
            $stmt->execute();
            $nuevosContador++;
        }
    }
}

header("Location: admin-permisos.php");
exit();
