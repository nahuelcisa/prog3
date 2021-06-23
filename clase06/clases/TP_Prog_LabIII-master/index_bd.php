<?php
    require_once("./backendBD/empleado.php");
    require_once("./backendBD/validarSesion_bd.php");
    require_once('./backendBD/fabrica_bd.php');
    
    $apellido= null;
    $nombre= null;
    $sexo= null;
    $legajo= null;
    $sueldo= null;
    $turno= null;
    $foto= null;
    $dni = isset($_POST["dni"]) ? $_POST["dni"] : NULL;
    
    if($dni != null)
    {
        $path="./archivos/empleados.txt";
        $fabrica = new Fabrica(".",7);
        $fabrica->TraerDeBaseDeDatos();
        $empleadoaModificar=null;
    
        foreach($fabrica->GetEmpleados() as $item)
        {
            if($item->GetDni() == $dni)
            {
                $empleadoaModificar = $item;
                $apellido=$empleadoaModificar->GetApellido();
                $nombre=$empleadoaModificar->GetNombre();
                $sexo=$empleadoaModificar->GetSexo();
                $legajo=$empleadoaModificar->GetLegajo();
                $sueldo=$empleadoaModificar->GetSueldo();
                $turno=$empleadoaModificar->GetTurno();
                break;
            }
        }
    }
?>

<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <script type="text/javascript" src="./javascript/funcionesBD.js"></script>
        <?php 
        if($dni != 0)
        {
            echo "<title>HTML 5 Formulario Modificar Empleado</title>";
        }
        else
        {
            echo "<title>HTML 5 - Formulario Alta Empleado</title>";
        }
        ?>
    <script src="./javascript/funciones.js"></script>
</head>
<body>
    <?php
        ValidarSesion("./login_bd.html");
        if($dni != 0)
        {
            echo "<h2>Modificar Empleado</h2>";
        }
        else
        {
            echo "<h2>Alta de Empleado</h2>";
        }
    ?>
    <table align="center">
        <form action="./backend/administracion.php" method="POST" enctype="multipart/form-data">

            <tr>
                <th style="text-align:left;padding-left:15px" colspan="2">
                    <h4>Datos personales</h4>
                </th>
                <tr>
                    <td style="text-align:left;padding-left:15px" colspan="2"><hr></td>
                </tr>
            </tr>
            <tr>
                <td style="text-align:left;padding-left:15px" >DNI: </td>
                <td style="text-align:left;padding-left:15px">
                    <input type="number" name="txtDni" id="txtDni" min="1000000" 
                    value=<?php echo $dni; if($dni != null) echo " readonly"?>>
                    <span id="spanTxtDni" style= display:none>*</span>
                </td>
            </tr>
            <tr>
                <td style="text-align:left;padding-left:15px">Apellido: </td>
                <td style="text-align:left;padding-left:15px">
                    <input type="text" name="txtApellido" id="txtApellido"
                    value=<?php echo $apellido?>
                    >
                    <span id="spanTxtApellido" style= display:none>*</span>
                </td>
            </tr>
            <tr>
                <td style="text-align:left;padding-left:15px">Nombre: </td>
                <td style="text-align:left;padding-left:15px">
                    <input type="text" name="txtNombre" id="txtNombre"
                    value=<?php echo $nombre?>
                    >
                    <span id="spanTxtNombre" style= display:none>*</span>
                </td>
            </tr>
            <tr>
                <td style="text-align:left;padding-left:15px">Sexo: </td>
                <td style="text-align:left;padding-left:15px">
                    <select name="cboSexo" id="cboSexo">
                        <option value="---">Seleccione</option>
                        <option value="F" 
                        <?php echo ($sexo == "F") ? "selected" : "";?>
                        >Femenino</option>
                        <option value="M"
                        <?php echo ($sexo == "M") ? "selected" : "";?>
                        >Masculino</option>
                    </select>
                    <span id="spanCboSexo" style= display:none>*</span>
                </td>
            </tr>
            <tr>
                <th style="text-align:left;padding-left:15px" colspan="2">
                    <h4>Datos laborales</h4>
                </th>
            </tr>
            <tr>
                <td style="text-align:left;padding-left:15px" colspan="2">
                    <hr>
                </td>
            </tr>
            <tr>
                <td style="text-align:left;padding-left:15px">Legajo: </td>
                <td style="text-align:left;padding-left:15px">
                    <input type="number" name="txtLegajo" id="txtLegajo" min="100"
                    value=<?php echo $legajo; if($dni != null) echo " readonly"?>
                    >
                    <span id="spanTxtLegajo" style= display:none>*</span>
                </td>
            </tr>
            <tr>
                <td style="text-align:left;padding-left:15px">Sueldo: </td>
                <td style="text-align:left;padding-left:15px">
                    <input type="number" step="500" name="txtSueldo" id="txtSueldo"
                    value=<?php echo $sueldo?>
                    >
                    <span id="spanTxtSueldo" style= display:none>*</span>
                </td>
            </tr>
            <tr>
                <td style="text-align:left;padding-left:15px">Turno: </td>
            </tr>
            <tr>
                <td style="text-align:left;padding-left:60px">
                    <input type="radio" name="rdoTurno" value="0" 
                    <?php echo ($turno == "M") ? "checked" : "";?>
                    checked>
                </td>
                <td>Mañana</td>
            </tr>
            <tr>
                <td style="text-align:left;padding-left:60px">
                    <input type="radio" name="rdoTurno" value="1"
                    <?php echo ($turno == "T") ? "checked" : "";?>
                    >
                </td>
                <td>Tarde</td>
            </tr>
            <tr>
                <td style="text-align:left;padding-left:60px">
                    <input type="radio" name="rdoTurno" value="2"
                    <?php echo ($turno == "N") ? "checked" : "";?>
                    >
                </td>
                <td>Noche</td>
            </tr>
            <tr>
                <td style="text-align:left;padding-left:15px">Foto:</td>
                <td style="text-align:left;padding-left:15px">
                    <input type="file" name="file" id="file">
                    <span id="spanFile" style= display:none>*</span>
                    <input type="hidden" name="hdnModificar" id="hdnModificar" value=<?php echo ($dni != null) ? "ok" : "no"?>>
                </td>
            </tr>
            <tr>
                <td style="text-align:left;padding-left:15px" colspan="2">
                    <hr>
                </td>
            </tr>
            <tr>
                <td colspan="2" align="right">
                    <input type="reset" value="Limpiar">
                </td>
            </tr>
            <tr>
                <td colspan="2" align="right">
                    <input type="submit" onclick="AdministrarValidacionesBD(event)" name="btnEnviar" id="btnEnviar" value=<?php echo ($dni != null) ? "Modificar" : "Enviar";?>>
                </td>
            </tr>
        </form>
    </table>
</body>
</html>