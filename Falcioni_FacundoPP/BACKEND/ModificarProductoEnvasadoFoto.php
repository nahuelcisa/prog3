<?php
    include_once("./clases/ProductoEnvasado.php");

    $producto_json = isset($_POST['producto_json']) ? $_POST['producto_json'] : NULL;   
    $foto = isset($_FILES["foto"]) ? $_FILES["foto"] : 0;

    $obj = json_decode($producto_json);
    $retornoJSON = new stdClass();

    $producto = new ProductoEnvasado($obj->nombre, $obj->origen, $obj->id, $obj->codigoBarra, $obj->precio);
    
    $array = ProductoEnvasado::Traer();
    
    foreach($array as $item)
    {
        if($item->id == $producto->id)
        {
            if($item->pathFoto != null)
            {
                $producto->pathFoto = $item->pathFoto;
            }
        }
    }

    $pathDestino = "productos/imagenes/" . $foto["name"];
    $flag = false;
    if(getimagesize($foto["tmp_name"]) != FALSE)
    {
        $tipoDeArchivo = pathinfo($pathDestino,PATHINFO_EXTENSION);
        $nombreArchivo = $producto->nombre . "." . $producto->origen . "." . date("G") . date("i") . date("s");
        $pathDestino = "./productos/imagenes/" . $nombreArchivo . "." . $tipoDeArchivo;
        

        if($tipoDeArchivo == "jpg" || $tipoDeArchivo == "bmp" || $tipoDeArchivo == "gif" || $tipoDeArchivo == "png" || $tipoDeArchivo == "jpeg")
        {
            if($foto["size"] <= 1000000)
            {
                $extension = pathinfo($pathDestino, PATHINFO_EXTENSION);
                $date = date("Gis");
                $pathFotoModificada = "productosModificados/{$producto->id}.{$producto->nombre}.modificado.$date.{$extension}";
                copy($producto->pathFoto, $pathFotoModificada);
                unlink($producto->pathFoto);
                move_uploaded_file($foto["tmp_name"],$pathDestino);
                $pathDestino = "productos/imagenes/" . $nombreArchivo . "." . $tipoDeArchivo;
                $producto->pathFoto = $pathDestino;
                $flag = true;
            }
        }
    }

    if($producto->Modificar())
    {
        if($flag)
        {
            $retornoJSON->exito = true;
            $retornoJSON->mensaje = "Producto modificado con exito";
        }
    }
    else
    {
        $retornoJSON->exito = false;
        $retornoJSON->mensaje = "No se pudo modificar el producto";
    }

    echo json_encode($retornoJSON);
?>