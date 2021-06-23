<?php
    include_once("./clases/empleado.php");

    $id = isset($_POST["id"]) ? $_POST["id"] : 0;

    $retornoJSON = new stdClass();

    
    if(Empleado::Eliminar($id))
    {
        $retornoJSON->exito = true;
        $retornoJSON->mensaje = "Empleado eliminado con exito";
    }
    else
    {
        $retornoJSON->exito = false;
        $retornoJSON->mensaje = "No se pudo eliminar el empleado";
    }

    echo json_encode($retornoJSON);
?>