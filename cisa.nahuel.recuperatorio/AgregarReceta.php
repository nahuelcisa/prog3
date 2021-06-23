<?php

    require_once ("./clases/Receta.php");

    $nombre = isset($_POST['nombre']) ? $_POST['nombre'] : NULL;
    $ingredientes = isset($_POST['ingredientes']) ? $_POST['ingredientes'] : NULL;
    $tipo = isset($_POST['tipo']) ? $_POST['tipo'] : NULL;
    $foto = isset($_FILES["foto"]) ? $_FILES["foto"] : NULL;

    $recetas = Receta::Traer();

    $receta = new Receta(0,$nombre,$ingredientes,$tipo,"");

    $retornoJSON = new stdClass();

    if($receta->Existe($recetas)){
        $retornoJSON->mensaje = "Ya se encuentra en la base de datos";
        $retornoJSON->exito = false;
    }else if($foto != NULL && getimagesize($foto["tmp_name"]) != FALSE)
    {
        $pathDestino = "../fotosBD/" . $foto["name"];
        $flag = false;
        
        $tipoDeArchivo = pathinfo($pathDestino,PATHINFO_EXTENSION);
        $nombreArchivo = $receta->nombre . ".". $receta->tipo ."." . date("G") . date("i") . date("s") . "." . $tipoDeArchivo;
        $pathDestino = "./recetas/imagenes/" . $nombreArchivo;

        if($tipoDeArchivo == "jpg" || $tipoDeArchivo == "bmp" || $tipoDeArchivo == "gif" || $tipoDeArchivo == "png" || $tipoDeArchivo == "jpeg")
        {
            if($foto["size"] <= 1000000)
            {
                move_uploaded_file($foto["tmp_name"],$pathDestino);
                $receta->pathFoto = $pathDestino;
                $flag = true;
            }
        }

        if($flag)
        {
            $receta->pathFoto =  "./recetas/imagenes/".$nombreArchivo;
            if($receta->Agregar())
            {
                $retornoJSON->exito = true;
                $retornoJSON->mensaje = "producto agregado con exito";
            }
            else
            {
                $retornoJSON->exito = false;
                $retornoJSON->mensaje = "No se pudo agregar el producto";
            }
            
        }
    }

    echo json_encode($retornoJSON);

?>