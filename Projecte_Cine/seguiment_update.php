<?php
require_once 'header.php';
require_once 'config/db_connect.php';

// Control d'accés
if (!$logado) {
    header("Location: error.php?tipus=sessio_error");
    exit();
}

// Verificar ID vàlid
if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: error.php?tipus=peticio_invalid");
    exit();
}

$id = (int)$_GET['id'];
$id_usuari = $_SESSION['usuari']['id'];

// Processar el formulari
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validació de l'estat buit
    if (empty($_POST['estat'])) {
        header("Location: error.php?tipus=buit");
        exit();
    }

    $estat = mysqli_real_escape_string($conexion, $_POST['estat']);
    $comentari = mysqli_real_escape_string($conexion, $_POST['comentari']);
    
    // Assegura que l'usuari només edita el seu propi registre
    $sql = "UPDATE seguiment SET estat = '$estat', comentari_personal = '$comentari' 
            WHERE id_seguiment = $id AND id_usuari = $id_usuari";
    
    if (mysqli_query($conexion, $sql)) {
        header("Location: seguiment_read.php?msg=actualitzat");
        exit();
    } else {
        header("Location: error.php?tipus=desconegut");
        exit();
    }
}

// Verificar que el registre existeix i pertany a l'usuari per carregar les dades
$sql_select = "SELECT s.*, p.titol 
               FROM seguiment s 
               JOIN pelicules p ON s.id_pelicula = p.id_pelicula 
               WHERE s.id_seguiment = $id AND s.id_usuari = $id_usuari";

$res = mysqli_query($conexion, $sql_select);
$data = mysqli_fetch_assoc($res);

// Si el registre no existeix o no pertany a l'usuari loguejat
if (!$data) {
    header("Location: error.php?tipus=peticio_invalid");
    exit();
}
?>

<div class="container" style="max-width: 600px;">
    <h2>✏️ Editar seguiment: <?php echo htmlspecialchars($data['titol']); ?></h2>
    
    <form method="POST" style="margin-top: 20px;">
        <label for="estat" style="font-weight: bold;">Estat de la pel·lícula:</label>
        <select name="estat" id="estat">
            <option value="Pendent" <?php if($data['estat']=='Pendent') echo 'selected'; ?>>Pendent</option>
            <option value="Vista" <?php if($data['estat']=='Vista') echo 'selected'; ?>>Vista</option>
        </select>

        <label for="comentari" style="font-weight: bold;">El meu comentari personal:</label>
        <textarea name="comentari" id="comentari" style="height: 100px;"><?php echo htmlspecialchars($data['comentari_personal']); ?></textarea>

        <div style="margin-top: 20px; display: flex; gap: 10px; align-items: center;">
            <button type="submit" class="btn btn-edit" style="height: auto; padding: 10px 20px; font-weight: bold;">
                💾 GUARDAR CANVIS
            </button>
            <a href="seguiment_read.php" style="color: #666; text-decoration: none; font-size: 0.9rem;">Cancel·lar</a>
        </div>
    </form>
</div>