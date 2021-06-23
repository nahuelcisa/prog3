<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Empleados Mostrar</title>
    </head>
    <body>
        
        <form action = "eliminar.php" method = "GET">
            <?php

            require_once "empleado.php";

            $path = "./archivos/empleados.txt";
            $archivo = fopen($path,"r");
            if($archivo != null)
            {   
                do
                {                
                    $cadena = fgets($archivo);

                    if($cadena)
                    {
                        $arrEmpleados = explode(" - ", $cadena);
                        echo  $cadena . "<a href=eliminar.php?legajo=$arrEmpleados[4]> Eliminar </a> <br>";
                    }                   
                    
                }while(!feof($archivo));                
            }

            fclose($archivo);
            echo "<a href= index.html> Inicio </a>";
            ?>
        </form>
    </body>
</html>