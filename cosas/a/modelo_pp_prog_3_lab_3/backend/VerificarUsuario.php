<?php
    include_once("./clases/Usuario.php");

    $usuarioJSON = isset($_POST["usuario_json"]) ? $_POST["usuario_json"] : 0;

    $obj = json_decode($usuarioJSON);

    $usuario = new Usuario();
    $obj = $usuario->TraerUno($obj->correo, $obj->clave);

    if(count($obj) > 0)
    {
        $retornoJSON->exito = true;
        $retornoJSON->mensaje = "El empleado ya existe";
    }
    else
    {
        $retornoJSON->exito = false;
        $retornoJSON->mensaje = "El empleado no existe";
    }
?>