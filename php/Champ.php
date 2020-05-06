<?php

class Champ{
    private  $ID ;
    private $nomChamp;
    private $longueurMax;
    private $ValMin;
    private $ValMax;
    private $DateMin;
    private $DateMax;
    private $file;
    private $typeChamp;

    public function __construct(){
        
    }

    public function getID(){
        return $this->ID;
    }
    public function getNom(){
        return $this->nomChamp;
    }
    public function getlongeur(){
        return $this->longueurMax;
    }
    public function getValMin(){
        return $this->ValMin;
    }
    public function getValMax(){
        return $this->ValMax;
    }
    public function getDateMin(){
        return $this->DateMin;
    }
    public function getDateMax(){
        return $this->DateMax;
    }
    public function getfile(){
        return $this->longueurMax;
    }
    public function getTypeChamp(){
        return $this->typeChamp;
    }

    public function setID($id){
        $this->ID = $id;
    }
    public function setNom($nom_Champ){
        $this->nomChamp = $nom_Champ;
    }
    public function setLongueur($longueur){
        $this->longueurMax = $longueur;
    }
    public function setValMin($valMin){
        $this->ValMin= $valMin;
    }
    public function setValMax($valMax){
        $this->ValMax= $valMax;
    }
    public function setDateMin($dateMin){
        $this->DateMin= $dateMin;
    }
    public function setDateMax($dateMax){
        $this->DateMax= $dateMax;
    }
    public function setFile($file){
        $this->file = $file;
    }


    public function createChamp($id,$nom_Champ,$longueur,$valMin,$valMax
                ,$dateMin,$dateMax,$file){
        $this->ID = $id;
        $this->nomChamp = $nom_Champ;
        $this->longueurMax = $longueur;
        $this->ValMin= $valMin;
        $this->ValMax= $valMax;
        $this->DateMin= $dateMin;
        $this->DateMax= $dateMax;
        $this->file = $file;
    }
}
