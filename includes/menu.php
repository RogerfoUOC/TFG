<nav class="sidebar">
  <ul>
    <li class="<?= ($page == 'home') ? 'active' : '' ?>">
      <a href="index.php"><i class="fa-solid fa-home"></i> Inici</a>
    </li>
    <li class="<?= ($page == 'panell') ? 'active' : '' ?>">
      <a href="panell.php"><i class="fa-regular fa-user"></i></fa-regular> Panell</a>
    </li>
    <li class="<?= ($page == 'alertes') ? 'active' : '' ?>">
      <a href="alertes.php"><i class="fa-regular fa-bell"></i></fa-regular> Alertes</a>
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



  <!-- Botó tancar mòbil -->
  <button id="close-menu" class="close-btn">
      <i class="fa-solid fa-xmark"></i>
  </button>
</nav>
