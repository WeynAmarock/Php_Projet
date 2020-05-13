<?php

class Champ{
    private  $id ;
    private $nomChamp;
    private $longueurMax;
    private $ValMin; // Val Min peut autant être une date que un chiffre ou un nombre
    private $ValMax; // Même chose que Val Min
    private $file; //Le file contient un nombre de valeur afin de remplir le champs
    private $type;
    private $liste;// Le user remplit une liste de valeur possible pour les champs

    public function __construct($id=NULL,$nom=NULL,$type=NULL){
        $this->id = $id;
        $this->nomChamp=$nom;
        $this->type=$type;
        $this->longueurMax = NULL;
        $this->ValMin = NULL;
        $this->ValMax = NULL;
        $this->file=NULL;
        $this->liste=NULL;
    }

    public function getID(){
        return $this->id;
    }
    public function getNom(){
        return $this->nomChamp;
    }
    public function getLongeur(){
        return $this->longueurMax;
    }
    public function getValMin(){
        return $this->ValMin;
    }
    public function getValMax(){
        return $this->ValMax;
    }
    public function getfile(){
        return $this->longueurMax;
    }
    public function getType(){
        return $this->type;
    }

    public function setID($id){
        $this->id = $id;
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
    public function setFile($file){
        $this->file = $file;
    }


    public function constructChar($longueur=NULL,$file=NULL,$liste=NULL){
        $this->longueurMax = $longueur;
        $this->file = $file;
        //$this->liste=$liste;
    }

    public function constructNb($longueur=NULL,$valMin=NULL,$valMax=NULL,$liste=NULL){
        $this->longueurMax = $longueur;
        $this->ValMin= $valMin;
        $this->ValMax=$valMax;
        //Faire le système de la liste.
    }

    public function constructTimeTinyint($valMin=NULL,$valMax=NULL,$liste=NULL){
        $this->ValMin= $valMin;
        $this->ValMax=$valMax;
        //Faire le système de la liste.
    }

    //Int et TinyInt
    public function getValueInt(){ //Donne une valeurs au hasard entre les 2 extremes donné par le user
        return rand($this->ValMin,$this->ValMax);
    }
    //Double Float
    public function getValuefloat(){
        return number_format($this->ValMin + lcg_value() 
            * abs($this->ValMax - $this->ValMin),3);
    }
    //Boolean
    public function getValueBoolean(){ 
        return rand(0,1);
    }
    //Time
    public function getValueTime(){

        $heure1=substr($valMax,0,strpos($time1,':'));
        $minute1=substr($valMax,strpos($time1,':')+1,strlen($time1));
        $heure2=substr($valMin,0,strpos($time2,':'));
        $minute2=substr($valMin,strpos($time2,':')+1,strlen($time2));

        if($heure1 == $heure2 && $minute1 == $minute2){
            return $heure1.':'.$minute1;
        }

        if($heure1==$heure2){
            $varH=$heure1;
            $varM=rand($minute2,$minute1);
        }

        if($heure1>$heure2 ){
            $varH=rand($heure2,$heure1);    
        }else{
            $varH=rand($heure2,$heure1+24);
            if($varH>=24){
                $varH=$varH-24;
            }
        }

        if($varH==$heure2){
            $varM=rand($minute2,60);
        }else if($varH==$heure1){
            $varM=rand(0,$minute1);
        }else{
            $varM=rand(0,60);
        }   

        if($varM<10){
            $varM='0'.$varM;
        }
        if($varH<10){
            $varH='0'.$varH;
        }
        return $varH.':'.$varM;
    }
    
    public function getValueDate(){

        $annee1=substr($valMax,0,4);
        $mois1=substr($valMax,5,2);
        $jour1=substr($valMax,8,2);
        $annee2=substr($valMin,0,4);
        $mois2=substr($valMin,5,2);
        $jour2=substr($valMin,8,2);

        $varA=rand($annee2,$annee1);

        if($mois1>$mois2){
            $varM=rand($mois2,$mois1);
        }else{
            $varM=rand($mois2,$mois1+12);
            if($varM>12){
                $varM=$varM-12;
            }   
        }

        if($jour1>$jour2){
            $varJ=rand($jour2,$jour1);
        }else{
            $varJ=rand($jour2,$jour1+12);
        if($varJ>12){
            $varj=$varJ-12;
        }
    }
    return $varA.'-'.$varM.'-'.$varJ;
    }

}    


    
