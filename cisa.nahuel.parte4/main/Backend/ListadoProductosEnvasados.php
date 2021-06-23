<?php

    require_once ("./clases/ProductoEnvasado.php");

    $tabla = isset($_GET["tabla"]) ? $_GET["tabla"] : NULL;

    $productos = ProductoEnvasado::Traer();

    if($tabla == "mostrar")
    {
        echo "<table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Codigo_Barra</th>
                    <th>Nombre</th>
                    <th>Origen</th>
                    <th>Precio</th>
                    <th>Foto</th>
                </tr>
            </thead>";
                foreach($productos as $item){
                    echo "
                    <tr>
                        <td>$item->id</td>
                        <td>$item->codigo_barra</td>                       
                        <td>$item->nombre</td>
                        <td>$item->origen</td>
                        <td>$item->precio</td>
                        <td><img src=$item->pathFoto width=50px height=50px></td>
                    </tr> ";
                }                            
       echo "</table>";
    }else
    {
        echo json_encode($productos);
    }

?>