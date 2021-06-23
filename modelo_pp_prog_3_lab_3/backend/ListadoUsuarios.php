<?php
    include_once("./clases/Usuario.php");
    
    $tabla = isset($_POST["tabla"]) ? $_POST["tabla"] : 0;

    if($tabla != "mostrar")
    {
        echo json_encode(Usuario::TraerTodos());
    }
    else
    {
        $array = Usuario::TraerTodos();
        echo "<table>
                <tr>
                    <td>
                        ID
                    </td>
                    <td>
                        CORREO
                    </td>
                    <td>
                        PERFIL
                    </td>
                    <td>
                        DESCRIPCION
                    </td>
                </tr>";

        foreach($array as $item)
        {
            echo "<tr>
                    <td>
                        $item->id
                    </td>
                    <td>
                        $item->correo
                    </td>
                    <td>
                        $item->perfil
                    </td>
                    <td>
                        $item->descripcion
                    </td>
                  </tr>";
        }
    }
?>