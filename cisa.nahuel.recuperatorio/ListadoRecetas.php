<?php

    require_once ("./clases/Receta.php");

    $recetas = Receta::Traer();

    echo "<table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>nombre</th>
                    <th>ingredientes</th>
                    <th>tipo</th>
                    <th>foto</th>
                </tr>
            </thead>";
                foreach($recetas as $item){
                    echo "
                    <tr>
                        <td>$item->id</td>
                        <td>$item->nombre</td>                       
                        <td>$item->ingredientes</td>
                        <td>$item->tipo</td>
                        <td><img src=$item->pathFoto width=50px height=50px></td>
                    </tr> ";
                }                            
       echo "</table>";

?>