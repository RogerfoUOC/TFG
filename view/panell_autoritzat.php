        <div class="panell">
            <h1>Panell</h1>
            <p>HOLA! <?= htmlspecialchars($userName) . ' (' . htmlspecialchars($userMail). ')' ?></p>
            <p><strong>Data d'alta: </strong><?= $dataRegistre ?></p>

            <div class="panell-botons">
                <a href="alertes.php" class="btn-alerta">Crear alerta</a>
                <form action="logout.php" method="POST">
                    <button type="submit" class="btn-logout">Desconnectar</button>
                </form>
            </div>

        </div>