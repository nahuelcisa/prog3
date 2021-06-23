<?php

    require_once("./clases/Cocinero.php");

    $email = isset($_GET['email']) ? $_GET['email'] : NULL;
    $especialidad = isset($_GET['especialidad']) ? $_GET['especialidad'] : NULL;

    if($email != NULL && $especialidad != NULL){

        $email = str_replace(".","_",$email);

        $valorCookie = "{$email}_{$especialidad}";

        if(isset($_COOKIE[$valorCookie]))
        {
            echo "El valor de la Cookie '$valorCookie' es [".$_COOKIE[$valorCookie]."]";
        }
        else
        {
            echo "no se encontro cookie";
        }
    }

?>