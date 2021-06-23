<?php
    require_once ("./clases/Usuario.php");

    $accion = isset($_GET["accion"]) ? $_GET["accion"] : NULL;
    $tabla = isset($_GET["tabla"]) ? $_GET["tabla"] : NULL;

    $array = Usuario::TraerTodos();

    if($tabla == "mostrar")
    {
        echo "<table>
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Correo</th>
                    <th>Descripcion</th>
                </tr>
            </thead>";
                foreach($array as $item){
                    echo "
                    <tr>
                        <th>$item->nombre</th>
                        <th>$item->correo</th>                       
                        <th>$item->descripcion</th>
                    </tr> ";
                }                            
       echo "</table>";
    }else
    {
        echo json_encode($array);
    }
?>