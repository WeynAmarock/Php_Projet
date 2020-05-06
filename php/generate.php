<?php
session_start();
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
        <form action="generate2.php" method="post">
                <div>
                     <label for="name">Nom du fichier :</label>
                     <input type="text" id="name" name="nameFile">
                     <select name="select">
                        <option>.csv</option>
                        <option>.sql</option>
                    </select>
                </div>
                </br>
                <label for="nbLigne">Nombre de ligne :</label>
                <input type="text" id="nbLigne" name="nbLigne">
                <br></br>
                <div id=donnees>
                    <label for="elements">Nombre de champs en fonction du type :</label>
                    <div>
                        <label for="int">Int :</label>
                        <input type="text" id="int" name="int" value='0'>
                    </div>
                    <div>
                        <label for="double float">Double float :</label>
                        <input type="text" id="double_float" name="double_float" value='0'>
                    </div>
                    <div>
                        <label for="char">Char :</label>
                        <input type="text" id="char" name="char" value='0'>
                    </div>
                    <div>
                        <label for="varchar">Varchar :</label>
                        <input type="text" id="varchar" name="varchar" value='0'>
                    </div>
                    <div>
                        <label for="tinyint">TinyInt :</label>
                        <input type="text" id="tinyint" name="tinyint" value='0'> 
                    </div>
                    <div>
                        <label for="date">Date :</label>
                        <input type="text" id="date" name="date" value='0'>
                    </div>
                    <div>
                        <label for="time">Time :</label>
                        <input type="text" id="time" name="time" value='0'>
                    </div>
                    <div>
                        <label for="datetime">Datetime :</label>
                        <input type="text" id="datetime" name="datetime" value='0'>
                    </div>
                    <div>
                        <label for="boolean">Boolean :</label>
                        <input type="text" id="boolean" name='boolean' value='0'>
                    </div>
                </div>
                <div id="model">
                    <label for="question">Souhaitez vous garder votre modèle ?</label>
                    <label for="oui">Oui</label>
                    <input type="radio" name="radio1" value="oui">
                    <label for="non">Non</label>
                    <input type="radio" name="radio1" value="non">
                </div>
                <input type="submit" value="Valider" >
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
