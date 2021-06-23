<?php

    require_once ("./clases/Producto.php"); 

    $nombre = isset($_GET['nombre']) ? $_GET['nombre'] : NULL;
    $origen = isset($_GET['origen']) ? $_GET['origen'] : NULL;

    $rta = new stdClass();
    $rta->bool = false;
    $rta->mensaje = "No se encontro cookie.";
    

    $nombreCookie = $nombre . "_" . $origen;

    if(isset($_COOKIE[$nombreCookie]))
    {
        $rta->bool = true;
        $rta->mensaje = "El valor de la Cookie '$nombreCookie' es [".$_COOKIE[$nombreCookie]."]";
    }

    echo json_encode($rta);
?>