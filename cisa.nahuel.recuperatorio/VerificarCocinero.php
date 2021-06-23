<?php

    require_once ("./clases/Cocinero.php");

    $email = isset($_POST['email']) ? $_POST['email'] : NULL;
    $clave = isset($_POST['clave']) ? $_POST['clave'] : NULL;

    $email = str_replace(".","_",$email);

    $cocinero = new Cocinero("",$email,$clave);

    $retorno = json_decode(Cocinero::VerificarExistencia($cocinero));

    $rta = new stdClass();
    $rta->bool = false;
    $rta->mensaje = "No se creo cookie.";
    $especialidad;

    if($retorno->bool){


        $cocineros = Cocinero::TraerTodos();

        foreach($cocineros as $item){

            if($item->email == $email && $item->clave == $clave)
            {
                $especialidad = $item->especialidad;
            }
        }

        
        $nombreCookie = "{$cocinero->email}_{$especialidad}";

        if(!isset($_COOKIE[$nombreCookie]))
        {
            setcookie($nombreCookie, date("G"). date("i"). date("s"));
            $rta->bool = true;
            $rta->mensaje = "Se creo la cookie.";
        }

        echo json_encode($rta);
        
    }
    else
    {
        echo json_encode($retorno);
    }

?>