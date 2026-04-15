<?php 
    $page = 'panell';
    session_start();
    include 'includes/header.php'; 
    include 'includes/connexio.php';
    include 'includes/queries.php';
    $userId             = $_SESSION['usuari_id'] ?? null;               //guardem l'ID d'usuari
    $usuari_validat     = $userId !== null;                             //comprobem si l'usuari està validat (true/false)
    $userName           = $_SESSION['nom_usuari'] ?? '';                //guardem el nom d'usuari si existeix la sessió, sino el deixem buit   
    $userMail           = $_SESSION['email'] ?? '';                     //guardem el mail si existeix la sessió, sino el deixem buit
    $error_login        = $_SESSION['error_login'] ?? null;             //recuperem errors del formulari
    $error_registre     = $_SESSION['error_registre'] ?? null;
    $error_session      = $_SESSION['error_session'] ?? null;
    $tab_actiu          = $_SESSION['tab_actiu'] ?? 'login';            //assignem la pestanya, si no sempre login
    $form_data          = $_SESSION['form_data'] ?? [];                 //guardem les dades del formulari per recuperar-les quan carrega amb algun error
    unset($_SESSION['error_login'], $_SESSION['error_registre'], $_SESSION['error_session'], $_SESSION['tab_actiu'], $_SESSION['form_data']); //netegem variables de sseesió un cop assigandes
?>
<div class="main-container">
    <?php include 'includes/menu.php'; ?>
    <div class="content">

    <?php if ($usuari_validat): $dataRegistre = dataRegistreUsuari($conn, $userId);?>
        <!-- Autoritzat -->
        <?php include 'view/panell_autoritzat.php'; ?>
    <?php else: ?>
        <!-- No autoritzat -->
        <?php include 'view/panell_noautoritzat.php'; ?>
    <?php endif; ?>  
    </div>
</div>

<script>
    const tabInicial = "<?= $tab_actiu ?>";
</script>
<?php if (!$usuari_validat): ?>
     <!-- evitem carregar la part de validació si ja estem validats -->
    <script defer src="js/tabs.js"></script>
    <script defer src="js/auth.js"></script>
   
<?php endif; ?>