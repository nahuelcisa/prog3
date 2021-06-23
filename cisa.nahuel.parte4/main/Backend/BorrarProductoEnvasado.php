<?php

    require_once ("./clases/ProductoEnvasado.php");

    $obj_producto = isset($_POST['obj_producto']) ? $_POST['obj_producto'] : NULL;
    $get = isset($_GET["get"]) ? $_GET["get"] : NULL;
    $obj = json_decode($obj_producto);

    $producto = new ProductoEnvasado($obj->id,$obj->codigo_barra,$obj->precio,$obj->pathFoto,$obj->nombre,$obj->origen);
    $retornoJSON = new stdClass();
    $retornoJSON->exito = false;
    $retornoJSON->mensaje = "error al eliminar";

    if($producto->Eliminar($producto->id))
    {
        $producto->GuardarEnArchivo();
        $retornoJSON->exito = true;
        $retornoJSON->mensaje = "producto eliminado con exito";
    }
    else if ($get == "")
    {
        echo "<table>
            <tr>
                <td>
                    ID
                </td>
                <td>
                    CODIGO_BARRA
                </td>
                <td>
                    NOMBRE
                </td>
                <td>
                    ORIGEN
                </td>
                <td>
                    PRECIO
                </td>
                <td>
                    FOTO
                </td>
            </tr>";
            
            $nombreArchivo = "./archivos/productos_envasados_borrados.txt";
            if(file_exists($nombreArchivo))
            {
                $archivo = fopen($nombreArchivo,"r");
                
                if(filesize($nombreArchivo))
                {
                    while (!feof($archivo)){
                    
                        $linea = fgets($archivo);
                        $linea = is_string($linea) ? trim($linea) : false;
                        $array = explode(" - ",$linea);
                        echo "<tr>
                            <td>
                                $array[0];
                            </td>
                            <td>
                                $array[1];
                            </td>
                            <td>
                                $array[2];
                            </td>
                            <td>
                                $array[3]
                            </td>
                            <td>
                                $array[4]
                            </td>
                            <td>
                                <img src=$array[5] alt=fotoProducto width=50px height=50px>
                            </td>
                        </tr>";
    
                    }

                    echo "</table>";
                    fclose($archivo); 
                    
                }
                        
            }     
    }

    echo json_encode($retornoJSON);

?>