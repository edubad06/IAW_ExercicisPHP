<?php
session_start();
// Buidem totes les variables de la sessió actual
$_SESSION = array();
// Si s'utilitzen cookies per a la sessió, les eliminem del navegador de l'usuari
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}
// Destruir la sessió i redirigir l'usuari a la pàgina del login
session_destroy();
header("Location: login.php");
exit();