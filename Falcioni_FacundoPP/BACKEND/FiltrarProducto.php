<?php

    require_once "clases/ProductoEnvasado.php";

    $origen = isset($_POST["origen"]) ? $_POST["origen"] : "";
    $nombre = isset($_POST["nombre"]) ? $_POST["nombre"] : "";

    $arrayProductos = ProductoEnvasado::Traer();

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
                PRECIO
            </td>
            <td>
                CODIGO DE BARRA
            </td>
            <td>
                FOTO
            </td>
            </tr>";

    if($origen != "" && $nombre == "") // Si origen es recibido pero no nombre
    {  
        
        foreach($arrayProductos as $item)
        {
            if($item->origen == $origen)
            {
                echo "<tr>
                        <td>
                            $item->id
                        </td>
                        <td>
                            $item->nombre
                        </td>
                        <td>
                            $item->origen
                        </td>
                        <td>
                            $item->precio
                        </td>
                        <td>
                            $item->codigoBarra
                        </td>
                        <td>
                            <img src=./BACKEND/{$item->pathFoto} alt=fotoProducto height=100px widht=100px/>
                        </td>
                        </tr>";
            }
        }

    }
    else if($origen == "" && $nombre != "")
    {
         
        foreach($arrayProductos as $item)
        {
            if($item->nombre == $nombre)
            {
                echo "<tr>
                        <td>
                            $item->id
                        </td>
                        <td>
                            $item->nombre
                        </td>
                        <td>
                            $item->origen
                        </td>
                        <td>
                            $item->precio
                        </td>
                        <td>
                            $item->codigoBarra
                        </tr>";
            }
        }

    }
    else if($nombre != "" && $origen != "")
    {
                       
        foreach($arrayProductos as $item)
        {
            if($item->nombre == $nombre && $item->origen == $origen)
            {
                echo "<tr>
                        <td>
                            $item->id
                        </td>
                        <td>
                            $item->nombre
                        </td>
                        <td>
                            $item->origen
                        </td>
                        <td>
                            $item->precio
                        </td>
                        <td>
                            $item->codigoBarra
                        </td>
                        </tr>";
            }
        }
    }
?>