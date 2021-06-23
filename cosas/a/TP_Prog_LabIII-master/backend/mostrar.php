<?php
    require_once("fabrica.php");
    include_once("validarSesion.php");
?>

    <?php
        ValidarSesion("../login.html");
        if(file_exists("../archivos/empleados.txt"))
        {
            $path = "../archivos/empleados.txt";
        }

        $archivo = fopen($path,"r");
        $fabrica = new Fabrica(".", 7);
        $fabrica->TraerDeArchivo($path);
        $arrEmpleados = $fabrica->GetEmpleados();
        $empleados = "";

        if(count($arrEmpleados) == 0)
        {
            echo "<tr>
                    <td style=text-align:left;padding-left:15px colspan=2>
                        No hay empleados para mostrar.
                    </td>
                  </tr>";
        }
        else
        {
                $empleados = '<table class="table">
                                <thead style="background:rgb(14, 26, 112);color:#fff;">
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
                                <td><img src='archivos/".$item->GetPathFoto()."' width='100px' height='100px'/></td>
                                <td>
                                    <input type=button value=Modificar class=MiBotonUTN id=btnModificar onclick=Main.ModificarEmpleado({$item->GetDni()})>
                                </td>
                                <td>
                                    <input type=button value=Eliminar class=MiBotonUTN id=btnEliminar onclick=Main.EliminarEmpleado({$item->GetLegajo()})
                                </td>
                              </tr>";
            }
                $empleados .= "</table>";

                echo $empleados;
        }

    ?>
