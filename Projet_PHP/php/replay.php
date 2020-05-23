
<?php
//Cette page php sert à la génération de donnée avec un modèle deja existant dans la BDD

//Le fonctionnemet se décompose en 2 parties 

include "fonctions.php";
session_start();

try{
    $db = new PDO($mysqlDsn, $mysqlDbUser, $mysqlDbPwd, array('PDO::ATTR_PERSITENT=>true)'));
}catch(PDOException $e){
    echo "Echec de la connexion : ". $e->getMessage() . "\n";
    exit;
}

if(count($_POST)==0){ //1ère partie, le user rentre dans la page
    $afficheModele=1;
    $afficheChamps=0;
    $afficheFile=0;
    //préparation de la requête et execution :
    $query = $db->prepare("SELECT * FROM modele");
    $query->execute();
    //récuperation des résultats
    $tabModele = $query->fetchAll(PDO::FETCH_CLASS, 'Modele');
}else if($_POST['Charger']=='Charger ce modele ?') { //Le user a cliqué sur charger

    $afficheModele=0;
    $afficheChamps=0;
    $afficheFile=1;

    $nbLigne=$_POST['nbLigne'];
    $tabChamp=$_SESSION['tabChamp'];
    $nbTotalChamp=$_SESSION['nbTotalChamp'];
    $libelle=$_SESSION['libelle'];

    //On récupère toute les informations du modele à partir de son libelle
    $tabModele=dbRequestAllChampOnLibelle($db,'modele','Modele',$libelle);
    $modele=$tabModele[0];
    echo $modele->getNom();
   

    //$tabValue = createTabValue($tabChamp,$nbLigne,$nbTotalChamp);

    /*$file= fopen('sql-csv/'.$modele->getNom().$modele->getType(),'w');
    if($modele->getType()=='.sql'){
        createSql($file,$tabValue,$tabChamp,$modele->getNom(),$modele->getType(),$nbTotalChamps,$nbLigne);   
    }else{
        createCSV($file,$tabValue,$tabChamp,$modele->getNom(),$modele->getType(),$nbTotalChamps,$nbLigne); 
    }
    fclose($file);*/

}else {
    $afficheModele=0;
    $afficheChamps=1;
    $afficheFile=0;
    $nomTable=substr($_POST['Charger'],8);
    //On récupère toute les informations dsur les champs à partir du libelle du modele
    $tabChamp=dbRequestAllChampOnLibelle($db,'champ','Champ',$nomTable);
}

?>

<!DOCTYPE html>
<html>
    <head>
        <title>Projet PHP</title>
        <meta charset="utf-8">
        <link type="text/css" rel="stylesheet" href="../css/main.css">
        <link href="https://fonts.googleapis.com/css2?family=Righteous&display=swap" rel="stylesheet"> 
        <link type="text/css" rel="stylesheet" href="../css/test.css">
        <link type="text/css" rel="stylesheet" href="../css/header.css">
        <link type="text/css" rel="stylesheet" href="../css/footer.css">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

    </head>

    <body>
        
        <div id="header">
			<div id="ph">
				<img id="img" src="../images/fond.png" width=100%>
			</div>
			<div id="navbar">
				
				<img id="logo" src="../images/elePHPant.png">
	
				<ul id="menu">
					<li><a href="../index.php">Accueil</a></li>
					<li><a href="generate.php">Générer</a></li>
					<li><a href="replay.php" class="active">Rejouer</a></li>
					<li><a href="back.php">Back</a></li>
				</ul>
			</div>
        </div>
        <br><br>
        <div id="content">
            <?php if($afficheFile):?>
                <label for='telecharger'>Télécharger le fichier</label>
                <a href="<?php echo 'sql-csv/'.$modele->getNomFile();?>"><?php echo $modele->getNomFile();?></a>
            <?php endif ;?>
            <form method="post" action="replay.php">
            <?php 
            if($afficheModele):
            ?>
                <table id="tableModele" class="table table-striped">
                    <thead>
                        <tr>
                            <th> Libele du modele   </th>
                            <th> Nom de la table   </th>
                            <th> Nom du fichier   </th>
                            <th> Date de création du modele</th>
                            <th> Générer des données </th>
                        </tr>
                    </thead> 

                    <tbody>
                    <?php 
                        foreach( $tabModele as $modele):
                    ?>
                    <tr>
                        <td class="libelleModele"><?php echo $modele->getLibele();?></td>
                        <td class="nomModele"><?php echo $modele->getNom();?></td>
                        <td class="nomFichierModele"><?php echo $modele->getNomFile();?></td>
                        <td class="dateModele"><?php echo $modele->getDate();?></td>
                        <td><input type="submit" value="<?php $_SESSION['libelle']=$modele->getLibele();
                        echo 'Charger '.$modele->getLibele();?>" name="Charger" class="button ok"></td>
                    </tr>
                    <?php 
                       endforeach;
                    ?>
                    </tbody>
                    </table>

            <?php endif;
            //Si le user ne rentre pas dans le bloc if précédent cela veut dire que nous sommes dans la génération des champs du modèle choisi
            if($afficheChamps):
            ?>
            <p> <label>Table : <?php echo $nomTable;?></label></p>
            <p>
                <label for="nbLigne">Nombre de ligne : </label>
                <input name="nbLigne" required/>
                </br></br>
            </p>
            <TABLE id="tableChamps">
                <THEAD>
                    <tr>
                        <th>Nom du champ</th>
                        <th>Longeur du champ</th>
                        <th>Nom du fichier texte</th>
                        <th>Val Min Nb</th>
                        <th>Val Max Nb</th>
                        <th>Val Min Date</th>
                        <th>Val Max Date</th>
                        <th>Libelle</th>
                        <th>Type du champ</th>
                    </tr>
                </THEAD>
                
                <TBODY>
                <?php $nbTotalChamp=0;
                foreach($tabChamp as $champ):
                    $nbTotalChamp++;
                ?>
                    <tr>
                        <td id=""><?php if($champ->getNom()){echo $champ->getNom();}else{echo'NULL';}?></td>
                        <td id=""><?php if($champ->getLongueur()){echo $champ->getLongueur();}else{echo'NULL';}?></td>
                        <td id=""><?php if($champ->getListe()){echo $champ->getListe();}else{echo'NULL';}?></td>
                        <td id=""><?php if($champ->getValMinNb()){echo $champ->getValMinNb();}else{echo'NULL';};?></td>
                        <td id=""><?php if($champ->getValMaxNb()){echo $champ->getValMaxNb();}else{echo'NULL';}?></td>
                        <td id=""><?php if($champ->getValMinDate()){echo $champ->getValMaxDate();}else{echo'NULL';}?></td>
                        <td id=""><?php if($champ->getValMaxDate()){echo $champ->getValMaxDate();}else{echo'NULL';}?></td>
                        <td id=""><?php if($champ->getLibelle()){echo $champ->getLibelle();}else{echo'NULL';}?></td>
                        <td id=""><?php if($champ->getType()){echo $champ->getType();}else{echo'NULL';}?></td>
                    </tr>
                <?php $_SESSION['nbTotalChamp']=$nbTotalChamp;
                $_SESSION['tabChamp']=$tabChamp;
                endforeach;?>
                </TBODY>
            </TABLE>
            <input type="submit" value="<?php echo 'Charger ce modele ?';?>" name="Charger">
            <?php endif;?>
              </form>
        </div>

        <footer>
            <hr id="grey_hr">
            <div id="isen" class="elem_foot">
                <img src="../images/ISEN.jpg" id="logo_isen">
            </div>
        
            <div id="mentions" class="elem_foot">
                <p>@-2020-Gouyet-Poupon<br>Projet CIR2 </p>
            </div>

            <div id="logo_php" class="elem_foot">
                <img src="../images/elePHPant.png" width="10%">
            </div>
        </footer>
    </body>
</html>


