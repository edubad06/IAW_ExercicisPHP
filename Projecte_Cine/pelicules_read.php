<?php
require_once 'header.php';
require_once 'config/db_connect.php';

// Control d'accés
if (!$logado || $rol !== 'Moderador') { 
    header("Location: error.php?tipus=sessio_error"); 
    exit(); 
}

// Lògica d'estadístiques
$sql_stats = "SELECT 
                COUNT(*) as total, 
                AVG(puntuacio) as media,
                SUM(CASE WHEN puntuacio >= 8 THEN 1 ELSE 0 END) as top_pelis
              FROM pelicules";
$res_stats = mysqli_query($conexion, $sql_stats);

if (!$res_stats) {
    header("Location: error.php?tipus=desconegut");
    exit();
}
$stats = mysqli_fetch_assoc($res_stats);

// Lògica d'ordenació
// Recollim els paràmetres de la URL i validem les columnes per evitar injeccions
$ordre = $_GET['ordre'] ?? 'titol';
$dir = $_GET['dir'] ?? 'ASC';

$columnes_valides = ['titol', 'genere', 'any_estrena', 'puntuacio'];
if (!in_array($ordre, $columnes_valides)) { $ordre = 'titol'; }

// Consulta per obtenir el catàleg complet aplicant l'ordenació triada per l'usuari
$sql = "SELECT * FROM pelicules ORDER BY $ordre $dir";
$res = mysqli_query($conexion, $sql);

if (!$res) {
    header("Location: error.php?tipus=desconegut");
    exit();
}
?>

<div class="container">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
        <h2>🎥 Gestió del Catàleg de la Comunitat</h2>
        <a href="pelicules_create.php" class="btn btn-add">➕ Nova Pel·lícula</a>
    </div>

    <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 15px; margin-bottom: 30px;">
        <div style="background: #e3f2fd; padding: 15px; border-radius: 8px; text-align: center; border: 1px solid #bbdefb;">
            <span style="display: block; font-size: 0.9rem; color: #1976d2;">Total Catàleg</span>
            <strong style="font-size: 1.5rem;"><?php echo $stats['total'] ?? 0; ?> pelis</strong>
        </div>
        <div style="background: #f1f8e9; padding: 15px; border-radius: 8px; text-align: center; border: 1px solid #dcedc8;">
            <span style="display: block; font-size: 0.9rem; color: #388e3c;">Nota Mitjana</span>
            <strong style="font-size: 1.5rem;">⭐ <?php echo number_format($stats['media'] ?? 0, 1); ?></strong>
        </div>
        <div style="background: #fff3e0; padding: 15px; border-radius: 8px; text-align: center; border: 1px solid #ffe0b2;">
            <span style="display: block; font-size: 0.9rem; color: #f57c00;">Pel·lícules TOP</span>
            <strong style="font-size: 1.5rem;">🔥 <?php echo $stats['top_pelis'] ?? 0; ?></strong>
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th><a href="?ordre=titol&dir=<?php echo $dir == 'ASC' ? 'DESC' : 'ASC'; ?>" style="text-decoration:none; color:inherit;">Títol ▲▼</a></th>
                <th>Gènere</th>
                <th>Director</th>
                <th><a href="?ordre=any_estrena&dir=<?php echo $dir == 'ASC' ? 'DESC' : 'ASC'; ?>" style="text-decoration:none; color:inherit;">Any ▲▼</a></th>
                <th>Puntuació</th>
                <th style="width: 110px;">Accions</th>
            </tr>
        </thead>
        <tbody>
            <?php if(mysqli_num_rows($res) > 0): ?>
                <?php while($row = mysqli_fetch_assoc($res)): ?>
                <tr>
                    <td><strong><?php echo htmlspecialchars($row['titol']); ?></strong></td>
                    <td><?php echo htmlspecialchars($row['genere']); ?></td>
                    <td><?php echo htmlspecialchars($row['director']); ?></td>
                    <td><?php echo $row['any_estrena']; ?></td>
                    <td>⭐ <?php echo $row['puntuacio']; ?></td>
                    <td class="acciones">
                        <a href="pelicules_update.php?id=<?php echo $row['id_pelicula']; ?>" class="btn btn-edit" title="Editar">✏️</a>
                        <a href="pelicules_delete.php?id=<?php echo $row['id_pelicula']; ?>" class="btn btn-del" onclick="return confirm('Segur que vols eliminar-la?')" title="Eliminar">🗑️</a>
                    </td>
                </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr><td colspan="6" style="text-align:center;">No hi ha pel·lícules al catàleg.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>