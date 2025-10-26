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
    <p>Benvingut/da <?php echo $_SESSION['usuari']; ?></p>
    <h2>Pàgina 2</h2>
</body>
</html>