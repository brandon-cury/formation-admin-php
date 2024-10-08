<?php
namespace App\Controller;
session_start();

//chargement des class
require_once __DIR__ . '/../../config.php';
spl_autoload_register(function($class){ require_once  ROOT_PATH . '/' . $class . '.php'; });

use App\Controller\FormationController;
use views\AlertController;
use App\Lib\Auth;

//verifier si on a les variables en post et si l'utilisateur est un admin
if (empty($_POST) || !Auth::admin()) {
    header("HTTP/1.1 405");
    die;
}
//verifier si chaque champ du tableau post contient une valeur sauf le champ active
foreach($_POST as $key => $value){
    if(empty($value) && $key != 'active'){
        AlertController::alert('Erreur: Veuillez remplir tous les champs', 'danger');
        header('Location: ../../index.php?slug=views/ajoutFormation.php');
        die;
    }
}
//creation d'une nouvelle formation et redirection sur le profil de la formation
$formation = new FormationController();
if($formation->create($_POST['nom_formation'], $_POST['nom_enseignant'], $_POST['duree_formation'], $_POST['nb_etudiants_max'], $_POST['active'], $_FILES['fichier_horaire_pdf'])){
    $_SESSION['id_formation'] = $formation->getIdFormation();
    AlertController::alert('La formation a été créer avec success', 'success');   
    header('Location: ../../index.php?slug=views/profilFormation.php');
    die;
}
