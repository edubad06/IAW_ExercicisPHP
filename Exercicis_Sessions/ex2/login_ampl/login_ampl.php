<?php
session_start();
$usuari = $_POST['usuari'];
$pwd = $_POST['pwd'];

if ($usuari == $pwd) {
    $_SESSION['usuari'] = $usuari;
    echo '<a href="pag1.php">Anar a la pàgina 1</a>';
    echo '<br><br>';
    echo '<a href="pag2.php">Anar a la pàgina 2</a>';
} else {
    echo 'Usuari o contrasenya incorrectes';
    echo '<br><br>';
    echo '<a href="index.html">Tornar al login</a>';
}
?>