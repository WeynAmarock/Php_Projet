<?php

class Modele {
    private $nom_Modele;
    private $libele;
    private $dateCreation;
    private $typeFile;

    /*public function __construct($nom_M,$type_M,$nb_ligne,$tab_champs){
        $this->nom_Modele=$nom_M;
        $this->type_File=$type_M;
        $this->nbLigne=$nb_Ligne;
        $this->tab_champs=$tab_champs;
        $this->date_Creation = date('d-m-y h:i:s');

    }*/

    public function __construct(){
        
    }
    

    public function getNom(){
        return $this->nom_Modele;
    }
    public function getType(){
        return $this->type_File;
    }
    public function getCdate(){
        return $this->dateCreation;
    }
    public function getLibele(){
        return $this->libele;
    }

    public function setNom($nom){
        $this->nom_Modele = $nom;
    }
    public function setType($type){
        $this->type_File = $type;
    }

    public function setDate($date){
        $this->dateCreation = $date;
    }
    public function setlibele($lib){
        $this->libele=$lib;
    }

    public function CreateModele($nom,$type){
        $this->nom_Modele = $nom;
        $this->type_File = $type;
        $this->dateCreation = date('d-m-y h:i:s');
    }

    public function showModele(){
        echo "Nom modèle : ".$this->nom_Modele;
        echo "</br>";
        echo "Date : ";
        echo $this->dateCreation;
        echo "</br>";
        echo "type : " . $this->type_File;
    }
    

}
