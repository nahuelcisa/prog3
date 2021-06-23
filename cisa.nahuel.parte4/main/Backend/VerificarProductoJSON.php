<?php

    require_once ("./clases/Producto.php");

    $nombre = isset($_POST['nombre']) ? $_POST['nombre'] : NULL;
    $origen = isset($_POST['origen']) ? $_POST['origen'] : NULL;

    $producto = new Producto($nombre,$origen);

    $retorno = json_decode(Producto::VerificarProductoJSON($producto));

    $rta = new stdClass();
    $rta->bool = false;
    $rta->mensaje = "No se creo cookie.";

    if($retorno->bool){
        
        $nombreCookie = "{$producto->nombre}_{$producto->origen}";

        if(!isset($_COOKIE[$nombreCookie]))
        {
            setcookie($nombreCookie, date("G"). date("i"). date("s") . $retorno->mensaje);
            $rta->bool = true;
            $rta->mensaje = "Se creo la cookie.";
        }

        echo json_encode($rta);
        
    }
    else
    {
        echo json_encode($retorno);
    }
?>