<?php
namespace App\Controller;

//chargement des class à utiliser
require_once __DIR__ . '/../../config.php';
spl_autoload_register(function($class){ require_once  ROOT_PATH . '/' . $class . '.php'; });
use App\Lib\Tool;
use App\Model\Formation;
use views\AlertController;


//creation du controller des formations (class)
class FormationController{

    private int|null $id_formation = null;
    private string $nom_formation;
    private int $duree_formation;
    private string $nom_enseignant;
    private int $nb_etudiants_max;
    private string $fichier_horaire_pdf;
    private int $active;

    //permet de récupérer id de la formation
    public function getIdFormation():int{
        return $this->id_formation;
    }

    //permet de récupérer le nom de la formation
    public function getNomFormation():string{
        return $this->nom_formation;
    }

    //permet de récupérer la durée de la formation
    public function getDureeFormation():int{
        return $this->duree_formation;
    }

    //permet de récupérer le nom de l'enseignant de la formation
    public function getNomEnseignant():string{
        return $this->nom_enseignant;
    }

    //permet de récupérer le Nombre d'étudiant de la formation
    public function getNbEtudiantsMax():int{
        return $this->nb_etudiants_max;
    }

    //permet de récupérer le nom du fichier horaire de la formation
    public function getFichierHorairePdf():string{
        return $this->fichier_horaire_pdf;
    }

    //permet de récupérer le chemin du fichier horaire de la formation
    public function getFichierHorairePdfSrc():string{
        return 'upload/' . $this->fichier_horaire_pdf;
    }

    //permet de récupérer le statut de la formation
    public function getActive():int{
        return $this->active;
    }

    //permet de récupérer le statut de la formation sous forme d'active ou Inactif
    public function getStatut():string{
       if($this->active == 1){
        return 'Actif';
       }
       return 'Inactif';
    }

    //permet de modifier id de la formation
    private function setIdFormation(int $id_formation): void {
        $this->id_formation = $id_formation;
    }

    //permet de modifier le nom de la formation
	public function setNomFormation(string $nom_formation): void {
        $this->$nom_formation = $nom_formation;
    }

    /**
     * La méthode create() retourne true si la formation a bien été enregistré et false en cas d’erreur 
     */
    public function create(string $nom_formation, string $nom_enseignant, int $duree_formation, int $nb_etudiants_max, int $active, array $fichier) : bool {
        $bool = false;
        $uniqueNameFormation = $this->uniqueNameFormation($nom_formation);
        $data = Tool::validDataType(['nom_formation'=> $nom_formation, 'nom_enseignant' => $nom_enseignant, 'duree_formation'=> $duree_formation, 'nb_etudiants_max'=> $nb_etudiants_max, 'active'=> $active]);
        $pdfInsert = $this->getHorairePDF($fichier);
        if($pdfInsert == false || $data == false || $uniqueNameFormation == false){
            header('Location: ../../index.php?slug=views/ajoutFormation.php');
            die;
        };
        $this->nom_formation = $data['nom_formation'];
        $this->nom_enseignant = $data['nom_enseignant'];
        $this->duree_formation = $data['duree_formation'];
        $this->nb_etudiants_max = $data['nb_etudiants_max'];
        $this->active = $data['active'];
                
        $value = Formation::create($this);

        if (is_int($value)) {
            $this->id_formation = $value;
            $bool = true;
        }
        return $bool;
        
    }
    /**
     * La méthode update() retourne true si la formation a bien été modifié et false en cas d’erreur 
     */
    public function update(string $nom_formation, string $nom_enseignant, int $duree_formation, int $nb_etudiants_max, int $active, array $fichier) : bool {
        $pdfInsert = true;
           
        $uniqueNameFormation = $this->uniqueNameFormation($nom_formation);
        $data = Tool::validDataType(['nom_formation'=> $nom_formation, 'nom_enseignant' => $nom_enseignant, 'duree_formation'=> $duree_formation, 'nb_etudiants_max'=> $nb_etudiants_max, 'active'=> $active]);
        if(!empty($fichier['name'])){
            $pdfInsert = $this->getHorairePDF($fichier);
        }
        if($pdfInsert == false || $data == false || $uniqueNameFormation == false){
            header('Location: ../../index.php?slug=views/updateFormation.php');
            die;
        }
        

        $this->nom_formation = $data['nom_formation'];
        $this->nom_enseignant = $data['nom_enseignant'];
        $this->duree_formation = $data['duree_formation'];
        $this->nb_etudiants_max = $data['nb_etudiants_max'];
        $this->active = $data['active'];

        return Formation::update($this);
        
    }  
    /**
     * @param array fichier : est un tableau contenant les paramètres du fichier
     * @return bool :prend la valeur true si le fichier a bien été enregistré ou modifié et false en cas d'erreur
     */
    public function getHorairePDF(array $fichier):bool{
        $maxFileSize = 10*1024*1024;
        if($fichier['error'] === UPLOAD_ERR_OK && $fichier['type'] == 'application/pdf' && $fichier['size'] < $maxFileSize){
            
            $dossierDestination = __DIR__ . '/../../upload/';
            if(!isset($this->fichier_horaire_pdf)){
                $this->fichier_horaire_pdf = $this->createUniquePdfName();
            }
            $nomUnique = $this->fichier_horaire_pdf;
            
            $cheminDestination = $dossierDestination . $nomUnique;
            if(move_uploaded_file($fichier['tmp_name'], $cheminDestination)){
                return true;
            }            
        }
        AlertController::alert("L’Horaire doit être de type PDF et 10Mo max!", 'danger');
        return false;
    }
    /**
     * @return string : un nom unique de fichier pdf
     * Exemple: horaire1.pdf, horaire2.pdf ...
     */
    public static function createUniquePdfName() : string{
        $lastFormation = Formation::lastFormation();
        if($lastFormation == false){
            return 'horaire1.pdf';
        }
        $num = $lastFormation->getIdFormation() + 1;
        return 'horaire' . $num . '.pdf';
    }
    /**
     * @param string $nom_formation : nom de la formation 
     * @return bool : true si le nom de la formation passé en paramètre n'existe pas encore dans la base de données et False si le nom existe déjà
     */
    public function uniqueNameFormation(string $nom_formation):bool{
        $nom_formation = Tool::cleanData($nom_formation);
        $verify = true;
        $formation = Formation::getFormationByName($nom_formation);
        if(is_a($formation, FormationController::class)){
            if(isset($this->id_formation)){
                $verify = ($formation->getIdFormation() == $this->id_formation);
            }else{
                $verify = false;
            }
        }

        if($verify == false){
            $alert = 'Une formation existe déjà avec le nom: ' . $nom_formation;
            AlertController::alert($alert, 'danger');
        }
        return $verify;
    }
    /**
     * @param string $trie : nom du champ de la table formations  par lequel on aimerait trier les résultats
     * @param int|null $statut : ne peut prendre que la valeur 0, 1 ou null.
     *  à 0 il permet de récupérer uniquement les formations supprimés; 
     * à 1 il permet de récupérer uniquement les formations actives; 
     * à null il permet de récupérer toutes les formations. il est a null par défaut 
     */
    public static function AllFormation(string $trie = 'nom_formation', int|null $statut = null): array{
        $trie = Tool::cleanData($trie);
        if(isset($statut)){
            $statut = Tool::cleanData($statut);
        }
        

        return Formation::AllFormation($trie, $statut);
    }

    //permet de récupérer une formation à partir de son id
    public static function getFormationById(int $id_formation) : false|FormationController {
        $id_formation = Tool::cleanData($id_formation);

        return Formation::getFormationById($id_formation);
    }

    //permet de chercher une formation
    public static function search(string $search, string $trie = 'nom_formation', int|null $statut = null): Array{
        $search = Tool::cleanData($search);

        return Formation::search($search, $trie, $statut);
    }
	
    

}