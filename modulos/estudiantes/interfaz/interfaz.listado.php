<?php
	require_once $_SERVER['DOCUMENT_ROOT'].'/Sistema/modulos/login/modelo/sesion.php';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8" />
    <title>Sistema</title>
</head>
<body>
<?php require_once '../../interfaz.menu.php';?>
<br />
<div class="transBack">
	<div class="displayData">
		<div class="title">
				<h2>Estudiantes</h2>
		</div>	
		<br />
		<br />
		<div class="displayTable">
			<table>
				<tr>
					<td><label for="bcedula">C&eacute;dula:</label></td>
					<td><input type="text" name="bcedula" id="bcedula"/></td>
				</tr>
			</table>		
		</div>
	</div>
</div>
</body>
</html>