<?php
//chargement des class
require_once __DIR__ . '/../config.php';
spl_autoload_register(function($class){ require_once  ROOT_PATH . '/' . $class . '.php';});

use App\Lib\Auth;

// Vérification que la requête provient de index.php
if (str_contains($_SERVER['SCRIPT_NAME'], 'index.php')) {
    if (!empty($_GET['slug'])) {
        App\Lib\Tool::getContent($_GET['slug']);
    }else{
        if(Auth::admin()){
            header('Location: index.php?slug=views/all.php');
        }
        header('Location: index.php?slug=views/home.php');
    }
} else {
    if (!defined('ROOT_PATH')) {
        $redirect = '../index.php';
    } else {
        $redirect = ROOT_PATH . 'index.php';
    }
    // sinon, redirection vers index.php
    header('Location: ' . $redirect);
    exit;
}



