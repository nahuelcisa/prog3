<?php
    require_once("empleado.php");
    require_once("fabrica.php");

    $dni = isset($_POST["dni"]) ? $_POST["dni"] : 0;
    $apellido = isset($_POST["apellido"]) ? $_POST["apellido"] : 0;
    $path = "../archivos/empleados.txt";
    $flag = FALSE;
    
    if(file_exists($path))
    {
        $fabrica = new Fabrica(".",7);
        $fabrica->TraerDeArchivo($path);

        foreach($fabrica->GetEmpleados() as $item)
        {
            if($item->GetDni() == $dni && $item->GetApellido() == $apellido)
            {
                $flag = TRUE;
                break;
            }
        }

        if($flag)
        {
            session_start();
            $_SESSION["DNIEmpleado"] = $dni;
            header("Location: ../ajax.php");
        }
        else
        {
            echo "No se encontro un empleado con esos datos. <br>
            <a href=../login.html>Login</a>";
        }
    }
?>