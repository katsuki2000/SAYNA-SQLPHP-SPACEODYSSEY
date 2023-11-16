<?php
/**
 * Fichier mission.php
 * 
 * Ce fichier contient le code PHP qui affiche la liste des missions de l'agence spatiale.
 * Il utilise le thème AdminLTE pour créer une interface graphique moderne et élégante.
 * Il affiche les missions sous forme de tableau, avec les informations sur le nom, la date, le statut, la planète, le vaisseau et les astronautes de chaque mission.
 * Il permet aussi de modifier ou de supprimer une mission en cliquant sur les boutons correspondants.
 */

// Inclusion des fichiers header.php, connexion.php et menuGauche.php
include("header.php");
include("connexion.php");
include("menuGauche.php");

// Requête SQL pour récupérer les missions
$sql = "SELECT m.id, m.nom, m.date_debut, m.date_fin, m.status, p.nom as planete, v.nom as vaisseau, GROUP_CONCAT(a.nom SEPARATOR ', ') as astronautes FROM mission m
JOIN planete p ON m.planete_id = p.id
JOIN affectation af ON m.id = af.mission_id
JOIN vaisseau v ON af.vaisseau_id = v.id
JOIN astronaute a ON af.astronaute_id = a.id
GROUP BY m.id";
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
          <h1 class="m-0 text-dark">Gestion des missions</h1>
        </div>
      </div>
    </div>
  </div>
  <!-- Fin de l'entête du contenu -->

  <!-- Contenu -->
  <section class="content">
    <div class="container-fluid">
      <!-- Tableau des missions -->
      <div class="card">
        <div class="card-header">
          <h3 class="card-title">Liste des missions</h3>
        </div>
        <div class="card-body">
          <table id="example1" class="table table-bordered table-striped">
            <thead>
            <tr>
              <th>Id</th>
              <th>Nom</th>
              <th>Date de début</th>
              <th>Date de fin</th>
              <th>Statut</th>
              <th>Planète</th>
              <th>Vaisseau</th>
              <th>Astronautes</th>
              <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            <?php
            // Affichage des missions sous forme de lignes du tableau
            if ($result->num_rows > 0) {
              while($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row["id"] . "</td>";
                echo "<td>" . $row["nom"] . "</td>";
                echo "<td>" . $row["date_debut"] . "</td>";
                echo "<td>" . $row["date_fin"] . "</td>";
                echo "<td>" . $row["status"] . "</td>";
                echo "<td>" . $row["planete"] . "</td>";
                echo "<td>" . $row["vaisseau"] . "</td>";
                echo "<td>" . $row["astronautes"] . "</td>";
                // Boutons pour modifier ou supprimer la mission
                echo "<td>";
                echo "<a href='modifier_mission.php?id=" . $row["id"] . "' class='btn btn-primary'><i class='fas fa-edit'></i></a> ";
                echo "<a href='supprimer_mission.php?id=" . $row["id"] . "' class='btn btn-danger' onclick='return confirm(\"Êtes-vous sûr de vouloir supprimer cette mission ?\")'><i class='fas fa-trash'></i></a>";
                echo "</td>";
                echo "</tr>";
              }
            }
            ?>
            </tbody>
          </table>
        </div>
      </div>
      <!-- Fin du tableau des missions -->
    </div>
  </section>
  <!-- Fin du contenu -->
</div>
<!-- Fin du contenu principal -->
<?php
// Inclusion du fichier footer.php
include("footer.php");
?>