<?php
/**
 * Fichier index.php
 * 
 * Ce fichier contient le code HTML qui affiche la page d'accueil de l'application.
 * Il utilise le thème AdminLTE pour créer une interface graphique moderne et élégante.
 * Il affiche le dashboard de suivi des astronautes, avec l'image du jour de la NASA et les cartes des missions.
 */

// Inclusion des fichiers header.php, connexion.php, APOD.php et menuGauche.php
include("header.php");
include("connexion.php");
include("APOD.php");
include("menuGauche.php");

// Appel de la fonction display_apod pour afficher l'image du jour de la NASA
display_apod($conn);

// Requête SQL pour récupérer les informations sur les missions, les planètes, les vaisseaux et les astronautes
$sql = "SELECT m.nom, m.status, p.nom AS planete, v.nom AS vaisseau, GROUP_CONCAT(a.nom SEPARATOR ', ') AS astronautes, GROUP_CONCAT(a.etat_sante SEPARATOR ', ') AS etats_sante FROM mission m JOIN planete p ON m.id_planete = p.id JOIN affectation af ON m.id = af.id_mission JOIN vaisseau v ON af.id_vaisseau = v.id JOIN astronaute a ON af.id_astronaute = a.id GROUP BY m.id";
$result = $conn->query($sql);

// Début du code HTML
?>
<!-- Contenu principal -->
<div class="content-wrapper">
  <!-- Entête du contenu -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0 text-dark">Dashboard de suivi des astronautes</h1>
        </div>
      </div>
    </div>
  </div>
  <!-- Fin de l'entête du contenu -->

  <!-- Contenu -->
  <section class="content">
    <div class="container-fluid">
      <!-- Carte de l'image du jour -->
      <div class="card card-primary card-outline">
        <div class="card-header">
          <h3 class="card-title">Image du jour de la NASA</h3>
        </div>
        <div class="card-body">
          <?php
          // Affichage de l'image du jour avec son titre et sa description
          echo "<h1>$title</h1>";
          echo "<img src='$url' alt='$title' class='img-fluid'>";
          echo "<p>$explanation</p>";
          ?>
        </div>
      </div>
      <!-- Fin de la carte de l'image du jour -->
      <!-- Cartes des missions -->
      <div class="row">
        <?php
        // Affichage des missions sous forme de cartes
        if ($result->num_rows > 0) {
          while($row = $result->fetch_assoc()) {
            // Choix de la couleur du badge en fonction du statut de la mission
            switch ($row["status"]) {
              case "en préparation":
                $badge_color = "warning";
                break;
              case "en cours":
                $badge_color = "primary";
                break;
              case "terminée":
                $badge_color = "success";
                break;
              case "abandonnée":
                $badge_color = "danger";
                break;
              default:
                $badge_color = "secondary";
            }
            // Affichage de la carte de la mission
            echo "<div class='col-md-4'>";
            echo "<div class='card card-outline card-primary'>";
            echo "<div class='card-header'>";
            echo "<h3 class='card-title'>" . $row["nom"] . "</h3>";
            echo "<div class='card-tools'>";
            echo "<span class='badge badge-" . $badge_color . "'>" . $row["status"] . "</span>";
            echo "</div>";
            echo "</div>";
            echo "<div class='card-body'>";
            echo "<p><strong>Planète : </strong>" . $row["planete"] . "</p>";
            echo "<p><strong>Vaisseau : </strong>" . $row["vaisseau"] . "</p>";
            echo "<p><strong>Astronautes : </strong>" . $row["astronautes"] . "</p>";
            // Affichage des icônes en fonction de l'état de santé des astronautes
            $etats_sante = explode(", ", $row["etats_sante"]);
            foreach ($etats_sante as $etat_sante) {
              switch ($etat_sante) {
                case "Bon":
                  echo "<i class='fas fa-smile text-success'></i> ";
                  break;
                case "Malade":
                  echo "<i class='fas fa-frown text-warning'></i> ";
                  break;
                case "Décédé":
                  echo "<i class='fas fa-skull-crossbones text-danger'></i> ";
                  break;
                default:
                  echo "<i class='fas fa-question text-secondary'></i> ";
              }
            }
            echo "</div>";
            echo "</div>";
            echo "</div>";
          }
        }
        ?>
      </div>
      <!-- Fin des cartes des missions -->
    </div>
  </section>
  <!-- Fin du contenu -->
</div>
<!-- Fin du contenu principal -->
<?php
// Inclusion du fichier footer.php
include("footer.php");
?>