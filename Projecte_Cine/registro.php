<?php
require_once 'header.php';
require_once 'config/conexion.php';

$error = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom = mysqli_real_escape_string($conexion, $_POST['nom']);
    $email = mysqli_real_escape_string($conexion, $_POST['email']);
    $pass = password_hash($_POST['password'], PASSWORD_DEFAULT);
    
    // Comprovar si l'email ja existeix a la BD
    $checkEmail = mysqli_query($conexion, "SELECT id_usuari FROM usuaris WHERE email = '$email'");
    
    if (mysqli_num_rows($checkEmail) > 0) {
        $error = "Aquest correu electrònic ja està registrat. Prova amb un altre o inicia sessió.";
    } else {
        // Inserir nou usuari amb el rol Usuari per defecte
        $sql = "INSERT INTO usuaris (id_rol, email, password_hash, nom_usuari) VALUES (1, '$email', '$pass', '$nom')";
        
        if (mysqli_query($conexion, $sql)) {
            header("Location: login.php?msg=registre_ok");
            exit();
        } else {
            $error = "S'ha produït un error inesperat en el registre.";
        }
    }
}
?>

<div class="container" style="max-width:450px; margin-top: 60px;">
    <h2 style="text-align: center; border: none;">Crea el teu Compte</h2>
    
    <?php if(!empty($error)): ?>
        <div style="background: #fee2e2; color: #b91c1c; padding: 12px; border-radius: 6px; margin-bottom: 20px; text-align: center; border: 1px solid #f87171;">
            <?php echo $error; ?>
        </div>
    <?php endif; ?>
    
    <form method="POST">
        <label for="nom">Nom d'Usuari</label>
        <input type="text" name="nom" id="nom" placeholder="Ex: Marc88" required value="<?php echo isset($_POST['nom']) ? htmlspecialchars($_POST['nom']) : ''; ?>">

        <label for="email">Correu Electrònic</label>
        <input type="email" name="email" id="email" placeholder="correu@exemple.com" required>

        <label for="password">Contrasenya</label>
        <input type="password" name="password" id="password" required>

        <button type="submit" class="btn btn-add" style="width:100%; padding: 15px; font-weight: bold;">
            REGISTRAT
        </button>
    </form>
    
    <div style="text-align: center; margin-top: 20px; font-size: 0.9rem;">
        Ja tens compte? <a href="login.php" style="color: #00d4ff; font-weight: bold;">Inicia sessió</a>
    </div>
</div>