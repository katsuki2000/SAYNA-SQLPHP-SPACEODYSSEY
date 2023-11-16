<?php
/**
 * Fichier header.php
 * 
 * Ce fichier contient le début du code HTML commun à toutes les pages de l'application.
 * Il inclut les fichiers CSS du thème AdminLTE et le fichier CSS personnalisé pour le thème de l'espace.
 * Il affiche la barre de navigation avec les liens vers l'accueil et le menu.
 */

// Début du code HTML
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard de suivi des astronautes</title>
  <!-- Inclusion des fichiers CSS du thème AdminLTE -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
<body class="hold-transition sidebar-mini">
<div class="wrapper">

  <!-- Barre de navigation -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Liens à gauche -->
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