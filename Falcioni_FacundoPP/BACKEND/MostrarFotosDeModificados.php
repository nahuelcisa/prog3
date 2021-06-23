<?php
    include_once("./clases/ProductoEnvasado.php");

    $arrayFotos = ProductoEnvasado::MostrarModificados();
    
    foreach($arrayFotos as $foto)
    {
        echo "<tr>
            <td>
                <img src= ./BACKEND/productosModificados/$foto alt=fotoProd width=50px height=50px>
            </td>
            </tr>";
    }
?>