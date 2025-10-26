<?php
session_start();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Pàgina 2</title>
</head>
<body>
    <p>Benvingut/da <?php echo $_SESSION['usuari']; ?>  <a href="logout.php">Tancar sessió</a></p>
    <h2>Pàgina 2</h2>
</body>
</html>