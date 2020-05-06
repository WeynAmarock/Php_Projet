<?php

include "php/champ.php";

//file_put_contents('CreateTable.sql','CREATE TABLE (');

$test = 0;


?>

<!DOCTYPE html>
<html>

<!---<a href="sql/projet.sql">fichier 1</a>-->

<form action="test.php" method="post">
    <label for="name">Nom du fichier :</label>
    <input type="text" id="name" name="nom">
    
    <input type="submit" style="width:200px" value="LED1">
</form>

<?php
for($i=0;$i<5;$i++){
    if(!empty($_POST['nom'])){
        echo $_POST['nom'];
    }else{
        echo("test nulle");
        $test = $test + 1;
        echo $test;
    }
}  
?>

</html>