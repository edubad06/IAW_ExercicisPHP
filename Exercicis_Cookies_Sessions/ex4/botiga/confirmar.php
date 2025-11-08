<?php
session_start();
unset($_SESSION['cistella']);
session_destroy();
setcookie('poma', '', time() - 3600);
setcookie('taronja', '', time() - 3600);
header("Location: index.html");
?>