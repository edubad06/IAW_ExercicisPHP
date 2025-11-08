<?php
session_start();

if (isset($_COOKIE['visites'])) {
    $visites = $_COOKIE['visites'] + 1;
} else {
    $visites = 1;
}

setcookie('visites', $visites, time() + 365 * 24 * 60 * 60);

if (isset($_SESSION['visites_sessio'])) {
    $_SESSION['visites_sessio']++;
} else {
    $_SESSION['visites_sessio'] = 1;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Comptador de visites</title>
</head>
<body>
    <h2>Comptador de visites</h2>
    <p>Has visitat aquesta pàgina <?php echo $visites; ?> vegades en total.</p>
    <p>Has visitat aquesta pàgina <?php echo $_SESSION['visites_sessio']; ?> vegades durant aquesta sessió.</p>
</body>
</html>