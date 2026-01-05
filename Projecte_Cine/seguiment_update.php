<?php
require_once 'header.php';
require_once 'config/conexion.php';

if (!isset($_GET['id'])) { header("Location: error.php?msg=Falta ID."); exit(); }

$id = (int)$_GET['id'];
$id_usuari = $_SESSION['usuari']['id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $estat = $_POST['estat'];
    $comentari = mysqli_real_escape_string($conexion, $_POST['comentari']);
    
    $sql = "UPDATE seguiment SET estat = '$estat', comentari_personal = '$comentari' 
            WHERE id_seguiment = $id AND id_usuari = $id_usuari";
    
    if (mysqli_query($conexion, $sql)) {
        header("Location: seguiment_read.php?msg=actualitzat");
        exit();
    } else {
        header("Location: error.php?msg=Error al guardar els canvis.");
        exit();
    }
}

// Verificar que el registre existeix i pertany a l'usuari
$res = mysqli_query($conexion, "SELECT s.*, p.titol FROM seguiment s JOIN pelicules p ON s.id_pelicula = p.id_pelicula WHERE s.id_seguiment = $id AND s.id_usuari = $id_usuari");
$data = mysqli_fetch_assoc($res);

if (!$data) {
    header("Location: error.php?msg=No s'ha trobat la pel·lícula a la teva llista.");
    exit();
}
?>
<div class="container">
    <h2>✏️ Editar seguiment: <?php echo htmlspecialchars($data['titol']); ?></h2>
    <form method="POST">
        <label>Estat:</label>
        <select name="estat">
            <option value="Pendent" <?php if($data['estat']=='Pendent') echo 'selected'; ?>>Pendent</option>
            <option value="Vista" <?php if($data['estat']=='Vista') echo 'selected'; ?>>Vista</option>
        </select>
        <label>El meu comentari:</label>
        <textarea name="comentari"><?php echo htmlspecialchars($data['comentari_personal']); ?></textarea>
        <button type="submit" class="btn btn-edit">Actualitzar</button>
        <a href="seguiment_read.php">Tornar</a>
    </form>
</div>