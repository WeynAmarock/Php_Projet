<<?php

class Modele {
    private $libelle;
    private $nom_table;
    private $nom_fichier;
    private $date_creation;
    private $type_File;

   
    public function constructModele($nom,$type,$id_Libele){
        $this->nom_table = $nom;
        $this->libele=$id_Libele.'_'.$nom;
        $this->nom_fichier=$nom.$type;
        $this->type_file = $type;
        $this->date_creation = date('d-m-y h:i:s');
    }
    

    public function getNom(){
        return $this->nom_table;
    }
    public function getType(){
        return $this->type_File;
    }
    public function getNomFile(){
        return $this->nom_fichier;
    }
    public function getDate(){
        return $this->date_creation;
    }
    public function getLibele(){
        return $this->libelle;
    }

    public function setNom($nom){
        $this->nom_table = $nom;
    }
    public function setType($type){
        $this->type_File = $type;
    }

    public function setDate($date){
        $this->date_creation = $date;
    }
    public function setlibele($lib){
        $this->libelle=$lib;
    }

    public function setNomFile($nom_F){
        $this->nom_fichier=$nom_F;
    }
    

}
