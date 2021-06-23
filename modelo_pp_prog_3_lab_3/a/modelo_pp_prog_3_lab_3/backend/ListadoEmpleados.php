<?php
    include_once("./clases/empleado.php");
    
    $tabla = isset($_POST["tabla"]) ? $_POST["tabla"] : 0;

    if($tabla != "mostrar")
    {
        echo json_encode(Empleado::TraerTodos());
    }
    else
    {
        $array = Empleado::TraerTodos();
        echo "<table>
                <tr>
                    <td>
                        ID
                    </td>
                    <td>
                        NOMBRE
                    </td>
                    <td>
                        CORREO
                    </td>
                    <td>
                        DESCRIPCION
                    </td>
                    <td>
                        SUELDO
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
                        $item->correo
                    </td>
                    <td>
                        $item->descripcion
                    </td>
                    <td>
                        $item->sueldo
                    </td>
                    <td>
                        <img src=$item->foto alt=fotoEmpleado width=50px height=50px>
                    </td>
                    </tr>";
                }
    }
?>

