<?php
    require_once("fabrica_bd.php");
    include_once("../backendBD/validarSesion_bd.php");
?>

    <?php
        ValidarSesion("../login_bd.html");
        $fabrica = new Fabrica(".", 7);
        $fabrica->TraerDeBaseDeDatos();
        $arrEmpleados = $fabrica->GetEmpleados();
        $empleados = "";

        if(count($arrEmpleados) == 0)
        {
            echo "<tr>
                    <td>
                        No hay empleados para mostrar.
                    </td>
                  </tr>";
        }
        else
        {
                $empleados = '<table class="table">
                                <thead>
                                    <tr>
                                        <th>  DNI </th>
                                        <th>  NOMBRE     </th>
                                        <th>  APELLIDO       </th>
                                        <th>  SEXO     </th>
                                        <th>  LEGAJO     </th>
                                        <th>  SUELDO     </th>
                                        <th>  TURNO     </th>
                                        <th>  FOTO     </th>
                                        <th colspan=2>  ACCION     </th>
                                    </tr> 
                                </thead>';
            foreach($fabrica->GetEmpleados() as $item)
            {
                $empleados .= "<tr>
                                <td>{$item->GetDni()}</td>
                                <td>{$item->GetNombre()}</td>
                                <td>{$item->GetApellido()}</td>
                                <td>{$item->GetSexo()}</td>
                                <td>{$item->GetLegajo()}</td>
                                <td>{$item->GetSueldo()}</td>
                                <td>{$item->GetTurno()}</td>
                                <td><img src='archivos/".$item->GetPathFoto()."' width='50px' height='50px'/></td>
                                <td>
                                    <input type=button value=Modificar class=MiBotonUTN id=btnModificar onclick=MainBD.ModificarEmpleadoBD({$item->GetDni()})>
                                </td>
                                <td>
                                    <input type=button value=Eliminar class=MiBotonUTN id=btnEliminar onclick=MainBD.EliminarEmpleadoBD({$item->GetLegajo()})
                                </td>
                              </tr>";
            }
                $empleados .= "</table>";

                echo $empleados;
        }

    ?>
