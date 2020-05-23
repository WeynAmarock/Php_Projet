﻿<!-- Ok pour CSS -->
<?php




?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Php</title>
        <link type="text/css" rel="stylesheet" href="css/header.css">
        <link type="text/css" rel="stylesheet" href="css/footer.css">
	</head>
	<body>
		<div id="header">
			<div id="ph">
				<img id="img" src="images/fond.png" width=100%>
			</div>
			<div id="navbar">
				
				<img id="logo" src="images/elePHPant.png">
	
				<ul id="menu">
					<li><a href="index.php" class="active">Accueil</a></li>
					<li><a href="php/generate.php">Générer</a></li>
					<li><a href="php/replay.php">Rejouer</a></li>
					<li><a href="php/back.php">Back</a></li>
				</ul>
			</div>
        </div>
        <hr id="hr">
        <section>
            <div id="choix">
                <button class="choix" onclick=window.location.href="php/generate.php">Génération de donnéees</button>
                <button class="choix" onclick=window.location.href="php/replay.php">Rejouer un modèle</button>
                <button class="choix" onclick=window.location.href="php/back.php">Back</button>
            </div>
        
        </section>



        <footer>
            <hr id="grey_hr">
            <div id="isen" class="elem_foot">
                <img src="images/ISEN.jpg" id="logo_isen">
            </div>
        
            <div id="mentions" class="elem_foot">
                <p>@-2020-Gouyet-Poupon<br>Projet CIR2 </p>
            </div>

            <div id="logo_php" class="elem_foot">
                <img src="images/elePHPant.png" width="10%">
            </div>
        </footer>
	</body>
</html>


