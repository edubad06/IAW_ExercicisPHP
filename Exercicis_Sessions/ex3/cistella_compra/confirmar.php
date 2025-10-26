<?php
session_start();
unset($_SESSION['cistella']);
session_destroy();
header("Location: index.html");
?>