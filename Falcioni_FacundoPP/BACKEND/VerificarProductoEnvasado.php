<?php
    include_once("./clases/ProductoEnvasado.php");

    $obj_producto = isset($_POST["obj_producto"]) ? $_POST["obj_producto"] : 0;

    $obj = json_decode($obj_producto);
    $producto = new ProductoEnvasado($obj->nombre, $obj->origen);

    $array = ProductoEnvasado::Traer();

    foreach($array as $item)
    {
        if($producto->nombre == $item->nombre && $producto->origen == $item->origen)
        {
            $producto = $item;
        }
    }

    if($producto->Existe($array))
    {
        echo $producto->ToJSON();
    }
    else
    {
        echo "{}";
    }
?>