<?php
    include_once("./clases/ProductoEnvasado.php");

    $json = isset($_POST["producto_json"]) ? $_POST["producto_json"] : 0;

    $obj = json_decode($json);
    $producto = new ProductoEnvasado($obj->nombre, $obj->origen, $obj->id);

    $retornoJSON = new stdClass();

    if(ProductoEnvasado::Eliminar($producto->id))
    {
        $retornoJSON->exito = true;
        $retornoJSON->mensaje = "Producto eliminado con exito";
        $producto->GuardarJSON("./archivos/productos_eliminados.json");
    }
    else
    {
        $retornoJSON->exito = false;
        $retornoJSON->mensaje = "No se pudo eliminar el producto";
    }

    echo json_encode($retornoJSON);
?>