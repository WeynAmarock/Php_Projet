<?php

include "init-mysql.php";
include "generateChamps.php";

session_start();




//On inclue toute les classes utilisé dans ce fichier
spl_autoload_register(function($class){
    include($class.'.php');
    }
);

//On récupére tout les valeurs du 1er formulaire
$modele = new Modele();
$modele->createModele($_POST["nameFile"],$_POST["select"]);

//echo $modele->getNom();

$_SESSION['nom_Modele']=$modele->getNom();
$_SESSION['type_Modele']=$modele->getType();

$nbLigne = intval($_POST['nbLigne']);
$_SESSION['nbLigne'] = $nbLigne;

//Creation du fichier de donnée
if($modele->getType()=='.sql'){
    //file_put_contents('sql/'.$modele->getNom_M().$modele->getType()
    //    ,'CREATE TABLE ' .'\''. $modele->getNom_M() . '\' (' );
}

//On crée un tableau avec les nombres de champs en fonction du type voulu
$nbTypeChamps = array(
    'int' => $_POST['int'],
    'double_float' => $_POST['double_float'],
    'char' => $_POST['char'],
    'varchar' => $_POST['varchar'],
    'tinyint' => $_POST['tinyint'],
    'date' => $_POST['date'],
    'time' => $_POST['time'],
    'datetime-local' => $_POST['DateTime'],
    'boolean' => $_POST['boolean'],
);
$_SESSION['nbTypeChamps']= $nbTypeChamps;
// Récupération du nombre total de champs
$nbTotalChamps = 0;
foreach ($nbTypeChamps as  $value){
    $nbTotalChamps = $nbTotalChamps + $value;
}
$_SESSION['nbTotalChamps']= $nbTotalChamps;

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
        $nbC=1;
        foreach( $nbTypeChamps as $key => $value){
            if($value){
                for($i=0;$i<$value;$i++){
                generateChamps($key,$nbC);
                $nbC++;
                }    
            }
        }    
        ?>

        <input type="submit" id="content" value="Valider" >
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
























<?php
/*$sauvegarde = $_POST['radio1'];

if($sauvegarde == 'oui'){
    //ouverture de la connection
    try{
        $pdo = new PDO($mysqlDsn,$mysqlDbUser,$mysqlDbPwd, array(PDO::ATTR_PERSISTENT=>true));
    }catch(PDOException $e) {
        echo "Failed to get DB handle: " . $e->getMessage() . "\n";
        exit;
    }
    
    $insertQuery = 'INSERT INTO voyage ( label, date, montant, id_theme ) 
        VALUES ( :label, :date, :montant, :theme )';
        
    $query = $pdo->prepare($insertQuery);
}
*/
?>

