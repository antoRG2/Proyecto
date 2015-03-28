<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/Sistema/modulos/login/modelo/sesion.php';
require_once '../../areaConocimiento/modelo/clase.areaC.php';
$objArea = new AreaC;
$objArea -> _QUERY();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8" />
    <title>Sistema</title>
    <link rel="stylesheet" type="text/css" href="../../../CSS/menu.css">
    <link rel="stylesheet" type="text/css" href="../../../CSS/site.css">
   <link rel="stylesheet" type="text/css" href="../../../CSS/Elementos de Prueba/agregarAreaConocimiento.css">
    
    <script  src="../../../js/jquery.js"></script>
    <script  src="../../../js/jquery.ui.js"></script>
    <script  src="../../../js/menu.js"></script>
    <script  src="../../../js/areasC.js"></script>
</head>
<body>
<?php require_once '../../interfaz.menu.php';?>
<br />
<div class="transBack">
	<div class="displayData">
		<div class="title">
				<h2>&Aacute;reas de Conocimiento</h2>
		</div>
	
		<br />
		<form name="FRMARC" id="FRMARC" method="post" action="../modelo/control.areaC.php">
			<table>
				<tr>
					<td><label for='areaC'>&Aacute;rea de Conocimiento:</label></td>
					<td><?=$objArea -> _HTML_SELECT()?></td>
				</tr>
				<tr>
					<td><label for="nombre">Nombre:</label></td>
					<td><input type="text" name="nombre" id="nombre" /></td>
				</tr>
				
			<br />
			<center>
				<input type="button" name="btnGuardar" id="btnGuardar" value='Guardar'/>
				<input style="display: none" type="button" name="btnEliminar" id="btnEliminar" value='Eliminar'/>
			</center>
		</form>
	</div>
</div>
</body>
</html>