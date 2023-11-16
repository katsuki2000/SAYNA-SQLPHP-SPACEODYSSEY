<?php
// Inclusion du fichier contenant la fonction connect_db
include("db.php");

// Appel de la fonction connect_db
$conn = connect_db();

// R�cup�ration de l'id de la mission � modifier
$id = $_GET["id"];

// Requ�te SQL pour r�cup�rer les informations de la mission
$sql = "SELECT m.id, m.nom, m.date_debut, m.date_fin, m.status, p.id as planete_id, v.id as vaisseau_id, GROUP_CONCAT(a.id SEPARATOR ', ') as astronautes_id FROM mission m
JOIN planete p ON m.planete_id = p.id
JOIN affectation af ON m.id = af.mission_id
JOIN vaisseau v ON af.vaisseau_id = v.id
JOIN astronaute a ON af.astronaute_id = a.id
WHERE m.id = $id
GROUP BY m.id";
$result = $conn->query($sql);
$row = $result->fetch_assoc();

// R�cup�ration des donn�es de la mission
$nom = $row["nom"];
$date_debut = $row["date_debut"];
$date_fin = $row["date_fin"];
$status = $row["status"];
$planete_id = $row["planete_id"];
$vaisseau_id = $row["vaisseau_id"];
$astronautes_id = explode(", ", $row["astronautes_id"]);

// Requ�te SQL pour r�cup�rer les plan�tes
$sql_planetes = "SELECT * FROM planete";
$result_planetes = $conn->query($sql_planetes);

// Requ�te SQL pour r�cup�rer les vaisseaux
$sql_vaisseaux = "SELECT * FROM vaisseau";
$result_vaisseaux = $conn->query($sql_vaisseaux);

// Requ�te SQL pour r�cup�rer les astronautes
$sql_astronautes = "SELECT * FROM astronaute";
$result_astronautes = $conn->query($sql_astronautes);

// Traitement du formulaire de modification
if (isset($_POST["modifier"])) {
  // R�cup�ration des donn�es du formulaire
  $nom = $_POST["nom"];
  $date_debut = $_POST["date_debut"];
  $date_fin = $_POST["date_fin"];
  $status = $_POST["status"];
  $planete_id = $_POST["planete_id"];
  $vaisseau_id = $_POST["vaisseau_id"];
  $astronautes_id = $_POST["astronautes_id"];

  // Validation des donn�es
  $erreurs = [];
  if (empty($nom)) {
    $erreurs[] = "Le nom est obligatoire.";
  }
  if (empty($date_debut)) {
    $erreurs[] = "La date de d�but est obligatoire.";
  }
  if (empty($date_fin)) {
    $erreurs[] = "La date de fin est obligatoire.";
  }
  if (empty($status)) {
    $erreurs[] = "Le statut est obligatoire.";
  }
  if (empty($planete_id)) {
    $erreurs[] = "La plan�te est obligatoire.";
  }
  if (empty($vaisseau_id)) {
    $erreurs[] = "Le vaisseau est obligatoire.";
  }
  if (empty($astronautes_id)) {
    $erreurs[] = "Les astronautes sont obligatoires.";
  }

  // Si pas d'erreurs, on ex�cute la requ�te SQL UPDATE
  if (empty($erreurs)) {
    $sql_update = "UPDATE mission SET nom = ?, date_debut = ?, date_fin = ?, status = ?, planete_id = ? WHERE id = ?";
    $stmt_update = $conn->prepare($sql_update);
    $stmt_update->bind_param("ssssii", $nom, $date_debut, $date_fin, $status, $planete_id, $id);
    $stmt_update->execute();

    // On supprime les anciennes affectations de la mission
    $sql_delete = "DELETE FROM affectation WHERE mission_id = ?";
    $stmt_delete = $conn->prepare($sql_delete);
    $stmt_delete->bind_param("i", $id);
    $stmt_delete->execute();

    // On ins�re les nouvelles affectations de la mission
    foreach ($astronautes_id as $astronaute_id) {
      $sql_insert = "INSERT INTO affectation (mission_id, vaisseau_id, astronaute_id) VALUES (?, ?, ?)";
      $stmt_insert = $conn->prepare($sql_insert);
      $stmt_insert->bind_param("iii", $id, $vaisseau_id, $astronaute_id);
      $stmt_insert->execute();
    }

    // On affiche un message de confirmation et on redirige vers la liste des missions
    echo "<script>alert('Mission modifi�e avec succ�s.');</script>";
    echo "<script>window.location.href = 'mission.php';</script>";
  }
}

// D�but du code HTML
?>
<!-- Contenu principal -->
<div class="content-wrapper">
  <!-- Ent�te du contenu -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0 text-dark">Modifier une mission</h1>
        </div>
      </div>
    </div>
  </div>
  <!-- Fin de l'ent�te du contenu -->

  <!-- Contenu -->
  <section class="content">
    <div class="container-fluid">
      <!-- Formulaire de modification -->
      <div class="card card-primary">
        <div class="card-header">
          <h3 class="card-title">Saisir les informations de la mission</h3>
        </div>
        <form method="post" action="">
          <div class="card-body">
            <!-- Affichage des erreurs �ventuelles -->
            <?php
            if (!empty($erreurs)) {
              echo "<div class='alert alert-danger'>";
              echo "<ul>";
              foreach ($erreurs as $erreur) {
                echo "<li>$erreur</li>";
              }
              echo "</ul>";
              echo "</div>";
            }
            ?>
            <!-- Champ nom -->
            <div class="form-group">
              <label for="nom">Nom</label>
              <input type="text" class="form-control" id="nom" name="nom" value="<?php echo $nom; ?>">
            </div>
            <!-- Champ date de d�but -->
            <div class="form-group">
              <label for="date_debut">Date de d�but</label>
              <input type="date" class="form-control" id="date_debut" name="date_debut" value="<?php echo $date_debut; ?>">
            </div>
            <!-- Champ date de fin -->
            <div class="form-group">
              <label for="date_fin">Date de fin</label>
              <input type="date" class="form-control" id="date_fin" name="date_fin" value="<?php echo $date_fin; ?>">
            </div>
            <!-- Champ statut -->
            <div class="form-group">
              <label for="status">Statut</label>
              <select class="form-control" id="status" name="status">
                <option value="">S�lectionner un statut</option>
                <option value="en pr�paration" <?php if ($status == "en pr�paration") echo "selected"; ?>>En pr�paration</option>
                <option value="en cours" <?php if ($status == "en cours") echo "selected"; ?>>En cours</option>
                <option value="termin�e" <?php if ($status == "termin�e") echo "selected"; ?>>Termin�e</option>
                <option value="abandonn�e" <?php if ($status == "abandonn�e") echo "selected"; ?>>Abandonn�e</option>
              </select>
            </div>
            <!-- Champ plan�te -->
            <div class="form-group">
              <label for="planete_id">Plan�te</label>
              <select class="form-control" id="planete_id" name="planete_id">
                <option value="">S�lectionner une plan�te</option>
                <?php
                // Affichage des plan�tes sous forme d'options
                if ($result_planetes->num_rows > 0) {
                  while ($row_planete = $result_planetes->fetch_assoc()) {
                    echo "<option value='" . $row_planete["id"] . "'";
                    if ($planete_id == $row_planete["id"]) echo "selected";
                    echo ">" . $row_planete["nom"] . "</option>";
                  }
                }
                ?>
              </select>
            </div>
            <!-- Champ vaisseau -->
            <div class="form-group">
              <label for="vaisseau_id">Vaisseau</label>
              <select class="form-control" id="vaisseau_id" name="vaisseau_id">
                <option value="">S�lectionner un vaisseau</option>
                <?php
                // Affichage des vaisseaux sous forme d'options
                if ($result_vaisseaux->num_rows > 0) {
                  while ($row_vaisseau = $result_vaisseaux->fetch_assoc()) {
                    echo "<option value='" . $row_vaisseau["id"] . "'";

		if ($vaisseau_id == $row_vaisseau[�id�]) 
echo �selected�; echo �>� . $row_vaisseau[�nom�] . �</option>�; } } ?> 
		</select> 
	</div> 

<!-- Champ astronautes -->
	 <div class=�form-group�>
		 <label for=�astronautes_id�>Astronautes</label> 
	<select class=�form-control� id=�astronautes_id� name=�astronautes_id[]� multiple> 
	<?php
 // Affichage des astronautes sous forme d�options if ($result_astronautes->num_rows > 0) { while ($row_astronaute = $result_astronautes->fetch_assoc()) { echo �<option value='� . $row_astronaute[�id�] . �'�;
 if (in_array($row_astronaute[�id�], $astronautes_id)) echo �selected�; echo �>� . $row_astronaute[�nom�] . �</option>�; } } ?> </select> </div> </div> <div class=�card-footer�>

 <!-- Bouton pour modifier la mission -->

 <button type=�submit� class=�btn btn-primary� name=�modifier�>Modifier</button> 
</div>
 </form>
 </div>
 <!-- Fin du formulaire de modification -->
 </div> 
</section>
 <!-- Fin du contenu -->
 </div>
 <!-- Fin du contenu principal --> 
<?php 
// Inclusion du fichier footer.php
 include(�footer.php�);
 ?>
