<?php
require_once 'header.php';
require_once 'config/db_connect.php';

// Processar dades del formulari
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validar camps buits
    if (empty($_POST['nom']) || empty($_POST['email']) || empty($_POST['password'])) {
        header("Location: error.php?tipus=buit");
        exit();
    }

    // Prevenció d'injeccions SQL
    $nom = mysqli_real_escape_string($conexion, $_POST['nom']);
    $email = mysqli_real_escape_string($conexion, $_POST['email']);
    
    // Validar format d'email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        header("Location: error.php?tipus=email_invalid");
        exit();
    }

    // Validar duplicats
    $checkUser = mysqli_query($conexion, "SELECT id_usuari FROM usuaris WHERE email = '$email' OR nom_usuari = '$nom'");
    
    if (mysqli_num_rows($checkUser) > 0) {
        header("Location: error.php?tipus=usuari_duplicat");
        exit();
    }

    // Encriptar contrasenya
    $pass = password_hash($_POST['password'], PASSWORD_DEFAULT);
    
    // Inserir l'usuari amb el rol 1
    $sql = "INSERT INTO usuaris (id_rol, email, password_hash, nom_usuari) VALUES (1, '$email', '$pass', '$nom')";
    
    if (mysqli_query($conexion, $sql)) {
        // Redirigir a login
        header("Location: login.php?msg=registre_ok");
        exit();
    } else {
        // Control de l'error
        header("Location: error.php?tipus=desconegut");
        exit();
    }
}
?>

<div class="container" style="max-width:450px; margin-top: 60px;">
    <h2 style="text-align: center; border: none;">Crea el teu Compte</h2>
    
    <form method="POST">
        <label for="nom">Nom d'Usuari</label>
        <input type="text" name="nom" id="nom" placeholder="Ex: Marc88">

        <label for="email">Correu Electrònic</label>
        <input type="email" name="email" id="email" placeholder="correu@exemple.com">

        <label for="password">Contrasenya</label>
        <input type="password" name="password" id="password">

        <button type="submit" class="btn btn-add" style="width:100%; padding: 15px; font-weight: bold;">
            REGISTRAR-SE
        </button>
    </form>
    
    <div style="text-align: center; margin-top: 20px; font-size: 0.9rem;">
        Ja tens compte? <a href="login.php" style="color: #007bff; font-weight: bold;">Inicia sessió</a>
    </div>
</div>