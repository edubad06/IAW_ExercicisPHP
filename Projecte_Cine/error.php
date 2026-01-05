<?php
require_once 'header.php';
$msg = $_GET['msg'] ?? 'S\'ha produït un error inesperat.';
?>

<div class="container" style="text-align: center; border-top: 5px solid #dc3545;">
    <h2 style="color: #dc3545;">🚨 Atenció</h2>
    <p style="font-size: 1.2rem;"><?php echo htmlspecialchars($msg); ?></p>
    <br>
    <a href="index.html" class="btn btn-edit" style="background: #6c757d; color:white;">Tornar a l'Inici</a>
</div>
