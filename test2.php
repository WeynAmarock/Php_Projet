<?php

$i = 0;

?>


<!DOCTYPE html>
<html>

<!---<a href="sql/projet.sql">fichier 1</a>-->

<form action="test.php" method="post">

<?php
while($i<3) // Ta condition ici, ne laisse pas ça, c'est une boucle infinie
{
    echo '<h1>Etape 2: </h1>
        <fieldset>
            <legend>Paramétrage des champs :</legend>
            <div id="num_champ">
                <!-- Récupérer le numéro de champ en php pour l\'afficher -->
            </div>
            <div id="nom" class="elem_form">
                <label for="champ_name">Nom du champ </label>
                <input type="text" id="champ_name" class="champ">
            </div>

            <div id="type" class="elem_form">
                <label for="champ_type">Type du champ </label>
                <input type="text" id="champ_type" class="champ">
            </div>

            <div id="size" class="elem_form">
                <label for="champ_size">Taille du champ </label>
                <input type="int" id="champ_size" class="champ">
            </div>

            <div id="values" class="elem_form">
                <label for="champ_values">Valeurs extrêmes</label>
                <input type="int" id="val_min" class="champ_b">
                <input type="int" id="val_max" class="champ_b">
            </div>

        </fieldset>';
    $i++;
}
?>

    
    
    <input type="submit" style="width:200px" value="LED1">
</form>


</html>