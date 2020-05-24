<?php

include "fonctions.php";
session_start();

$_SESSION['erreurType']=NULL; //On initialise erreur dans la session qui est une variable qui sert à retourner les erreurs dans le form de generate2
$_SESSION['erreurId']=NULL; //Cette variable sert à connaitre dans quel champ est l erreur dans generate2.php

//On prend toute les valeurs de la table type_champ pour vérifier quelle sont les types à afficher
//Connexion à la base de donnée
try{
    $db = new PDO($mysqlDsn, $mysqlDbUser, $mysqlDbPwd, array('PDO::ATTR_PERSITENT=>true)'));
}catch(PDOException $e){
    echo "Echec de la connexion : ". $e->getMessage() . "\n";
    exit;
}
//préparation de la requête et execution :
$query = $db->prepare("SELECT * FROM type_champ");
$query->execute();
//récuperation des résultats
$repType = $query->fetchAll();


//On vérifie que la page n'est pas le retour de generate2.php
if(count($_POST)>0){
    if($_POST['suivant']=='Retour'){
        $retour=1; //Cette variable sert àvérifier si on viens de genrerate2.php
        $modele=$_SESSION['modele'];
        $nbLigne=$_SESSION['nbLigne'];
        $nbTypeChamps=$_SESSION['nbTypeChamps'];
    }
}else{
    $retour=0;
}


?>

<!DOCTYPE html>
<html>
    <head>
        <title>generate</title>
        <meta charset="utf-8">
        <link type="text/css" rel="stylesheet" href="/tpphp/Projet_ThomasGouyet/css/main.css">
        <link href="https://fonts.googleapis.com/css2?family=Righteous&display=swap" rel="stylesheet"> 
        <link type="text/css" rel="stylesheet" href="/tpphp/Projet_ThomasGouyet/css/test.css">
    </head>

    <body>
   
        <?php include "header.php"; ?>
        
        <div id="content">

        <!-- Les if($retour) servent à retourner les valeurs de generate2.php quand le user clique sur retour--->

        <form action="generate2.php" method="post">
                <div>
                     <label for="name">Nom du fichier :</label>
                     <input required type="text" id="name" name="nameFile" 
                      <?php if($retour){echo 'value="'.$modele->getNom().'"';}?>
                      >
                     <select name="select" >
                        <option <?php if($retour){
                                if($modele->getType()=='.sql'){echo 'selected';}
                                }?>
                        >.sql</option>
                        <opztion <?php if($retour){
                                if($modele->getType()=='.csv'){echo 'selected';}
                                }?>>.csv</option>
                    </select>
                </div>
                </br>
                <label for="nbLigne">Nombre de ligne :</label>
                <input required type="int" id="nbLigne" name="nbLigne" 
                <?php if($retour){echo 'value="'.$nbLigne.'"';}?>>
                <br></br>
                <div id=donnees>
                    <label for="elements">Nombre de champs en fonction du type :</label>
                    
                       <?php
                       $id=0; //Cette variable est l'identifiant des noms des types de champ afin de les récupérer plus tard 
                       $tabType=array();
                            foreach($repType as $tab){
                                if($tab['actif']){
                                    $tabType[$id]=$tab['type_champ'];
                                    echo '<div>
                                            <label for="'.$tab['type_champ'].'">'.$tab['type_champ'].' :</label> 
                                            <input required type="text" id="'.$tab['type_champ'].'" name="'.$tab['type_champ'].'" ';
                                            if($retour){ 
                                                echo 'value = "'.$nbTypeChamps[$tab['type_champ']].'"';
                                            }else{echo 'value="0">';}
                                        echo '</div>';
                                        $id++;
                                }
                            }
                            $_SESSION['tabType']=$tabType;
                       ?>
                </div>
                <div id="model">
                    <label for="question">Souhaitez vous garder votre modèle ?</label>
                    <label for="oui">Oui</label>
                    <input type="radio" name="radio1" value="oui" required>
                    <label for="non">Non</label>
                    <input type="radio" name="radio1" value="non">
                </div>

                <input type="submit" value="Valider" name="suivant" >
            </form>
        </div>

        <div id="footer">
            <hr id="h_foot">
            <p id="p_footer">@2020-Gouyet/Poupon<br>
                CIR2 ISEN Brest 
            </p>
            <img id="logo_isen" src="/tpphp/Projet_ThomasGouyet/image/ISEN.jpg">
            
        </div>
    </body>
</html>
