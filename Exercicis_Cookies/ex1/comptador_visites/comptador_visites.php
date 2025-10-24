<?php
$codi_desc = $_GET['desc'];
if(isset($_COOKIE['visites'])) {
    $num_visites = $_COOKIE['visites'] + 1;
} else {
    $num_visites = 1;
}

setcookie('visites', $num_visites);     
echo "Comptador de visites: $num_visites<br><br>";

if(isset($_COOKIE['descompte'])) {
    $descompte = $_COOKIE['descompte'];
} else {
    $descompte = false;
}

if (($codi_desc == "BOTIGA20" && $num_visites >= 5 && $descompte == false) || ($codi_desc == "BOTIGA50" && $num_visites >= 10 && $descompte == false)) {
    setcookie('descompte', true);
    echo "S'ha aplicat el descompte<br><br>";
} else {
    echo "El codi de descompte no és vàlid o no se introduït cap<br><br>";
}

if($num_visites == 5 && $descompte == false) {
    echo "Oferta exclusiva! Utilitza el codi BOTIGA20 per obtenir un 20% de descompte en les teves primeres compres a la botiga";
} elseif ($num_visites == 10 && $descompte == false) {
    echo "Oferta exclusiva sols per a tu! Utilitza el codi BOTIGA50 per obtenir un 50% de descompte en les teves primeres compres a la botiga";
}
?>