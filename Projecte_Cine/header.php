<?php
if (session_status() == PHP_SESSION_NONE) { session_start(); }

$logado = isset($_SESSION['usuari']);
$nom_usuari = $logado ? $_SESSION['usuari']['nom_usuari'] : 'Convidat';
$rol = $logado ? $_SESSION['usuari']['nom_rol'] : '';

// Control d'accés
$pagina_actual = basename($_SERVER['PHP_SELF']);
$paginas_publiques = ['index.html', 'login.php', 'registro.php', 'error.php'];

if (!$logado && !in_array($pagina_actual, $paginas_publiques)) {
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="ca">
<head>
    <meta charset="UTF-8">
    <title>CineManager - Projecte IAW</title>
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; margin: 0; background-color: #f4f7f6; color: #333; }
        nav { background: #1a1a1a; color: white; padding: 1rem 2rem; display: flex; justify-content: space-between; align-items: center; }
        nav a { color: #00d4ff; text-decoration: none; margin-left: 20px; font-weight: 500; }
        nav a:hover { color: #fff; }
        
        .container { 
            max-width: 1000px; 
            margin: 30px auto; 
            background: white; 
            padding: 30px; 
            border-radius: 12px; 
            box-shadow: 0 4px 15px rgba(0,0,0,0.1); 
        }
        
        table { width: 100%; border-collapse: collapse; margin-top: 20px; background: #fff; table-layout: auto; }
        th, td { padding: 12px 15px; border: 1px solid #eee; text-align: left; }
        th { background: #f8f9fa; font-weight: bold; }
        
        .acciones {
            display: flex;
            gap: 10px;
            align-items: center;
            justify-content: flex-start;
        }

        .btn { 
            padding: 8px 12px; 
            border-radius: 6px; 
            text-decoration: none; 
            display: inline-flex;
            align-items: center;
            justify-content: center;
            transition: 0.3s;
            border: none;
            cursor: pointer;
            min-width: 38px;
            height: 38px;
            box-sizing: border-box;
        }
        .btn-add { background: #28a745; color: white; }
        .btn-edit { background: #007bff; color: white; }
        .btn-del { background: #dc3545; color: white; }
        .btn:hover { opacity: 0.8; transform: translateY(-1px); }

        input, select, textarea { 
            width: 100%; 
            padding: 10px; 
            border: 1px solid #ccc; 
            border-radius: 5px; 
            box-sizing: border-box; 
            margin-bottom: 15px;
        }
    </style>
</head>
<body>
<nav>
    <div style="font-size: 1.5rem;">🎬 <strong>CineManager</strong></div>
    <div>
        <a href="index.html">Inici</a>
        <?php if ($logado): ?>
            <a href="stats.php">Cercador</a>
            <?php if ($rol === 'Usuari'): ?>
                <a href="seguiment_read.php">La meva Llista</a>
            <?php else: ?>
                <a href="pelicules_read.php">Gestió Catàleg</a>
            <?php endif; ?>
            <span style="margin-left:20px; color:#aaa;">| <?php echo htmlspecialchars($nom_usuari); ?></span>
            <a href="logout.php" style="color: #ff4d4d;">Sortir</a>
        <?php else: ?>
            <a href="login.php">Login</a>
            <a href="registro.php">Registre</a>
        <?php endif; ?>
    </div>
</nav>