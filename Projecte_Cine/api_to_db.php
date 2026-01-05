<?php
require_once 'header.php';
require_once 'config/conexion.php';
session_start();

// Control d'accés
if (!isset($_SESSION['usuari'])) { 
    header("Location: error.php?msg=Has d'iniciar sessió per afegir pel·lícules.");
    exit(); 
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_usuari = $_SESSION['usuari']['id'];
    
    // Neteja de dades
    $titol = mysqli_real_escape_string($conexion, $_POST['titol']);
    $genere = mysqli_real_escape_string($conexion, $_POST['genere']); 
    $director = mysqli_real_escape_string($conexion, $_POST['director']);
    $any = (int)$_POST['any'];
    $sinopsi = mysqli_real_escape_string($conexion, $_POST['sinopsi']);
    $puntuacio = (float)$_POST['puntuacio'];

    // Comprovar si ja existeix al catàleg
    $check = mysqli_query($conexion, "SELECT id_pelicula FROM pelicules WHERE titol = '$titol'");
    
    if (!$check) {
        header("Location: error.php?msg=Error al consultar el catàleg existent.");
        exit();
    }

    if (mysqli_num_rows($check) > 0) {
        $id_pelicula = mysqli_fetch_assoc($check)['id_pelicula'];
    } else {
        // Insertar al catàleg general
        $sql_ins = "INSERT INTO pelicules (titol, genere, director, any_estrena, sinopsi, puntuacio) 
                    VALUES ('$titol', '$genere', '$director', $any, '$sinopsi', $puntuacio)";
        
        if (mysqli_query($conexion, $sql_ins)) {
            $id_pelicula = mysqli_insert_id($conexion);
        } else {
            header("Location: error.php?msg=No s'ha pogut registrar la pel·lícula al catàleg general.");
            exit();
        }
    }

    // Insertar a la llista de seguiment de l'usuari
    $sql_follow = "INSERT INTO seguiment (id_usuari, id_pelicula, estat, comentari_personal) 
                   VALUES ($id_usuari, $id_pelicula, 'Pendent', '') 
                   ON DUPLICATE KEY UPDATE id_usuari=id_usuari";
    
    if (mysqli_query($conexion, $sql_follow)) {
        header("Location: seguiment_read.php?msg=afegida");
        exit();
    } else {
        header("Location: error.php?msg=Error al vincular la pel·lícula a la teva llista personal.");
        exit();
    }
} else {
    // Si s'intenta accedir per URL sense POST
    header("Location: error.php?msg=Petició no vàlida.");
    exit();
}