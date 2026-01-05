<?php
require_once 'header.php';
require_once 'config/conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_usuari = $_SESSION['usuari']['id'];
    $id_peli = (int)$_POST['id_pelicula'];
    $comentari = mysqli_real_escape_string($conexion, $_POST['comentari']);
    
    $sql = "INSERT INTO seguiment (id_usuari, id_pelicula, comentari_personal) VALUES ($id_usuari, $id_peli, '$comentari')";
    if (mysqli_query($conexion, $sql)) {
        header("Location: seguiment_read.php");
        exit();
    } else {
        $error = "Aquesta pel·lícula ja és a la teva llista.";
    }
}
$pelis = mysqli_query($conexion, "SELECT id_pelicula, titol FROM pelicules ORDER BY titol ASC");
?>