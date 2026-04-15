<div class="panell">
    <h1>Panell</h1>
    <div class="card-usuari">
        <h2><?=htmlspecialchars($userName) ?></h2>

        <div class="fila cont-auth">
            <span class="label">Correu electrònic:</span>
            <span id="span-user-mail" class="valor"><?=htmlspecialchars($userMail) ?></span>
            <button id="btn-editar-mail" class="btn-editar" title="Editar correu">
                <i class="fa-solid fa-pen"></i>
            </button>            
            <input type="text" id="input-user-pass" class=" ocult" value="<?= htmlspecialchars($userMail) ?>">
            <button id="btn-guardar-mail" class="btn-guardar ocult" title="Guardar correu">
                <i class="fas fa-save"></i>
            </button>
        </div>

        <div class="fila">
            <span class="label">Contrasenya:</span>
            <span class="valor">************</span>
            <a href="#editar_password.php" class="btn-editar" title="Editar contrasenya">
                <i class="fa-solid fa-pen"></i>
            </a>
        </div>

        <div class="fila">
            <span class="label">Alertes creades:</span>
            <span class="valor">4</span>
        </div>

        <div class="fila">
            <span class="label">Alertes actives:</span>
            <span class="valor">3</span>
        </div>

        <div class="fila">
            <span class="label">Última alerta:</span>
            <span class="valor">10/04/2026 15:32:50</span>
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

<style>
    .card-usuari {
        max-width: 420px;
        padding: 20px;
    }

    /* Files label + valor */
    .fila {
        display: grid;
        grid-template-columns: 1fr auto 35px; /* reserva espai icona */
        align-items: center;
        gap: 10px;
        margin-bottom: 10px;
        line-height: 2.5rem;
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
        width: 30px;
        height: 30px;
        /* border: 1px solid #ccc; */
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
    .btn-guardar {
        background-color: #e5e7eb; /* gris clar */
        border: none;
        border-radius: 8px;
        padding: 8px;
        cursor: pointer;

        display: inline-flex;
        align-items: center;
        justify-content: center;

        width: 35px;
        height: 35px;

        transition: background-color 0.2s ease, transform 0.1s ease;
    }

    .btn-editar i,
    .btn-guardar i {
        font-size: 14px;
        color: #111827; /* gris fosc */
    }

    /* Hover */
    .btn-editar:hover,
    .btn-guardar:hover {
        background-color: #d1d5db;
    }

    /* Click */
    .btn-editar:active,
    .btn-guardar:active {
        transform: scale(0.95);
    }

       .ocult  {
        display: none;
    }
</style>
<script defer src="js/panell.js"></script>
