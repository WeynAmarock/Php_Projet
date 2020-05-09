<?php

include "init-mysql.php";
include "generateChamps.php";

session_start();

$nbLigne = $_SESSION['nbLigne'];
$nbTotalChamps = $_SESSION['nbTotalChamps'];
$nbTypesChamps= $_SESSION['nbTypeChamps'];
$nom_modele=$_SESSION['nom_Modele'];
$type_modele=$_SESSION['type_Modele'];

//ar_dump($modele);

//On inclue toute les classes utilisé dans ce fichier
spl_autoload_register(function($class){
    include($class.'.php');
    }
);

//echo $_POST['int_name1'];

$tabChamp = array();


$i=1;
foreach($nbTypesChamps as $key => $value){
    if($value){
        for($j=0;$j<$value;$j++){
            $tabChamp[$i-1]= new Champ ($i,$_POST[$key.'_name'.$i]
                ,$key);
            if($key == 'char' || $key=='varchar'){
                $tabChamp[$i-1]->constructChar($_POST[$key.'_size'.$id]
                    ,$_POST[$key.'_file'.$id]
                    ,$_POST[$key.'_list'.$id]);
            }else if($key == 'boolean'){

            }else{
                $tabChamp[$i-1]->constructNb($_POST[$key.'_size'.$id]
                ,$_POST[$key.'_min'.$id]
                ,$_POST[$key.'_max'.$id]
                ,$_POST[$key.'_list'.$id]);
            }
            $i++;
        }        
    }
    
}


/*
Ce que 'on veut :

CREATE TABLE 'modele->getNom()' (
    // Le nombre de fois que l on a de champs
    'champ[i]->getNom()' champ->getType() (champ->getLongeur),
    [...]
)ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `theme` (`champ[i]`, `champ[i+1]`) VALUES
    (champ[i]->value(), champ[i+1]->value()),
    //Ceci NbLigne fois
);
*/

$file= fopen($nom_modele.$type_modele,'w');

//Creation du fichier sql
if($type_modele=='.sql'){
    fputs($file,'CREATE  TABLE \''.$nom_modele.'\' ('."\n");
    for($i=0;$i<$nbTotalChamps;$i++){
        fputs($file,"\t".'\''.$tabChamp[$i]->getNom().'\' '.$tabChamp[$i]->getType());
        if($tabChamp[$i]->getLongeur()){
            fputs($file,'('.$tabChamp[$i]->getLongeur().')');
        }
        fputs($file,' NOT NULL ,'."\n");
    }
    fputs($file,') ENGINE=InnoDB DEFAULT CHARSET=utf8;');
}


fclose($file);

?>


<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        
        <style>
            #test_header{
                display: inline-block;
                width: 101%;
                margin-top: -10px;
                margin-left: -10px;
                padding: 0;
            }            
        </style>
    </head>
    <body>
        <img src="/tpphp/Projet_ThomasGouyet/image/header.png" id="test_header">
    </body>
</html>
