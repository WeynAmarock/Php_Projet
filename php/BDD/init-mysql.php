<?php
//Configuration de la conexion à la BDD

$mysqlServerIp 		= "127.0.0.1";
$mysqlServerPort 	= "3306";
$mysqlDbName 		= "projet_tg_tp";
$mysqlDbUser 		= "root";
$mysqlDbPwd 		= "cir23";
$mysqlDbCharset 	= "UTF8";

$mysqlDsn = "mysql:host=".$mysqlServerIp.";port=".$mysqlServerPort.";dbname=".
            $mysqlDbName.";charset=".$mysqlDbCharset.";";

?>