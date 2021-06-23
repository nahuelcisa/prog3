<?php
    require_once ("./clases/Empleado.php");

    $json = isset($_POST["empleado_json"]) ? $_POST["empleado_json"] : NULL;
    $foto = isset($_FILES["foto"]) ? $_FILES["foto"] : NULL;

    $obj = json_decode($json);

    $rta = new stdClass();
    $rta->bool = false;
    $rta->mensaje = "Hubo un error al modificar.";

    $empleado = new Empleado();

    $empleado->id = $obj->id;
    $empleado->nombre = $obj->nombre;
    $empleado->id_perfil = $obj->id_perfil;
    $empleado->correo = $obj->correo;
    $empleado->sueldo = $obj->sueldo;
    $empleado->clave = $obj->clave;

    if($foto == NULL)
    {
        $empleado->foto = $obj->pathFoto;
    }
    else
    {
        $destino = "../fotosBD/" . $foto["name"];
        $flag = false;

        if(getimagesize($foto["tmp_name"]) != false)
        {
            $tipo = pathinfo($destino, PATHINFO_EXTENSION);
            $nombreFoto = $empleado->nombre . "." . date("G") . date("i") . date("s") .".". $tipo;
            $destinoFoto = "./empleados/fotos/". $nombreFoto;

            if($tipo == "jpg" || $tipo == "bmp" || $tipo == "gif" || $tipo == "png" || $tipo == "jpeg")
            {
                if($foto["size"] <= 5000000)
                {
                    move_uploaded_file($foto["tmp_name"],$destinoFoto);
                    $flag = true;
                }
            }
        }
        if($flag)
        {
            $empleado->foto = "./backend/empleados/fotos/".$nombreFoto;
        }
        else
        {
            $empleado->foto = $obj->pathFoto;
        }
    }

    if($empleado->Modificar())
    {
        $rta->bool = true;
        $rta->mensaje = "Empleado modificado con exito";
    }
    else
    {
        $rta->bool = false;
        $rta->mensaje = "No se pudo modificar el usuario";
    }

    echo json_encode($rta);

?>