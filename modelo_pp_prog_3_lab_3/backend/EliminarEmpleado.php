<?php

    require_once ("./clases/Empleado.php");

    $id = isset($_POST["id"]) ? $_POST["id"] : NULL;

    $rta = new stdClass();
    $rta->bool = false;
    $rta->mensaje = "Hubo un error al Eliminar.";

    if(Empleado::Eliminar($id))
    {
        $rta->bool = true;
        $rta->mensaje = "Empleado eliminado con exito";
    }

    echo json_encode($rta);
?>