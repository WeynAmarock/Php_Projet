
include "init-mysql.php";
include "generateChamps.php";

session_start();

//On inclue toute les classes utilisé dans ce fichier
spl_autoload_register(function($class){
    include($class.'.php');
    }
);

$nbLigne = $_SESSION['nbLigne'];
$nbTotalChamps = $_SESSION['nbTotalChamps'];
$nbTypesChamps= $_SESSION['nbTypeChamps'];
$nom_modele=$_SESSION['nom_Modele'];
$type_modele=$_SESSION['type_Modele'];

//On compte le nombre de Libele deja exisant pour le id du libele du nouveau modéle 
try{
    $projet_tg_tp = new PDO($mysqlDsn, $mysqlDbUser, $mysqlDbPwd, array('PDO::ATTR_PERSITENT=>true)'));
}catch(PDOException $e){
    echo "Echec de la connexion : ". $e->getMessage() . "\n";
    exit;
}

//préparation de la requête et execution :
$query = $projet_tg_tp->prepare("SELECT COUNT(libelle) FROM modele");
$query->execute();

//récuperation des résultats
$res = $query->fetchAll();

$tabChamp = array();


$id=1;
foreach($nbTypesChamps as $key => $value){
    if($value){
        for($j=0;$j<$value;$j++){;
            $tabChamp[$id-1]= new Champ ($id,$_POST[$key.'_name'.$id]
                ,$key);
            if($key == 'char' || $key=='varchar'){
                $tabChamp[$id-1]->constructChar($_POST[$key.'_size'.$id]
            );//,$_POST[$key.'_file'.$id]);
            }
            if($key =='int' || $key=='double_float' || $key=='tinyint'){
                $tabChamp[$id-1]->constructNb($_POST[$key.'_min'.$id]
                    ,$_POST[$key.'_max'.$id]);
                    echo 'test1 </br>';
                    //Faire avec le file aussi
            }
            if($key == 'date'|| $key=='datetime-local'||$key=='time'){
                $tabChamp[$id-1]->constructTime($_POST[$key.'_min'.$id]
                ,$_POST[$key.'_max'.$id]);
                //Faire avec le file aussi
            }
            $id++;
        }        
    }
    
}

//var_dump($tabChamp[0]);

/*
Ce que 'on veut :

INSERT INTO `theme` (`champ[i]`, `champ[i+1]`) VALUES
    (champ[i]->value(), champ[i+1]->value()),
    //Ceci NbLigne fois
);
*/

$file= fopen('sql/'.$nom_modele.$type_modele,'w');

//Creation du fichier sql
if($type_modele=='.sql'){
    fputs($file,'INSERT INTO \''.$nom_modele.'\'(');
    for($i=0;$i<$nbTotalChamps;$i++){
        fputs($file,'\''.$tabChamp[$i]->getNom().'\'');
        if($i<$nbTotalChamps-1){
            fputs($file,' ,');
        }else{
            fputs($file,') VALUES'."\n");
        }
    }

    for($j=0;$j<$nbLigne;$j++){
        fputs($file,'( ');
        for($i=0;$i<$nbTotalChamps;$i++){
            //echo("      test2 </br>"); 
            switch($tabChamp[$i]->getType()){
                case 'int' :
                case 'tinyint':
                    $var = $tabChamp[$i]->getValueNb();
                break;
                case 'double_float' :
                    $var = $tabChamp[$i]->getValueFloat();
                break;
                case 'boolean' :
                    $var=$tabChamp[$i]->getValueBoolean();
                break;
                case 'time' :
                    $var=$tabChamp[$i]->getValueTime($tabChamp[$i]->getValMinDate(),$tabChamp[$i]->getValMaxDate());
                break;
                case 'date':
                    $var=$tabChamp[$i]->getValueDate($tabChamp[$i]->getValMinDate(),$tabChamp[$i]->getValMaxDate());
                break;
                case 'datetime-local':
                    $var=$tabChamp[$i]->getValueDateTime($tabChamp[$i]->getValMinDate(),$tabChamp[$i]->getValMaxDate());
                break;
            }
            fputs($file,'"'.$var.'" ');
            if($i<$nbTotalChamps-1){
                fputs($file,', ');
                
            }  
                 
        }
        fputs($file,')');
        if($j<$nbLigne-1){
            fputs($file,','."\n");
        }
    }
    fputs($file,';');
        
        
}


fclose($file);

?>


<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        
        <style>
            #test_header{
                display: inline-block;
                width: 101%;
                margin-top: -10px;
                margin-left: -10px;
                padding: 0;
            }            
        </style>
    </head>
    <body>
       <!--- <img src="/tpphp/Projet_ThomasGouyet/image/header.png" id="test_header">--->
    </body>
</html>
