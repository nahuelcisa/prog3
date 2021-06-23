<?php

    require_once ('../vendor/autoload.php');
    require_once ("fabrica_bd.php");
    include_once ("../backendBD/validarSesion_bd.php");

    header('content-type:application/pdf');

    $mpdf = new \Mpdf\Mpdf(['orientation' => 'P', 
                            'pagenumPrefix' => 'Página nro. ',
                            'pagenumSuffix' => ' - ',
                            'nbpgPrefix' => ' de ',
                            'nbpgSuffix' => ' páginas']);

    $mpdf->SetProtection(array(), $_SESSION["DNIEmpleadoBD"], 'MyPassword');

    $mpdf->SetHeader('{PAGENO}{nbpg}');
    $mpdf->setFooter('{PAGENO}');

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
                            <td><img src='{$item->GetPathFoto()}' width='50px' height='50px'/></td>
                          </tr>";
        }
            $empleados .= "</table>";

    }
    $mpdf->WriteHTML("Alumno: Cisa Nahuel");
    $mpdf->WriteHTML("Ingreso sesion con: " . $_SESSION["DNIEmpleadoBD"]);


    $mpdf->WriteHTML($empleados);

    $mpdf->Output('mi_pdf.pdf', 'I');

?>
