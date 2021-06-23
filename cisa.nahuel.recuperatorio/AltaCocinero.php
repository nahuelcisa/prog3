<?php

    require_once ("./clases/Cocinero.php");

    $especialidad = isset($_POST['especialidad']) ? $_POST['especialidad'] : NULL;
    $email = isset($_POST['email']) ? $_POST['email'] : NULL;
    $clave = isset($_POST['clave']) ? $_POST['clave'] : NULL;

    $rta = new stdClass();
    $rta->bool = false;
    $rta->mensaje = "Hubo un error al agregar.";

    if($especialidad != NULL && $email != NULL && $clave != NULL){
        
        $obj = new Cocinero($especialidad,$email,$clave);
    
        $obj->GuardarEnArchivo();

        $rta->bool = true;
        $rta->mensaje = "Se agrego con exito.";
    }

    echo json_encode($rta);


?>