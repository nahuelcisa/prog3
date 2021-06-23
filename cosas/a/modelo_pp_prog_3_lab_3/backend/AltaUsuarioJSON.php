<?php
    include_once("./clases/Usuario.php");

    $correo = isset($_POST["correo"]) ? $_POST["correo"] : 0;
    $clave = isset($_POST["clave"]) ? $_POST["clave"] : 0;
    $nombre = isset($_POST["nombre"]) ? $_POST["nombre"] : 0;


    $usuario = new Usuario();
    $usuario->correo = $correo;
    $usuario->clave = $clave;
    $usuario->nombre = $nombre;

    echo $usuario->GuardarEnArchivo();
?>