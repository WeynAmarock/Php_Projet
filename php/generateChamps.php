<?php

function generateChamps($type, $id){

    $divG='<legend>Paramétrage du champ n\''. $id .' de type '.$type. ':</legend>
    <div name="num_champ">
        <!-- Récupérer le numéro de champ en php pour l\'afficher -->
    </div>
    <div name="nom_int" class="elem_form">
        <label for="'.$type.'_name'.$id.'">Nom du champ </label>
        <input type="text" name="'.$type.'_name'.$id.'" class="champ">
    </div>

    <div id="size" class="elem_form">
        <label for="'.$type.'_size'.$id.'">Taille du champ </label>
        <input type="int" name="'.$type.'_size'.$id.'" class="champ">
    </div>

    <div id="values" class="elem_form">
        <label>Valeurs extrêmes</label>
        <input type="int" id="'.$type.'_min'.$id.'" class="champ_b">
        <input type="int" id="'.$type.'_max'.$id.'" class="champ_b">
    </div>

</fieldset>
</br>';

    /*switch($type){
        
        case "int":

            echo 
        break;

        case 
    } */

    echo $divG;
}






?>