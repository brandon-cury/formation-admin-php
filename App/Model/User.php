<?php
namespace App\Model;

//chargement du fichier config et des class
require_once __DIR__ . '/../../config.php';
spl_autoload_register(function($class){ require_once  ROOT_PATH . '/' . $class . '.php'; var_dump(ROOT_PATH . '/' . $class . '.php'); });

use PDO;
use App\Controller\UserController;

//creation de la class User
class User{

    //creation de quelques utilisateurs
    private static array $user_db = [
        [
            'login' => 'moukam',
            'password' => 'brandon',
            'role' => 'admin',
            'id' => 1
        ],
        [
            'login' => 'moukam1',
            'password' => 'brandon1',
            'role' => 'user',
            'id' => 2
        ]

    ];

    /**
     * @param int $id : Id de l'utilisateur
     * @return false|UserController : false si l'utilisateur ayant pour id $id n'a pas été trouvé 
     * et un objet de type UserController au cas contraire
     */
    public static function id(int $id): UserController|false{
        $user = false;
        $index_user = array_search($id, array_column(self::$user_db, "id"));

        if ($index_user !== false) {
            $user_array = self::$user_db[$index_user];
            $user = new UserController($user_array['login'], $user_array['password'], $user_array['role']);
            $user->setId($user_array['id']);
        }
        return $user;
    }

    /**
     * @param string $login : login de l'utilisateur
     * @param string $password : mot de passe de l'utilisateur
     * @return false|UserController : false si l'utilisateur ayant pour login $login et pour mot de passe $password n'a pas été trouvé 
     * et un objet de type UserController au cas contraire
     */
    public static function login(string $login, string $password): UserController|false{
        $user = false;
        $index_user = array_search($login, array_column(self::$user_db, "login"));
        if ($index_user !== false) {
            $user_array = self::$user_db[$index_user];
            //verify password 
            if ($user_array['password'] === $password){
                $user = new UserController($user_array['login'], $user_array['password'], $user_array['role']);
                $user->setId($user_array['id']);
            }
            
        }
        return $user;

    }

}