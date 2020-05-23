<?php
    
    function ConnectToBDD(){    //Fonction permettant de se connecter à la base de données
        include('BDD/init-mysql.php');
        try {
            $bdd = new PDO('mysql:host='.$mysqlServerIp.';dbname='.$mysqlDbName.';charset=utf8',$mysqlDbUser, $mysqlDbPwd);
            $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch(PDOException $exception) {
            error_log('Connection error: '.$exception->getMessage());
            return false;
        }
        return $bdd;
    }

    function AfficheElements($bdd){     //fonction permettant de récupérer les élements de la table à l'écran sous forme de tableau
        try {
            $request = 'SELECT * FROM type_champ';
            $statement = $bdd->prepare($request);
            $statement->execute();
            $result = $statement->fetchAll(PDO::FETCH_ASSOC);

        } catch (PDOException $exception) {
            error_log('Request error: ' .$exception->getMessage());
            return false;
        }
        return $result;
    }

    function UpdateBDD($bdd, $act, $type_champ){        //fonction censée permettre de mettre à jour les élements de la base de données
        try{
            $requete = "UPDATE type_champ SET actif =:actif WHERE type_champ=:type_champ";
            $req = $bdd->prepare($requete);
            $req->bindParam(':actif', $act, PDO::PARAM_STR);
            $req->bindParam(':type_champ', $type_champ, PDO::PARAM_STR);
            $req->execute();
        }
        catch(PDOException $exception){
            error_log('Erreur requête :'.$exception->getMessage());
            return false;
        }
        return true;
    }

    function AjouterChamp($bdd, $type_champ){
        try{
            $ajout = "INSERT INTO type_champ VALUES (:type_champ,'1')";
            $add = $bdd->prepare($ajout);
            $add->bindParam(':type_champ', $type_champ, PDO::PARAM_STR);
            $add->execute();
        }
        catch(PDOException $exception){
            error_log('Erreur requête :'.$exception->getMessage());
            return false;
        }
        return true;
    }
    
    // Connexion à la base de donéee
    $bdd = ConnectToBDD();
    if (!$bdd) {
    	echo "Problème de connexion à la bdd.";
    	exit();
    }

    // On récupère les types et leurs états
    $result = AfficheElements($bdd);

    //Si le bouton est cliqué on regarde la valeur de chaque checkbox
    if (isset($_POST['btnSub'])) {
    	$i = 0;
        foreach ($result as $elt) {
        	if (isset($_POST['actif'.$elt['type_champ']])) {
        		// echo $_POST['actif'.$elt['type_champ']];
        		if ($elt['actif'] == '1'){
        			$result[$i]['actif'] = '0';
        		} else {
        			$result[$i]['actif'] = '1';
        		} 
        	}
        	$i += 1;
        }

    	//On update notre base de donnée
    	foreach ($result as $elt) {
    		$response = UpdateBDD($bdd, $elt['actif'], $elt['type_champ']);
    		if(!$response) {
    			echo 'Probleme de requete (UpdateBDD) <br>';
    			exit();
    		}
    	}
    }

    if (isset($_POST['AjoutChamp'])) {
        $type_champ = $_POST['champ'];
        $ok = AjouterChamp($bdd, $type_champ);
    }
    
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Back</title>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
        <link type="text/css" rel="stylesheet" href="../css/back.css">
        <link type="text/css" rel="stylesheet" href="../css/main.css">
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
					<li><a href="replay.php">Rejouer</a></li>
					<li><a href="back.php" class="active">Back</a></li>
				</ul>
			</div>
        </div>
        <br><br><br>
        <div id="content">
            <form method="POST">
                <div class="container">
                    <table class="table table-striped">
                        <tr>
                            <th>type_champ</th>
                            <th>actif</th>
                            <th>Modifier état</th>
                        </tr>
                        <tr>
                            <!-- affichage à l'écran sous forme de tableau -->
                            <?php foreach($result as $elt):?>
                        </tr>
                        <tr>
                            <td><?= $elt['type_champ'] ?></td>
                            <td><?= $elt['actif'] ?></td>
                            <td><input type="checkbox" name="<?php echo 'actif'.$elt['type_champ'];?>"></td> 
                        </tr>
                            <?php endforeach; ?>
                    </table>
                </div>
                <button type="submit" name="btnSub" class="button ok">Valider</button>
                   
            </form>
            <form method="POST">
                    <input type="text" name="champ">
                    <button type="submit" name="AjoutChamp" class="button ok">Ajouter un champ</button>
            </form>
        </div>
        
        <br><br>
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