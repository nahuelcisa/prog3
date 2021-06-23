<?php
    include_once("./clases/ProductoEnvasado.php");

    $codigoBarra = isset($_POST["codigoBarra"]) ? $_POST["codigoBarra"] : 0;
    $nombre = isset($_POST["nombre"]) ? $_POST["nombre"] : 0;
    $origen = isset($_POST["origen"]) ? $_POST["origen"] : 0;
    $precio = isset($_POST["precio"]) ? $_POST["precio"] : 0;
    $foto = isset($_FILES["foto"]) ? $_FILES["foto"] : 0;

    $producto = new ProductoEnvasado($nombre, $origen, 0, $codigoBarra,$precio);
    $retornoJSON = new stdClass();

    if($producto->Existe(ProductoEnvasado::Traer()))
    {
        $retornoJSON->exito = false;
        $retornoJSON->mensaje = "El producto ya existe en la base de datos";
    }
    else
    {
        $pathDestino = "productos/imagenes/" . $foto["name"];
        $flag = false;
        if(getimagesize($foto["tmp_name"]) != FALSE)
        {
            $tipoDeArchivo = pathinfo($pathDestino,PATHINFO_EXTENSION);
            $nombreArchivo = $producto->nombre . "." . $producto->origen . "." . date("G") . date("i") . date("s");
            $pathDestino = "productos/imagenes/" . $nombreArchivo . "." . $tipoDeArchivo;
            
    
            if($tipoDeArchivo == "jpg" || $tipoDeArchivo == "bmp" || $tipoDeArchivo == "gif" || $tipoDeArchivo == "png" || $tipoDeArchivo == "jpeg")
            {
                if($foto["size"] <= 1000000)
                {
                    move_uploaded_file($foto["tmp_name"],$pathDestino);
                    $pathDestino = "productos/imagenes/" . $nombreArchivo . "." . $tipoDeArchivo;
                    $producto->pathFoto = $pathDestino;
                    $flag = true;
                }
            }
        }
    
        if($flag)
        {
            if($producto->Agregar())
            {
                $retornoJSON->exito = true;
                $retornoJSON->mensaje = "El producto fue agregado correctamente a la base de datos";
            }
        }
        else
        {
            $retornoJSON->exito = false;
            $retornoJSON->mensaje = "La imagen no es correcta";
        }
    }

    echo json_encode($retornoJSON);  
?>