<?php

class Champ{
    private  $id ;
    private $nomChamp;
    private $longueurMax;
    private $val_min_nb; 
    private $val_max_nb; 
    private $val_min_date; 
    private $val_max_date; 
    private $liste_txt; //Le file contient un nombre de valeur afin de remplir le champs
    private $type;
    private $etat; //Optionel
    private $libele;

    public function __construct($id,$nom,$type,$lib=NULL){
        $this->id = $id;
        $this->nomChamp=$nom;
        $this->type=$type;
        $this->longueurMax = NULL;
        $this->val_min_nb = NULL;
        $this->val_max_nb = NULL;
        $this->val_min_date = NULL;
        $this->val_max_date = NULL;
        $this->liste_txt=NULL;
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
    public function getValMinNb(){
        return $this->val_min_nb;
    }
    public function getValMinDate(){
        return $this->val_min_date;
    }
    public function getValMaxNb(){
        return $this->val_max_nb;
    }
    public function getValMaxDate(){
        return $this->val_max_date;
    }
    public function getfile(){
        return $this->longueurMax;
    }
    public function getType(){
        return $this->type;
    }
    public function getLibele(){
        return $this->libele;
    }


    public function setlibele($lib){
        $this->libele=$lib;
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
    public function setValMinNb($valMin){
        $this->val_min_nb= $valMin;
    }
    public function setValMinDate($valMin){
        $this->val_min_date= $valMin;
    }
    public function setValMaxNb($valMax){
        $this->val_max_nb= $valMax;
    }
    public function setValMaxDate($valMax){
        $this->val_max_date= $valMax;
    }
    public function setFile($file){
        $this->file = $file;
    }


    public function constructChar($longueur=NULL,$liste=NULL){
        $this->longueurMax = $longueur;
       // $this->liste_txt = $file;
    }

    public function constructNb($valMin=NULL,$valMax=NULL,$liste=NULL){
        $this->val_min_nb= $valMin;
        $this->val_max_nb=$valMax;
        //Faire le système de la liste.
    }
    public function constructTime($valMin=NULL,$valMax=NULL,$liste=NULL){
        $this->val_min_date= $valMin;
        $this->val_max_date=$valMax;
        //Faire le système de la liste.
    }

    //Int et TinyInt
    public function getValueNb(){ //Donne une valeurs au hasard entre les 2 extremes donné par le user
        return rand($this->val_min_nb,$this->val_max_nb);
    }
    //Double Float
    public function getValuefloat(){
        return number_format($this->val_min_nb + lcg_value() 
            * abs($this->val_max_nb - $this->val_min_nb),3);
    }
    //Boolean
    public function getValueBoolean(){ 
        return rand(0,1);
    }
    //Time
    public function getValueTime($valMin,$valMax){

        $heure1=substr($valMax,0,strpos($valMax,':'));
        $minute1=substr($valMax,strpos($valMax,':')+1,strlen($valMax));
        $heure2=substr($valMin,0,strpos($valMin,':'));
        $minute2=substr($valMin,strpos($valMin,':')+1,strlen($valMin));

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
    
    public function getValueDate($valMin,$valMax){

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

    public function getValueDateTime($valMin,$valMax){
        $date1=substr($valMax,0,9);
        $heure1=substr($valMax,11,5);
        $date2=substr($valMin,0,9);
        $heure2=substr($valMin,11,5);
        return $this->getValueDate($date2,$date1).'T'.$this->getValueTime($heure2,$heure1);
    }
}




