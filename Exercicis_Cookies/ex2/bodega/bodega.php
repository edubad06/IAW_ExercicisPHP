<?php
$majoredat = $_GET["majoredat"];
$idioma = $_GET["idioma"];
$moneda = $_GET["moneda"];

setcookie("majoredat", $majoredat);
setcookie("idioma", $idioma);
setcookie("moneda", $moneda);

if ($majoredat == "no") {
    switch ($idioma) {
        case 'ca':
            echo "No et podem vendre alcohol si ets menor d'edat";
            break;
        case 'es':
            echo "No te podemos vender alcohol si eres menor de edad";
            break;
        case 'en':
            echo "We cannot sell you alcohol if you are a minor";
            break;
    }
} else {
    switch ($idioma) {
        case 'ca':
            switch ($moneda) {
                case 'eur':
                    echo "T'oferim el vi 'Les Terrasses' a un preu de 39 €<br><br>";
                    echo "T'oferim el vi 'Camins del Priorat' a un preu de 25 €";
                    break;
                case 'gbp':
                    echo "T'oferim el vi 'Les Terrasses' a un preu de 34 £<br><br>";
                    echo "T'oferim el vi 'Camins del Priorat' a un preu de 22 £";
                    break;
                case 'usd':
                    echo "T'oferim el vi 'Les Terrasses' a un preu de 45 $<br><br>";
                    echo "T'oferim el vi 'Camins del Priorat' a un preu de 29 $";
                    break;
            }
            break;
        case 'es':
            switch ($moneda) {
                case 'eur':
                    echo "Te ofrecemos el vino 'Les Terrasses' a un precio de 39 €<br><br>";
                    echo "Te ofrecemos el vino 'Camins del Priorat' a un precio de 25 €";
                    break;
                case 'gbp':
                    echo "Te ofrecemos el vino 'Les Terrasses' a un precio de 34 £<br><br>";
                    echo "Te ofrecemos el vino 'Camins del Priorat' a un precio de 22 £";
                    break;
                case 'usd':
                    echo "Te ofrecemos el vino 'Les Terrasses' a un precio de 45 $<br><br>";
                    echo "Te ofrecemos el vino 'Camins del Priorat' a un precio de 29 $";
                    break;
            }
            break;
        case 'en':
            switch ($moneda) {
                case 'eur':
                    echo "We offer you the 'Les Terrasses' wine at a price of €39<br><br>";
                    echo "We offer you the 'Camins del Priorat' wine at a price of €25";
                    break;
                case 'gbp':
                    echo "We offer you the 'Les Terrasses' wine at a price of £34<br><br>";
                    echo "We offer you the 'Camins del Priorat' wine at a price of £22";
                    break;
                case 'usd':
                    echo "We offer you the 'Les Terrasses' wine at a price of $45<br><br>";
                    echo "We offer you the 'Camins del Priorat' wine at a price of $29";
                    break;
            }
            break;
    }
}
?>