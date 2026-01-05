<?php
// Credencials BBDD
$servidor = "localhost";
$usuario_db = "root";
$password_db = "";
$nombre_db = "cine_app";

// API KEY per OMDb
$MOVIE_API_KEY = "key_ex"; 

$conexion = mysqli_connect($servidor, $usuario_db, $password_db, $nombre_db);

if (!$conexion) {
    die("Error de conexión: " . mysqli_connect_error());
}
mysqli_set_charset($conexion, "utf8mb4");
?>