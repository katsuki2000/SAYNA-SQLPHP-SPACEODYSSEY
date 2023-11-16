<?php
/**
 * Fichier menuGauche.php
 * 
 * Ce fichier contient le code HTML qui affiche le menu lat�ral de l'application.
 * Il utilise les composants graphiques du th�me AdminLTE et les ic�nes Font Awesome.
 * Il affiche le logo de l'agence, le nom de l'utilisateur connect� et les liens vers les pages de gestion des plan�tes, des astronautes, des missions et des vaisseaux.
 */

// D�finition des variables PHP
$user_name = "Nom de l'utilisateur"; // Le nom de l'utilisateur connect�
$active_page = "planete"; // Le nom de la page active du menu

// D�but du code HTML
?>
<!-- Menu lat�ral -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
  <!-- Logo -->
  <a href="index.php" class="brand-link">
    <img src="dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
    <span class="brand-text font-weight-light">Stellar Tech</span>
  </a>

  <!-- Menu lat�ral -->
  <div class="sidebar">
    <!-- Utilisateur connect� -->
    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
      <div class="image">
        <img src="dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
      </div>
      <div class="info">
        <a href="#" class="d-block"><?php echo $user_name; ?></a>
      </div>
    </div>

    <!-- Menu principal -->
    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <!-- Menu des plan�tes -->
        <li class="nav-item">
          <a href="planete.php" class="nav-link <?php echo ($active_page == "planete") ? "active" : ""; ?>">
            <i class="nav-icon fas fa-globe"></i>
            <p>
              Plan�tes
            </p>
          </a>
        </li>
        <!-- Menu des astronautes -->
        <li class="nav-item">
          <a href="astronaute.php" class="nav-link <?php echo ($active_page == "astronaute") ? "active" : ""; ?>">
            <i class="nav-icon fas fa-user-astronaut"></i>
            <p>
              Astronautes
            </p>
          </a>
        </li>
        <!-- Menu des missions -->
        <li class="nav-item">
          <a href="mission.php" class="nav-link <?php echo ($active_page == "mission") ? "active" : ""; ?>">
            <i class="nav-icon fas fa-rocket"></i>
            <p>
              Missions
            </p>
          </a>
        </li>
        <!-- Menu des vaisseaux -->
        <li class="nav-item">
          <a href="vaisseau.php" class="nav-link <?php echo ($active_page == "vaisseau") ? "active" : ""; ?>">
            <i class="nav-icon fas fa-space-shuttle"></i>
            <p>
              Vaisseaux
            </p>
          </a>
        </li>
      </ul>
    </nav>
    <!-- Fin du menu principal -->
  </div>
  <!-- Fin du menu lat�ral -->
</aside>
<!-- Fin du menu lat�ral -->