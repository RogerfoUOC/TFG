<?php 
$toastError = $_SESSION['toast_error'] ?? null;
$okEmailMsg = $_SESSION['ok_email'] ?? null;
$oldEmail = $_SESSION['old_email'] ?? null;
unset($_SESSION['toast_error']);
unset($_SESSION['ok_email']);
unset($_SESSION['old_email']);
$errorEmail = $toastError !== null;
?>

<div class="panell">
    <h1>Panell</h1>
<?php if ($toastError): ?>
    <div class="toast error-box"><?= $toastError ?></div>
<?php endif; ?>

<?php if ($okEmailMsg): ?>
    <div class="toast success-box"><?= $okEmailMsg ?></div>
<?php endif; ?>
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
        <h3>Canvi de contrasenya</h3>
        <form method="POST" id="form-pass" action="./includes/update-password.php">
            <div class="grup-form">
                <label for="pass-actual">Contrasenya actual</label>
                <input id="pass-actual" type="password" name="pass-actual" placeholder="••••••••" autocomplete="current-password">
                <span id="show-pass-actual" class="sw-psw"><i class="fas fa-eye"></i></span>
                <span id="hide-pass-actual" class="sw-psw ocult"><i class="fas fa-eye-slash"></i></span>
            </div>
            <div class="grup-form">
                <label for="pass-nova">Nova contrasenya</label>
                <input id="pass-nova" type="password" name="pass-nova" placeholder="••••••••" autocomplete="new-password">
                <span id="show-pass-nova" class="sw-psw"><i class="fas fa-eye"></i></span>
                <span id="hide-pass-nova" class="sw-psw ocult"><i class="fas fa-eye-slash"></i></span>
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

<style>
    .card-usuari {
        max-width: 500px;
        padding: 20px;
    }

    /* Files label + valor */
    .fila {
        display: grid;
        grid-template-columns: 1fr auto 40px 40px; /* reserva espai icona */
        align-items: center;
        gap: 10px;
        line-height: 2.5rem;
    }

    .fila.cont-auth {
        max-width: inherit;
    }

    form#form-email {
        margin-bottom: 0;
    }

    /* Etiquetes */
    .label {
        font-weight: bold;
    }

    /* Botons */
    .botons {
        display: flex;
        flex-direction: column;
        gap: 10px;
        margin-top: 20px;
    }

    /* Base botó */
    .btn {
        padding: 10px;
        cursor: pointer;
    }
    .btn-editar {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 40px;
        height: 40px;
        border: 1px solid #ccc; 
        border-radius: 4px;
        text-decoration: none;
        cursor: pointer;
    }
    .btn-editar i {
        font-size: 14px;
    }
    .btn-editar:hover {
        text-decoration: none;
    }



    .btn-editar,
    .btn-guardar,
    .btn-cancelar {
        background-color: #e5e7eb; /* gris clar */
        border: none;
        border-radius: 6px;
        padding: 8px;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 40px;
        height: 40px;
        transition: background-color 0.2s ease, transform 0.1s ease;
    }
    .btn-guardar {
        border:1px solid green;
    }
    .btn-cancelar {
        border:1px solid red;
    }
    
    .btn-editar i,
    .btn-guardar i,
    .btn-cancelar i {
        font-size: 14px;
        color: #111827; /* gris fosc */
    }
    
    /* Hover */
    .btn-editar:hover {
        background-color: #ebebeb;
    }
    .btn-guardar:hover {
        background-color: #e8f5e9;
    }
    .btn-cancelar:hover {
        background-color: #ffebee;
    }
    

    /* Click */
    .btn-editar:active,
    .btn-guardar:active,
    .btn-cancelar:active {
        transform: scale(0.95);
    }

       .ocult  {
        display: none;
    }

    .error-container {
        grid-column: 1 / -1; /* ocupa tota la fila */
    }

    .toast {
        position: fixed;
        top: 20px;
        left: 50%;
        transform: translateX(-50%);
        box-shadow: 0 4px 10px rgba(0,0,0,0.2);
        z-index: 9999;   
        opacity: 1;
        transition: opacity 0.5s ease;
    }
    
/* -- MODAL CANVI PASS PANELL -- */



.capa-modal {
    position: fixed;           /* clau per sobre de tota la pàgina */
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;

        background: rgba(0,0,0,0.5);  /* fons fosc */
        
        display: flex;
        justify-content: center;   /* centrat horitzontal */
        align-items: center;       /* centrat vertical */
        
        z-index: 9999;             /* per sobre de tot */
        
        /* ocult per defecte */
        opacity: 0;
        pointer-events: none;
        transition: opacity 0.2s ease;
    }
    
    .capa-modal.actiu {
        opacity: 1;
        pointer-events: all;
    }
    
    .modal-pass {
        max-width: 300px;
        padding: 2rem;
        border-radius: 10px;
        width: 100%;
        background: #fff;
        box-shadow: 0 10px 30px rgba(0,0,0,0.2);
    }
    
    .grup-btns {
        display: flex;
        gap: 10px; /* opcional, separació */
    }

    .btn-submit {
        flex: 3; /* ocupa 3 parts */
    }

    .btn-cancel {
        flex: 1; /* ocupa 1 part */
    }


</style>
<script defer src="js/validation.js"></script>
<script defer src="js/panell.js"></script>
