<?php
    require_once "clases/ProductoEnvasado.php";

    $arrayFotos = ProductoEnvasado::MostrarModificados();
    echo "<table>";
    foreach($arrayFotos as $foto)
    {
        echo "<tr>
            <td>
                <img src= ../backend/productos/productosModificados/$foto alt=fotoProd width=50px height=50px>
            </td>
            </tr>";
    }
    echo "</table>";

?>