<?php

    require_once ("./clases/Usuario.php");

    $usuario = isset($_POST['usuario_json']) ? $_POST['usuario_json'] : NULL;

    $rta = new stdClass();
    $rta->bool = false;
    $rta->mensaje = "Hubo un error al buscarlo.";

    $arr = Usuario::TraerUno($usuario);

    if(count($arr) > 0 )
    {
        $rta->bool = true;
        $rta->mensaje = "Se encontro con exito.";
    }

    echo json_encode($rta);

?>