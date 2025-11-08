<?php
session_start();

$preus = array(
    "poma" => 0.5,
    "taronja" => 0.8
);

if (isset($_SESSION['cistella'])) {
    $cistella = $_SESSION['cistella'];
} else {
    $cistella = [];
}

if (empty($cistella)) {
    if (isset($_COOKIE['poma'])) {
        $cistella['poma'] = $_COOKIE['poma'];
    }
    if (isset($_COOKIE['taronja'])) {
        $_cistella['taronja'] = $_COOKIE['taronja'];
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Resum compra</title>
</head>
<body>
    <h2>Resum compra</h2>
    <?php
    $total = 0;
    foreach ($cistella as $producte => $quantitat) {
        $total_prod = $quantitat * $preus[$producte];
        $total += $total_prod;
        echo "$quantitat $producte = $total_prod €<br>";
    }
    echo "Total: $total €";
    ?>
    <br>
    <a href="confirmar.php">Confirmar compra</a>
</body>
</html>