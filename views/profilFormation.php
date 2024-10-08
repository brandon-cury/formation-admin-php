<?php
require_once __DIR__ . '/../config.php';
use App\Lib\Auth;

use App\Controller\FormationController;

if(!Auth::admin()){
  header('Location: index.php');
}
if(!empty($_SESSION['id_formation'])){
    $formation = FormationController::getFormationById($_SESSION['id_formation']);
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
    <h1 class='my-4'>Formation : <?= $formation->getNomFormation() ?></h1>
   <table class="table table-striped">
    <tbody>
    <tr>
      <th scope="row">Nom de la Formation</th>
      <td><?= $formation->getNomFormation() ?></td>
    </tr>
    <tr>
      <th scope="row">Durée</th>
      <td><?= $formation->getDureeFormation() ?> Périodes</td>
    </tr>
    <tr>
      <th scope="row">Nom de l'enseignant</th>
      <td><?= $formation->getNomEnseignant() ?></td>
    </tr>
     <tr>
      <th scope="row">Nb d'etudiants max</th>
      <td><?= $formation->getNbEtudiantsMax() ?></td>
    </tr>
     <tr>
      <th scope="row">Fichier horaire</th>
      <td><a class='text-decoration-none' href="<?= $formation->getFichierHorairePdfSrc() ?>" target="_blank" rel="noopener noreferrer">HORAIRE EN PDF</a></td>
    </tr>
     <tr>
      <th scope="row">Statut</th>
      <td><?= $formation->getStatut() ?></td>
    </tr>
  </tbody>
</table>
<form action="App/Controller/FormationSession.php" method="post">
        <input type="hidden" name="id" value="<?= $formation->getIdFormation() ?>">
        <input type="hidden" name="type" value="update">
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

