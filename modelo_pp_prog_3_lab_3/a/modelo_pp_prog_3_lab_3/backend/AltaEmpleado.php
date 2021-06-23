<?php
    include_once("./clases/empleado.php");

    $json = isset($_POST["empleado_json"]) ? $_POST["empleado_json"] : 0;
    $foto = isset($_FILES["foto"]) ? $_FILES["foto"] : 0;

    $retornoJSON = new stdClass();

    if($foto != 0)
    {
        $obj = json_decode($json);

        $empleado = new Empleado();

        $empleado->id = $obj->id;
        $empleado->nombre = $obj->nombre;
        $empleado->id_perfil = $obj->id_perfil;
        $empleado->correo = $obj->correo;
        $empleado->foto = $obj->foto;
        $empleado->sueldo = $obj->sueldo;
        $empleado->clave = $obj->clave;

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

        if($flag == true)
        {
            if($empleado->Agregar())
            {
                $retornoJSON->exito = true;
                $retornoJSON->mensaje = "empleado agregado con exito";
            }
            else
            {
                $retornoJSON->exito = false;
                $retornoJSON->mensaje = "No se pudo agregar el empleado";
            }
        }
    }
    else
    {
        $retornoJSON->exito = false;
        $retornoJSON->mensaje = "Debe enviar una foto";
    }

    echo json_encode($retornoJSON);
?>