<?php 
$toastError = $_SESSION['toast_error'] ?? null;
$okEmailMsg = $_SESSION['ok_email'] ?? null;
$okPasswordMsg = $_SESSION['ok_password'] ?? null;
$oldEmail = $_SESSION['old_email'] ?? null;
unset($_SESSION['toast_error']);
unset($_SESSION['ok_email']);
unset($_SESSION['ok_password']);
unset($_SESSION['old_email']);
$errorEmail = !empty($oldEmail);
?>


<div class="panell">
    <h1>Panell</h1>
<?php
    if ($toastError)   echo '<div class="toast error-box">'   . htmlspecialchars($toastError)    . '</div>';
    if ($okEmailMsg)   echo '<div class="toast success-box">' . htmlspecialchars($okEmailMsg)    . '</div>';
    if ($okPasswordMsg)echo '<div class="toast success-box">' . htmlspecialchars($okPasswordMsg) . '</div>';
?>
    <div class="card-usuari">
        <h2><?=htmlspecialchars($userName) ?></h2>
        <form id="form-email" method="POST" action="includes/update-email.php">
            <div class="fila cont-auth">
                <span class="label">Correu electrònic:</span>
                <span id="span-user-mail" class="valor <?= $errorEmail ? 'ocult' : '' ?>"><?=htmlspecialchars($userMail) ?></span>
                <button type="button" id="btn-editar-mail" class="btn-editar <?= $errorEmail ? 'ocult' : '' ?>" title="Editar correu">
                    <i class="fa-solid fa-pen"></i>
                </button>            
                <input type="text" name="email" id="input-user-mail" class="<?= $errorEmail ? 'input-error' : 'ocult' ?>" value="<?= htmlspecialchars($oldEmail ?? $userMail) ?>">
                <button type="submit" id="btn-guardar-mail" class="btn-guardar <?= $errorEmail ? '' : 'ocult' ?>" title="Guardar correu">
                    <i class="fas fa-save"></i>
                </button>
                <button type="button" id="btn-cancelar-mail" class="btn-cancelar <?= $errorEmail ? '' : 'ocult' ?>" title="Cancelar">
                    <i class="fa-solid fa-xmark"></i>
                </button>
                <div class="error-container">
                </div>
            </div>
        </form>
        <div class="fila">
            <span class="label">Contrasenya:</span>
            <span class="valor">************</span>
            <button id="btn-editar-pass" class="btn-editar" title="Editar contrasenya">
                <i class="fa-solid fa-pen"></i>
            </button> 
        </div>

        <div class="fila">
            <span class="label">Alertes creades:</span>
            <span class="valor">0</span>
        </div>

        <div class="fila">
            <span class="label">Alertes actives:</span>
            <span class="valor">0</span>
        </div>

        <div class="fila">
            <span class="label">Última alerta:</span>
            <span class="valor">-</span>
        </div>

        <div class="fila">
            <span class="label">Data de registre:</span>
            <span class="valor"><?= htmlspecialchars($dataRegistre) ?></span>
        </div>
        <div class="panell-botons">
            <a href="alertes.php" class="btn-alerta">Crear alerta</a>
            <form action="logout.php" method="POST">
                <button type="submit" class="btn-logout">Desconnectar</button>
            </form>
        </div>       
    </div>
</div>

<div id="modal-pass" class="capa-modal">
    <div class="modal-pass marc">
        <h2>Canvi de contrasenya</h2>
        <form method="POST" id="form-pass" action="./includes/update-password.php">
            <div class="grup-form">
                <label for="pass-actual">Contrasenya actual</label>
                <input id="pass-actual" type="password" name="pass-actual" placeholder="••••••••" autocomplete="current-password">
                <span id="show-pass-actual" class="sw-psw"><i class="fas fa-eye"></i></span>
                <span id="hide-pass-actual" class="sw-psw ocult"><i class="fas fa-eye-slash"></i></span>
            </div>
            <div class="grup-form">
                <label for="pass-nou">Nova contrasenya</label>
                <input id="pass-nou" type="password" name="pass-nou" placeholder="••••••••" autocomplete="new-password">
                <span id="show-pass-nou" class="sw-psw"><i class="fas fa-eye"></i></span>
                <span id="hide-pass-nou" class="sw-psw ocult"><i class="fas fa-eye-slash"></i></span>
            </div>
            <div class="grup-form">
                <label for="pass-confirm">Confirmar contrasenya</label>
                <input id="pass-confirm" type="password" name="pass-confirm" placeholder="••••••••" autocomplete="new-password">
                <span id="show-pass-confirm" class="sw-psw"><i class="fas fa-eye"></i></span>
                <span id="hide-pass-confirm" class="sw-psw ocult" ><i class="fas fa-eye-slash"></i></span>
            </div>
            <div class="grup-btns">
                <button type="submit" class="btn-submit">Canviar contrasenya</button>
                <button type="button" id="btn-cancelar-pass" class="btn-cancel">Cancel·lar</button>
            </div>
        </form>
    </div>
</div>
<script defer src="js/panell.js"></script>
