<?php
session_start();

$preus = array(
    "poma" => 0.5,
    "taronja" => 0.8
);

if (!isset($_SESSION['cistella'])) {
    $_SESSION['cistella'] = [];
}

$poma_quant = $_GET['poma'];
$taronja_quant = $_GET['taronja'];

if ($poma_quant > 0) {
    if (isset($_SESSION['cistella']['poma'])) {
        $_SESSION['cistella']['poma'] += $poma_quant;
    } else {
        $_SESSION['cistella']['poma'] = $poma_quant;
    }
}

if ($taronja_quant > 0) {
    if (isset($_SESSION['cistella']['taronja'])) {
        $_SESSION['cistella']['taronja'] += $taronja_quant;
    } else {
        $_SESSION['cistella']['taronja'] = $taronja_quant;
    }
}

header("Location: index.html");
?>