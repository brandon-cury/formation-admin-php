<?php
namespace App\Controller;
//demarage de la session
session_start();

//chargement des class
require_once __DIR__ . '/../../config.php';
spl_autoload_register(function($class){ require_once  ROOT_PATH . '/' . $class . '.php'; });

use App\Controller\UserController;
use views\AlertController;
use App\Lib\Auth;
//redirection si post est vide
if (empty($_POST)) {
    header("HTTP/1.1 405");
    die;
}

//verifier si les information login et mot de passe sont correcte et création de la session user_id
$user = UserController::login($_POST['login'], $_POST['password']);
if(is_a($user, UserController::class)){  
    $_SESSION['user_id'] = $user->getId();
    if(Auth::admin()){
        header('Location: ../../index.php?slug=views/all.php');
        die;
    }
    header('Location: ../../index.php?slug=views/home.php');
    die;
}
//message d'erreur en cas de nom connexion
AlertController::alert('Vos informations sont incorrectes', 'danger'); 
header('Location: ../../index.php?slug=views/login.php');