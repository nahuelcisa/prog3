<?php
	include_once("./backend/validarSesion.php");
	ValidarSesion("./login.html");
?>

<!doctype html>
<html>
<head>
	<title>ALTA DE EMPLEADOS CON AJAX</title>

	<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">

	<script type="text/javascript" src="./javascript/funciones.js"></script>
		
</head>
<body>
	<div class="container">
		<div class="page-header">
			<h1>EMPLEADOS CON AJAX</h1>      
		</div>
		<div class="CajaInicio animated bounceInRight" style="width:1100px">
			<h4 style="border:solid;padding:10px">Facundo Gabriel Falcioni</h4>
			<table>
				<tbody>
					<tr>
						<td width="95%">
							<div id="divFrm" style="height:500px;overflow:auto;border-style:solid">
						</td>
						<td rowspan="2">
							<div id="divEmpleados" style="height:500px;overflow:auto;border-style:solid">
							</div>
						</td>
					</tr>
				</tbody>
			</table>
			<h6 style="display:block;border:solid;padding:10px;">
			<a href="./backend/cerrarSesion.php">Cerrar sesion</a>
			</h6>
		</div>
	</div>
</body>
</html>