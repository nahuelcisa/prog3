<?php

    require_once ("./clases/ProductoEnvasado.php");

    $obj_producto = isset($_POST['obj_producto']) ? $_POST['obj_producto'] : NULL;

    $obj = json_decode($obj_producto);

    $productosbbdd = ProductoEnvasado::Traer();

    $producto = new ProductoEnvasado(0,0,0,"",$obj->nombre,$obj->origen);

    if($producto->Existe($productosbbdd))
    {
        echo $producto->ToJSON();
    }
    else
    {
        echo "{}";
    }

?>