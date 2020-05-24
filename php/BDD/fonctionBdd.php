<?php

require_once("../php/BDD/init-mysql.php") ;


//Cette fonction sert à se connecter à une BDD
function dbConnect(){
    try {
        $projet_tg_tp = new PDO($mysqlDsn, $mysqlDbUser, $mysqlDbPwd, array('PDO::ATTR_PERSITENT=>true)'));
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch(PDOException $exception) {
        error_log('Connection error: '.$exception->getMessage());
        return false;
    }
    return $db;
}

//Fonction servant à compter quelque chose dans une table
function countOnBdd($objet,$table,$db){
    $request='"SELECT count('.$objet.') FROM '.$table.'"';
    $query = $db->prepare($request);
    $query->execute();
    $countObject = $query->fetch();
    return $countObject[0];
}

//Fonction qui retourne une toute une table où le libelle est égale au libelle fournie en paramètre
function dbRequestAllChampOnLibelle($db,$table,$classe,$libelle) {
    try {
      $request = 'SELECT *
              FROM '.$table.'
              WHERE libelle = :libelle';
        $statement = $db->prepare($request);
        $statement->bindParam(':libelle', $libelle, PDO::PARAM_STR);
        $statement->execute();
        $result = $statement->fetchAll(PDO::FETCH_CLASS, $classe);

    } catch (PDOException $exception) {
        error_log("Request error : " .$exception->getMessage());
        return false;
    }
    return $result;
}








?>
