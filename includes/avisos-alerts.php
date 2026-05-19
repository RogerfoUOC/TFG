<?php
if (session_status() === PHP_SESSION_NONE) session_start();
if (!isset($_SESSION['usuari_id'])) return;

include_once 'includes/queries.php';

$alertesPendents = obtenirAlertsWebPendents($conn, $_SESSION['usuari_id']);
?>

<!-- DEBUG alertes: <?= $alertesPendents ? $alertesPendents->num_rows : 'NULL' ?> -->

<?php if ($alertesPendents && $alertesPendents->num_rows > 0): ?>
    <div class="contenidor-alertes">
    <?php while ($alerta = $alertesPendents->fetch_assoc()): ?>
        <div class="toast toast-alerta">
            <span class="toast-alerta-text">
                <i class="fa-solid fa-triangle-exclamation"></i> #<?= $alerta['id'] ?> 
                <?= htmlspecialchars(ucfirst($alerta['sensor'])) ?> 
                <?= htmlspecialchars($alerta['localitzacio']) ?> 
                <?= htmlspecialchars($alerta['condicio']) ?> 
                <?= htmlspecialchars($alerta['valor']) . ($alerta['sensor'] === 'temperatura' ? 'º' : '%') ?> — 
                <strong><?= htmlspecialchars($alerta['valor_sensor']) . ($alerta['sensor'] === 'temperatura' ? 'º' : '%') ?></strong>
                <span class="toast-hora">(<?= date('d/m H:i', strtotime($alerta['data_activacio'])) ?>)</span>
            </span>
            <form method="POST" action="includes/tancar-alertes.php">
                <input type="hidden" name="log_id" value="<?= $alerta['id'] ?>">
                <input type="hidden" name="redirect" value="<?= htmlspecialchars($_SERVER['REQUEST_URI']) ?>">
                <button type="submit" class="btn-tancar-alerta">Tancar</button>
            </form>
        </div>
        <?php endwhile; ?>
    </div>
<?php endif; ?>