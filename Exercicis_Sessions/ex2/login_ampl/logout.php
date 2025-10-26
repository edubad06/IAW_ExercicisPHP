<?php
session_start();
unset($_SESSION['usuari']);
session_destroy();
header("Location: index.html");
?>