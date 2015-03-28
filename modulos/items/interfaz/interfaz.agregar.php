<?php
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
    <link rel="stylesheet" type="text/css" href="../../../CSS/Elementos de Prueba/crearItems.css"
    <link rel="stylesheet" type="text/css" href="../../../CSS/jquery.ui.css">    
    
    <script  src="../../../js/jquery.js"></script>
    <script  src="../../../js/jquery.ui.js"></script>
    <script  src="../../../js/menu.js"></script>
    <script  src="../../../js/agregarItems.js"></script>
</head>
<body>
<?php require_once '../../interfaz.menu.php';?>
<br />
<div class="transBack">
	<div class="displayData">
		<div class="title">
			<h2>Agregar Items</h2>
		</div>
		<br />
		<form name="FRMItems" id="FRMItems" method="post" action="../modelo/control.item.php">
			<table>
				<tr>
					<td><label for="nombre">Nombre:</label></td>
					<td><input type="text" name="nombre" id="nombre" style="width: 500px;" /></td>
				</tr>
				<tr>
					<td><label for="dificultad">Dificultad:</label></td>
					<td><select name="dificultad" id="dificultad">
						<option value="0" selected>...</option>
						<option value="1">F&aacute;cil</option>
						<option value="2">Medio</option>
						<option value="3">Dificil</option>
					</select></td>
				</tr>
				<tr>
					<td><label for="tipo">Tipo:</label></td>
					<td><select name="tipo" id="tipo" class="scheck">
						<option value="0" selected>...</option>
						<option value="1">Seleci&oacute;n &Uacute;nica</option>
						<option value="2">Drag / Drop</option>
					</select></td>
				</tr>
				<tr>
					<td><label for="clasificacion">Clasificaci&oacute;n:</label></td>
					<td><select name="clasificacion" id="clasificacion" class="scheck">
						<option value="0" selected>...</option>
						<option value="1">Imagenes</option>
						<option value="2">Texto</option>
						<option value="3">Audio</option>
					</select></td>
				</tr>
				<tr>
					<td><label for="tEnunciado">Tipo Enunciado:</label></td>
					<td><select name="tEnunciado" id="tEnunciado">
						<option value="0" selected>...</option>
						<option value="1">Imagenes</option>
						<option value="2">Texto</option>
						<option value="3">Audio</option>
					</select></td>
				</tr>
				<tr>
					<td><label>Enunciado:</label></td>
					<td id='tdEnunciado1' style="display: none"><input type="file" name='enunciadoImg' id='enunciadoImg'/></td>
					<td id='tdEnunciado2' style="display: none; width: 500px;"><input type="text" name='enunciadoTxt' id='enunciadoTxt'/></td>
					<td id='tdEnunciado3' style="display: none"><input type="file" name='enunciadoAudio' id='enunciadoAudio'/></td>
				</tr>
				<tr>
					<td><label for="descripcion">Descripci&oacute;n:</label></td>
					<td><textarea id="descripcion" name="descripcion" style="width: 500px;height: 66px;"></textarea></td>
				</tr>
				<tr>
					<td><label for='areaC'>&Aacute;rea de Conocimiento:</label></td>
					<td><?=$objArea -> _HTML_SELECT()?></td>
				</tr>
				<tr>
					<td><label for="nRespuestas">Cantidad de Respuestas:</label></td>
					<td><input type='text' readonly size='2' value="2"  style="width:20px" id='nRespuestas' name="nRespuestas"/></td>
				</tr>
			</table>
			<br />
			<div id="areaRespuestas"></div>
			<br />
			<center>
				<div id="controlbuttonsDiv">
					<div class="controlbuttons"><input type="button" name="btnCancelar" id="btnCancelar" value='Cancelar'/></div>
					<div class="controlbuttons"><input type="button" name="btnGuardar"  id="btnGuardar" value='Guardar'/></div>					
				</div>
			</center>
		</form>
	</div>
</div>
</body>
</html>