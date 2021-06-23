<?php

    require_once ("./clases/Receta.php");

    $receta = isset($_POST['receta']) ? $_POST['receta'] : NULL;

    $obj = json_decode($receta);

    $obj2 = new Receta(0,$obj->nombre,"",$obj->tipo,"");

    $recetas = Receta::Traer();

    $rta = false;

    foreach($recetas as $item){
        if($item->nombre == $obj2->nombre && $item->tipo == $obj2->tipo){
            echo $item->ToJSON();
            $rta = true;
            break;
        }
    }

    if(!$rta){
        echo "no coincide el nombre o el tipo o ambos.";
    }
?>