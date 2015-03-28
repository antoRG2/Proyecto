<?php
	require_once $_SERVER['DOCUMENT_ROOT'].'/Sistema/modulos/login/modelo/sesion.php';
	require_once '../modelo/clase.configuracion.php';
	
	$objConf = new Configuracion;
	$objConf -> _QUERY();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8" />
    <title>Sistema</title>
	    <link rel="stylesheet" type="text/css" href="../../../CSS/menu.css">
        <link rel="stylesheet" type="text/css" href="../../../CSS/site.css">
	    <link rel="stylesheet" type="text/css" href="../../../CSS/listarConfiguraciones.css">
	    <link rel="stylesheet" type="text/css" href="../../../js/dataTables/css/jquery.dataTables.css">
    
    
    <script  src="../../../js/jquery.js"></script>
    <script  src="../../../js/jquery.ui.js"></script>
    <script  src="../../../js/menu.js"></script>
    <script  src="../../../js/dataTables/js/jquery.dataTables.js"></script>
    <script  src="../../../js/listarConfiguraciones.js"></script>
</head>
<body>
<?php require_once '../../interfaz.menu.php';?>
<br />
<div class="transBack">
	<div class="displayData">
			<div class="title">
				<h2>Configuraciones</h2>
			</div>	

		<br />
				<br />
				<div class="displayTable">
						<table id="tlistado" border="1" cellpadding="0" cellspacing="0">
						<thead>
							<tr>
								<th>Nombre</th>
								<th>Descripci&oacute;n</th>
								<th colspan="2">Acci&oacute;n</th>
							</tr>
							<tr class='delete'>
							    <th>&nbsp;</th> <!-- column 2 -->
							    <th>&nbsp;</th> <!-- column 3 -->
							    <th>&nbsp;</th> <!-- column 4 -->
							     <th>&nbsp;</th> <!-- column 4 -->
							 </tr>
					</thead>
					<tbody>
					<?php for($i = 0; $i < $objConf -> get_Contador(); $i++){?>
						<tr>
							<td><?=$objConf -> get_Nombre($i,"HTML")?></td>
							<td><?=$objConf -> get_Descripcion($i,"HTML")?></td>
							<td><?php if($objConf -> get_UsuarioID($i) !== $usuario_id){?>
							<a href="interfaz.modificar.php?ConfID=<?=$objConf -> get_ID($i)?>" title="Editar Configuracion"><img src="../../../CSS/img/Editar.png" /></a></td>
							<?php }else{?> No se puede modidicar la configuraci&oacute;n <?php }?>
							<td><?php if($objConf -> get_UsuarioID($i) !== $usuario_id){?>
							<a href="javascript:Eliminar(<?=$objConf -> get_ID($i)?>);" title="Eliminar Configuracion"><img src="../../../CSS/img/Eliminar.png" /></a></td>
							<?php }else{?> No se puede eliminar la configuraci&oacute;n <?php }?>
							</tr>
						<?php }?>
						</tbody>
					</table>
					<br />
						<a href="interfaz.agregar.php" title="Crear Configuraci&oacute;n"><img src="../../../CSS/img/Nuevo.png"/><p>Agregar Configuraci&oacute;n</p></a>
					</div>
				</div>
	</div>
</div>
</body>
</html>