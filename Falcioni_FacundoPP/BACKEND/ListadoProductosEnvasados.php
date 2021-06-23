<?php
    include_once("./clases/ProductoEnvasado.php");
    
    $tabla = isset($_GET["tabla"]) ? $_GET["tabla"] : 0;

    if($tabla != "mostrar")
    {
        echo json_encode(ProductoEnvasado::Traer());
    }
    else
    {
        $array = ProductoEnvasado::Traer();
        echo "<table>
                <tr>
                    <td>
                        ID
                    </td>
                    <td>
                        NOMBRE
                    </td>
                    <td>
                        CODIGO BARRA
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

        foreach($array as $item)
        {
            echo "<tr>
                    <td>
                        $item->id
                    </td>
                    <td>
                        $item->nombre
                    </td>
                    <td>
                        $item->codigoBarra
                    </td>
                    <td>
                        $item->origen
                    </td>
                    <td>
                        $item->precio
                    </td>
                    <td>
                        $item->pathFoto
                    </td>
                  </tr>";
        }
    }
?>