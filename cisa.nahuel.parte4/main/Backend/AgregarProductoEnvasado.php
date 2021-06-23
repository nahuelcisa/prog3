<?php

    require_once ("./clases/ProductoEnvasado.php");

    $codigoBarra = isset($_POST['codigoBarra']) ? $_POST['codigoBarra'] : NULL;
    $nombre = isset($_POST['nombre']) ? $_POST['nombre'] : NULL;
    $origen = isset($_POST['origen']) ? $_POST['origen'] : NULL;
    $precio = isset($_POST['precio']) ? $_POST['precio'] : NULL;
    $foto = isset($_FILES["foto"]) ? $_FILES["foto"] : NULL;

    $retornoJSON = new stdClass();

    $productosbbdd = ProductoEnvasado::Traer();
    $producto = new ProductoEnvasado(0,$codigoBarra,$precio,$foto,$nombre,$origen);

    if($producto->Existe($productosbbdd))
    {
        echo "El producto ya esta en la base de datos.";
    }
    else if ($foto != NULL && getimagesize($foto["tmp_name"]) != FALSE)
    {

        $pathDestino = "../fotosBD/" . $foto["name"];
        $flag = false;
        
        $tipoDeArchivo = pathinfo($pathDestino,PATHINFO_EXTENSION);
        $nombreArchivo = $producto->nombre . ".". $producto->origen ."." . date("G") . date("i") . date("s") . "." . $tipoDeArchivo;
        $pathDestino = "./productos/imagenes/" . $nombreArchivo;

        if($tipoDeArchivo == "jpg" || $tipoDeArchivo == "bmp" || $tipoDeArchivo == "gif" || $tipoDeArchivo == "png" || $tipoDeArchivo == "jpeg")
        {
            if($foto["size"] <= 1000000)
            {
                move_uploaded_file($foto["tmp_name"],$pathDestino);
                $producto->pathFoto = $pathDestino;
                $flag = true;
            }
        }

        if($flag)
        {
            $producto->pathFoto =  "../backend/productos/imagenes/".$nombreArchivo;
            if($producto->Agregar())
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
    else
    {
        $rta->bool = false;
        $rta->mensaje = "Tiene que agregar una foto.";
    }

    echo json_encode($retornoJSON);

?>