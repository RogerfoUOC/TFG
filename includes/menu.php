<?php if (session_status() === PHP_SESSION_NONE) session_start(); ?>
<nav class="sidebar">
  <ul>
    <li class="<?= ($page == 'home') ? 'active' : '' ?>">
      <a href="index.php"><i class="fa-solid fa-home"></i> Inici</a>
    </li>
    <li class="<?= ($page == 'panell') ? 'active' : '' ?>">
      <a href="panell.php"><i class="fa-regular fa-user"></i> Panell</a>
    </li>
    <li class="<?= ($page == 'alertes') ? 'active' : '' ?>">
      <a href="alertes.php"><i class="fa-regular fa-bell"></i> Alertes</a>
    </li>
    <li class="<?= ($page == 'historic') ? 'active' : '' ?>">
      <a href="historic.php"><i class="fa-solid fa-calendar-days"></i> Històric</a>
    </li>
    <li class="<?= ($page == 'compara') ? 'active' : '' ?>">
      <a href="compara.php"><i class="fa-solid fa-code-compare"></i> Compara</a>
    </li>
    <li class="<?= ($page == 'log') ? 'active' : '' ?>">
      <a href="log.php"><i class="fa-solid fa-file-lines"></i> Logs</a>
    </li>
    <li class="<?= ($page == 'projecte') ? 'active' : '' ?>">
      <a href="projecte.php"><i class="fa-regular fa-circle-question"></i> Projecte</a>
    </li>
  </ul>

  <?php if (isset($_SESSION['usuari_id'])): ?>
  <a href="logout.php" class="logout-btn">
    <i class="fa-solid fa-power-off"></i> Tancar sessió
  </a>
  <?php endif; ?>

  <!-- Botó tancar mòbil -->
  <button id="close-menu" class="close-btn" aria-label="Tancar menú">
      <i class="fa-solid fa-xmark"></i>
  </button>
</nav>
