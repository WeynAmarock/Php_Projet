<?php

include "fonctions.php";


session_start();

//On récupére les données de generate2.php
$nbLigne = $_SESSION['nbLigne'];
$nbTotalChamps = $_SESSION['nbTotalChamps'];
$nbTypesChamps= $_SESSION['nbTypeChamps'];
$modele=$_SESSION['modele'];
$libelle=$_SESSION['libelle'];


//On vérifie que le user a cliqué sur suivant dans la page précédente
if($_POST['suivant']=='Suivant'){

    //On compte le nombre de id deja exisant 
    try{
        $projet_tg_tp = new PDO($mysqlDsn, $mysqlDbUser, $mysqlDbPwd, array('PDO::ATTR_PERSITENT=>true)'));
    }catch(PDOException $e){
        echo "Echec de la connexion : ". $e->getMessage() . "\n";
        exit;
    }
    //préparation de la requête et execution :
    $query = $projet_tg_tp->prepare("SELECT count(id) FROM champ");
    $query->execute();
    $idChamp = $query->fetch();


    $tabChamp = array();
    $idC=$idChamp[0]+1;    // la variable id sert comme identifiant dans la base de donnée afin de pouvoir avoir deux champ de même nom mais de modeles différents                
    $id=0;   // id est le numéro du champs; Il est incrémenté d un par champs créé mais n'est l'id du champ que durant la création des données

    //On crée un tableau qui contient tout les champs et qui les initialise
    foreach($nbTypesChamps as $key => $value){
        if($value){
            for($j=0;$j<$value;$j++){
                $tabChamp[$id]= new Champ ();
                echo $idC;
                $tabChamp[$id]->constructChamp($idC,$_POST[$key.'_name'.$id],$key,$libelle);
                switch($key){
                    case 'Boolean':
                    break;
                    case 'Varchar':
                    case 'Char':
                        $tabChamp[$id]->constructChar($_POST[$key.'_size'.$id]
                        ,$_POST[$key.'_liste'.$id]);
                    break;
                    case 'Integer':
                    case 'Double':
                        $tabChamp[$id]->constructNb($_POST[$key.'_min'.$id]
                        ,$_POST[$key.'_max'.$id]);
                    break;
                    case 'Tinyint':
                        //On vérifie que les nombre donnés par le user sont < 256
                        if($_POST[$key.'_min'.$id]<256 && $_POST[$key.'_max'.$id]<256){
                            $tabChamp[$id]->constructNb($_POST[$key.'_min'.$id]
                            ,$_POST[$key.'_max'.$id]);
                        }else{
                            $_SESSION['erreurType']='Tinyint';
                            $_SESSION['erreurId']=$id;
                            header('Location: generate2.php');
                            exit();
                        }
                    break;
                    case 'Date':
                    case 'datetime-local':
                        $tabChamp[$id]->constructDate($_POST[$key.'_min'.$id]
                        ,$_POST[$key.'_max'.$id]);
                    break;
                    case 'Time':
                        $tabChamp[$id]->constructTime($_POST[$key.'_min'.$id]
                        ,$_POST[$key.'_max'.$id]);
                    break;
                    default:    //Si le user crée un nouveau type, on crée un champ dont on définie la taille et dont on donne un fichier pour remplir les valeurs
                        $tabChamp[$id]->constructChar($_POST[$key.'_size'.$id]
                        ,$_POST[$key.'_liste'.$id]); 
                    break;
                }
                $id++;
                $idC++;
            }        
        }
    
    }
    $_SESSION['tabChamp']=$tabChamp;

    //On crée un tableau qui contient toute les valeurs demandé par le user
    $tabValue=createTabValue($tabValue,$tabChamp,$nbLigne,$nbTotalChamps);
    $_SESSION['tabValue']=$tabValue;
    //echo $tabChamp[0]->getlibelle();
}



//On vérifie si le user a cliqué sur Accepter sur cette page
if($_POST['suivant']=="Accepter"){
    $tabValue=$_SESSION['tabValue'];
    $tabChamp=$_SESSION['tabChamp'];

    //Sauvegarde du modèle si le user a cliqué sur sauvergarder 
    if($_SESSION['sauvegarde'] == 'oui'){
        //ouverture de la connection
        try{
            $pdo = new PDO($mysqlDsn,$mysqlDbUser,$mysqlDbPwd, array(PDO::ATTR_PERSISTENT=>true));
        }catch(PDOException $e) {
            echo "Failed to get DB handle: " . $e->getMessage() . "\n";
            exit;
        }


        /*$insertQueryM = 'INSERT INTO modele ( libelle,nom_fichier, nom_table, date_creation ) 
            VALUES ( :libelle, :nom_fichier, :nom_table, :date_creation)';
        
        $queryM = $pdo->prepare($insertQueryM);
        if($queryM->execute(array( ':libelle' 	=> $libelle, 
								':nom_fichier' 	=> $modele->getNomFile(), 
								':nom_table' 	=> $modele->getNom(),
								':date_creation' 	=> $modele->getDate())))
		{
			echo"insertion réussie";
		}else{
            echo"insertion échouée - erreur ".print_r($queryM->errorInfo());
            
        }*/

        //Sauvegarde des Champ si le user a cliqué sur sauvergarder 
        
        foreach($tabChamp as  $champ){
            var_dump($champ);
           /* $insertQueryC = 'INSERT INTO champ (id, nom_champ, longueur, val_min_nb, val_max_nb, val_min_date, val_max_date, liste_txt, libelle, type_champ  ) 
            VALUES ( :id, :nom_champ, :longueur, :val_min_nb, :val_max_nb, :val_min_date, :val_max_date, :liste_txt, :libelle, :type_champ)';
        
            $queryC = $pdo->prepare($insertQueryC);
            if($queryC->execute(array( ':id' 	=> $champ->getId(), 
								':nom_champ' 	=> $champ->getNom(), 
								':longueur' 	=> $champ->getLongueur(),
                                ':val_min_nb' 	=> $champ->getValMinNb(),
                                ':val_max_nb' 	=> $champ->getValMaxNb(),
                                ':val_min_date' 	=> $champ->getValMinDate(),
                                ':val_max_date' 	=> $champ->getValMaxDate(),
                                ':liste_txt'    =>   $champ->getliste(),
                                ':libelle'   =>      $champ->getLibelle(),
                                ':type_champ'   =>  $champ->getType())))
            {
                echo"insertion réussie";
		    }else{
                echo"insertion échouée - erreur ".print_r($queryC->errorInfo());
            
            } */
               
        }   
    }

     //Dans ce cas on crée le fichier avec les donnée que veut le user
    $file= fopen('sql-csv/'.$modele->getNom().$modele->getType(),'w');
    if($modele->getType()=='.sql'){
        createSql($file,$tabValue,$tabChamp,$modele->getNom(),$modele->getType(),$nbTotalChamps,$nbLigne);   
    }else{
        createCSV($file,$tabValue,$tabChamp,$modele->getNom(),$modele->getType(),$nbTotalChamps,$nbLigne); 
    }
    fclose($file);
}



?>


<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>generate</title>
        <meta charset="utf-8">
        <link type="text/css" rel="stylesheet" href="/tpphp/Projet_ThomasGouyet/css/main.css">
        <link href="https://fonts.googleapis.com/css2?family=Righteous&display=swap" rel="stylesheet"> 
        <link type="text/css" rel="stylesheet" href="/tpphp/Projet_ThomasGouyet/css/test.css">
    </head>
    <body>
       <!--- <img src="/tpphp/Projet_ThomasGouyet/image/header.png" id="test_header">--->
    <?php include "header.php"; 

    // Si le user a cliqué sur suivant dans generate2.php
    if($_POST['suivant']=='Suivant'){
    createTable($tabValue,$tabChamp,$nbTotalChamps,$nbLigne);
    echo '<form action="generate3.php" method="post">
            <input type="submit" name="suivant" value="Accepter" >
        </form>
    <!---On crée ce formulaire pour retourner dans generate2.php dans le cas où le user clique sur retour-->
        <form action="generate2.php" method="post">
            <input type="submit" value="Retour"  name="suivant" >
        </form>';
    }

    //Si le user a cliqué sur accepter dans generate3.php
    if($_POST['suivant']=="Accepter"){
        echo '<form action="/tpphp/Projet_ThomasGouyet" method="post">
                <input type="submit" value="Retour à la page d\'acceuil" >
            </form>
            </br>';
        echo '<a href="sql-csv/'.$modele->getNomFile().'">lien fichier '.$modele->getNomFile().'</a>';
        
    }
    ?>

    

    </body>
</html>

