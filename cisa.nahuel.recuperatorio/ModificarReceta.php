<?php
    include_once("./clases/Receta.php");

    $receta_json = isset($_POST['receta_json']) ? $_POST['receta_json'] : NULL;   
    $foto = isset($_FILES["foto"]) ? $_FILES["foto"] : 0;

    $obj = json_decode($receta_json);
    $retornoJSON = new stdClass();

    $receta = new Receta($obj->id, $obj->nombre, $obj->ingredientes, $obj->tipo, $obj->pathFoto);

    $pathDestino = "recetas/imagenes/" . $foto["name"];
    $flag = false;
    if(getimagesize($foto["tmp_name"]) != FALSE)
    {
        $tipoDeArchivo = pathinfo($pathDestino,PATHINFO_EXTENSION);
        $nombreArchivo = $receta->nombre . "." . $receta->tipo . "." . date("G") . date("i") . date("s");
        $pathDestino = "./recetas/imagenes/" . $nombreArchivo . "." . $tipoDeArchivo;
        

        if($tipoDeArchivo == "jpg" || $tipoDeArchivo == "bmp" || $tipoDeArchivo == "gif" || $tipoDeArchivo == "png" || $tipoDeArchivo == "jpeg")
        {
            if($foto["size"] <= 1000000)
            {
                $extension = pathinfo($pathDestino, PATHINFO_EXTENSION);
                $date = date("Gis");
                $pathFotoModificada = "recetasModificadas/{$receta->nombre}.{$receta->tipo}.modificado.$date.{$extension}";
                copy($receta->pathFoto, $pathFotoModificada);
                unlink($receta->pathFoto);
                move_uploaded_file($foto["tmp_name"],$pathDestino);
                $pathDestino = "./recetas/imagenes/" . $nombreArchivo . "." . $tipoDeArchivo;
                $receta->pathFoto = $pathDestino;
                $flag = true;
            }
        }
    }

    if($receta->Modificar())
    {
        if($flag)
        {
            $retornoJSON->exito = true;
            $retornoJSON->mensaje = "Receta modificada con exito";
        }
    }
    else
    {
        $retornoJSON->exito = false;
        $retornoJSON->mensaje = "No se pudo modificar la receta";
    }

    echo json_encode($retornoJSON);
?>