<?php
// Desactivar la visualització d'errors per evitar corrompre el fitxer binari del PDF
error_reporting(0); 
ini_set('display_errors', 0);

require_once 'config/db_connect.php';
require_once 'fpdf/fpdf.php'; // Llibreria externa per a la generació de PDF
session_start();

// Si no hi ha sessió activa, redirigim a l'error
if (!isset($_SESSION['usuari'])) { 
    header("Location: error.php?tipus=sessio_error");
    exit(); 
}

$id_usuari = $_SESSION['usuari']['id'];

// Extensió de la classe FPDF per personalitzar la capçalera i el peu de pàgina
class PDF extends FPDF {
    function Header() {
        $this->SetFont('Arial', 'B', 20);
        $this->SetTextColor(33, 37, 41);
        $this->Cell(0, 15, iconv('UTF-8', 'windows-1252//TRANSLIT', 'LA MEVA LLISTA DE PEL·LÍCULES'), 0, 1, 'C');
        $this->Ln(4); 
    }

    function Footer() {
        $this->SetY(-15);
        $this->SetFont('Arial', 'I', 9);
        $this->SetTextColor(128);
        // Numeració de pàgines automàtica
        $this->Cell(0, 10, iconv('UTF-8', 'windows-1252//TRANSLIT', 'Pàgina ') . $this->PageNo() . '/{nb}', 0, 0, 'C');
    }
}

// Netejar el buffer de sortida per assegurar que el PDF es generi correctament
if (ob_get_length()) ob_end_clean();

// Inicialitzar l'objecte PDF i configurar marges
$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage();

$margenIzquierdo = 20;
$pdf->SetMargins($margenIzquierdo, 15, $margenIzquierdo); 
$pdf->SetAutoPageBreak(true, 20);

// Consulta SQL per obtenir les dades de seguiment de l'usuari actual
$sql = "SELECT p.titol, p.genere, p.any_estrena, s.estat, p.puntuacio, s.comentari_personal 
        FROM seguiment s 
        JOIN pelicules p ON s.id_pelicula = p.id_pelicula 
        WHERE s.id_usuari = $id_usuari 
        ORDER BY s.data_afegit DESC";

$resultat = mysqli_query($conexion, $sql);

// Bucle de renderitzat de cada pel·lícula al PDF
while ($row = mysqli_fetch_assoc($resultat)) {
    $pdf->SetX($margenIzquierdo);

    // Títol de la pel·lícula
    $pdf->SetFont('Arial', 'B', 13);
    $pdf->SetFillColor(245, 245, 245);
    $pdf->SetTextColor(0, 80, 160); 
    $pdf->Cell(0, 11, iconv('UTF-8', 'windows-1252//TRANSLIT', '  ' . strtoupper($row['titol'])), 0, 1, 'L', true);

    // Bloc d'informació tècnica (Any, Gènere i Nota)
    $pdf->SetX($margenIzquierdo);
    $pdf->SetFont('Arial', 'B', 10);
    $pdf->SetTextColor(70, 70, 70);
    $info = $row['any_estrena'] . "  |  " . $row['genere'] . "  |  Nota: " . $row['puntuacio'] . "/10";
    $pdf->Cell(0, 8, iconv('UTF-8', 'windows-1252//TRANSLIT', $info), 0, 1, 'L');

    // Estat de visionat
    $pdf->SetX($margenIzquierdo);
    $pdf->SetFont('Arial', 'I', 9);
    $pdf->SetTextColor(100, 100, 100);
    $pdf->Cell(0, 5, iconv('UTF-8', 'windows-1252//TRANSLIT', "Estat: " . $row['estat']), 0, 1, 'L');

    // Comentari personal de l'usuari
    $pdf->Ln(1);
    $pdf->SetX($margenIzquierdo);
    $pdf->SetFont('Arial', '', 10.5);
    $pdf->SetTextColor(40, 40, 40);
    $comentario = !empty($row['comentari_personal']) ? $row['comentari_personal'] : "Sense comentaris personals.";
    $pdf->MultiCell(0, 5.5, iconv('UTF-8', 'windows-1252//TRANSLIT', '"' . $comentario . '"'), 0, 'L');

    // Línia separadora entre registres
    $pdf->Ln(4); 
    $pdf->SetDrawColor(210, 210, 210);
    $currentY = $pdf->GetY();
    $pdf->Line($margenIzquierdo, $currentY, 190, $currentY);
    $pdf->Ln(7); 
}

// Forçat de descàrrega del fitxer amb el nom especificat
$pdf->Output('D', 'la_meva_llista.pdf');