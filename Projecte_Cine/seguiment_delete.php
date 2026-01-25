<?php
require_once 'header.php';
require_once 'config/db_connect.php';

// Control d'accés
if (!$logado) {
    header("Location: error.php?tipus=sessio_error");
    exit();
}

if (isset($_GET['id'])) {
    $id = (int)$_GET['id'];
    $id_usuari = $_SESSION['usuari']['id'];
    
    // Esborrar registre assegurant que pertany a l'usuari loguejat
    $sql = "DELETE FROM seguiment WHERE id_seguiment = $id AND id_usuari = $id_usuari";
    $resultat = mysqli_query($conexion, $sql);
    
    // Verificar que s'hagi eliminat correctament
    if ($resultat && mysqli_affected_rows($conexion) > 0) {
        // Redirecció amb missatge d'èxit
        header("Location: seguiment_read.php?msg=eliminat");
        exit();
    } else {
        // Si no s'ha esborrat res, pot ser que l'ID no existeixi o no sigui seu
        header("Location: error.php?tipus=peticio_invalid");
        exit();
    }
} else {
    // Si no hi ha ID a la URL
    header("Location: error.php?tipus=peticio_invalid");
    exit();
}