<?php
    require_once ("./clases/ProductoEnvasado.php");

    $producto_json = isset($_POST['producto_json']) ? $_POST['producto_json'] : NULL;
    //$foto = isset($_FILES["foto"]) ? $_FILES["foto"] : NULL;

    $obj = json_decode($producto_json);

    $rta = new stdClass();
    $rta->bool = false;
    $rta->mensaje = "Hubo un error al modificar.";

    $producto = new ProductoEnvasado($obj->id,$obj->codigo_barra,$obj->precio,"",$obj->nombre,$obj->origen);

    if($producto->Modificar())
    {
        $rta->bool = true;
        $rta->mensaje = "producto modificado con exito";
    }

    echo json_encode($rta);
?>