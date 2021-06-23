<?php

    require_once ("./clases/Usuario.php");

    $accion = isset($_POST["accion"]) ? $_POST["accion"] : NULL;
    $id = isset($_POST["id"]) ? $_POST["id"] : NULL;

    $rta = new stdClass();
    $rta->bool = false;
    $rta->mensaje = "Hubo un error al eliminar.";


    if($accion == "borrar")
    {
        if(Usuario::Eliminar($id))
        {
            $rta->bool = true;
            $rta->mensaje = "Se elimino con exito.";
        }
    }

    echo json_encode($rta);

?>