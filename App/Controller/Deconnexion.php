<?php
namespace App\Controller;

//Redirigé l'utilisateur s'il accède en Get
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    header("HTTP/1.1 405");
    die;
}
//suppresion de la session
session_destroy();
//redirection vers la page d'accueil
header('Location: index.php');