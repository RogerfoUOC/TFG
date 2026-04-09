<?php 
    $page = 'panell';
    include 'includes/header.php'; 
    include 'includes/connexio.php';
    include 'includes/queries.php';
    session_start();
    $usuari_validat     = isset($_SESSION['usuari_id']);
    $userName           = isset($_SESSION['nom_usuari']) ? $_SESSION['nom_usuari'] : '';    
    $userMail           = isset($_SESSION['email']) ? $_SESSION['email'] : '';
    $error_login        = $_SESSION['error_login'] ?? null;
    $error_registre     = $_SESSION['error_registre'] ?? null;
    $error_session      = $_SESSION['error_session'] ?? null;
    $tab_actiu          = $_SESSION['tab_actiu'] ?? 'login';
    $form_data          = $_SESSION['form_data'] ?? [];
    unset($_SESSION['error_login'], $_SESSION['error_registre'], $_SESSION['error_session'], $_SESSION['tab_actiu'], $_SESSION['form_data']);
?>
<div class="main-container">
    <?php include 'includes/menu.php'; ?>
    <div class="content">

    <?php if ($usuari_validat): ?>
        <!-- Autoritzat -->
        <div class="panell">
            <h1>Panell</h1>
            <p>HOLA! <?= htmlspecialchars($userName) . ' (' . htmlspecialchars($userMail). ')' ?></p>
            <p><strong>Registrat el: </strong><?= date("d/m/Y H:i", strtotime($user['created_at'])) ?></p>
            <a href="logout.php" class="btn-logout">Tancar sessió</a>
        </div>
    <?php else: ?>
        <div class="capa-auth">
            <!-- No autoritzat -->
            <div class="cont-auth marc">
                <div class="tabs-auth">
                    <button class="tab-btn active" id="btn-login-tab">
                        Login
                    </button>
                    <button class="tab-btn" id="btn-registre-tab">
                        Registre
                    </button>
                </div>
                <!-- Pestanya LOGIN -->
                <div id="tab-login" class="tab-content active">
                        <?php if ($error_login): ?>
                            <p class="error-box"><?= htmlspecialchars($error_login) ?></p>
                        <?php endif; ?>
                        <?php if ($error_session): ?>
                            <p class="error-box"><?= htmlspecialchars($error_session) ?></p>
                        <?php endif; ?>

                    <form id="form-login" method="POST" action="includes/auth.php">
                        <input type="hidden" name="accio" value="login">
                        <div class="grup-form">
                            <label for="mail-login">Correu electrònic:</label>
                            <input id="mail-login"type="text" name="mail-login" placeholder="Correu electrònic">
                        </div>
                        <div class="grup-form">
                            <label for="password-login">Contrasenya:</label>
                            <input id="password-login" type="password" name="password-login" placeholder="••••••••">
                            <span id="show-pass0" class="sw-psw" ><i class="fas fa-eye"></i></span>
                            <span id="hide-pass0" class="sw-psw ocult" ><i class="fas fa-eye-slash"></i></span>
                        </div>    
                        <button id="btn-login" class="btn-submit" type="submit" >Entrar</button>   
                    </form>
                </div>
                <!-- Pestanya REGISTRE -->
                <div id="tab-registre" class="tab-content">
                    <?php if ($error_registre): ?>
                       <p class="error-box"><?= htmlspecialchars($error_registre) ?></p>
                    <?php endif; ?>
                    <form  id="form-registre" action="includes/auth.php" method="POST" >
                        <input type="hidden" name="accio" value="registre">
                        <div class="grup-form">
                            <label for="username">Nom d'usuari:</label>
                            <input id="username" class="<?= !empty($form_data['username']) ? 'input-correct' : '' ?>" type="text" name="username" placeholder="Nom d'usuari" value="<?= htmlspecialchars($form_data['username'] ?? '') ?>">
                        </div>
                        <div class="grup-form">
                            <label for="email">Correu electrònic:</label>
                            <input id="email"  class="<?= isset($form_data['email']) ? 'input-error' : '' ?>" type="email" name="email" placeholder="Mail" value="<?= htmlspecialchars($form_data['email'] ?? '') ?>">
                        </div>
                        <div id="label-pass1" class="grup-form">
                            <label for="password1">Contrasenya:</label>
                            <input id="password1" type="password" name="password1" placeholder="••••••••">
                            <span id="show-pass1" class="sw-psw"><i class="fas fa-eye"></i></span>
                            <span id="hide-pass1" class="sw-psw ocult"><i class="fas fa-eye-slash"></i></span>
                        </div>
                        <div id="label-pass2" class="grup-form">
                            <label for="password2">Repeteix la contrasenya:</label>
                            <input id="password2" type="password" name="password2" placeholder="••••••••">
                            <span id="show-pass2" class="sw-psw"><i class="fas fa-eye"></i></span>
                            <span id="hide-pass2" class="sw-psw ocult" ><i class="fas fa-eye-slash"></i></span>
                        </div>
                        <button id="btn-registre" class="btn-submit" type="submit">Crear usuari</button>
                    </form>
                </div>
            </div>
        </div>  
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