<?php
// Credencials BBDD (Modificar per les vostres credencials)
$servidor = "localhost";
$usuario_db = "root";
$password_db = "";
$nombre_db = "cine_app";

// API KEY per OMDb
$MOVIE_API_KEY = "YOUR_API_KEY_HERE"; // Modificar per afegir la vostra API KEY

// Connexió amb la BBDD
$conexion = mysqli_connect($servidor, $usuario_db, $password_db, $nombre_db);

// Verificació de la connexió
if (!$conexion) {
    die("Error de conexión: " . mysqli_connect_error());
}

// Joc de caràcters a utf8mb4
mysqli_set_charset($conexion, "utf8mb4");
?>