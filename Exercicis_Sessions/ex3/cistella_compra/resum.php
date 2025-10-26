<?php
session_start();

$preus = array(
    "poma" => 0.5,
    "taronja" => 0.8
);
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
    foreach ($_SESSION['cistella'] as $producte => $quantitat) {
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