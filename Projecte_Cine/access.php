<?php
require_once 'header.php';
require_once 'config/db_connect.php';

// Recuperar dades de la sessió de l'usuari loguejat
$id_usuari = $_SESSION['usuari']['id'];
$nom_usuari = $_SESSION['usuari']['nom_usuari'];
$rol_actual = $_SESSION['usuari']['nom_rol']; 

// Estadístiques personals: comptar total, vistes i pendents de l'usuari
$sql_stats = "SELECT 
                COUNT(*) as total,
                SUM(CASE WHEN estat = 'Vista' THEN 1 ELSE 0 END) as vistes,
                SUM(CASE WHEN estat = 'Pendent' THEN 1 ELSE 0 END) as pendents
              FROM seguiment 
              WHERE id_usuari = $id_usuari";

$res_stats = mysqli_query($conexion, $sql_stats);
$stats = mysqli_fetch_assoc($res_stats);
?>

<div class="container" style="max-width: 1100px; margin: 0 auto; padding: 20px;">
    
    <div style="margin-bottom: 40px; text-align: center;">
        <h1 style="border: none; margin-bottom: 10px; font-size: 2.5rem;">Benvingut, <?php echo htmlspecialchars($nom_usuari); ?>! 🎬</h1>
        <p style="color: #666; font-size: 1.1rem;">Gestiona el teu univers cinematogràfic des d'aquí.</p>
    </div>

    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 20px; margin-bottom: 40px;">
        <div style="background: #fff; padding: 20px; border-radius: 15px; box-shadow: 0 4px 15px rgba(0,0,0,0.05); text-align: center; border-top: 5px solid #007bff;">
            <span style="color: #888; font-weight: bold; font-size: 0.8rem; text-transform: uppercase;">La meva llista</span>
            <div style="font-size: 2.2rem; font-weight: bold; margin-top: 5px;"><?php echo $stats['total'] ?? 0; ?></div>
        </div>
        <div style="background: #fff; padding: 20px; border-radius: 15px; box-shadow: 0 4px 15px rgba(0,0,0,0.05); text-align: center; border-top: 5px solid #28a745;">
            <span style="color: #888; font-weight: bold; font-size: 0.8rem; text-transform: uppercase;">Vistes</span>
            <div style="font-size: 2.2rem; font-weight: bold; margin-top: 5px; color: #28a745;"><?php echo $stats['vistes'] ?? 0; ?></div>
        </div>
        <div style="background: #fff; padding: 20px; border-radius: 15px; box-shadow: 0 4px 15px rgba(0,0,0,0.05); text-align: center; border-top: 5px solid #ffc107;">
            <span style="color: #888; font-weight: bold; font-size: 0.8rem; text-transform: uppercase;">Pendents</span>
            <div style="font-size: 2.2rem; font-weight: bold; margin-top: 5px; color: #856404;"><?php echo $stats['pendents'] ?? 0; ?></div>
        </div>
    </div>

    <hr style="border: 0; border-top: 1px solid #eee; margin-bottom: 40px;">

    <h3 style="margin-bottom: 25px; text-align: left; color: #333;">Accions disponibles</h3>
    
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 25px;">
        
        <a href="movie_search.php" style="text-decoration: none; color: inherit; display: flex;">
            <div style="background: #f0f7ff; padding: 30px; border-radius: 20px; border: 1px solid #cfe2f3; transition: 0.3s; width: 100%; box-sizing: border-box;" onmouseover="this.style.transform='translateY(-5px)'; this.style.boxShadow='0 10px 20px rgba(0,0,0,0.1)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='none'">
                <div style="font-size: 2.5rem; margin-bottom: 15px;">🔍</div>
                <h4 style="margin: 0 0 10px 0; color: #0056b3; font-size: 1.3rem;">Cercador</h4>
                <p style="margin: 0; color: #555; font-size: 0.95rem; line-height: 1.5;">Busca pel·lícules a la base de dades mundial i afegeix-les a la teva llista.</p>
            </div>
        </a>

        <a href="cataleg.php" style="text-decoration: none; color: inherit; display: flex;">
            <div style="background: #fffdf0; padding: 30px; border-radius: 20px; border: 1px solid #f9f2d0; transition: 0.3s; width: 100%; box-sizing: border-box;" onmouseover="this.style.transform='translateY(-5px)'; this.style.boxShadow='0 10px 20px rgba(0,0,0,0.1)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='none'">
                <div style="font-size: 2.5rem; margin-bottom: 15px;">📚</div>
                <h4 style="margin: 0 0 10px 0; color: #856404; font-size: 1.3rem;">Catàleg</h4>
                <p style="margin: 0; color: #555; font-size: 0.95rem; line-height: 1.5;">Explora les pel·lícules que ja estan registrades a CineManager i afegeix-les directament.</p>
            </div>
        </a>

        <a href="seguiment_read.php" style="text-decoration: none; color: inherit; display: flex;">
            <div style="background: #f6fff0; padding: 30px; border-radius: 20px; border: 1px solid #d9f2d0; transition: 0.3s; width: 100%; box-sizing: border-box;" onmouseover="this.style.transform='translateY(-5px)'; this.style.boxShadow='0 10px 20px rgba(0,0,0,0.1)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='none'">
                <div style="font-size: 2.5rem; margin-bottom: 15px;">🍿</div>
                <h4 style="margin: 0 0 10px 0; color: #2d6a12; font-size: 1.3rem;">La meva llista</h4>
                <p style="margin: 0; color: #555; font-size: 0.95rem; line-height: 1.5;">Revisa el teu seguiment, canvia l'estat de les teves pelis o exporta la teva llista.</p>
            </div>
        </a>

        <?php if ($rol_actual === 'Moderador'): ?>
        <a href="pelicules_read.php" style="text-decoration: none; color: inherit; display: flex;">
            <div style="background: #fff9f0; padding: 30px; border-radius: 20px; border: 1px solid #f9ebd6; transition: 0.3s; width: 100%; box-sizing: border-box;" onmouseover="this.style.transform='translateY(-5px)'; this.style.boxShadow='0 10px 20px rgba(0,0,0,0.1)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='none'">
                <div style="font-size: 2.5rem; margin-bottom: 15px;">⚙️</div>
                <h4 style="margin: 0 0 10px 0; color: #a35200; font-size: 1.3rem;">Administració</h4>
                <p style="margin: 0; color: #555; font-size: 0.95rem; line-height: 1.5;">Gestiona el catàleg global del sistema, edita dades o elimina pel·lícules de la base.</p>
            </div>
        </a>
        <?php endif; ?>

    </div>
</div>