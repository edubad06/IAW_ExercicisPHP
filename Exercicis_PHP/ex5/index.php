<?php
$preu = $_GET['preu'];
$iva = $_GET['iva'];
$preu_iva = number_format($preu + ($preu * $iva / 100), 2);
echo "Preu final amb l'IVA: $preu_iva €";
?>