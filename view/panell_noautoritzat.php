        <div class="capa-auth">
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
                        <button id="btn-login" class="btn-submit" type="submit">Entrar</button>   
                    </form>
                </div>
                <!-- Pestanya REGISTRE -->
                <div id="tab-registre" class="tab-content">
                    <?php if ($error_registre): ?>
                       <p class="error-box"><?= htmlspecialchars($error_registre) ?></p>
                    <?php endif; ?>
                    <form  id="form-registre" action="includes/auth.php" method="POST" novalidate>
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