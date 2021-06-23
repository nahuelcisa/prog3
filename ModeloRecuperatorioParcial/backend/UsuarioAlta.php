<?php

    require_once("./clases/Usuario.php");

    $email = isset($_POST['email']) ? $_POST['email'] : NULL;
    $clave = isset($_POST['clave']) ? $_POST['clave'] : NULL;

    if($email != NULL && $clave != NULL){
        $usuario = new Usuario($email,$clave);

        echo $usuario->GuardarEnArchivo();
    }else
    {
        echo "hubo un error.";
    }

?>