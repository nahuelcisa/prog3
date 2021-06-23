<?php
    include_once("./clases/Usuario.php");

    $id = isset($_POST["id"]) ? $_POST["id"] : 0;

    $retornoJSON = new stdClass();

    if(Usuario::Eliminar($id))
    {
        $retornoJSON->exito = true;
        $retornoJSON->mensaje = "Usuario eliminado con exito";
    }
    else
    {
        $retornoJSON->exito = false;
        $retornoJSON->mensaje = "No se pudo eliminar el usuario";
    }

    echo json_encode($retornoJSON);
?>