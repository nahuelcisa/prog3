<?php
    include_once("./clases/empleado.php");

    $json = isset($_POST["usuario_json"]) ? $_POST["usuario_json"] : 0;
    $foto = isset($_FILES["foto"]) ? $_FILES["foto"] : 0;

    $obj = json_decode($json);
    $retornoJSON = new stdClass();

    $empleado = new Empleado();

    $empleado->id = $obj->id;
    $empleado->nombre = $obj->nombre;
    $empleado->id_perfil = $obj->id_perfil;
    $empleado->correo = $obj->correo;
    $empleado->sueldo = $obj->sueldo;
    $empleado->clave = $obj->clave;
    
    if($foto == 0)
    {
        $empleado->foto = $obj->pathFoto;
    }
    else
    {
        $pathDestino = "../fotosBD/" . $foto["name"];
        $flag = false;

        if(getimagesize($foto["tmp_name"]) != FALSE)
        {
            $tipoDeArchivo = pathinfo($pathDestino,PATHINFO_EXTENSION);
            $nombreArchivo = $empleado->nombre . "." . date("G") . date("i") . date("s");
            $pathDestino = "./empleados/fotos/" . $nombreArchivo . "." . $tipoDeArchivo;
            

            if($tipoDeArchivo == "jpg" || $tipoDeArchivo == "bmp" || $tipoDeArchivo == "gif" || $tipoDeArchivo == "png" || $tipoDeArchivo == "jpeg")
            {
                if($foto["size"] <= 1000000)
                {
                    move_uploaded_file($foto["tmp_name"],$pathDestino);
                    $flag = true;
                }
            }
        }
        if($flag)
        {
            $empleado->foto = $pathDestino;
        }
        else
        {
            $empleado->foto = $obj->pathFoto;
        }
    }

    if($empleado->Modificar())
    {
        $retornoJSON->exito = true;
        $retornoJSON->mensaje = "Empleado modificado con exito";
    }
    else
    {
        $retornoJSON->exito = false;
        $retornoJSON->mensaje = "No se pudo modificar el usuario";
    }
?>