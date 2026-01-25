<?php
require_once 'header.php';
require_once 'config/db_connect.php';

// Control d'accés
if (!$logado) {
    header("Location: error.php?tipus=sessio_error");
    exit();
}

// Processament del formulari
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validar camps buits
    if (empty($_POST['id_pelicula'])) {
        header("Location: error.php?tipus=buit");
        exit();
    }

    // Identificació de l'usuari per sessió i neteja de dades
    $id_usuari = $_SESSION['usuari']['id'];
    $id_peli = (int)$_POST['id_pelicula'];
    $comentari = mysqli_real_escape_string($conexion, $_POST['comentari']);
    
    // Validació duplicats
    $check = mysqli_query($conexion, "SELECT id_seguiment FROM seguiment WHERE id_usuari = $id_usuari AND id_pelicula = $id_peli");
    
    if (mysqli_num_rows($check) > 0) {
        header("Location: error.php?tipus=peli_duplicada");
        exit();
    }

    // Inserció a la BBDD
    $sql = "INSERT INTO seguiment (id_usuari, id_pelicula, comentari_personal) VALUES ($id_usuari, $id_peli, '$comentari')";
    
    if (mysqli_query($conexion, $sql)) {
        header("Location: seguiment_read.php?msg=afegida");
        exit();
    } else {
        header("Location: error.php?tipus=desconegut");
        exit();
    }
}

// Obtenir llistat de totes les pel·lícules disponibles al catàleg
$pelis = mysqli_query($conexion, "SELECT id_pelicula, titol FROM pelicules ORDER BY titol ASC");
?>

<div class="container" style="max-width: 600px;">
    <h2>➕ Afegir a la meva llista</h2>
    <p>Selecciona una pel·lícula del catàleg general per fer-ne el seguiment.</p>

    <form method="POST">
        <label for="id_pelicula">Pel·lícula:</label>
        <select name="id_pelicula" id="id_pelicula">
            <option value="">-- Selecciona una pel·lícula --</option>
            <?php while($p = mysqli_fetch_assoc($pelis)): ?>
                <option value="<?php echo $p['id_pelicula']; ?>">
                    <?php echo htmlspecialchars($p['titol']); ?>
                </option>
            <?php endwhile; ?>
        </select>

        <label for="comentari">El teu comentari (opcional):</label>
        <textarea name="comentari" id="comentari" placeholder="Què t'ha semblat?"></textarea>

        <div style="margin-top: 20px;">
            <button type="submit" class="btn btn-add" style="width: 100%; height: auto; padding: 12px; font-weight: bold;">
                AFEGIR A LA MEVA LLISTA
            </button>
            <div style="text-align: center; margin-top: 15px;">
                <a href="seguiment_read.php" style="color: #666; text-decoration: none;">Tornar a la llista</a>
            </div>
        </div>
    </form>
</div>