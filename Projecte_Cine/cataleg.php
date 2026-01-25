<?php
require_once 'header.php';
require_once 'config/db_connect.php';

// Gestió del cercador
$cerca = isset($_GET['cerca']) ? mysqli_real_escape_string($conexion, $_GET['cerca']) : '';
$sql = "SELECT * FROM pelicules";
// Filtrar per títol o gènere si l'usuari ha introduït una paraula clau
if (!empty($cerca)) {
    $sql .= " WHERE titol LIKE '%$cerca%' OR genere LIKE '%$cerca%'";
}
// Ordenar els resultats alfabèticament per títol
$sql .= " ORDER BY titol ASC";
$res = mysqli_query($conexion, $sql);
?>

<div class="container">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px;">
        <h2>📚 Catàleg de la Comunitat</h2>
        <a href="movie_search.php" class="btn btn-edit" style="height:auto; padding:10px 20px;">🔍 Cercador</a>
    </div>

    <form method="GET" style="display: flex; gap: 10px; margin-bottom: 30px;">
        <input type="text" name="cerca" placeholder="Cerca al catàleg..." value="<?php echo htmlspecialchars($cerca); ?>" style="margin-bottom:0;">
        <button type="submit" class="btn btn-edit" style="height:auto; width:100px;">Filtrar</button>
    </form>

    <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 20px;">
        <?php if(mysqli_num_rows($res) > 0): ?>
            <?php while($peli = mysqli_fetch_assoc($res)): ?>
                <div style="background: white; border: 1px solid #ddd; padding: 20px; border-radius: 15px; box-shadow: 0 4px 6px rgba(0,0,0,0.05); display: flex; flex-direction: column; justify-content: space-between;">
                    <div>
                        <div style="display:flex; justify-content:space-between; align-items:flex-start; gap: 10px;">
                            <h4 style="margin: 0; color: #1a1a1a; font-size: 1.2rem; line-height: 1.2;">
                                <?php echo htmlspecialchars($peli['titol']); ?>
                            </h4>
                            <span style="background: #ffc107; color: #000; padding: 5px 10px; border-radius: 8px; font-weight: bold; font-size: 0.9rem; display: flex; align-items: center; gap: 5px; white-space: nowrap; height: fit-content;">
                                ⭐ <?php echo number_format($peli['puntuacio'], 1); ?>
                            </span>
                        </div>
                        <p style="margin: 10px 0; font-size: 0.9rem; color: #666;">
                            <strong>Gènere:</strong> <?php echo htmlspecialchars($peli['genere']); ?><br>
                            <strong>Any:</strong> <?php echo $peli['any_estrena']; ?>
                        </p>
                    </div>
                    
                    <div style="margin-top: 15px; border-top: 1px solid #eee; padding-top: 15px;">
                        <a href="movie_import.php?id_local=<?php echo $peli['id_pelicula']; ?>" class="btn btn-add" style="width: 100%; height:auto; padding:12px; text-decoration:none; text-align:center; display:flex; align-items:center; justify-content:center; color:white; font-weight:bold;">
                            <span style="font-size:1.0rem; margin-right:8px;">+</span> Afegir a la meva llista
                        </a>
                    </div>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p style="grid-column: 1/-1; text-align: center; color: #999; padding: 40px;">El catàleg està buit o no hi ha coincidències.</p>
        <?php endif; ?>
    </div>
</div>