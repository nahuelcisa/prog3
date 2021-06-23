<?php

    require_once ("./clases/Televisor.php");

    $teles = Televisor::Traer();

        echo "<table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>tipo</th>
                    <th>precio</th>
                    <th>paisOrigen</th>
                    <th>Path</th>
                    <th>Precio IVA</th>
                </tr>
            </thead>";
                foreach($teles as $item){
                    echo "
                    <tr>
                        <td>$item->id</td>
                        <td>$item->tipo</td>                       
                        <td>$item->precio</td>
                        <td>$item->paisOrigen</td>
                        <td><img src=$item->path width=50px height=50px></td>
                        <td>{$item->CalcularIVA()}</td>
                    </tr> ";
                }                            
       echo "</table>";

?>