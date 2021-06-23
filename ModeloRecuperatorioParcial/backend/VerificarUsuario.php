<?php

    require_once("./clases/Usuario.php");

    $email = isset($_POST['email']) ? $_POST['email'] : NULL;
    $clave = isset($_POST['clave']) ? $_POST['clave'] : NULL;

    if($email != null && $clave != null){
        $usuario = new Usuario($email, $clave);

        if(Usuario::VerificarExistencia($usuario)){

            $email = str_replace(".","_",$email);

            $valorCookie = $email;

            if(!isset($_COOKIE[$valorCookie])){
                $fecha = date("His");
                setcookie($valorCookie,$fecha);

                header("Location: ListadoUsuarios.php");

            }else{

                echo "La Cookie ya esta creada";
            }

            
        }
    }

?>