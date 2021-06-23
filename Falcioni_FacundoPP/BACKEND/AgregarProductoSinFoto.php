<?php
    require_once ("./clases/ProductoEnvasado.php");

    $producto_json = isset($_POST['producto_json']) ? $_POST['producto_json'] : NULL;

    $obj = json_decode($producto_json);

    $producto = new ProductoEnvasado($obj->nombre, $obj->origen, 0, $obj->codigoBarra, $obj->precio);

    $retornoJSON = new stdClass();
    $retornoJSON->exito = false;
    $retornoJSON->mensaje = "Hubo un error al agregar.";

    if($producto->Agregar())
    {
        $retornoJSON->exito = true;
        $retornoJSON->mensaje = "Se agrego con exito.";
    }

    echo json_encode($retornoJSON);
?>