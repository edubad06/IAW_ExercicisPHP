<?php
require_once 'header.php';
require_once 'config/db_connect.php';

// Només el Moderador pot accedir
if (!$logado || $rol !== 'Moderador') { 
    header("Location: error.php?tipus=sessio_error"); 
    exit(); 
}

// Processar dades del formulari
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validar camps buits
    if (empty($_POST['titol']) || empty($_POST['genere'])) {
        header("Location: error.php?tipus=buit");
        exit();
    }

    // Neteja de dades per seguretat
    $titol = mysqli_real_escape_string($conexion, $_POST['titol']);
    $genere = mysqli_real_escape_string($conexion, $_POST['genere']);
    $director = mysqli_real_escape_string($conexion, $_POST['director']);
    $any = (int)$_POST['any'];
    $puntuacio = (float)$_POST['puntuacio'];
    $sinopsi = mysqli_real_escape_string($conexion, $_POST['sinopsi']);

    // Validar formats d'any i puntuació
    if ($any < 1888 || $any > date("Y") + 10) {
        header("Location: error.php?tipus=data_incorrecta");
        exit();
    }
    if ($puntuacio < 0 || $puntuacio > 10) {
        header("Location: error.php?tipus=num_invalid");
        exit();
    }

    // Validar duplicat de títol
    $checkDuplicate = mysqli_query($conexion, "SELECT id_pelicula FROM pelicules WHERE titol = '$titol'");
    
    if (mysqli_num_rows($checkDuplicate) > 0) {
        header("Location: error.php?tipus=peli_duplicada");
        exit();
    }

    // Si tot és correcte, fem el insert
    $sql = "INSERT INTO pelicules (titol, genere, director, any_estrena, puntuacio, sinopsi) 
            VALUES ('$titol', '$genere', '$director', $any, $puntuacio, '$sinopsi')";
    
    if (mysqli_query($conexion, $sql)) {
        header("Location: pelicules_read.php?msg=creada");
        exit();
    } else {
        header("Location: error.php?tipus=desconegut");
        exit();
    }
}
?>

<div class="container">
    <h2>➕ Afegir Nova Pel·lícula</h2>
    <form method="POST">
        <label>Títol:</label>
        <input type="text" name="titol" placeholder="Ex: One Piece">
        
        <label>Gènere:</label>
        <select name="genere">
            <option value="">-- Selecciona un gènere --</option>
            <option value="Acció">Acció</option>
            <option value="Drama">Drama</option>
            <option value="Comèdia">Comèdia</option>
            <option value="Ciència Ficció">Ciència Ficció</option>
            <option value="Terror">Terror</option>
        </select>

        <label>Director:</label>
        <input type="text" name="director">

        <label>Any d'estrena:</label>
        <input type="number" name="any" placeholder="Ex: 2024">

        <label>Puntuació:</label>
        <input type="number" name="puntuacio" step="0.1" min="0" max="10" value="5.0">

        <label>Sinopsi:</label>
        <textarea name="sinopsi"></textarea>

        <div style="margin-top: 20px;">
            <button type="submit" class="btn btn-add">Guardar Pel·lícula</button>
            <a href="pelicules_read.php" style="margin-left: 15px; color: #666;">Cancel·lar</a>
        </div>
    </form>
</div>