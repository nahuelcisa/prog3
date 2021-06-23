<?php

    require_once ("./clases/Usuario.php");

    $json = isset($_POST['usuario_json']) ? $_POST['usuario_json'] : NULL;

    $obj = json_decode($json);

    $usuario = new Usuario();

    $usuario->id = $obj->id;
    $usuario->correo = $obj->correo;
    $usuario->clave = $obj->clave;
    $usuario->nombre = $obj->nombre;
    $usuario->id_perfil = $obj->id_perfil;

    $rta = new stdClass();
    $rta->bool = false;
    $rta->mensaje = "Hubo un error al modificar.";

    if($usuario->Modificar())
    {
        $rta->bool = true;
        $rta->mensaje = "Se modifico con exito.";
    }

    echo json_encode($rta);

?>