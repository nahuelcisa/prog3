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
        $path = "../archivos/empleados.txt";
        $archivo = fopen($path, "r");
        

        $fabrica = new Fabrica("",7);
        $fabrica->TraerDeArchivo($path);
        foreach($fabrica->GetEmpleados() as $item)
        {
            if($item->GetLegajo() == $legajo)
            {
                if($fabrica->EliminarEmpleado($item))
                {
                    unlink($item->GetPathFoto());
                    $fabrica->GuardarArchivo($path);
                    // echo "Empleado eliminado con exito <br>";
                    // echo "<a href='mostrar.php'>Mostrar empleados</a>";
                    break;
                }
                else
                {
                    // echo "No se pudo eliminar <br>";
                    // echo "<a href='../index.php'>Alta de empleados</a>";
                    break;
                }
            }
        }
    ?>    
</body>
</html>