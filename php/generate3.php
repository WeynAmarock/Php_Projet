<?php

include "init-mysql.php";
include "generateChamps.php";

session_start();



//On inclue toute les classes utilisé dans ce fichier
spl_autoload_register(function($class){
    include($class.'.php');
    }
);

echo $_POST['int_name1'];