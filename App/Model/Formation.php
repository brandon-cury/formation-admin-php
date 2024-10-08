<?php
namespace App\Model;

//chargement du fichier config et des class
require_once __DIR__ . '/../../config.php';
spl_autoload_register(function($class){ require_once  ROOT_PATH . '/' . $class . '.php'; });

use App\Lib\Tool;
use App\Controller\FormationController;
use App\Model\Model;

//creation de la class Formation 
class Formation extends Model{
    
    /**
     * @param $formation : est un objet de type FormationController
     * @return false|int : false si l'insertion en basse de données n'a pas marché 
     * et un entier (int) representant id de la nouvelle formation lorsque l'insertion a marché
     */
    public static function create(FormationController $formation): false|int{
        $db = self::db();

        $req = $db->prepare("INSERT INTO formations (nom_formation, nom_enseignant, duree_formation, nb_etudiants_max, active, fichier_horaire_pdf) VALUES (?, ?, ?, ?, ?, ?)");
        $params = [$formation->getNomFormation(), $formation->getNomEnseignant(), $formation->getDureeFormation(), $formation->getNbEtudiantsMax(),  $formation->getActive(),  $formation->getFichierHorairePdf()];
        $req->execute($params);
            if($req->rowCount() > 0){
                return $db->lastInsertId();
            }
            return false;
    }

    /**
     * @param $formation : est un objet de type FormationController
     * @return bool : true si la formation a bien été modifier et false au cas contraire
     */
    public static function update(FormationController $formation): bool{
        $db = self::db();
        $req = $db->prepare("UPDATE formations SET  nom_formation=?, nom_enseignant =?, duree_formation =?, nb_etudiants_max =?, active =? , fichier_horaire_pdf =? WHERE  id_formation =?");
        $params = [$formation->getNomFormation(), $formation->getNomEnseignant(), $formation->getDureeFormation(), $formation->getNbEtudiantsMax(),  $formation->getActive(),  $formation->getFichierHorairePdf(), $_SESSION['id_formation']];
        $req->execute($params);
        return true;
    }

    /**
     * @param int $idFormation : Id de la formation
     * @return false|FormationController : false si la formation ayant pour id $idFormation n'a pas été trouvé 
     * et un objet de type FormationController au cas contraire
     */
    public static function getFormationById(int $idFormation): false|FormationController{
        $db = self::db();
        $req = $db->prepare("SELECT * FROM formations WHERE id_formation=?");
        $req->execute([$idFormation]);
        $req->setFetchMode(\PDO::FETCH_CLASS, FormationController::class);
        return $req->fetch();
    }

    /**
     * @param string $nom_formation : nom de la formation
     * @return false|FormationController : false si la formation ayant pur nom $nom_Formation n'a pas été trouvé 
     * et un objet de type FormationController au cas contraire
     */
    public static function getFormationByName(string $nom_formation): false|FormationController{
        $db = self::db();
        $req = $db->prepare("SELECT * FROM formations WHERE nom_formation=?");
        $req->execute([$nom_formation]);
        $req->setFetchMode(\PDO::FETCH_CLASS, FormationController::class);
        return $req->fetch();
    }

    /**
     * @param string $trie : nom du champ de la table formations  par lequel on aimerait trier les résultats
     * @param int|null $statut : ne peut prendre que la valeur 0, 1 ou null.
     *  à 0 il permet de récupérer uniquement les formations supprimés; 
     * à 1 il permet de récupérer uniquement les formations actives; 
     * à null il permet de récupérer toutes les formations.
     */
    public static function AllFormation(string $trie, int|null $statut): array{
        $db = self::db();
        $query = "SELECT * FROM formations ";
        if(isset($statut)){
            $query .= "WHERE active=? ";
        }
        $query .= "ORDER BY $trie ASC";

        $req = $db->prepare($query);
        $params = [];
        if(isset($statut)){
            $params[] = $statut;
        }
        
        $req->execute($params); 
        return $req->fetchAll(\PDO::FETCH_CLASS, FormationController::class);

    }

    /**
     * permet d'obtenir la dernière formaton enregistrée en base de données
     */
    public static function lastFormation() : FormationController|bool{
        $db = self::db();
        //obtenir le dernier matricule
        $req_ma = $db->prepare("SELECT * FROM formations order by id_formation desc Limit 1");
        $req_ma->execute();
        $req_ma->setFetchMode(\PDO::FETCH_CLASS, FormationController::class);
        return $req_ma->fetch();
    }
    
    /**
     * search() : Permet de rechercher une formation en base de données
     * @param string $search : chaine de caractère à rechercher
     * @param string $trie : Nom du champ par lequel on souhaite effectué le trie. Par défaut le trie s'effectue sur le champ nom_formation
     * @param int $statut : permet d'effectué
     */
    public static function search(string $search, string $trie = 'nom_formation', int|null $statut = null): Array{
        $db = self::db();
        $query = "SELECT * FROM formations WHERE CONCAT(nom_formation, ' ', duree_formation, ' ', nom_enseignant, ' ', nb_etudiants_max) like ? ";
        if(isset($statut)){
            $query .= " AND active=? ";
        }
        $query .= " ORDER BY $trie ASC ";
        $req = $db->prepare($query);
        $params = [];
        $params[] = "%{$search}%";
        if(isset($statut)){
            $params[] = "$statut";
        }
        $req->execute($params);
        return $req->fetchAll(\PDO::FETCH_CLASS, FormationController::class);
    }
    

}