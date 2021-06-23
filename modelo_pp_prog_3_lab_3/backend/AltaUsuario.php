<?php

    require_once ("./clases/Usuario.php");

    $correo = isset($_POST['correo']) ? $_POST['correo'] : NULL;
    $clave = isset($_POST['clave']) ? $_POST['clave'] : NULL;
    $nombre = isset($_POST['nombre']) ? $_POST['nombre'] : NULL;
    $id_perfil = isset($_POST['id_perfil']) ? $_POST['id_perfil'] : NULL;

    $usuario = new Usuario();

    $usuario->correo = $correo;
    $usuario->clave = $clave;
    $usuario->nombre = $nombre;
    $usuario->id_perfil = $id_perfil;

    $rta = new stdClass();
    $rta->bool = false;
    $rta->mensaje = "Hubo un error al agregar.";

    if($usuario->Agregar())
    {
        $rta->bool = true;
        $rta->mensaje = "Se agrego con exito.";
    }

    echo json_encode($rta);

?>