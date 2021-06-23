<?php

    require_once ("./clases/Producto.php"); 

    $listar = isset($_GET['listar']) ? $_GET['listar'] : NULL;

    if($listar == 'listar')
    {
        $retorno = Producto::TraerJSON();

        echo json_encode($retorno);
    }

?>