<?php

    require_once("./clases/Usuario.php");

    $email = isset($_GET['email']) ? $_GET['email'] : NULL;

    if($email != NULL ){

        $email = str_replace(".","_",$email);

        $valorCookie = $email;

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