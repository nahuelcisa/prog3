<?php
    include_once("./clases/Usuario.php");

    $json = isset($_POST["usuario_json"]) ? $_POST["usuario_json"] : 0;

    $obj = json_decode($json);
    $usuario = new Usuario();
    $usuario->id = $obj->id;

    if($usuario->Modificar($obj->correo, $obj->nombre, $obj->perfil))
    {
        $retornoJSON->exito = true;
        $retornoJSON->mensaje = "Usuario modificado con exito";
    }
    else
    {
        $retornoJSON->exito = false;
        $retornoJSON->mensaje = "No se pudo modificar el usuario";
    }
?>