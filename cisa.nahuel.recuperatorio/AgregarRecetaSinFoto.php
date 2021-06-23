<?php

    require_once ("./clases/Receta.php");

    $nombre = isset($_POST['nombre']) ? $_POST['nombre'] : NULL;
    $ingredientes = isset($_POST['ingredientes']) ? $_POST['ingredientes'] : NULL;
    $tipo = isset($_POST['tipo']) ? $_POST['tipo'] : NULL;

    $array = Receta::Traer();

    $rta = new stdClass();
    $rta->bool = false;
    $rta->mensaje = "No se agrego la receta.";

    if($nombre != NULL && $ingredientes != NULL && $tipo != NULL)
    {
        $receta = new Receta(0,$nombre,$ingredientes,$tipo,"");
 
        if($receta->Agregar()){
            $rta->bool = true;
            $rta->mensaje = "Se agrego con exito.";
        }

        echo json_encode($rta);
    }

?>