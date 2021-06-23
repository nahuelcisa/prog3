<?php

    $opcion = isset($_POST['opcion']) ? $_POST['opcion'] : NULL;
    $correo = isset($_POST['correo']) ? $_POST['correo'] : NULL;
    $clave = isset($_POST['clave']) ? $_POST['clave'] : NULL;

    $host = "localhost";
    $user = "id16589534_usuariostest";
    $pass = "Rj4D3h>Ms=418g1c";
    $base = "id16589534_usuarios_test";

    switch($opcion){

        case "login":

            echo "hola";


            $con = @mysqli_connect($host, $user, $pass, $base);

            $sql = "SELECT usuarios.nombre, perfiles.descripcion
            FROM `usuarios`
            JOIN `perfiles` ON usuarios.perfil = perfiles.id
            WHERE usuarios.correo = '$correo' && usuarios.clave = '$clave'";

            $rs = $con->query($sql);

            while ($row = $rs->fetch_object())
            { 
                $user_arr[] = $row;
            }  

            
            if(isset($user_arr) == true){ 
                echo "<pre>";
                var_dump($user_arr); 
                echo "</pre>";
            }else{
                echo "USUARIO NO COINCIDE";
            }
            
            mysqli_close($con);
        break;
        
        case "mostrar":

            $con = @mysqli_connect($host, $user, $pass, $base);
            
            $sql = "SELECT * FROM usuarios
            JOIN `perfiles` ON usuarios.perfil = perfiles.id";

            $rs = $con->query($sql);

            while ($row = $rs->fetch_object())
            { 
                $user_arr[] = $row;
            }        
        
            echo "<pre>";
            
            var_dump($user_arr); 
                
            echo "</pre>";

            mysqli_close($con);          
        break;
    }
?>