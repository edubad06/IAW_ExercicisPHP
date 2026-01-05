<?php
require_once 'header.php';
require_once 'config/conexion.php';

// Processar dades del formulari
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = mysqli_real_escape_string($conexion, $_POST['email']);
    $pass = $_POST['password'];
    
    // Cercar usuari i el seu rol
    $sql = "SELECT u.*, r.nom_rol FROM usuaris u JOIN rols r ON u.id_rol = r.id_rol WHERE u.email = '$email'";
    $res = mysqli_query($conexion, $sql);
    $user = mysqli_fetch_assoc($res);
    
    // Verificar contrasenya
    if ($user && password_verify($pass, $user['password_hash'])) {
        $_SESSION['usuari'] = [
            'id' => $user['id_usuari'], 
            'nom_usuari' => $user['nom_usuari'], 
            'nom_rol' => $user['nom_rol']
        ];
        header("Location: acces.php");
        exit();
    } else {
        $error = "Email o contrasenya incorrectes.";
    }
}
?>

<div class="container" style="max-width:450px; margin-top: 60px;">
    <h2 style="text-align: center; border: none;">Accés al Sistema</h2>
    
    <?php if(isset($error)) echo "<p style='color:red; text-align:center; font-weight:bold;'>$error</p>"; ?>

    <form method="POST">
        <label for="email">Correu Electrònic</label>
        <input type="email" id="email" name="email" placeholder="usuari@exemple.com" required>

        <label for="password">Contrasenya</label>
        <input type="password" id="password" name="password" placeholder="••••••••" required>

        <button type="submit" class="btn btn-edit" style="width:100%; padding: 15px; background: #1a1a1a; font-weight: bold;">
            INICIAR SESSIÓ
        </button>
    </form>
    
    <div style="text-align: center; margin-top: 20px; font-size: 0.9rem; color: #666;">
        Encara no tens compte? <a href="registro.php" style="color: #28a745; font-weight: bold;">Registra't aquí</a>
    </div>
</div>