<?php

    require_once ("./clases/Usuario.php");

    $correo = isset($_POST['correo']) ? $_POST['correo'] : NULL;
    $clave = isset($_POST['clave']) ? $_POST['clave'] : NULL;
    $nombre = isset($_POST['nombre']) ? $_POST['nombre'] : NULL;

    $usuario = new Usuario();

    $usuario->correo = $correo;
    $usuario->clave = $clave;
    $usuario->nombre = $nombre;

    $usuario->GuardarEnArchivo();

?>