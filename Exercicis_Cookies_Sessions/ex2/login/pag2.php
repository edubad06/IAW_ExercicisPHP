<?php
session_start();
if (isset($_COOKIE['usuari'])) {
    $username = $_COOKIE['usuari'];
} else {
    $username = $_SESSION['usuari'];
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Pàgina 2</title>
</head>
<body>
    <p>Benvingut/da <?php echo $username; ?></p>
    <h2>Pàgina 2</h2>
</body>
</html>