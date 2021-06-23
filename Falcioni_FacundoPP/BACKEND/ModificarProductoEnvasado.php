<?php
    require_once("./clases/ProductoEnvasado.php");

    $json = isset($_POST["producto_json"]) ? $_POST["producto_json"] : 0;

    $obj = json_decode($json);
    $producto = new ProductoEnvasado($obj->nombre, $obj->origen, $obj->id, $obj->codigoBarra,$obj->precio);
    $retornoJSON = new stdClass();

    $flag = false;
    $array = ProductoEnvasado::Traer();

    foreach($array as $item)
    {
        if($item->id == $producto->id)
        {
            $flag = true;
        }
    }

    if(!$flag)
    {
        $retornoJSON->exito = false;
        $retornoJSON->mensaje = "El producto no existe en la base de datos";
    }
    else
    {    
        if($producto->Modificar())
        {
            $retornoJSON->exito = true;
            $retornoJSON->mensaje = "El producto fue modificado correctamente";
        }
        else
        {
            $retornoJSON->exito = false;
            $retornoJSON->mensaje = "El producto no fue modificado";
        }
    }

    echo json_encode($retornoJSON);

   
?>
?>