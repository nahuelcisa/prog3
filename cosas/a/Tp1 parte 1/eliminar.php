<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eliminar empleados</title>
</head>
<body>
    <?php
        require_once("fabrica.php");
        require_once("empleado.php");

        $legajo = isset($_GET["legajo"]) ? $_GET["legajo"] : 0;
        $path = "./archivos/empleados.txt";
        $archivo = fopen($path, "r");
        $flag = false;
        do
        {
            $linea = fgets($archivo);
            $linea = is_string($linea) ? trim($linea) : false;
            if($linea != false)
            {
                $arr = explode(" - ",$linea);
                if($arr[4] == $legajo)
                {
                    $empleado = new Empleado($arr[0],$arr[1],$arr[3],$arr[2],$arr[4],$arr[5],$arr[6]);
                    $fabrica = new Fabrica("",7);
                    $fabrica = $fabrica->TraerDeArchivo($path);
                    if($fabrica->EliminarEmpleado($empleado))
                    {
                        $fabrica->GuardarArchivo($path);
                        echo "Empleado eliminado con exito <br>";
                        echo "<a href='mostrar.php'>Mostrar empleados</a>";
                        break;
                    }
                    else
                    {
                        echo "No se pudo eliminar <br>";
                        echo "<a href='index.html'>Inicio</a>";
                        break;
                    }
                }
            }
        }while(!feof($archivo));
        fclose($archivo);
    ?>    
</body>
</html>