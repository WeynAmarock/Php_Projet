<?php
function generateChamps($type, $id){

    $textLegend=
    '<legend>Paramétrage du champ n\''.$id.' de type '.$type.':</legend>';

    $textNom=
    '<div name="nom" class="elem_form">
        <label for="'.$type.'_name'.$id.'">Nom du champ </label>
        <input type="text" name="'.$type.'_name'.$id.'" class="champ">
    </div>';

    $textSize=
    '<div id="size" class="elem_form">
        <label for="'.$type.'_size'.$id.'">Taille du champ </label>
        <input type="int" name="'.$type.'_size'.$id.'" class="champ">
    </div>';

    $textValExtreme=
    '<div id="values" class="elem_form">
        <label>Valeurs extrêmes</label>
        <input type='.$type.' name="'.$type.'_min'.$id.'" class="champ_b">
        <input type='.$type.' name="'.$type.'_max'.$id.'" class="champ_b">
    </div>';

    $textList=
    '<div id="liste_valeurs">
        <label for="liste'.$type.' '.$id.'">Liste de valeurs</label>
        <input type="file" name="liste'.$type.'_liste'.$id.'" class="champ">
    </div>';

    $textFile=
    '<div id="fichier">
        <label for="fichier'.$type.$id.'">Fichier</label>
        <input type="file" name="fichier'.$type.'_file'.$id.'" class="champ">
    </div>';

    switch($type){
        case "int":
        case "double_float":
        case "tinyint":
            echo $textLegend.$textNom.$textSize.$textValExtreme.$textList.'</br>';
        break;

        case "datetime":
        case "time":
        case "date":
            echo $textLegend.$textNom.$textValExtreme.$textList.'</br>';

        case "char":
        case "varchar":

            echo $textLegend.$textNom.$textSize.$textFile.'</br>';
        break;
        
        case "boolean":
            echo $textLegend.$textNom.'</div>';
        break;

    }
}




?>
