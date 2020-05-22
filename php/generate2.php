<?php

include "fonctions.php";

session_start();

$erreurType = $_SESSION['erreurType'];  //Variable contenant le type de l'erreur retourné par generate3.php
$erreurId=$_SESSION['erreurId'];        //Variable contenant l'id de l'erreur retourné par generate3.php


if(count($_POST)>0 ){
    //On vérifie si le user a cliqué sur Suivant dans generate.php
    if($_POST['suivant']=="Valider"){
        $suivant=1;
    }else{
        $suivant=0;
    }
    //On vérifie si le user a cliqué sur Retour dans generate3.php
    if($_POST['suivant']=="Retour"){
        $retour1=1;
    }else{
        $retour1=0;
    }
}else{
    $suivant=0;
    $retour1=0;
}


//Ou alors, on a trouver une erreur dans les valeurs fournie par le user
if($retour1==1 || $erreurType != NULL){
    $retour2=1; //Cette variable sert à vérifier que l on vient de generate3.php
    $tabChamp=$_SESSION['tabChamp'];
    $nbTypeChamps=$_SESSION['nbTypeChamps'];
}else{
    $retour2=0;
}




//On vérifie si le user a cliqué sur valider dans generate.php
if($suivant){
    //On compte le nombre de Libele deja exisant 
    try{
        $projet_tg_tp = new PDO($mysqlDsn, $mysqlDbUser, $mysqlDbPwd, array('PDO::ATTR_PERSITENT=>true)'));
    }catch(PDOException $e){
        echo "Echec de la connexion : ". $e->getMessage() . "\n";
        exit;
    }
    //préparation de la requête et execution :
    $queryL = $projet_tg_tp->prepare("SELECT COUNT(libelle) FROM modele");
    $queryL->execute();
    //récuperation des résultats
    $idLibelle = $queryL->fetch();

    //On récupére tout les valeurs du 1er formulaire
    $libelle=$idLibelle[0].'_'.$_POST["nameFile"];
    $modele=new Modele();
    $modele->constructModele($_POST["nameFile"],$_POST["select"],$libelle);
    $sauvegarde = $_POST['radio1'];
    $nbLigne = $_POST['nbLigne'];
    //On crée un tableau avec les nombres de champs en fonction du type voulu
    $nbTypeChamps = array(
        'Integer' => $_POST['Integer'],
        'Double' => $_POST['Double'],
        'Char' => $_POST['Char'],
        'Varchar' => $_POST['Varchar'],
        'Tinyint' => $_POST['Tinyint'],
        'Date' => $_POST['Date'],
        'Time' => $_POST['Time'],
        'datetime-local' => $_POST['DateTimes'],
        'Boolean' => $_POST['Boolean'],
    );
    // Récupération du nombre total de champs
    $nbTotalChamps = 0;
    foreach ($nbTypeChamps as  $value){
        $nbTotalChamps = $nbTotalChamps + $value;
    }

    //On envoie les données collectées à la session.
    $_SESSION['modele']=$modele;
    $_SESSION['libelle']=$libelle;
    $_SESSION['nbLigne'] = $nbLigne;
    $_SESSION['nbTotalChamps']=$nbTotalChamps;
    $_SESSION['nbTypeChamps']= $nbTypeChamps;
    $_SESSION['sauvegarde']=$sauvegarde;

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
        
        <div id="header">
            <nav>
                <ul>
                    <li class="deroulant"><a href="/main.php"><img id="img-bar" src="/tpphp/Projet_ThomasGouyet/image/bar-menu2.png"></a>
                        <ul class="sous">
                            <li><a href="replay.php">Rejouer un modèle</a></li>
                            <li><a href="back.php">Back</a></li>
                        </ul>
                    </li>
                        
                </ul>
            </nav>
            <div id="titre">
                <h2>Générer des données</h2>
            </div>
            <hr id="h_head">
            <img id="img" src="/tpphp/Projet_ThomasGouyet/image/elePHPant.png">
            
        </div>
        
        
        <div id="content">
        <form action="generate3.php" method="post">

        <?php
        $nbC=0; //Cette variable est le nombre de champ deja créé. Durant la création des données, elle sera l'id du champ
        foreach( $nbTypeChamps as $key => $value){
            if($value){
                for($i=0;$i<$value;$i++){
                    if($retour2){
                        generateChamps($key,$nbC,$erreurType,$erreurId,$tabChamp[$i]);
                    }else{
                        generateChamps($key,$nbC,NULL,NULL,NULL);
                    }
                $nbC++;
                }    
            }
        }      
        ?>
        <input type="submit" value="Suivant"  name="suivant" >
        </form>

        <!---Ce formulaire sert à retourner dans generate.php dans le cas où le user clique sur retour-->
        <form action="generate.php" method="post">
            <input type="submit" value="Retour"  name="suivant" >
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
