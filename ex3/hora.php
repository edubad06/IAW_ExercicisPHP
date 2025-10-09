<?php
date_default_timezone_set('Europe/Madrid');

$hora = date("G");
$hora_completa = date("H:i");

echo $hora_completa;
echo "<br>";

if ($hora >= 5 && $hora < 14) {
    echo "Bon dia";
} elseif ($hora >= 14 && $hora < 19) {
    echo "Bona tarda";
} else {
    echo "Bona nit";
}
?>