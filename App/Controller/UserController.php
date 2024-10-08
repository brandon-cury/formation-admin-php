<?php
namespace App\Controller;

require_once __DIR__ . '/../../config.php';
spl_autoload_register(function($class){ require_once  ROOT_PATH . '/' . $class . '.php'; var_dump(ROOT_PATH . '/' . $class . '.php'); });

use App\Lib\Tool;
use App\Model\Formation;
use App\Model\User;

//creation du controller des utilisateurs (class)
class UserController{
    private string $login;
    private string $password;
    private string $role;
    private int $id;

    //constructeur
    public function __construct(string $login, string $password, string $role){
        $this->login = $login;
        $this->password = $password;
        $this->role = $role;
    }
    //permet de récupérer le login d'un utilisateur
    public function getLogin(): string{
        return $this->login;
    }

    //permet de récupérer le mot de passe d'un utilisateur
    public function getPassword() : string {
        return $this->password;
    }

    //permet de récupérer le role d'un utilisateur
    public function getRole() : string {
        return $this->role;
    }

    //permet de récupérer le Id d'un utilisateur
    public function getId(): int {
        return $this->id;
    }

    //permet de modifier Id d'un utilisateur
    public function setId(int $id): void{
        $this->id = $id;
    }

    //permet de récupérer un utilisateur à partir de son login et mot de passe
    public static function login(string $login, string $password):UserController|false{
        return User::login($login, $password);
    }

    //permet de récupérer un utilisateur à partir de son Id
    public static function id(int $id):UserController|false{
        return User::id($id);
    }
}