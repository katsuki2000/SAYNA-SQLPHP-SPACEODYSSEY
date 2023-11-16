
<?php
// Inclusion du fichier contenant la fonction connect_db
include("db.php");

// Appel de la fonction connect_db
$conn = connect_db();

// Requ�te SQL pour r�cup�rer les plan�tes
$sql = "SELECT * FROM planete";
$stmt = $conn->prepare($sql);
$stmt->execute();
$result = $stmt->fetchAll();

// D�but du code HTML
?>
<!-- Contenu principal -->
<div class="content-wrapper">
  <!-- Ent�te du contenu -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0 text-dark">Gestion des plan�tes</h1>
        </div>
      </div>
    </div>
  </div>
  <!-- Fin de l'ent�te du contenu -->

  <!-- Contenu -->
  <section class="content">
    <div class="container-fluid">
      <!-- Tableau des plan�tes -->
      <div class="card">
        <div class="card-header">
          <h3 class="card-title">Liste des plan�tes</h3>
        </div>
        <div class="card-body">
          <table id="example1" class="table table-bordered table-striped">
            <thead>
            <tr>
              <th>Id</th>
              <th>Nom</th>
              <th>Circonf�rence (km)</th>
              <th>Distance � la Terre (km)</th>
              <th>Documentation</th>
              <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            <?php
            // Affichage des plan�tes sous forme de lignes du tableau
            foreach ($result as $row) {
              echo "<tr>";
              echo "<td>" . $row["id"] . "</td>";
              echo "<td>" . $row["nom"] . "</td>";
              echo "<td>" . $row["circonference"] . "</td>";
              echo "<td>" . $row["distance"] . "</td>";
              echo "<td>" . $row["documentation"] . "</td>";
              // Boutons pour modifier ou supprimer la plan�te
              echo "<td>";
              echo "<a href='modifier_planete.php?id=" . $row["id"] . "' class='btn btn-primary'><i class='fas fa-edit'></i></a> ";
              echo "<a href='supprimer_planete.php?id=" . $row["id"] . "' class='btn btn-danger' onclick='return confirm(\"�tes-vous s�r de vouloir supprimer cette plan�te ?\")'><i class='fas fa-trash'></i></a>";
              echo "</td>";
              echo "</tr>";
            }
            ?>
            </tbody>
          </table>
        </div>
      </div>
      <!-- Fin du tableau des plan�tes -->
    </div>
  </section>
  <!-- Fin du contenu -->
</div>
<!-- Fin du contenu principal -->
<?php
// Inclusion du fichier footer.php
include("footer.php");
?>