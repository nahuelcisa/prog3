<?php

    require_once ("./clases/Usuario.php");

    $accion = isset($_GET["accion"]) ? $_GET["accion"] : NULL;

    if($accion == "listar")
    {
        $retorno = Usuario::TraerTodosJSON();

        $usuariosJSON = json_encode($retorno);

        echo $usuariosJSON;
    }

?>