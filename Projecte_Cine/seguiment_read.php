<?php
require_once 'header.php';
require_once 'config/db_connect.php';

// Control d'accés
if (!$logado) { 
    header("Location: error.php?tipus=sessio_error"); 
    exit(); 
}

$id_usuari = $_SESSION['usuari']['id'];
$filtre = $_GET['estat'] ?? 'tots';

// Consulta JOIN per combinar seguiment i dades de pel·lícula
$sql = "SELECT s.*, p.titol, p.genere 
        FROM seguiment s 
        JOIN pelicules p ON s.id_pelicula = p.id_pelicula 
        WHERE s.id_usuari = $id_usuari";

// Aplicar filtre si n'hi ha
if ($filtre !== 'tots') { 
    $filtre_safe = mysqli_real_escape_string($conexion, $filtre);
    $sql .= " AND s.estat = '$filtre_safe'"; 
}

$res = mysqli_query($conexion, $sql);

if (!$res) {
    header("Location: error.php?tipus=desconegut");
    exit();
}
?>

<div class="container">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
        <h2>🍿 La meva Llista de Seguiment</h2>
        <a href="movie_search.php" class="btn btn-add">🔍 Buscar més pel·lícules</a>
    </div>
    
    <div style="background: #f8f9fa; padding: 15px; border-radius: 8px; margin-bottom: 20px; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 10px;">
        
        <form method="GET" style="display: flex; align-items: center; gap: 10px; margin-bottom: 0;">
            <span>Filtrar per estat:</span>
            <select name="estat" onchange="this.form.submit()" style="width: auto; margin-bottom: 0;">
                <option value="tots" <?php if($filtre=='tots') echo 'selected'; ?>>Totes les pelis</option>
                <option value="Pendent" <?php if($filtre=='Pendent') echo 'selected'; ?>>Pendents</option>
                <option value="Vista" <?php if($filtre=='Vista') echo 'selected'; ?>>Vistes</option>
            </select>
        </form>

        <div style="display: flex; gap: 10px;">
            <a href="export_csv.php" class="btn" style="background: #28a745; color: white; height: auto; padding: 8px 15px; font-weight: bold; font-size: 0.9rem; text-decoration: none; border-radius: 4px;">
                Exportar a CSV
            </a>
            <a href="export_pdf.php" class="btn" style="background: #dc3545; color: white; height: auto; padding: 8px 15px; font-weight: bold; font-size: 0.9rem; text-decoration: none; border-radius: 4px;">
                Exportar a PDF
            </a>
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th>Títol</th>
                <th>Gènere</th>
                <th>Estat</th>
                <th>Comentari</th>
                <th style="width: 110px;">Accions</th>
            </tr>
        </thead>
        <tbody>
            <?php if(mysqli_num_rows($res) > 0): ?>
                <?php while($row = mysqli_fetch_assoc($res)): ?>
                <tr>
                    <td><strong><?php echo htmlspecialchars($row['titol']); ?></strong></td>
                    <td><small><?php echo htmlspecialchars($row['genere']); ?></small></td>
                    <td>
                        <span style="padding: 4px 10px; border-radius: 20px; font-size: 0.85rem; font-weight: bold; 
                                     background: <?php echo $row['estat']=='Vista' ? '#d1e7dd':'#fff3cd'; ?>; 
                                     color: <?php echo $row['estat']=='Vista' ? '#0f5132':'#856404'; ?>;">
                            <?php echo $row['estat']; ?>
                        </span>
                    </td>
                    <td>
                        <?php if(!empty($row['comentari_personal'])): ?>
                            <i style="color: #555; font-size: 0.9rem;">"<?php echo htmlspecialchars($row['comentari_personal']); ?>"</i>
                        <?php else: ?>
                            <span style="color: #ccc; font-size: 0.8rem;">Sense comentaris</span>
                        <?php endif; ?>
                    </td>
                    <td class="acciones">
                        <a href="seguiment_update.php?id=<?php echo $row['id_seguiment']; ?>" class="btn btn-edit" title="Editar">✏️</a>
                        <a href="seguiment_delete.php?id=<?php echo $row['id_seguiment']; ?>" class="btn btn-del" onclick="return confirm('Vols treure-la de la llista?')" title="Eliminar">🗑️</a>
                    </td>
                </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="5" style="text-align:center; padding: 40px; color: #777;">
                        No tens cap pel·lícula en aquesta secció. <br>
                        <a href="movie_search.php" style="color: #007bff;">Comença a buscar ara!</a>
                    </td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?php 
if (isset($_GET['msg']) && $_GET['msg'] === 'afegida') {
    echo "<script>alert('Pel·lícula afegida correctament a la teva llista!');</script>";
}
if (isset($_GET['msg']) && $_GET['msg'] === 'eliminat') {
    echo "<script>alert('Registre eliminat de la teva llista.');</script>";
}
?>