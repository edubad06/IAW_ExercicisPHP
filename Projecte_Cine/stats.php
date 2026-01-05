<?php
require_once 'header.php';
require_once 'config/conexion.php';

// Control d'accés
if (!$logado) { 
    header("Location: login.php"); 
    exit(); 
}

$pelicula_data = null;
$error_api = null;

// Processar la cerca quan s'envia el formulari
if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['titol'])) {
    $titol_buscat = urlencode(trim($_POST['titol']));
    
    // URL de la API OMDb
    $url = "http://www.omdbapi.com/?t={$titol_buscat}&apikey={$MOVIE_API_KEY}";
    
    // Realitzar la petició
    $res = @file_get_contents($url);
    
    if ($res) {
        $data = json_decode($res, true);
        
        // Verificar si la API ha retornat una pel·lícula vàlida
        if (isset($data['Response']) && $data['Response'] === "True") {
            $pelicula_data = $data;
        } else {
            $error_api = "No s'ha trobat cap pel·lícula amb aquest títol a la base de dades internacional.";
        }
    } else {
        $error_api = "Error de connexió: No s'ha pogut contactar amb el servidor de cinema.";
    }
}
?>

<div class="container">
    <h2>🔍 Cercador de Cinema (OMDb API)</h2>
    <p>Troba qualsevol pel·lícula i afegeix-la directament al teu catàleg i llista de seguiment.</p>
    
    <form method="POST" style="display:flex; gap:10px; margin-bottom: 20px;">
        <input type="text" name="titol" placeholder="Escriu el títol (ex: Matrix, Inception, Titanic...)" required style="margin-bottom:0;">
        <button type="submit" class="btn btn-edit" style="white-space:nowrap; background:#1a1a1a;">Cercar</button>
    </form>

    <?php if ($error_api): ?> 
        <div style="background:#fee2e2; color:#b91c1c; padding:15px; border-radius:8px; border:1px solid #f87171; margin-bottom: 20px;">
            <strong>Avís:</strong> <?php echo htmlspecialchars($error_api); ?>
        </div>
    <?php endif; ?>

    <?php if ($pelicula_data): ?>
        <div style="margin-top:30px; display: flex; flex-wrap: wrap; gap: 30px; background: #f9f9f9; padding: 25px; border-radius: 12px; border: 1px solid #ddd;">
            
            <div style="text-align: center;">
                <img src="<?php echo ($pelicula_data['Poster'] !== 'N/A') ? $pelicula_data['Poster'] : 'https://via.placeholder.com/300x450?text=Sense+Imatge'; ?>" 
                     alt="Poster" 
                     style="width: 250px; border-radius: 8px; box-shadow: 0 4px 10px rgba(0,0,0,0.3);">
            </div>

            <div style="flex: 1; min-width: 300px;">
                <h3 style="margin-top:0; color:#007bff; font-size: 2rem;"><?php echo htmlspecialchars($pelicula_data['Title']); ?></h3>
                
                <p><strong>📅 Any:</strong> <?php echo htmlspecialchars($pelicula_data['Year']); ?></p>
                <p><strong>🎬 Director:</strong> <?php echo htmlspecialchars($pelicula_data['Director']); ?></p>
                <p><strong>🎭 Gènere:</strong> <?php echo htmlspecialchars($pelicula_data['Genre']); ?></p>
                <p><strong>📝 Sinopsi:</strong> <?php echo htmlspecialchars($pelicula_data['Plot']); ?></p>
                <p style="font-size: 1.2rem;"><strong>⭐ Puntuació IMDB:</strong> <span style="color:#f39c12; font-weight:bold;"><?php echo htmlspecialchars($pelicula_data['imdbRating']); ?></span></p>

                <hr style="border:0; border-top:1px solid #eee; margin: 20px 0;">

                <form action="api_to_db.php" method="POST">
                    <input type="hidden" name="titol" value="<?php echo htmlspecialchars($pelicula_data['Title']); ?>">
                    <input type="hidden" name="genere" value="<?php echo htmlspecialchars($pelicula_data['Genre']); ?>">
                    <input type="hidden" name="director" value="<?php echo htmlspecialchars($pelicula_data['Director']); ?>">
                    <input type="hidden" name="any" value="<?php echo (int)$pelicula_data['Year']; ?>">
                    <input type="hidden" name="sinopsi" value="<?php echo htmlspecialchars($pelicula_data['Plot']); ?>">
                    <input type="hidden" name="puntuacio" value="<?php echo (float)$pelicula_data['imdbRating']; ?>">
                    
                    <button type="submit" class="btn btn-add" style="background: #e67e22; width: 100%; padding: 15px; font-weight: bold; font-size: 1rem;">
                        📥 AFEGIR A LA MEVA LLISTA
                    </button>
                </form>
                <p style="font-size: 0.8rem; color: #777; margin-top: 10px; text-align: center;">
                    *Aquesta acció desarà la pel·lícula amb les dades oficials i la posarà a la teva llista personal.
                </p>
            </div>
        </div>
    <?php endif; ?>
</div>

<?php 
// Gestió de missatges de retorn
if (isset($_GET['msg'])) {
    if ($_GET['msg'] === 'error_db') echo "<script>alert('Error: El gènere de la API no és compatible amb el format de la teva base de dades.');</script>";
    if ($_GET['msg'] === 'error_seguiment') echo "<script>alert('Error al guardar a la teva llista.');</script>";
}
?>