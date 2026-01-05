<?php
session_start();
require_once 'header.php';
require_once 'config/conexion.php';

if (isset($_SESSION['usuari']) && isset($_GET['id'])) {
    $id = (int)$_GET['id'];
    $id_usuari = $_SESSION['usuari']['id'];
    
    // Verifiquem l'execució de la consulta
    $resultat = mysqli_query($conexion, "DELETE FROM seguiment WHERE id_seguiment = $id AND id_usuari = $id_usuari");
    
    if ($resultat && mysqli_affected_rows($conexion) > 0) {
        header("Location: seguiment_read.php?msg=eliminat");
    } else {
        header("Location: error.php?msg=No s'ha pogut eliminar el registre o no t'hi pertany.");
    }
} else {
    header("Location: error.php?msg=Petició no vàlida.");
}
exit();