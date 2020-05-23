<?php

class Champ{
    private  $id ;
    private $nom_champ;
    private $longueur;
    private $val_min_nb; 
    private $val_max_nb; 
    private $val_min_date; 
    private $val_max_date; 
    private $liste_txt; //Le file contient un nombre de valeur afin de remplir le champs
    private $type_champ;
    private $libelle;

    public function constructChamp($id,$nom,$type,$lib){
        $this->id = $id;
        $this->nom_champ=$nom;
        $this->type_champ=$type;
        $this->libelle=$lib;

        $this->longueur = NULL;
        $this->val_min_nb = NULL;
        $this->val_max_nb = NULL;
        $this->val_min_date = NULL;
        $this->val_max_date = NULL;
        $this->liste_txt=NULL;
    }

    public function getId(){
        return $this->id;
    }

    public function getNom(){
        return $this->nom_champ;
    }
    public function getLongueur(){
        return $this->longueur;
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
    public function getliste(){
            return $this->liste_txt;
    }
    public function getType(){
        return $this->type_champ;
    }
    public function getLibelle(){
        return $this->libelle;
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
        $this->longueur = $longueur;
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
    public function setListe($liste){
        $this->file_txt = $liste;
    }

//Les fonctions suivantes servent à construire les champs en fonction de leur type

    //La fonction constructChar sert aussi pour la conqtruction de nouveau type si le user en rajoute
    public function constructChar($longueur=NULL,$liste=NULL){
        $this->longueur = $longueur;
        $this->liste_txt = $liste;
    }

    public function constructNb($valMin,$valMax){
        $this->val_min_nb= $valMin;
        $this->val_max_nb=$valMax;
    }
    public function constructDate($valMin,$valMax){
        $this->val_min_date= $valMin;
        $this->val_max_date=$valMax;
    }

    public function constructTime($valMin,$valMax){
        $this->val_min_date='0000-00-00 '. $valMin;
        $this->val_max_date='0000-00-00 '.$valMax;
        
    }


//Les fonctions suivantes servent à retourner des valeurs en fonction du type de champs

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
        }else{

            if($heure1>$heure2 ){
                $varH=rand($heure2,$heure1);    
            }else{
                $varH=rand($heure2,$heure1+24);
                if($varH>=24){
                    $varH=$varH-24;
                }
            }

            if($varH==$heure2){
                $varM=rand($minute2,59);
            }else if($varH==$heure1){
                $varM=rand(0,$minute1);
            }else{
                $varM=rand(0,59);
            }   
        }

        return $varH.':'.$varM;
    }
    

//On place les valeurs en paramètre afin de pouvoir appeler getValueDate() et getValueD() dans getValueDateTime()

    public function getValueDate($valMin,$valMax){
        
        $annee1=substr($valMax,0,4);
        $mois1=substr($valMax,5,2);
        $jour1=substr($valMax,8,2);
        $annee2=substr($valMin,0,4);
        $mois2=substr($valMin,5,2);
        $jour2=substr($valMin,8,2);

        //On donne à la variable anneeMax la plus grande valeur entre les 2 années et à anneeMin la plus petite
        if($annee1>$annee2){
            $anneeMax=$annee1;
            $anneeMin=$annee2;
        }else{
            $anneeMax=$annee2;
            $anneeMin=$annee1;
        }
        $varA=rand($anneeMin,$anneeMax);

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

    public function getValueChar(){
        $fp = fopen('liste/'.$this->liste_txt, 'r');
        $content = fgets($fp);
        $elem = array();
        $elem = explode(" ", $content);
        $nbElem = count($elem);
        $nbaleat = rand(0, $nbElem-1);
        fclose($fp);
        return $elem[$nbaleat];
    }

}


