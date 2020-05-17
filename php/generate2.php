<?php

include "init-mysql.php";
include "generateChamps.php";

session_start();
;

//On inclue toute les classes utilisé dans ce fichier
spl_autoload_register(function($class){
    include($class.'.php');
    }
);

//On vérifie si le user a cliqué sur valider dans generate.php
if($_POST['suivant']=="Valider"){
    //On compte le nombre de Libele deja exisant pour le id du libele du nouveau modéle 
    try{
        $projet_tg_tp = new PDO($mysqlDsn, $mysqlDbUser, $mysqlDbPwd, array('PDO::ATTR_PERSITENT=>true)'));
    }catch(PDOException $e){
        echo "Echec de la connexion : ". $e->getMessage() . "\n";
        exit;
    }
    //préparation de la requête et execution :
    $query = $projet_tg_tp->prepare("SELECT COUNT(libelle) FROM modele");
    $query->execute();
    //récuperation des résultats
    $res = $query->fetch();


    //On récupére tout les valeurs du 1er formulaire
    $nomModele=$_POST["nameFile"];
    $typeModele=$_POST["select"];
    $libele=$res[0].'_'.$_POST["nameFile"];
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
    $_SESSION['nom_Modele']=$nomModele;
    $_SESSION['type_Modele']=$typeModele;
    $_SESSION['libele']=$libele;
    $_SESSION['nbLigne'] = $nbLigne;
    $_SESSION['nbTotalChamps']=$nbTotalChamps;
    $_SESSION['nbTypeChamps']= $nbTypeChamps;
    $_SESSION['sauvegarde']=$sauvegarde;

}

//On vérifie si le user a cliqué sur Retour dans generate3.php
if($_POST['suivant']=='Retour'){
    $tabChamp=$_SESSION['tabChamp'];
    $nbTypeChamps=$_SESSION['nbTypeChamps'];

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
        $nbC=0;
        foreach( $nbTypeChamps as $key => $value){
            if($value){
                for($i=0;$i<$value;$i++){
                    echo 'ttrrt';
                    if($_POST['suivant']=='Retour'){
                        generateChamps($key,$nbC,$tabChamp[$i]);
                    }else{
                        generateChamps($key,$nbC,NULL);
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


<?php

//Sauvegarde du modèle si le user a cliqué sur sauvergarder 
if($_SESSION['sauvegarde'] == 'oui'){
    //ouverture de la connection
    try{
        $pdo = new PDO($mysqlDsn,$mysqlDbUser,$mysqlDbPwd, array(PDO::ATTR_PERSISTENT=>true));
    }catch(PDOException $e) {
        echo "Failed to get DB handle: " . $e->getMessage() . "\n";
        exit;
    }
    
    $insertQuery = 'INSERT INTO modele ( libele,nom_fichier, nom_table, date_creation ) 
        VALUES ( :libele, :nom_fichier, :nom_table, :date_creation)';
        
    $query = $pdo->prepare($insertQuery);
    if($query->execute(array( 	':libele' 	=> $libele, 
								':nom_fichier' 	=> $nomModele.$typeModele, 
								':nom_table' 	=> $nomModele,
								':date_creation' 	=> date('d-m-y h:i:s') )))
		{
			echo"insertion réussie";
		}else{
			echo"insertion échouée - erreur ".print_r($query->errorInfo());
		}
}

?>
