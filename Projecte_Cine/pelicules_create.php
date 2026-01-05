<?php
require_once 'header.php';
require_once 'config/conexion.php';

// Control d'accés
if (!$logado || $rol !== 'Moderador') { 
    header("Location: error.php?msg=Accés denegat."); 
    exit(); 
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titol = mysqli_real_escape_string($conexion, $_POST['titol']);
    $genere = mysqli_real_escape_string($conexion, $_POST['genere']);
    $director = mysqli_real_escape_string($conexion, $_POST['director']);
    $any = (int)$_POST['any'];
    $puntuacio = (float)$_POST['puntuacio'];
    $sinopsi = mysqli_real_escape_string($conexion, $_POST['sinopsi']);

    // Comprovar dades duplicades
    $checkDuplicate = mysqli_query($conexion, "SELECT id_pelicula FROM pelicules WHERE titol = '$titol'");
    
    if (mysqli_num_rows($checkDuplicate) > 0) {
        header("Location: error.php?msg=Aquesta pel·lícula '$titol' ja existeix al catàleg.");
        exit();
    }

    // Si no existeix, fem el insert
    $sql = "INSERT INTO pelicules (titol, genere, director, any_estrena, puntuacio, sinopsi) 
            VALUES ('$titol', '$genere', '$director', $any, $puntuacio, '$sinopsi')";
    
    if (mysqli_query($conexion, $sql)) {
        header("Location: pelicules_read.php?msg=creada");
        exit();
    } else {
        header("Location: error.php?msg=S'ha produït un error en guardar la pel·lícula.");
        exit();
    }
}
?>

<div class="container">
    <h2>➕ Afegir Nova Pel·lícula</h2>
    <form method="POST">
        <label>Títol:</label>
        <input type="text" name="titol" required placeholder="Ex: One Piece">
        
        <label>Gènere:</label>
        <select name="genere" required>
            <option value="Acció">Acció</option>
            <option value="Drama">Drama</option>
            <option value="Comèdia">Comèdia</option>
            <option value="Ciència Ficció">Ciència Ficció</option>
            <option value="Terror">Terror</option>
        </select>

        <label>Director:</label>
        <input type="text" name="director">

        <label>Any d'estrena:</label>
        <input type="number" name="any">

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