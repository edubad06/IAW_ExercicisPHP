<?php
require_once 'header.php';
require_once 'config/db_connect.php';

// Control d'accés
if (!$logado) { 
    header("Location: error.php?tipus=sessio_error"); 
    exit(); 
}

$llista_pelis = [];
$detall_peli = null;
$error_api = null;

$api_key = $MOVIE_API_KEY;

// Si fem una nova cerca per formulari, netegem la selecció actual de la URL
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    unset($_GET['id']); 
}

// Si rebem un ID d'IMDB per URL, fem una consulta específica per obtenir la sinopsi i detalls complets.
if (isset($_GET['id'])) {
    $id = urlencode($_GET['id']);
    // Petició a l'API
    $url = "http://www.omdbapi.com/?i={$id}&plot=full&apikey={$api_key}";
    $res = @file_get_contents($url);
    if ($res) {
        $detall_peli = json_decode($res, true); // Convertir el JSON en un array
    }
}

// Cercador
// Si el cercador està buit, mostra resultats genèrics de "movie"
if ($_SERVER['REQUEST_METHOD'] === 'POST' || (empty($llista_pelis) && !isset($_GET['id']))) {
    
    $cerca_usuari = isset($_POST['cerca']) ? trim($_POST['cerca']) : '';
    $any = isset($_POST['any']) ? trim($_POST['any']) : ''; 
    $tipus = isset($_POST['tipus']) ? $_POST['tipus'] : '';

    $paraula_clau = empty($cerca_usuari) ? "movie" : urlencode($cerca_usuari);
    $url_base = "http://www.omdbapi.com/?s={$paraula_clau}&apikey={$api_key}";
    
    // Afegir filtres a la URL de l'API
    if (!empty($any)) { $url_base .= "&y=" . urlencode($any); }
    if (!empty($tipus)) { $url_base .= "&type=" . urlencode($tipus); }
    
    // Obtenir resultats de la pàgina 1
    $res1 = @file_get_contents($url_base . "&page=1");
    
    if ($res1) {
        $data1 = json_decode($res1, true);
        if (isset($data1['Response']) && $data1['Response'] === "True") {
            $resultats_api = $data1['Search'];

            // Demanar pàgina 2 i ajuntar els resultats
            $res2 = @file_get_contents($url_base . "&page=2");
            if ($res2) {
                $data2 = json_decode($res2, true);
                if (isset($data2['Search'])) {
                    $resultats_api = array_merge($resultats_api, $data2['Search']);
                }
            }

            // Neteja de duplicats i limitació a 10 resultats
            $ids_vistes = []; 
            $temp_llista = [];

            foreach ($resultats_api as $peli) {
                if (!in_array($peli['imdbID'], $ids_vistes) && count($temp_llista) < 10) {
                    $temp_llista[] = $peli;
                    $ids_vistes[] = $peli['imdbID'];
                }
            }

            // Ordenar per any d'estrena
            usort($temp_llista, function($a, $b) {
                $anyA = (int)filter_var($a['Year'], FILTER_SANITIZE_NUMBER_INT);
                $anyB = (int)filter_var($b['Year'], FILTER_SANITIZE_NUMBER_INT);
                return $anyB <=> $anyA;
            });
            
            $llista_pelis = $temp_llista;
        } else {
            $error_api = "No s'han trobat resultats per a aquesta cerca.";
        }
    }
}
?>

<div class="container">
    <h2>🔍 Cercador de pel·lícules</h2>
    <p>Explora les novetats o cerca pel·lícules/sèries mitjançant l'API d'OMBd.</p>

    <form method="POST" style="background: #f8f9fa; padding: 20px; border-radius: 10px; border: 1px solid #ddd; margin-bottom: 30px;">
        <div style="display: grid; grid-template-columns: 2fr 1fr 1fr; gap: 15px;">
            <div>
                <label style="font-weight:bold;">Títol:</label>
                <input type="text" name="cerca" placeholder="Ex: Marvel, Batman..." value="<?php echo isset($_POST['cerca']) ? htmlspecialchars($_POST['cerca']) : ''; ?>">
            </div>
            <div>
                <label style="font-weight:bold;">Any:</label>
                <input type="number" name="any" placeholder="Ex: 2025" value="<?php echo isset($_POST['any']) ? htmlspecialchars($_POST['any']) : ''; ?>">
            </div>
            <div>
                <label style="font-weight:bold;">Tipus:</label>
                <select name="tipus">
                    <option value="">Tots</option>
                    <option value="movie" <?php echo (isset($_POST['tipus']) && $_POST['tipus'] == 'movie') ? 'selected' : ''; ?>>Pel·lícules</option>
                    <option value="series" <?php echo (isset($_POST['tipus']) && $_POST['tipus'] == 'series') ? 'selected' : ''; ?>>Sèries</option>
                </select>
            </div>
        </div>
        <button type="submit" class="btn btn-edit" style="width: 100%; margin-top: 15px; background: #1a1a1a; font-weight:bold; height:auto; padding:12px;">🚀 Cercar</button>
    </form>

    <?php if ($detall_peli): ?>
        <div id="detall" style="background: #fff; padding: 25px; border-radius: 12px; border: 2px solid #28a745; margin-bottom: 40px; display: flex; gap: 30px; flex-wrap: wrap; box-shadow: 0 10px 30px rgba(0,0,0,0.1);">
            <div style="flex: 0 0 200px; text-align: center;">
                <img src="<?php echo ($detall_peli['Poster'] !== 'N/A') ? $detall_peli['Poster'] : 'https://via.placeholder.com/200x300'; ?>" style="width:100%; border-radius:8px;">
            </div>
            <div style="flex: 1; min-width: 300px;">
                <div style="display:flex; justify-content:space-between; align-items:flex-start;">
                    <h3 style="margin-top:0; color:#28a745;"><?php echo htmlspecialchars($detall_peli['Title']); ?></h3>
                    <a href="movie_search.php" style="text-decoration:none; color:#999; font-size:1.5rem;">&times;</a>
                </div>
                <p><strong>📅 Any:</strong> <?php echo $detall_peli['Year']; ?> | <strong>⭐ IMDB:</strong> <?php echo $detall_peli['imdbRating']; ?></p>
                <p><strong>📝 Sinopsi:</strong> <?php echo htmlspecialchars($detall_peli['Plot']); ?></p>
                
                <div style="margin-top:20px;">
                    <a href="movie_import.php?imdbID=<?php echo $detall_peli['imdbID']; ?>" class="btn btn-add" style="display:block; width:100%; background:#28a745; height:auto; padding:12px; font-weight:bold; text-align:center; color:white; border-radius:6px; text-decoration:none;">
                        📥 AFEGIR A LA MEVA LLISTA
                    </a>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <?php if (!empty($llista_pelis)): ?>
        <h3 style="margin-bottom:20px; color:#555;">Resultats:</h3>
        <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(180px, 1fr)); gap: 20px;">
            <?php foreach ($llista_pelis as $peli): ?>
                <a href="movie_search.php?id=<?php echo $peli['imdbID']; ?>#detall" style="text-decoration:none; color:inherit;">
                    <div style="background: #fff; border: 1px solid #ddd; border-radius: 8px; padding: 10px; text-align: center; height: 100%; display:flex; flex-direction:column; justify-content:space-between; transition: 0.3s;" onmouseover="this.style.borderColor='#007bff'" onmouseout="this.style.borderColor='#ddd'">
                        <img src="<?php echo ($peli['Poster'] !== 'N/A') ? $peli['Poster'] : 'https://via.placeholder.com/150x220?text=Sense+Poster'; ?>" style="width:100%; border-radius:4px; margin-bottom:10px;">
                        <div>
                            <h4 style="font-size: 0.9rem; margin: 5px 0;"><?php echo htmlspecialchars($peli['Title']); ?></h4>
                            <p style="font-size: 0.8rem; color: #777;"><?php echo $peli['Year']; ?></p>
                        </div>
                        <span style="color: #007bff; font-size: 0.8rem; font-weight:bold; margin-top:10px;">Veure detalls →</span>
                    </div>
                </a>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <?php if ($error_api) echo "<div style='color:#b91c1c; background:#fee2e2; padding:15px; border-radius:8px; margin-top:20px;'>$error_api</div>"; ?>
</div>