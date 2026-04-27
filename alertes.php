<?php 
    $page = 'alertes';
    include 'includes/header.php'; 
    include 'includes/connexio.php';
    session_start();
    $usuari_validat     = isset($_SESSION['usuari_id']);
    $userName           = isset($_SESSION['nom_usuari']) ? $_SESSION['nom_usuari'] : '';    
    $userMail           = isset($_SESSION['email']) ? $_SESSION['email'] : '';
?>


<div class="main-container">
    <?php include 'includes/menu.php'; ?>
    <div class="content">

    <?php if ($usuari_validat): ?>
        <!-- Autoritzat -->
        <?php include 'view/alertes_autoritzat.php'; ?>
    <?php else: 
            $_SESSION['error_session'] = "Per gestionar les alertes t'has de validar.";
            header("Location: panell.php");
            exit;
     endif; ?>  
    </div>
</div>