<?php

    require_once ("./clases/Televisor.php");

    $tipo = isset($_POST['tipo']) ? $_POST['tipo'] : NULL;
    $precio = isset($_POST['precio']) ? $_POST['precio'] : NULL;
    $paisOrigen = isset($_POST['paisOrigen']) ? $_POST['paisOrigen'] : NULL;
    $foto = isset($_FILES["foto"]) ? $_FILES["foto"] : NULL;

    $tele = new Televisor(0,$tipo,$precio,$paisOrigen,$foto);

    $array = Televisor::Traer();

    if($tele->Verificar($array)){
        if($foto != NULL && getimagesize($foto["tmp_name"]) != FALSE)
        {
            $pathDestino = "../fotosBD/" . $foto["name"];
            $flag = false;
        
        $tipoDeArchivo = pathinfo($pathDestino,PATHINFO_EXTENSION);
        $nombreArchivo = $tele->tipo . ".". $tele->paisOrigen ."." . date("G") . date("i") . date("s") . "." . $tipoDeArchivo;
        $pathDestino = "./televisores/imagenes/" . $nombreArchivo;

        if($tipoDeArchivo == "jpg" || $tipoDeArchivo == "bmp" || $tipoDeArchivo == "gif" || $tipoDeArchivo == "png" || $tipoDeArchivo == "jpeg")
        {
            if($foto["size"] <= 1000000)
            {
                move_uploaded_file($foto["tmp_name"],$pathDestino);
                $tele->path = $pathDestino;
                $flag = true;
            }
        }

            if($flag)
            {
                $tele->pathFoto =  "./televisores/imagenes/". $nombreArchivo;
                if($tele->Agregar())
                {
                    echo "producto agregado con exito";
                }
                else
                {
                    echo "No se pudo agregar el producto";
                }
                
            }
        }

    
    }else{
        echo "Ya se encuentra la television.";
    }

?>