<?php 
#Cambiar luego por la página de seciones
	require_once $_SERVER['DOCUMENT_ROOT'].'/Sistema/modulos/login/modelo/sesion.php';

	require_once '../modelo/clase.areaC.php';
	
	$objAreaC = new AreaC;
	$objAreaC -> _QUERY();
?>
<!DOCTYPE html>
<html lang="es">
	<head>
	    <meta charset="utf-8" />
	    <title>Sistema</title>
	    <link rel="stylesheet" type="text/css" href="../../../CSS/menu.css">
        <link rel="stylesheet" type="text/css" href="../../../CSS/site.css">
	    <link rel="stylesheet" type="text/css" href="../../../CSS/Elementos de Prueba/listaItems.css">
	    <link rel="stylesheet" type="text/css" href="../../../js/dataTables/css/jquery.dataTables.css">
	   
	    <script  src="../../../js/jquery.js"></script>
	    <script  src="../../../js/menu.js"></script>
	    <script  src="../../../js/dataTables/js/jquery.dataTables.js"></script>
	    <script  src="../../../js/listarAreaC.js"></script>
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
				<div class="displayTable">
						<table id="tlistado" border="1" cellpadding="0" cellspacing="0">
						<thead>
							<tr>
								<th>Nombre</th>
								<th colspan="2">Acci&oacute;n</th>
							</tr>
							<tr class='delete'>
							    <th>&nbsp;</th> <!-- column 2 -->
							    <th>&nbsp;</th> <!-- column 3 -->
							    <th>&nbsp;</th> <!-- column 4 -->
							 </tr>
					</thead>
					<tbody>
					<?php for($i = 0; $i < $objAreaC -> get_Contador(); $i++){?>
						<tr id='<?=$objAreaC -> get_ID($i)?>'>
							<td><?=$objAreaC -> get_Nombre($i,"HTML")?></td>
							<td><a class='editar' title="Editar"><img src="../../../CSS/img/Editar.png" /></a></td>
							<td><a href="javascript:Eliminar(<?=$objAreaC -> get_ID($i)?>);" title="Eliminar"><img src="../../../CSS/img/Eliminar.png" /></a></td>

							</tr>
						<?php }?>
						</tbody>
					</table>
					<br />
					<a class='agregar' title="Agregar Item"><img src="../../../CSS/img/Nuevo.png"/><p>Agregar &Aacute;rea</p></a>
				</div>
			</div>
		</div>	
	</body>
</html>