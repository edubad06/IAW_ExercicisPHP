<?php
require_once 'config/db_connect.php';
session_start();

// Si no hi ha sessió activa, redirigim a l'error
if (!isset($_SESSION['usuari'])) { 
    header("Location: error.php?tipus=sessio_error");
    exit(); 
}

$id_usuari = $_SESSION['usuari']['id'];
$nom_fitxer = "la_meva_llista.csv";

// Configurar les capçaleres HTTP per forçar la descàrrega del fitxer CSV
header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename=' . $nom_fitxer);

// Obrir la sortida de PHP com a fitxer per escriure
$sortida = fopen('php://output', 'w');

// Afegir el BOM UTF-8 perquè el full de càlcul reconegui correctament els accents
fprintf($sortida, chr(0xEF).chr(0xBB).chr(0xBF));

// Capçaleres de les columnes del CSV
fputcsv($sortida, array('Títol', 'Gènere', 'Any', 'Estat', 'Nota IMDB', 'Data Afegit', 'Comentaris'), ';');

// Consulta SQL per obtenir la llista personalitzada amb les dades de les pel·lícules
$sql = "SELECT p.titol, p.genere, p.any_estrena, s.estat, p.puntuacio, s.data_afegit, s.comentari_personal 
        FROM seguiment s 
        JOIN pelicules p ON s.id_pelicula = p.id_pelicula 
        WHERE s.id_usuari = $id_usuari 
        ORDER BY s.data_afegit DESC";

$resultat = mysqli_query($conexion, $sql);

// Recorre els resultats i escriure línia per línia al fitxer
while ($fila = mysqli_fetch_assoc($resultat)) {
    fputcsv($sortida, $fila, ';');
}

// Tancar el recurs i finalitzar l'execució
fclose($sortida);
exit();