<?php
session_start();
require_once 'header.php';
require_once 'config/conexion.php';

// Verificació de seguretat i permisos
if (!isset($_SESSION['usuari']) || $_SESSION['usuari']['nom_rol'] !== 'Moderador') {
    header("Location: error.php?msg=No tens permisos per realitzar aquesta acció.");
    exit();
}

if (isset($_GET['id'])) {
    $id = (int)$_GET['id'];
    
    // Intentar l'esborrat i comprovar si ha funcionat
    if (mysqli_query($conexion, "DELETE FROM pelicules WHERE id_pelicula = $id")) {
        header("Location: pelicules_read.php?msg=eliminada");
    } else {
        // Gestió de l'error si la pel·lícula té registres relacionats
        header("Location: error.php?msg=No s'ha pogut eliminar la pel·lícula. És possible que estigui sent utilitzada en una llista d'usuari.");
    }
} else {
    header("Location: error.php?msg=ID de pel·lícula no especificat.");
}
exit();