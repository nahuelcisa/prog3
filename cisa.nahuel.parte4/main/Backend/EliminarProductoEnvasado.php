<?php

    require_once ("./clases/ProductoEnvasado.php");

    $producto_json = isset($_POST['producto_json']) ? $_POST['producto_json'] : NULL;

    $obj = json_decode($producto_json);

    $rta = new stdClass();
    $rta->bool = false;
    $rta->mensaje = "Hubo un error al eliminar.";

    if(ProductoEnvasado::Eliminar($obj->id))
    {
        $rta->bool = true;
        $rta->mensaje = "Se elimino con exito.";

        $prodcto = new ProductoEnvasado($obj->id,0,0,"",$obj->nombre,$obj->origen);

        $prodcto->GuardarJSON('./archivos/productos_eliminados.json');
    }

    echo json_encode($rta);

?>

