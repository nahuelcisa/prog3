<?php

    require_once ("./clases/ProductoEnvasado.php");

    $producto_json = isset($_POST['producto_json']) ? $_POST['producto_json'] : NULL;

    $obj = json_decode($producto_json);

    $producto = new ProductoEnvasado(0,$obj->codigo_barra,$obj->precio,"",$obj->nombre,$obj->origen);

    $rta = new stdClass();
    $rta->bool = false;
    $rta->mensaje = "Hubo un error al agregar.";

    if($producto->Agregar())
    {
        $rta->bool = true;
        $rta->mensaje = "Se agrego con exito.";
    }

    echo json_encode($rta);
?>