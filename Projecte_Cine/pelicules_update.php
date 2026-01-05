<?php
require_once 'header.php';
require_once 'config/conexion.php';

// Control d'accés
if (!$logado || $rol !== 'Moderador') { 
    header("Location: error.php?msg=Accés denegat: Només els administradors poden editar dades."); 
    exit(); 
}

// Verificar ID vàlid
if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: error.php?msg=No s'ha especificat cap ID de pel·lícula per editar.");
    exit();
}

$id = (int)$_GET['id'];
$error = "";

// Processar el formulari
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titol = mysqli_real_escape_string($conexion, $_POST['titol']);
    $genere = mysqli_real_escape_string($conexion, $_POST['genere']);
    $director = mysqli_real_escape_string($conexion, $_POST['director']);
    $any = (int)$_POST['any'];
    $puntuacio = (float)$_POST['puntuacio'];
    $sinopsi = mysqli_real_escape_string($conexion, $_POST['sinopsi']);

    $sql_update = "UPDATE pelicules SET 
                    titol = '$titol', 
                    genere = '$genere', 
                    director = '$director', 
                    any_estrena = $any, 
                    puntuacio = $puntuacio, 
                    sinopsi = '$sinopsi' 
                   WHERE id_pelicula = $id";
    
    if (mysqli_query($conexion, $sql_update)) {
        header("Location: pelicules_read.php?msg=updated");
        exit();
    } else {
        header("Location: error.php?msg=Error fatal a la base de dades en actualitzar.");
        exit();
    }
}

// Obtenir dades de la pel·lícula
$res = mysqli_query($conexion, "SELECT * FROM pelicules WHERE id_pelicula = $id");
if (!$res || mysqli_num_rows($res) === 0) {
    header("Location: error.php?msg=La pel·lícula amb ID $id no s'ha trobat al sistema.");
    exit();
}
$peli = mysqli_fetch_assoc($res);
?>

<div class="container">
    <h2>✏️ Editar Pel·lícula: <?php echo htmlspecialchars($peli['titol']); ?></h2>
    
    <form method="POST">
        <label>Títol:</label>
        <input type="text" name="titol" value="<?php echo htmlspecialchars($peli['titol']); ?>" required>
        
        <label>Gènere:</label>
        <select name="genere" required>
            <option value="Acció" <?php if($peli['genere'] == 'Acció') echo 'selected'; ?>>Acció</option>
            <option value="Drama" <?php if($peli['genere'] == 'Drama') echo 'selected'; ?>>Drama</option>
            <option value="Comèdia" <?php if($peli['genere'] == 'Comèdia') echo 'selected'; ?>>Comèdia</option>
            <option value="Ciència Ficció" <?php if($peli['genere'] == 'Ciència Ficció') echo 'selected'; ?>>Ciència Ficció</option>
            <option value="Terror" <?php if($peli['genere'] == 'Terror') echo 'selected'; ?>>Terror</option>
            <?php if(!in_array($peli['genere'], ['Acció','Drama','Comèdia','Ciència Ficció','Terror'])): ?>
                <option value="<?php echo htmlspecialchars($peli['genere']); ?>" selected>
                    <?php echo htmlspecialchars($peli['genere']); ?> (API)
                </option>
            <?php endif; ?>
        </select>

        <label>Director:</label>
        <input type="text" name="director" value="<?php echo htmlspecialchars($peli['director']); ?>">

        <label>Any d'estrena:</label>
        <input type="number" name="any" value="<?php echo $peli['any_estrena']; ?>">

        <label>Puntuació (0-10):</label>
        <input type="number" name="puntuacio" step="0.1" min="0" max="10" value="<?php echo $peli['puntuacio']; ?>">

        <label>Sinopsi:</label>
        <textarea name="sinopsi" style="height:120px;"><?php echo htmlspecialchars($peli['sinopsi']); ?></textarea>

        <div style="margin-top: 20px;">
            <button type="submit" class="btn btn-edit">Actualitzar Pel·lícula</button>
            <a href="pelicules_read.php" style="margin-left: 15px; color: #666;">Cancel·lar</a>
        </div>
    </form>
</div>