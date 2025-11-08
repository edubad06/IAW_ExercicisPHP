<?php
session_start();
unset($_SESSION['usuari']);
session_destroy();
setcookie('usuari', '', time() - 3600);
header("Location: index.html");
?>