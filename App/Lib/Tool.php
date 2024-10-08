<?php
namespace App\Lib;

//chargement du fichier config et des class
require_once __DIR__ . '/../../config.php';
spl_autoload_register(function($class){ require_once  ROOT_PATH . '/' . $class . '.php'; });

use views\AlertController;

class Tool{
/**
 *  Fichier contenant les fonctions utilisées par notre application
 */


/**
 * @param string $data
 * @return string une chaine de caractere sans espace au début et a la fin, avec toutes les balises HTML et PHP supprimées
 */
public static function cleanData(string $data) :string {
    return strip_tags(trim($data));
}
/**
 * @param array $data
 * @return array|false un tableau contenant les données vérifié ou false si une erreur a été détecté
 */
public static function validDataType(array $data) :array|false {
    $bool = true;
    foreach ($data as $key => $value) {
        $data[$key] = self::cleanData($value);
        if($key == 'nom_formation' || $key == 'nom_enseignant'){
            if(!preg_match("/^(?=[ÉéèA-Za-z])([A-Za-z\p{L}\.\ \é\è]){2,}$/", $value)){
                $bool = false;
                $alert ='la taille minimum du ' . $key . ' doit être de minimum 2 caractères et ne doit contenir que les lettres ou \'é\', \'è\', \'.\' et \' \' !';
                AlertController::alert($alert, 'danger');
            }
        }
        elseif($key == 'nb_etudiants_max'){
            if(!is_int($value) || $value < 10 || $value >20){
                $bool = false;
                AlertController::alert('le nombre d\'étudiant doit être compris entre 10 et 20 !', 'danger');
            }
        }
        elseif($key == 'duree_formation' || $value < 0 || $value > 1000){
            if(!is_int($value)){
                $bool = false;
                AlertController::alert('le nombre de période doit être un entier !', 'danger');
            }
        }
        elseif($key == 'active'){
            if(!is_int($value) || !in_array($value, [0, 1])){
                $bool = false;
                AlertController::alert('Veillez choisir si la formation est active ou pas 0, 1 !', 'danger');
            }
        }
    }
    if($bool == false){
        return false;
    }
    return $data;
    
}
/**
 * getContent() : permet d'inclure le fichier passé url
 * @param string $slug : chemin du fichier a inclure
 * @return void : ne retourne rien
 */
public static function getContent(string $slug): void {
    if (!empty($slug) && file_exists($slug)) {
        include_once $slug;
    }
}


}