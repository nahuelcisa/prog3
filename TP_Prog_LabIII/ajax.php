<?php
	include_once("./backend/validarSesion.php");
	ValidarSesion("./login.html");
?>

<!doctype html>
<html>
<head>
	<title>ALTA DE EMPLEADOS ARCHIVOS</title>

	<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">

	<script type="text/javascript" src="./javascript/funciones.js"></script>
		
</head>
<body>
	<div class="container" style="width:auto; height:auto">
		<div class="page-header">
			<h1>ALTA DE EMPLEADOS ARCHIVOS</h1>      
		</div>
		<div>
			<h4 style="border:solid;padding:10px; font-size: 25px">CISA, Nahuel</h4>
			<table>
				<tbody>
					<tr>
						<td>
							<div id="divFrm" style="height:650px;width:800px;overflow:auto;border-style:solid">
						</td>
						<td>
							<div id="divEmpleados" style="height:650px;width:1090px;overflow:auto;border-style:solid">
							</div>
						</td>
					</tr>
				</tbody>
			</table>
			<h6 style="display:block;border:solid;padding:10px;width:500px; font-size:20px">
			<a href="./backend/cerrarSesion.php">Cerrar sesion</a>
			<a href="./login_bd.html" style="padding-left: 50px;">Login bases de datos</a>
			</h6>
		</div>
	</div>
</body>
</html>