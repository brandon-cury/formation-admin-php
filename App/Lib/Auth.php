<?php
namespace App\Lib;

//chargement de la page config et des class
require_once __DIR__ . '/../../config.php';
spl_autoload_register(function($class){ require_once  ROOT_PATH . '/' . $class . '.php'; var_dump(ROOT_PATH . '/' . $class . '.php'); });

use App\Model\User;
use App\Controller\UserController;
use PDO;

//creation de la classe d'authentification d'un utilisateur (Auth)
class Auth{
    
    //permet de verifier si on est connecté ou pas
    public static function verify():bool{
        if(!empty($_SESSION['user_id'])){
            return true;
        }
        return false;
    }

    //permet de verifier si l'utilisateur est un admin ou pas
    public static function admin():bool{
        if(self::verify()){
            if(self::user()->getRole() == 'admin'){
                return true;
            }
        }
        return false;
        
    }
    //permet de récupérer tous les information de l'utilisateur
    public static function user(): UserController{
        $user_id = $_SESSION['user_id'];
        $user = UserController::id($user_id);
        if(is_a($user, UserController::class)){
           return $user;
        }
    }
}
