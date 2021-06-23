<?php

    require_once "./clases/ProductoEnvasado.php";
    $origen= isset($_POST["origen"]) ? $_POST["origen"] : "";
    $nombre= isset($_POST["nombre"]) ? $_POST["nombre"] : "";

    $array = ProductoEnvasado::Traer();
    

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


    if($nombre != "" && $origen != "")
    {
        foreach($array as $item)
        {
            if($nombre == $item->nombre && $origen == $item->origen)
            {
                echo "<tr>
                            <td>
                                $item->id
                            </td>
                            <td>
                                $item->codigo_barra
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
                                <img src=$item->pathFoto alt=fotoProducto width=50px height=50px>
                            </td>
                        </tr>";
            }
        }
    }
    else
    {
        if($origen != "")
        {
            foreach($array as $item)
            {
                if($origen == $item->origen)
                {
                    echo "<tr>
                                <td>
                                    $item->id
                                </td>
                                <td>
                                    $item->codigo_barra
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
                                    <img src=$item->pathFoto alt=fotoProducto width=50px height=50px>
                                </td>
                            </tr>";
                }
            }
        }
        else
        {
            if($nombre != "")
            {
                foreach($array as $item)
                {
                    if($nombre == $item->nombre)
                    {
                        echo "<tr>
                                    <td>
                                        $item->id
                                    </td>
                                    <td>
                                        $item->codigo_barra
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
                                        <img src=$item->pathFoto alt=fotoProducto width=50px height=50px>
                                    </td>
                                </tr>";
                    }
                }
            }
        }
    }

    echo "</table>";
?>