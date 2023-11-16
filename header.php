<?php
/**
 * Fichier header.php
 * 
 * Ce fichier contient le d�but du code HTML commun � toutes les pages de l'application.
 * Il inclut les fichiers CSS du th�me AdminLTE et le fichier CSS personnalis� pour le th�me de l'espace.
 * Il affiche la barre de navigation avec les liens vers l'accueil et le menu.
 */

// D�but du code HTML
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard de suivi des astronautes</title>
  <!-- Inclusion des fichiers CSS du th�me AdminLTE -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
<body class="hold-transition sidebar-mini">
<div class="wrapper">

  <!-- Barre de navigation -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Liens � gauche -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="index.php" class="nav-link">Accueil</a>
      </li>
    </ul>
  </nav>
  <!-- Fin de la barre de navigation -->