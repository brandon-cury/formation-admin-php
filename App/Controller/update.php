<?php
namespace App\Controller;
//début de la session
session_start();

//chargement des class
require_once __DIR__ . '/../../config.php';
spl_autoload_register(function($class){ require_once  ROOT_PATH . '/' . $class . '.php'; });

use App\Controller\FormationController;
use views\AlertController;
use App\Lib\Auth;

//redirection si il y a aucune valeur en post ou si l'utilisateur n'est pas un admin
if (empty($_POST) || !Auth::admin()) {
    header("HTTP/1.1 405");
    die;
}
//vérifier que tous les champs sont rempli 
foreach($_POST as $key => $value){
    if(empty($value) && $key != 'active'){
        AlertController::alert('Erreur: Veuillez remplir tous les champs', 'danger');
        header('Location: ../../index.php?slug=views/updateFormation.php');
        die;
    }
}
//modifier la formation en base de données
$formation = FormationController::getFormationById($_SESSION['id_formation']);
if($formation->update($_POST['nom_formation'], $_POST['nom_enseignant'], $_POST['duree_formation'], $_POST['nb_etudiants_max'], $_POST['active'], $_FILES['fichier_horaire_pdf'])){
    AlertController::alert('La formation a été modifier avec success', 'success');   
    header('Location: ../../index.php?slug=views/profilFormation.php');
}
