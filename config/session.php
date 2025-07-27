<?php
// config/session.php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Verificar si las rutas ya están definidas
if (!isset($_SESSION["ROOT_PATH"])) {
    $_SESSION["ROOT_PATH"] = realpath(__DIR__ . "/..");
}

if (!isset($_SESSION["ROOT_WEB"])) {
    $_SESSION["ROOT_WEB"] = "/Proyectos/Sesionyusuarios";
}
