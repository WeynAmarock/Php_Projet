<?php


//Ce fichier php contient toute les fonctions siuées ailleurs que dans les classes Champ et Modele
//On utilise aussi ce fichier comme header pour inclure tout les autre fichier nécésaire à l'application

include "class/Champ.php";
include "BDD/fonctionBdd.php";
include "BDD/init-mysql.php"; 
include "class/Modele.php";


//La fonction generateChamp est utilisé pour afficher des divs en fonction du type et de l id donnée 
function generateChamps($type, $id,$erreurType,$erreurId,$champ=NULL){

    $textLegend=
    '<legend>Paramétrage du champ n\''.$id.' de type '.$type.':</legend>';

    $textNom=
    '<div name="nom" class="elem_form">
        <label for="'.$type.'_name'.$id.'">Nom du champ </label>
        <input required type="text" name="'.$type.'_name'.$id.'" class="champ"';
    if($champ){
        $textNom=$textNom.'value="'.$champ->getNom().'"';
    }    
    $textNom=$textNom.'></div>';

    $textSize=
    '<div id="size" class="elem_form">
        <label for="'.$type.'_size'.$id.'">Taille du champ </label>
        <input required type="int" name="'.$type.'_size'.$id.'" class="champ"';
    if($champ){
        $textSize=$textSize.'value="'.$champ->getLongueur().'"';
    }    
    $textSize=$textSize.'></div>';


    $textValExtremeNb=
    '<div id="values" class="elem_form">
        <label>Valeurs extrêmes</label>
        <input required type='.$type.' name="'.$type.'_min'.$id.'" class="champ_b"';
        if($champ){
            $textValExtremeNb= $textValExtremeNb.'value="'.$champ->getValMinNb().'"';
        }    
        $textValExtremeNb
            =$textValExtremeNb.' > <input required type='.$type.' name="'.$type.'_max'.$id.'" class="champ_b"';
    if($champ){
        $textValExtremeNb= $textValExtremeNb.'value="'.$champ->getValMaxNb().'"';
    }    
    $textValExtremeNb=$textValExtremeNb.'></div>';


    $textValExtremeDate=
    '<div id="values" class="elem_form">
        <label>Valeurs extrêmes</label>
        <input required type='.$type.' name="'.$type.'_min'.$id.'" class="champ_b"';
        if($champ){
            $textValExtremeDate= $textValExtremeDate.'value="'.$champ->getValMinDate().'"';
        }    
        $textValExtremeDate
            =$textValExtremeDate.'> <input required type='.$type.' name="'.$type.'_max'.$id.'" class="champ_b"';
    if($champ){
        $textValExtremeDate= $textValExtremeDate.'value="'.$champ->getValMaxDate().'"';
    }    
    $textValExtremeDate=$textValExtremeDate.' > </div>';

    $textValExtremeDateTime=
    '<div id="values" class="elem_form">
        <label>Valeurs extrêmes</label>
        <input required type= "datetime-local" name="'.$type.'_min'.$id.'" class="champ_b"';
        if($champ){
            $textValExtremeDateTime= $textValExtremeDateTime.'value="'.$champ->getValMinDate().'"';
        }    
        $textValExtremeDateTime
            =$textValExtremeDateTime.'> <input required type= "datetime-local" name="'.$type.'_max'.$id.'" class="champ_b"';
    if($champ){
        $textValExtremeDateTime= $textValExtremeDateTime.'value="'.$champ->getValMaxDate().'"';
    }    
    $textValExtremeDateTime=$textValExtremeDateTime.' > </div>';


    $textList=
    '<div id="liste_valeurs">
        <label for="'.$type.'_liste'.$id.'">Liste de valeurs</label>
        <input required type="file" name="'.$type.'_liste'.$id.'" class="champ"';
    if($champ){
        $textList=$textList.'value="'.$champ->getliste().'"';
    }    
    $textList=$textList.'></div>';


    switch($type){
        case "Integer":
        case "Double":
            echo $textLegend.$textNom.$textValExtremeNb.'</br>';
        break;
        case "Tinyint":
            if(!strcmp($erreurType,'Tinyint')){
                echo '<span>Une valeurs saisie est supérieur à 255 dans le champ '.$id.' !</span></br></br>';
            }
            echo $textLegend.$textNom.$textValExtremeNb.'</br>';
            
        break;
        case "DateTimes":
            echo $textLegend.$textNom.$textValExtremeDateTime.'</br>';
        break;
        case "Time":
        case "Date":
            echo $textLegend.$textNom.$textValExtremeDate.'</br>';
        break;
        case "Char":
        case "Varchar":
            echo $textLegend.$textNom.$textSize.$textList.'</br>';
        break;
        
        case "Boolean":
            echo $textLegend.$textNom.'</br>';
        break;
        default:
            echo $textLegend.$textNom.$textList.'</br>';
        break;

    }
}

function createSQL($file,$tabValue,$tabChamp,$nom_modele,$type_modele,$nbTotalChamps,$nbLigne){
    //Creation du fichier sql
    fputs($file,'INSERT INTO '.$nom_modele.' (');
    for($i=0;$i<$nbTotalChamps;$i++){
        fputs($file,$tabChamp[$i]->getNom());
        if($i<$nbTotalChamps-1){
            fputs($file,' ,');
        }else{
            fputs($file,') VALUES'."\n");
        }
    }
    for($i=0;$i<$nbLigne;$i++){
        fputs($file,'( ');
        for($id=0;$id<$nbTotalChamps;$id++){ 
            fputs($file,'"'.$tabValue[$i][$id].'" ');
            if($id<$nbTotalChamps-1){
                fputs($file,', ');
            }      
        }
        fputs($file,')');
        if($i<$nbLigne-1){
            fputs($file,','."\n");
        }
    }
    fputs($file,';');   
}

function createCSV($file,$tabValue,$tabChamp,$nom_modele,$type_modele,$nbTotalChamps,$nbLigne){
    //Creation fichier CSV
    $tab=array();
    //Cette ligne constitue les libellés des colonnes de notre fichier
    for($id=0;$id<$nbTotalChamps;$id++){
        $tab[0][$id]=$tabChamp[$id]->getNom();
    }
    //Cette ligne permet juste d\'espacer les libellés des enregistrements
    for($id=0;$id<$nbTotalChamps;$id++){
        $tab[1][$id]=' ';
    }
    for($i=2;$i<$nbLigne+2;$i++){
        for($id=0;$id<$nbTotalChamps;$id++){
            $tab[$i][$id]=$tabValue[$i-2][$id];
        }
    }

    foreach($tab as $ligne){
        fputcsv($file, $ligne, ";");
    }
}


//La fonction createTable sert à créer un tableau qui affiche 10 valeurs des différentes valeurs créées
function createTable($tabValue,$tabChamp,$nbTotalChamps,$nbLigne){
    //On ne veut afficher que les 10ère valeurs donc on vérifie que nbLigne > 10 
    if($nbLigne>10){
        $var=10; //La variable var est un  compteur pour afficher les valeurs un certain nombre de fois
    }else{
        $var=$nbLigne;
    }
    echo '<table id="tableVal">
                <caption>Valeurs crées par l\'application</caption>
            <tr>';
        for($i=0;$i<$nbTotalChamps;$i++){
                echo '<th>'.$tabChamp[$i]->getNom().'</th>';
            }
        echo '</tr>';
        for($i=0;$i<$var;$i++){
            echo '<tr>';
            for($id=0;$id<$nbTotalChamps;$id++){
                echo '<td>'.$tabValue[$i][$id].'</td>';
            }
            echo '</tr>';
        }
        echo '</table>';
}


//Fonction renvoyant un tableau rempli de valeurs créées à partir des paramètres des champs
function createTabValue($tabChamp,$nbLigne,$nbTotalChamps){
    $tabValue=array();
    for($i=0;$i<$nbLigne;$i++){
        for($id=0;$id<$nbTotalChamps;$id++){
            switch($tabChamp[$id]->getType()){
                case 'Varchar':
                case 'Char':
                    $tabValue[$i][$id]=$tabChamp[$id]->getValueChar();
                break;
                case 'Integer':
                case 'Tinyint':
                    $tabValue[$i][$id]=$tabChamp[$id]->getValueNb();
                break;
                case 'Double':
                    $tabValue[$i][$id]=$tabChamp[$id]->getValueFloat();
                break;
                case 'Date':
                    $tabValue[$i][$id]= $tabChamp[$id]->getValueDate($tabChamp[$id]->getValMinDate(),$tabChamp[$id]->getValMaxDate());
                break;
                case 'Time':
                    $tabValue[$i][$id]=$tabChamp[$id]->getValueTime ($tabChamp[$id]->getValMinDate(),$tabChamp[$id]->getValMaxDate());
                break;
                case 'DateTimes':
                    $tabValue[$i][$id]=$tabChamp[$id]->getValueDateTime ($tabChamp[$id]->getValMinDate(),$tabChamp[$id]->getValMaxDate());
                break;
                case 'Boolean':
                    $tabValue[$i][$id]=$tabChamp[$id]->getValueBoolean();
                break;
                default:
                    $tabValue[$i][$id]=$tabChamp[$id]->getValueChar(); //Si le user crée un nouveau type, les valeurs à créer seront données par fichier texte
                break;
            }
        }
    }
    return $tabValue;
}

?>
