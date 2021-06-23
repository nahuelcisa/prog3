<?php
    include_once("./clases/Usuario.php");

    $opcion = isset($_GET["opcion"]) ? $_GET["opcion"] : 0;

    switch($opcion)
    {
        case "Mostrar":
            $usuarios = Usuario::TraerTodosJSON();
            echo (json_encode($usuarios));
            break;
    }
?>