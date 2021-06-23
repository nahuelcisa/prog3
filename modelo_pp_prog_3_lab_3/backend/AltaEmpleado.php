<?php

    require_once ("./clases/Empleado.php");

    $correo = isset($_POST['correo']) ? $_POST['correo'] : NULL;
    $clave = isset($_POST['clave']) ? $_POST['clave'] : NULL;
    $nombre = isset($_POST['nombre']) ? $_POST['nombre'] : NULL;
    $id_perfil = isset($_POST['id_perfil']) ? $_POST['id_perfil'] : NULL;
    $foto = isset($_FILES['foto']) ? $_FILES['foto'] : NULL;
    $sueldo = isset($_POST['sueldo']) ? $_POST['sueldo'] : NULL;

    $rta = new stdClass();
    $rta->bool = false;
    $rta->mensaje = "Hubo un error al agregar.";

    if($foto != NULL){

        $emp = new Empleado();

        $emp->correo = $correo;
        $emp->clave = $clave;
        $emp->nombre = $nombre;
        $emp->id_perfil = $id_perfil;
        $emp->foto = $foto;
        $emp->sueldo = $sueldo;

        $flag = false;
        $destino = "../fotosBD/" . $foto["name"];

        if(getimagesize($foto["tmp_name"]) != false)
        {
            $tipo = pathinfo($destino, PATHINFO_EXTENSION);
            $nombreFoto = $emp->nombre . "." . date("G") . date("i") . date("s") .".". $tipo;
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
            $emp->foto = "./backend/empleados/fotos/".$nombreFoto;
            if($emp->Agregar())
            {
                $rta->bool = true;
                $rta->mensaje = "Se agrego con exito.";
            }
            else
            {
                $rta->bool = false;
                $rta->mensaje = "Error al agregar el empleado.";
            }
        }
    }
    else
    {
        $rta->bool = false;
        $rta->mensaje = "Tiene que agregar una foto.";
    }

    echo json_encode($rta);
    
?>