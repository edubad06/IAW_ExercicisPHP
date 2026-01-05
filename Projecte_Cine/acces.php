<?php
require_once 'header.php';

// Control d'accés
if (!$logado) {
    header("Location: login.php");
    exit();
}

// Verificació de seguretat de dades de sessió
if (!isset($_SESSION['usuari']['nom_rol']) || !isset($_SESSION['usuari']['nom_usuari'])) {
    header("Location: error.php?msg=Error de sessió: No s'ha pogut verificar el teu perfil.");
    exit();
}

$rol = $_SESSION['usuari']['nom_rol'];
$nom = $_SESSION['usuari']['nom_usuari'];
?>

<div class="container">
    <h1>Benvingut/da, <?php echo htmlspecialchars($nom); ?></h1>
    <p>Has accedit com a: <span class="badge" style="background: #eee; padding: 5px 10px; border-radius: 4px;"><strong><?php echo htmlspecialchars($rol); ?></strong></span></p>
    <hr style="border: 0; border-top: 1px solid #eee; margin: 25px 0;">

    <div style="background: #fdfdfd; padding: 20px; border-radius: 10px; border: 1px solid #f0f0f0;">
        <?php if ($rol === 'Moderador'): ?>
            <h3 style="color: #1a1a1a;">🛠️ Panell d'Administració</h3>
            <p>Com a Moderador, tens permisos totals per gestionar el catàleg global de pel·lícules.</p>
            <div style="margin-top: 20px;">
                <a href="pelicules_read.php" class="btn btn-add" style="padding: 12px 25px;">Gestió de Catàleg</a>
                <a href="stats.php" class="btn btn-edit" style="margin-left: 10px; background: #6c757d;">Cercador de Pel·lícules</a>
            </div>

        <?php elseif ($rol === 'Usuari'): ?>
            <h3 style="color: #007bff;">🍿 El teu Espai Personal</h3>
            <p>Com a Usuari, pots descobrir noves pel·lícules mitjançant la nostra eina de cerca i organitzar la teva llista personal.</p>
            <div style="margin-top: 25px; display: flex; gap: 15px;">
                <a href="stats.php" class="btn btn-add" style="padding: 12px 25px; flex: 1; text-align: center;">🔍 Cercador</a>
                <a href="seguiment_read.php" class="btn btn-edit" style="padding: 12px 25px; flex: 1; text-align: center; background:#007bff;">📋 La meva llista</a>
            </div>

        <?php else: ?>
            <?php header("Location: error.php?msg=El teu rol d'usuari no té un panell definit."); exit(); ?>
        <?php endif; ?>
    </div>
</div>