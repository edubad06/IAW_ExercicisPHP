<?php
$quantitat = $_GET['quantitat'];
$moneda = $_GET['moneda'];
$apiKey = 'f3bbccb5abcde21da66dfa4c';

if ($moneda == "eur-usd") {
    $url = "https://v6.exchangerate-api.com/v6/$apiKey/latest/EUR";
    $response = file_get_contents($url);
    $dada = json_decode($response, true);
    $canvi = $dada['conversion_rates']['USD'];
    $resultat = $quantitat * $canvi;
    echo "$quantitat € són $resultat $";
} else {
    $url = "https://v6.exchangerate-api.com/v6/$apiKey/latest/USD";
    $response = file_get_contents($url);
    $dada = json_decode($response, true);
    $canvi = $dada['conversion_rates']['EUR'];
    $resultat = $quantitat * $canvi;
    echo "$quantitat $ són $resultat €";
}
?>