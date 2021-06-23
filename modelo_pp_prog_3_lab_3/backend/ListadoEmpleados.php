<?php

    require_once ("./clases/Empleado.php");

    $tabla = isset($_GET["tabla"]) ? $_GET["tabla"] : NULL;


    $array = Empleado::TraerTodos();

    if($tabla == "mostrar")
    {
        echo "<table>
            <thead>
                <tr>
                    <th>Correo</th>
                    <th>Clave</th>
                    <th>Descripcion</th>
                    <th>Sueldo</th>
                    <th>Foto</th>
                </tr>
            </thead>";
                foreach($array as $item){
                    echo "
                    <tr>
                        <td>$item->nombre</td>
                        <td>$item->correo</td>                       
                        <td>$item->descripcion</td>
                        <td>$item->sueldo</td>
                        <td><img src=$item->foto width=50px height=50px></td>
                    </tr> ";
                }                            
       echo "</table>";
    }else
    {
        echo json_encode($array);
    }

?>