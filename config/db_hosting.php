<?php
$conn = mysqli_connect("PMYSQL131.dns-servicio.com", "root_sesionyusuarios", "%g97bR88o", "7660429_sesionyusuarios",3306);
if (!$conn) {
    die("Error de conexión: " . mysqli_connect_error());
}
