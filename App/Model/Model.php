<?php
namespace App\Model;

//chargement du fichier config et des class
require_once __DIR__ . '/../../config.php';
spl_autoload_register(function($class){ require_once  ROOT_PATH . '/' . $class . '.php'; var_dump(ROOT_PATH . '/' . $class . '.php'); });

use PDO;

//creation du model
class Model{

    /**
     * prermet d'effectué la connection à la base de données
     */
    public static function db(string $host = DB_HOST, string $dbname = DB_NAME, string $user = DB_USER, string $pass = DB_PASSWORD): PDO{
    try {
    $dsn = 'mysql:host=' . DB_HOST . ';dbname=' . $dbname;
    $pdo = new PDO($dsn, $user, $pass);
    } catch (PDOException $e) {
        echo "Failed: " . $e->getMessage();
    }
    return $pdo;
}
}