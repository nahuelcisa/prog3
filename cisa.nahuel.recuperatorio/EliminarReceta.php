<?php

    require_once ("./clases/Receta.php");


    $nombre = isset($_GET['nombre']) ? $_GET['nombre'] : NULL;
    $receta_json = isset($_POST['receta_json']) ? $_POST['receta_json'] : NULL;
    $accion = isset($_POST['accion']) ? $_POST['accion'] : NULL;

    $obj = json_decode($receta_json);

    $rta = new stdClass();
    $rta->bool = false;
    $rta->mensaje = "Hubo un error al eliminar.";

    $receta = new Receta($obj->id, $obj->nombre, "", $obj->tipo, "");

    if($nombre != NULL){

        $recetas = Receta::Traer();

        foreach($recetas as $item){
            if($item->nombre == $nombre){
                echo "se encuentra en la base de datos";
                break;
            }
        }
    }else if($accion == "borrar")
    {

        $recetasarray = Receta::Traer();

        foreach($recetasarray as $item){
            if($item->nombre == $receta->nombre && $item->tipo == $receta->tipo){
                $receta->pathFoto = $item->pathFoto;
            }
        }

        if($receta->Eliminar()){
            $receta->GuardarEnArchivo();
            $rta->bool = true;
            $rta->mensaje = "Se elimino.";
        }

        echo json_encode($rta);
    }

?>