<?php
require_once 'header.php';
require_once 'config/db_connect.php';

// Verificar usuari Moderador
if (!$logado || $rol !== 'Moderador') {
    header("Location: error.php?tipus=sessio_error");
    exit();
}

if (isset($_GET['id'])) {
    $id = (int)$_GET['id'];

    // Comprovem si algun usuari té aquesta pel·lícula a la seva llista de seguiment
    $check_relacions = mysqli_query($conexion, "SELECT id_seguiment FROM seguiment WHERE id_pelicula = $id");
    
    if (mysqli_num_rows($check_relacions) > 0) {
        // Si hi ha relacions, enviem al codi d'error corresponent
        header("Location: error.php?tipus=relacio_activa");
        exit();
    }

    // Si no hi ha relacions, esborrem el registre
    if (mysqli_query($conexion, "DELETE FROM pelicules WHERE id_pelicula = $id")) {
        header("Location: pelicules_read.php?msg=eliminada");
        exit();
    } else {
        header("Location: error.php?tipus=desconegut");
        exit();
    }
} else {
    // Si s'intenta accedir al fitxer sense un ID vàlid
    header("Location: error.php?tipus=peticio_invalid");
    exit();
}