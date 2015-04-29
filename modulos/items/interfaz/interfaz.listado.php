<!--//***********************************************************************//   
//                                                                           //
//                                                                           //       
//                                                                           //  
//                                                                           //
//                                                                           //
//                                                                           //
//                                                                           //
//                                                                           //   
//                                                                           //
//************************************************************************//-->

<?php 
	require_once $_SERVER['DOCUMENT_ROOT'].
        '/Sistema/modulos/login/modelo/sesion.php';
	require_once '../modelo/clase.item.php';
	
	$objItems = new Item;
	$objItems -> _QUERY();
?>
<!DOCTYPE html>
<html lang="es">
	<head>
	    <meta charset="utf-8" />
	    <title>Sistema</title>
	    <link rel="stylesheet" type="text/css" href="../../../CSS/menu.css">
        <link rel="stylesheet" type="text/css" href="../../../CSS/site.css">
	    <link rel="stylesheet" type="text/css" 
            href="../../../CSS/Elementos de Prueba/listaItems.css">
	    <link rel="stylesheet" type="text/css" 
            href="../../../js/dataTables/css/jquery.dataTables.css">
	    
	    
	    <script  src="../../../js/jquery.js"></script>
	    <script  src="../../../js/menu.js"></script>
	    <script  src="../../../js/dataTables/js/jquery.dataTables.js"></script>
	    <script  src="../../../js/listarItems.js"></script>
	</head>
	<body>
	<?php require_once '../../interfaz.menu.php';?>
	<br />
	<div class="transBack">
		<div class="displayData">
			<div class="title">
				<h2>Items</h2>
			</div>	
		
		<br />
				<div class="displayTable">
					<table id="tlistado" border="1" cellpadding="0" 
                            cellspacing="0">
						<thead>
							<tr>
								<th>Nombre</th>
								<th>Descripci&oacute;n</th>
								<th>Dificultad</th>
								<th>Tipo</th>
								<th>Clasificaci&oacute;n</th>
								<th>Enunciado</th>
								<th>&Aacute;rea de Conocimiento</th>
								<th colspan="2">Acci&oacute;n</th>
							</tr>
							<tr class='delete'>
							    <th>&nbsp;</th> <!-- column 1 -->
							    <th>&nbsp;</th> <!-- column 2 -->
							    <th>&nbsp;</th> <!-- column 3 -->
							    <th>&nbsp;</th> <!-- column 4 -->
							    <th>&nbsp;</th> <!-- column 5 -->
							    <th>&nbsp;</th> <!-- column 6 -->
							    <th>&nbsp;</th> <!-- column 7 -->
							    <th>&nbsp;</th> <!-- column 8 -->
							    <th>&nbsp;</th> <!-- column 9 -->
							 </tr>
					</thead>
					<tbody>
					    <?php for($i = 0; $i < $objItems -> get_Contador(); $i++){?>
						    <tr>
							    <td><?=$objItems -> get_Nombre($i,"HTML")?></td>
							    <td><?=$objItems -> get_Descripcion($i,"HTML")?></td>
							    <td><?=$objItems -> _TXTDIFICULTAD($objItems ->
                                get_Dificultad($i))?></td>
							    <td><?=$objItems -> _TXTTIPO($objItems -> 
                                get_Tipo($i))?></td>
							    <td><?=$objItems -> _TXTCLASIFICACION($objItems ->
                                get_Clasificacion($i))?></td>
							    <td><?=$objItems -> _TXTCLASIFICACION($objItems ->
                                get_Tipoenunciado($i))?></td>
							    <td><?=$objItems -> get_AreaConocimiento($i,"HTML")
                                ?></td>
							    <td><a href="interfaz.modificar.php?itemID=<?=$objItems
                                -> get_ID($i)?>" title="Editar Item">
                                    <img src="../../../CSS/img/Editar.png" /></a></td>
							    <td><a href="javascript:Eliminar(<?=$objItems -> 
                                get_ID($i)?>);" title="Eliminar Item">
                                    <img src="../../../CSS/img/Eliminar.png" /></a></td>

							    </tr>
						    <?php }?>
						</tbody>
					</table>
					<br />
					<a href="interfaz.agregar.php" title="Agregar Item">
                        <img src="../../../CSS/img/Nuevo.png"/><p>Agregar Item</p></a>
				</div>
			</div>
		</div>	
	</body>
</html>



<!--//********************************************************************//-->