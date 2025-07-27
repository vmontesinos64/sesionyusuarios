<?php
$conn = mysqli_connect("localhost", "root", "", "sesionyusuarios");
if (!$conn) {
    die("Error de conexión: " . mysqli_connect_error());
}
