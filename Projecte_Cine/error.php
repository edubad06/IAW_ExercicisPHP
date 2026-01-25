<?php
require_once 'header.php';

// Recollim el codi del tipus d'error
$tipus = $_GET['tipus'] ?? 'desconegut';

// Diccionari centralitzat de missatges d'error
$missatges = [
    // Errors de formulari i validació
    'buit'            => 'Tots els camps marcats com a obligatoris s\'han d\'omplir.',
    'email_invalid'   => 'El format del correu electrònic no és vàlid.',
    'num_invalid'     => 'Has introduït un valor numèric fora del rang permès.',
    'data_incorrecta' => 'La data o l\'any introduït no és vàlid o és fora de rang.',
    
    // Errors d'accés i sessió
    'login_fallit'    => 'L\'email o la contrasenya són incorrectes. Torna-ho a provar.',
    'sessio_error'    => 'La teva sessió ha caducat o no tens permisos per accedir a aquesta secció.',
    
    // Errors de Base de Dades i Duplicats
    'usuari_duplicat' => 'Aquest usuari o correu electrònic ja es troba registrat al sistema.',
    'peli_duplicada'  => 'Aquesta pel·lícula ja existeix a la llista.',
    'relacio_activa'  => 'No es pot eliminar aquest element perquè hi ha dades relacionades.',
    
    // Errors genèrics
    'peticio_invalid' => 'La petició realitzada no és vàlida o l\'ID especificat no existeix.',
    'desconegut'      => 'S\'ha produït un error inesperat al servidor. Si us plau, contacta amb l\'administrador.'
];

// Seleccionem el missatge corresponent o el genèric per defecte
$error_final = $missatges[$tipus] ?? $missatges['desconegut'];
?>

<div class="container" style="text-align: center; border-top: 5px solid #dc3545;">
    <h2 style="color: #dc3545; margin-top: 20px;">🚨 Atenció</h2>
    
    <div style="background: #fff5f5; padding: 30px; border-radius: 10px; border: 1px solid #ffc1c1; margin: 25px 0;">
        <p style="font-size: 1.2rem; color: #721c24; line-height: 1.5;">
            <strong>Avís:</strong> <?php echo htmlspecialchars($error_final); ?>
        </p>
    </div>

    <div style="margin-top: 30px; display: flex; justify-content: center; gap: 15px;">
        <a href="javascript:history.back()" class="btn" style="background: #6c757d; color:white; padding: 10px 25px; height: auto;">
            ⬅️ Tornar enrere
        </a>
        
        <a href="access.php" class="btn btn-edit" style="padding: 10px 25px; height: auto; background: #1a1a1a;">
            Anar a l'Inici
        </a>
    </div>
</div>