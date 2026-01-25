<?php
require_once 'header.php';
require_once 'config/db_connect.php';

// Comprovar si l'usuari està loguejat
if (!$logado) { 
    header("Location: error.php?tipus=sessio_error"); 
    exit(); 
}

$id_usuari = $_SESSION['usuari']['id'];
$id_peli = null;

// L'app pot rebre un ID de la nostra BBDD (id_local) o un ID de l'API (imdbID)
if (isset($_GET['id_local'])) {
    // Cas 1: La pel·lícula ja existeix al nostre catàleg local
    $id_peli = (int)$_GET['id_local'];
} 
elseif (isset($_GET['imdbID'])) {
    // Cas 2: La pel·lícula prové de l'API
    $imdbID = mysqli_real_escape_string($conexion, $_GET['imdbID']);
    $apiKey = $MOVIE_API_KEY;
    // Petició HTTP GET al servidor d'OMDb per obtenir les dades
    $url = "http://www.omdbapi.com/?i=$imdbID&apikey=$apiKey";
    $json = file_get_contents($url);
    $movie = json_decode($json, true);

    if (isset($movie['Response']) && $movie['Response'] === 'True') {
        // Neteja i captura de dades de l'API
        $titol = mysqli_real_escape_string($conexion, $movie['Title']);
        $any = (int)$movie['Year'];
        $genere = mysqli_real_escape_string($conexion, $movie['Genre']);
        $puntuacio = (float)$movie['imdbRating'];
        $director = mysqli_real_escape_string($conexion, $movie['Director'] ?? 'Desconegut');
        $sinopsi = mysqli_real_escape_string($conexion, $movie['Plot'] ?? 'Sense descripció');

        // Comprovar si ja existeix al catàleg
        $check = mysqli_query($conexion, "SELECT id_pelicula FROM pelicules WHERE titol = '$titol' AND any_estrena = $any");
        
        if (mysqli_num_rows($check) > 0) {
            // Si ja existeix, recuperem el seu ID local
            $peli_data = mysqli_fetch_assoc($check);
            $id_peli = $peli_data['id_pelicula'];
        } else {
            // Si és nova, la inserim al catàleg
            $sql_ins = "INSERT INTO pelicules (titol, any_estrena, genere, puntuacio, director, sinopsi) 
                        VALUES ('$titol', $any, '$genere', $puntuacio, '$director', '$sinopsi')";
            
            if (mysqli_query($conexion, $sql_ins)) {
                $id_peli = mysqli_insert_id($conexion);
            } else {
                die("Error al catàleg: " . mysqli_error($conexion));
            }
        }
    }
}

// Un cop tenim l'ID local, l'enllacem amb l'usuari a la taula seguiment
if ($id_peli) {
    // Comprovar si l'usuari ja té aquesta pel·lícula a la seva llista
    $checkSeg = mysqli_query($conexion, "SELECT id_seguiment FROM seguiment WHERE id_usuari = $id_usuari AND id_pelicula = $id_peli");
    
    if (mysqli_num_rows($checkSeg) > 0) {
        // Notificar duplicat a la llista
        header("Location: movie_search.php?msg=repetida");
    } else {
        // Inserir a la llista de l'usuari amb estat 'Pendent' per defecte
        $sql_final = "INSERT INTO seguiment (id_usuari, id_pelicula, estat) VALUES ($id_usuari, $id_peli, 'Pendent')";
        if (mysqli_query($conexion, $sql_final)) {
            header("Location: seguiment_read.php?msg=afegida");
        } else {
            header("Location: error.php?tipus=desconegut");
        }
    }
    exit();
} else {
    // Retorn per defecte si no s'ha pogut processar cap ID
    header("Location: cataleg.php");
    exit();
}