<?php
require_once __DIR__ . '/../config.php';
use App\Lib\Auth;

use App\Controller\FormationController;

if(!Auth::admin()){
  header('Location: index.php');
}

$formation_exit = false;
if(!empty($_SESSION['id_formation'])){
    $formation = FormationController::getFormationById($_SESSION['id_formation']);
    if(is_a($formation, FormationController::class)){
        $formation_exit = true; 
    }
}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
      rel="stylesheet"
      integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH"
      crossorigin="anonymous"
    />
    <title>Validation de formulaire</title>
  </head>
  <body>
    <div class="container">
    <h1 class="my-3">Modifier la formation : <?= $formation->getNomFormation() ?></h1>
    <form action="App/Controller/update.php" method="post" enctype="multipart/form-data"> 

      <div class="form-floating mb-3">
        <input type="text" class="form-control" id="nom_formation" name="nom_formation" <?php if($formation_exit){ echo "value=" . $formation->getNomFormation(); } ?> placeholder="CAP" required>
        <label for="nom_formation">Nom de la formation </label>
      </div>
      <div class="form-floating mb-3">
        <input type="text" class="form-control" id="nom_enseignant" name="nom_enseignant" value="<?php if($formation_exit){ echo $formation->getNomEnseignant(); } ?>" placeholder="Pr." required>
        <label for="nom_enseignant">Nom de l'enseignant</label>
      </div>
      <div class="form-floating mb-3">
        <input type="number" class="form-control" id="duree_formation" name="duree_formation" min="1" max="1000" <?php if($formation_exit){ echo "value=" . $formation->getDureeFormation(); } ?> placeholder="45" required>
        <label for="duree_formation">Durée de la formation en période</label>
      </div>
      <div class="form-floating mb-3">
        <input type="number" class="form-control" id="nb_etudiants_max" name="nb_etudiants_max" min="10" max="20" <?php if($formation_exit){ echo "value=" . $formation->getNbEtudiantsMax(); } ?> placeholder="12" required>
        <label for="nb_etudiants_max">Nb d'étudiant max entre 10 et 20</label>
      </div>
      <div class="form-floating mb-3">
        <select class="form-select" id="active" name="active" aria-label="Floating label select example">
          <option value="2" selected></option>
          <option value="1" <?php if($formation_exit){if($formation->getActive() == 1){ echo "selected"; }} ?>>Actif</option>
          <option value="0" <?php if($formation_exit && $formation->getActive() == 0){ echo "selected"; } ?>>Inactif</option>
        </select>
        <label for="active">Statut</label>
      </div>
      <div class="form-floating mb-3">
        <input type="file" class="form-control" id="fichier_horaire_pdf" name="fichier_horaire_pdf" accept=".pdf">
        <label for="fichier_horaire_pdf">Ajouter l'Horaire en PDF</label>
      </div>
      <button type="submit" class="btn btn-primary">Modifier</button>


    </form>
    </div>

    <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
      integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
      crossorigin="anonymous"
    ></script>
  </body>
</html>
