<?php
    include_once("./clases/Producto.php");

    $nombre = isset($_POST["nombre"]) ? $_POST["nombre"] : 0;
    $origen = isset($_POST["origen"]) ? $_POST["origen"] : 0;

    $producto = new Producto($nombre, $origen);

    $retornoJSON = new stdClass();
    $retornoJSON = json_decode(Producto::VerificarProductoJSON($producto));
    if($retornoJSON->existe == true)
    {
        $valorCookie = "{$producto->nombre}_{$producto->origen}";
        if(!isset($_COOKIE[$valorCookie]))
        {
            $fechaActual = date("Gis");
            setcookie($valorCookie, $fechaActual);
            $retornoJSON->exitoCokkie = true;
            $retornoJSON->mensajeCokkie = "cookie agregada con exito";
        }
    }
    echo json_encode($retornoJSON)
?>