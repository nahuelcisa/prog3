<?php
    include_once("./clases/Producto.php");

    $nombre = isset($_POST["nombre"]) ? $_POST["nombre"] : 0;
    $origen = isset($_POST["origen"]) ? $_POST["origen"] : 0;

    if($nombre != 0 && $origen != 0)
    {
        $producto = new Producto($nombre,$origen);
        $retornoJSON = $producto->GuardarJSON("./archivos/productos.json");

        echo $retornoJSON;
    }
?>