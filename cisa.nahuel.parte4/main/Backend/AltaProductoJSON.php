<?php

    require_once ("./clases/Producto.php");

    $nombre = isset($_POST['nombre']) ? $_POST['nombre'] : NULL;
    $origen = isset($_POST['origen']) ? $_POST['origen'] : NULL;

    $rta = new stdClass();
    $rta->bool = false;
    $rta->mensaje = "Hubo un error al agregar.";

    if($nombre != NULL && $origen != NULL){
        
        $obj = new Producto($nombre,$origen);
    
        $obj->GuardarJSON('./archivos/productos.json');

        $rta->bool = true;
        $rta->mensaje = "Se agrego con exito.";
    }

    echo json_encode($rta);


?>