<?php

namespace App\Controller;

//debut de la session
session_start();

//chargement des class
require_once __DIR__ . '/../../config.php';
spl_autoload_register(function($class){ require_once  ROOT_PATH . '/' . $class . '.php'; });

use App\lib\Auth;
use views\AlertController;
use App\Controller\FormationController;

//redirection si il y a aucune valeur en post ou si l'utilisateur n'est pas un admin
if (empty($_POST) || !isset($_POST['id']) || !Auth::admin()) {
    header("HTTP/1.1 405");
    die;
}
//verifier si la formation existe en base de données
$formation = FormationController::getFormationById($_POST['id']);
if(!is_a($formation, FormationController::class)){
    AlertController::alert('cette formation n\'existe pas !', 'danger');
    header('Location: ../../index.php?slug=views/all.php');
    die;
}

//enregistrement en session de id de la formation 
$_SESSION['id_formation'] = $_POST['id'];

//redirection 
if($_POST['type'] == 'veiw'){
    header('Location: ../../index.php?slug=views/profilFormation.php');
    die;
}
elseif($_POST['type'] == 'update'){
    header('Location: ../../index.php?slug=views/updateFormation.php');
    die;
}

