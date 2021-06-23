<?php
    include_once("./clases/usuario.php");

    $correo = isset($_POST["correo"]) ? $_POST["correo"] : 0;
    $clave = isset($_POST["clave"]) ? $_POST["clave"] : 0;
    $nombre = isset($_POST["nombre"]) ? $_POST["nombre"] : 0;
    $id_perfil = isset($_POST["id_perfil"]) ? $_POST["id_perfil"] : 0;

    $usuario = new Usuario();
    $usuario->correo = $correo;
    $usuario->clave = $clave;
    $usuario->nombre = $nombre;
    $usuario->id_perfil = $id_perfil;

    $retornoJSON = new stdClass();

    if(count($usuario->TraerUno($correo, $clave)))
    {
        if($usuario->Agregar())
        {
            $retornoJSON->exito = true;
            $retornoJSON->mensaje = "Usuario agregado con exito";
        }
        else
        {
            $retornoJSON->exito = false;
            $retornoJSON->mensaje = "No se pudo agregar el usuario";
        }
    }
    else
    {
        $retornoJSON->exito = false;
        $retornoJSON->mensaje = "Ya existe el usuario en la base";
    }

    echo json_encode($retornoJSON);
?>