<?php
    include_once("./clases/ProductoEnvasado.php");

    $producto_json = isset($_POST["producto_json"]) ? $_POST["producto_json"] : 0;
    $getSinParametros = isset($_GET["sinParams"]) ? $_GET["sinParams"] : 0;

    if(!$producto_json)
    {
        echo "<table>
            <tr>
                <td>
                    ID
                </td>
                <td>
                    NOMBRE
                </td>
                <td>
                    ORIGEN
                </td>
                <td>
                    CODIGO BARRA
                </td>
                <td>
                    PRECIO
                </td>
                <td>
                    FOTO
                </td>
                </tr>";
        
            if(!file_exists("./archivos/productos_envasados_borrados.txt"))
            {
                $archivo = fopen("./archivos/productos_envasados_borrados.txt", "w");
                fclose($archivo);
            }

            $archivo = fopen("./archivos/productos_envasados_borrados.txt", "r");
            
            do
            {
                $cadena = fgets($archivo);
                $cadena = is_string($cadena) ? trim($cadena) : false;
                if($cadena != false)
                {
                    $arr = explode(" - ", $cadena);
                    if($arr[0] != "" && $arr[0] != "\r\n")
                    {   
                        $producto = new ProductoEnvasado($arr[1],$arr[2],$arr[0],$arr[3],$arr[4],$arr[5]);
                        echo "<table>
                                <tr>
                                    <td>
                                        $producto->id
                                    </td>
                                    <td>
                                        $producto->nombre
                                    </td>
                                    <td>
                                        $producto->origen
                                    </td>
                                    <td>
                                        $producto->codigoBarra
                                    </td>
                                    <td>
                                        $producto->precio
                                    </td>
                                    <td>
                                        <img src=$producto->pathFoto alt=fotoProductoBorrada widht=100px height=100px/>
                                    </td>
                                </tr>";
                    }
                }
                
            }while(!feof($archivo));

            fclose($archivo);

    }
    else
    {
        $obj = json_decode($producto_json);
    
        $producto = new ProductoEnvasado($obj->nombre, $obj->origen, $obj->id, $obj->codigoBarra, $obj->precio, $obj->pathFoto);
        $retornoJSON = new stdClass();

        if(ProductoEnvasado::Eliminar($obj->id))
        {
            $producto->GuardarEnArchivo();
            $retornoJSON->exito = true;
            $retornoJSON->mensaje = "Producto eliminado con exito";
        }
        else
        {
            $retornoJSON->exito = false;
            $retornoJSON->mensaje = "El producto no pudo ser eliminado";
        }

        echo json_encode($retornoJSON);
    }
?>