<?php
$preu = $_POST['preu'];
$iva = $_POST['iva'];
$preu_iva = number_format($preu + ($preu * $iva / 100), 2);
echo "Preu final amb l'IVA: $preu_iva €";
?>