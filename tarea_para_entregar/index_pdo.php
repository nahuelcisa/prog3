<?php

    require_once ("AccesoDatos.php");
    require_once ("usuarios.php");

    $opcion = isset($_POST['opcion']) ? $_POST['opcion'] : NULL;
    $id = isset($_POST['id']) ? $_POST['id'] : NULL;
    $obj = isset($_POST['json']) ? $_POST['json']:NULL;
    
    switch($opcion){

        case "login":

        $obj = json_decode($_POST['json_login']);

        $correo = $obj->correo;
        $clave = $obj->clave;

        $us = Usuario::Login($correo, $clave);

        if(isset($us)){
            
            foreach ($us as $usuario) {
                
                print_r($usuario->MostrarDatos());
                print("
                        ");
            }
        }
        else
        {
            echo "USUARIO NO COINCIDE";
        }

        break;
        
        case "mostrar":

            $usuarios = Usuario::TraerTodosLosUsuarios();
            
            foreach ($usuarios as $usuario) {
                
                print_r($usuario->MostrarDatos());
                print("
                        ");
            }
                
        break;

        case "alta":
            
            $obj = json_decode($_POST['json']);
            $correo = $obj->correo;
            $clave = $obj->clave;
            $nombre = $obj->nombre;
            $perfil = $obj->perfil;

            Usuario::InsertarElUsuario($correo,$clave,$nombre,$perfil);

            echo "ok";

        break;

        case "modificar":

            $obj = json_decode($_POST['json_login']);
            $correo = $obj->correo;
            $clave = $obj->clave;
            $nombre = $obj->nombre;
            $perfil = $obj->perfil;

            Usuario::ModificarUsuario($id,$correo,$clave,$nombre,$perfil);

            echo "ok";

        break;

        case "baja":
            
            Usuario::EliminarUsuario($id);

            echo "ok";
        
        break;
    }
?>