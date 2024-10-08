<?php
require_once __DIR__ . '/../config.php';
spl_autoload_register(function($class){ require_once  ROOT_PATH . '/' . $class . '.php'; });

use App\Lib\Auth;

use App\Controller\FormationController;
use views\AlertController;

//verifions si l'utilisateur est un admin
if(!Auth::admin()){
  header('Location: index.php');
}


$formation_exit = false;
$formations = [];
$statut = null;
$trie='nom_formation';
if(!empty($_GET['trie'])){
  $trie = $_GET['trie'];
}

if(isset($_GET['statut'])){
  $statut = $_GET['statut'];
}
if(!empty($_GET['search'])){
  $formations = FormationController::search($_GET['search'], $trie, $statut);
  if(empty($formations)){
    AlertController::alert("Aucun utilisateur trouvé", 'danger');
  }
}else{
  $formations = FormationController::AllFormation($trie, $statut);
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
    <h1 class='my-4'>Formations</h1>
    <div class="my-4"> 

      <span>Trier par: </span>
      <div class="btn-group" role="group" aria-label="Basic radio toggle button group">

      <input type="radio" class="btn-check" name="trie" value="nom_formation" id="btnradio1" autocomplete="off">
      <label class="btn btn-outline-primary" for="btnradio1">Nom de la formation</label>

      <input type="radio" class="btn-check" name="trie" value="duree_formation" id="btnradio2" autocomplete="off">
      <label class="btn btn-outline-primary" name="trie" for="btnradio2">Durée</label>

      <input type="radio" class="btn-check" name="trie" value="nom_enseignant" id="btnradio3" autocomplete="off">
      <label class="btn btn-outline-primary" for="btnradio3">Nom de l'enseignant</label>

      <input type="radio" class="btn-check" name="trie" value="nb_etudiants_max" id="btnradio4" autocomplete="off">
      <label class="btn btn-outline-primary" for="btnradio4">Nb d'etudiants max</label>

      <input type="radio" class="btn-check" name="trie" value="active" id="btnradio5" autocomplete="off">
      <label class="btn btn-outline-primary" for="btnradio5">Statut</label>

    </div>
    </div>
   <table class="table table-striped">
  <thead>
    <tr>
      <th scope="col">Nom de la Formation</th>
      <th scope="col">Durée</th>
      <th scope="col">Nom de l'enseignant</th>
      <th scope="col">Nb d'etudiants max</th>
      <th scope="col">Fichier horaire</th>
      <th scope="col">Statut</th>
      <th scope="col">Action</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($formations as $formation) : ?>
      
      <tr>

      <td> 
        <form action="App/Controller/FormationSession.php" method="post">
          <input type="hidden" name="id" value="<?= $formation->getIdFormation() ?>">
          <input type="hidden" name="type" value="veiw">
          <button type="submit" class="btn btn-none text-primary"><?= $formation->getNomFormation() ?></button>
        </form>  
      </td>
      <td><?= $formation->getDureeFormation() ?> Périodes</td>
      <td><?= $formation->getNomEnseignant() ?> </td>
      <td><?= $formation->getNbEtudiantsMax() ?></td>

      <td><a class='text-decoration-none' href="<?= $formation->getFichierHorairePdfSrc() ?>" target="_blank" rel="noopener noreferrer">HORAIRE EN PDF</a></td>
      <td><div class="statutRadio <?= $formation->getStatut() ?>" > </div> </td>
      <td>
      <form action="App/Controller/FormationSession.php" method="post">
        <input type="hidden" name="id" value="<?= $formation->getIdFormation() ?>">
        <input type="hidden" name="type" value="update">
        <button type="submit" class="btn btn-primary">Modifier</button>
      </form>  
      </td>
    </tr>
    <?php endforeach ?>
  </tbody>
</table>
   </div>
    
    <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
      integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
      crossorigin="anonymous"
    ></script>
    
  </body>
 
</html>
