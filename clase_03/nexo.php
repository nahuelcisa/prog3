<?php


    $accion = isset($_POST["accion"]) ? $_POST["accion"] : 0;
    $accion = isset($_GET["accion"]) ? $_GET["accion"] : 0;
    $nombre = isset($_POST["nombre"]) ? $_POST["nombre"] : 0;
    $apellido = isset($_POST["apellido"]) ? $_POST["apellido"] : 0;
    $legajo = isset($_POST["legajo"]) ? $_POST["legajo"] : 0;

    $path = "./archivos/alumnos.txt";

    switch($accion){
        case "alta": 

            $archivo = fopen($path,"a");
        
            fwrite($archivo," - $legajo - $apellido - $apellido\r\n");
        
            fclose($archivo);
        break;
        
        case "listado":

            $archivo = fopen($path,"r");

            do
            {               
                $cadena = fgets($archivo);

                echo $cadena . '<br>';

            }while(!feof($archivo));

            fclose($archivo);
        break;

        case "verificar":
            $archivo = fopen($path,"r");
            $flag = false;

            do{
                $cadena = fgets($archivo);
                $arr = explode(" - ", $cadena);

                if($arr[0] == $legajo && $flag == false){
                    echo "- legajo - apellido - nombre";
                }




            }while(!feof($archivo));
        break;

    }
?>