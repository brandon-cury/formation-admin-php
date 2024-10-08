<?php
require_once __DIR__ . '/../config.php';
use App\Lib\Auth;

use App\Controller\FormationController;

//verifier si l'utilisateur est un admin
if(!Auth::admin()){
  header('Location: index.php');
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
    <h1 class="my-3">Ajouter une formation :</h1>
    <form action="App/Controller/addFormation.php" method="post" enctype="multipart/form-data"> 
      
      <div class="form-floating mb-3">
        <input type="text" class="form-control" id="nom_formation" name="nom_formation" placeholder="CAP" required>
        <label for="nom_formation">Nom de la formation </label>
      </div>
      <div class="form-floating mb-3">
        <input type="text" class="form-control" id="nom_enseignant" name="nom_enseignant" placeholder="Pr." required>
        <label for="nom_enseignant">Nom de l'enseignant</label>
      </div>
      <div class="form-floating mb-3">
        <input type="number" class="form-control" id="duree_formation" name="duree_formation" min="1" max="1000" placeholder="45" required>
        <label for="duree_formation">Durée de la formation en période</label>
      </div>
      <div class="form-floating mb-3">
        <input type="number" class="form-control" id="nb_etudiants_max" name="nb_etudiants_max" min="10" max="20" placeholder="12" required>
        <label for="nb_etudiants_max">Nb d'étudiant max entre 10 et 20</label>
      </div>
      <div class="form-floating mb-3">
        <select class="form-select" id="active" name="active" aria-label="Floating label select example">
          <option value="2" selected></option>
          <option value="1">Actif</option>
          <option value="0">Inactif</option>
        </select>
        <label for="active">Statut</label>
      </div>
      <div class="form-floating mb-3">
        <input type="file" class="form-control" id="fichier_horaire_pdf" name="fichier_horaire_pdf" accept=".pdf" required>
        <label for="fichier_horaire_pdf">Ajouter l'Horaire en PDF</label>
      </div>
      <button type="submit" class="btn btn-primary">Ajouter</button>

    </form>
    <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
      integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
      crossorigin="anonymous"
    ></script>
    </div>
  </body>
</html>
