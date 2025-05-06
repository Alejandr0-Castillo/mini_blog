<?php
$conexion = new mysqli("localhost", "root", "", "blog_db");

if ($conexion->connect_error) {
    die("Conexión fallida: " . $conexion->connect_error);
}
?>