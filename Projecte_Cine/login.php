<?php
require_once 'header.php';
require_once 'config/db_connect.php';

// Processar dades del formulari
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    // Validar camps buits
    if (empty($_POST['email']) || empty($_POST['password'])) {
        header("Location: error.php?tipus=buit");
        exit();
    }

    // Protecció contra Injecció SQL i recollida de dades
    $email = mysqli_real_escape_string($conexion, $_POST['email']);
    $pass = $_POST['password'];
    
    // Validar format d'email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        header("Location: error.php?tipus=email_invalid");
        exit();
    }

    // Consulta per cercar l'usuari i el seu rol
    $sql = "SELECT u.*, r.nom_rol FROM usuaris u JOIN rols r ON u.id_rol = r.id_rol WHERE u.email = '$email'";
    $res = mysqli_query($conexion, $sql);
    $user = mysqli_fetch_assoc($res);
    
    // Validar si l'usuari existeix i si la contrasenya es correcta
    if ($user && password_verify($pass, $user['password_hash'])) {
        $_SESSION['usuari'] = [
            'id' => $user['id_usuari'], 
            'nom_usuari' => $user['nom_usuari'], 
            'nom_rol' => $user['nom_rol']
        ];
        // // Redirecció al dashboard personalitzat
        header("Location: access.php");
        exit();
    } else {
        // Si el login falla, enviem al gestor centralitzat d'errors
        header("Location: error.php?tipus=login_fallit");
        exit();
    }
}
?>

<div class="container" style="max-width:450px; margin-top: 60px;">
    <h2 style="text-align: center; border: none;">Accés al Sistema</h2>
    
    <form method="POST">
        <label for="email">Correu Electrònic</label>
        <input type="email" id="email" name="email" placeholder="usuari@exemple.com">

        <label for="password">Contrasenya</label>
        <input type="password" id="password" name="password" placeholder="••••••••">

        <button type="submit" class="btn btn-edit" style="width:100%; padding: 15px; background: #1a1a1a; font-weight: bold;">
            INICIAR SESSIÓ
        </button>
    </form>
    
    <div style="text-align: center; margin-top: 20px; font-size: 0.9rem; color: #666;">
        Encara no tens compte? <a href="register.php" style="color: #28a745; font-weight: bold;">Registra't aquí</a>
    </div>
</div>