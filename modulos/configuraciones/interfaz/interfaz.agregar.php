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
	    <link rel="stylesheet" type="text/css" href="../../../CSS/crearConfiguraciones.css">
	    <link rel="stylesheet" type="text/css" href="../../../js/dataTables/css/jquery.dataTables.css">
	    
	    
	    <script  src="../../../js/jquery.js"></script>
	    <script  src="../../../js/jquery.ui.js"></script>
	    <script  src="../../../js/menu.js"></script>
	   
	    
	     <script>
	     	var json = null;
			$(function() {
				$( "#catalog" ).accordion();
				$( "#catalog li" ).draggable({
					appendTo: "body",
					helper: "clone"
				});
				$( "#drop ol" ).droppable({
					activeClass: "ui-state-default",
					hoverClass: "ui-state-hover",
					accept: ":not(.ui-sortable-helper)",
					drop: function( event, ui ) {
						$( this ).find( ".placeholder" ).remove();
						$( "<li id='"+ui.draggable.prop('id')+"'></li>" ).text( ui.draggable.text() ).appendTo( this );
					}
				}).sortable({
				items: "li:not(.placeholder)",
				sort: function() {
					$( this ).removeClass( "ui-state-default" );
				}
				});
				
				$("#btnLimpiar").click(function(){
					$( "#drop ol li" ).remove();
				});
				
				$("#btnCancelar").click(function(){
					if(confirm("¿Desea cancelar?"))
						window.location = "interfaz.listado.php";
				});
				
				$("#btnGuardar").click(function(){
					var nom = $('#nombre').val();
					var des = $('#descripcion').val();
					var pub = (document.getElementById("publica").checked)?1:0; 
					var bandera = true;
					var error = '';
					if($.trim(nom) == '' || nom.length == 0){
						bandera = false;
						error += "Por favor digite el nombre. \n";
					}
					if($.trim(des) == '' || des.length == 0){
						bandera = false;
						error += "Por favor digitar una descripción. \n";
					}
					if(!bandera){
						alert(error);
						return false;
					}
					var datos = [];
					$("#drop ol li").each(function(){
						
						datos.push($(this).attr("id"));
					});
					var dataJSON = JSON.parse(JSON.stringify(datos));
					
					var request = jQuery.ajax({
						type: 'POST',
						url: '../modelo/control.configuracion.php',  //file name
						data: "dataJSON=" + dataJSON + '&nombre=' + encodeURIComponent($('#nombre').val()) + '&descripcion=' + encodeURIComponent($('#descripcion').val()) + '&pub=' + pub,//data
						async:false
					});
					request.done(function(msg){
						if($.trim(msg) == 1){
							location.href = 'interfaz.listado.php';
						}
						else{
							alert("Error al guardar.");
							return false;
						}
					});
				});
				
				displayElements();
			});
			
			function displayElements()
			{			
				var contentToRemove = document.querySelectorAll("#catalog");
				$(contentToRemove).remove(); 
				
				var selected=$("#filtro").find('option:selected').text();
				var request = jQuery.ajax({
					type: 'POST',
					url: '../modelo/listado.items.json.php',  //file name
					data: 'id=0&selected='+$("#filtro").val(),//data
					async:false
				});
				
				request.done(function(msg){
					json = JSON.parse(msg);
				});
				switch(selected) {
				case "Todos":
				 	var catalog= '<div id="catalog"><h3><a href="#">Todos los items</a></h3><div><ul>';
				   	for(i = 0; i < json.length; i++){
				   		catalog += '<li id="'+ json[i]['id'] +'">'+ json[i]['nombre']  +'</li>';
				  	 }
				   	catalog +='</ul></div>';
				    break;
				    
				case "Dificultad":
				   var catalog= '<div id="catalog">';
				   	for(i = 0; i < json.length; i++){
				   		if(i == 0)
				   		{
				   			catalog += '<h3><a href="#">'+ json[i]['dificultad'] +'</a></h3><div><ul><li id="'+ json[i]['id'] +'">'+ json[i]['nombre']  +'</li>';
				   		}else
				   		{
				   			if(json[i]['dificultad'] == json[i - 1]['dificultad'])
				   				catalog += '<li id="'+ json[i]['id'] +'">'+ json[i]['nombre']  +'</li>'; 
				   			else
				   				catalog += '</ul></div><h3><a href="#">'+ json[i]['dificultad'] +'</a></h3><div><ul><li id="'+ json[i]['id'] +'">'+ json[i]['nombre']  +'</li>'; 
				   		}
				   	}
				   	catalog +='</ul></div>';
				    break;
				    				    
				case "Area de Conocimiento":
				 	  var catalog= '<div id="catalog">';
				   	for(i = 0; i < json.length; i++){
				   		if(i == 0)
				   		{
				   			catalog += '<h3><a href="#">'+ json[i]['area'] +'</a></h3><div><ul><li id="'+ json[i]['id'] +'">'+ json[i]['nombre']  +'</li>';
				   		}else
				   		{
				   			if(json[i]['area'] == json[i - 1]['area'])
				   				catalog += '<li id="'+ json[i]['id'] +'">'+ json[i]['nombre']  +'</li>'; 
				   			else
				   				catalog += '</ul></div><h3><a href="#">'+ json[i]['area'] +'</a></h3><div><ul><li id="'+ json[i]['id'] +'">'+ json[i]['nombre']  +'</li>'; 
				   		}
				   	}
				   	catalog +='</ul></div>';
				    break;
				} 
				
			    $('#draggable').append(catalog);
				  $( "#catalog li" ).draggable({
				appendTo: "body",
				helper: "clone"
				});
				
				$(".ui-droppable li").dblclick(function(){
					$(this).remove();
				});	
			}
		</script>
	</head>
	<body>
	<?php require_once '../../interfaz.menu.php';?>
	<br />
	<div class="transBack">
		<div class="displayData">
			<div class="title">
				<h2>Crear Configuraci&oacute;n</h2>
			</div>			
			<br />
			
				<form name="FRMItems" id="FRMItems" method="post" action="../modelo/control.item.php">
				<table>
					<tr>
						<td><label for="nombre">Nombre:</label></td>
						<td><input type="text" name="nombre" id="nombre" style="width: 500px;"  /></td>
					</tr>
					<tr>
						<td><label for="descripcion">Descripci&oacute;n:</label></td>
						<td><textarea id="descripcion" name="descripcion" style="width: 500px;height: 50px;"></textarea></td>
					</tr>
					<tr>
						<td><label for="filtro">Filtrar por:</label></td>
						<td><select name="filtro" id="filtro" onchange="displayElements()">
							<option value="0" selected>Todos</option>
							<option value="1">Dificultad</option>
							<option value="2">Area de Conocimiento</option>
						</select></td>
					</tr>
					<tr>
						<td><label for="publica">¿La configuraci&oacute;n es p&uacute;blica?</label></td>
						<td><input type="checkbox" id="publica" name="publica"></td>
					</tr>
				</table>			
	
				<div class="dragDropContainer">
				
					<div id="drop">
						<h3 class="ui-widget-header">Configuraci&oacute;n de Prueba</h3>
						<div class="ui-widget-content">
							<ol>
								<li class="placeholder">Arrastre los items aqui</li>
							</ol>
						</div>
					</div>
					
					<div id="draggable">
						<h3 class="ui-widget-header">Items Disponibles</h3>
						<div id="catalog"></div>
                                        </div>			
				</div>
					
			<!-- <center>-->
				<div class="controlbuttonsDiv">
					<div style="float:left"><input type="button" name="btnLimpiar" id="btnLimpiar" value='Limpiar'/></div>
					<div style="float:right"><input type="button" name="btnCancelar" id="btnCancelar" value='Cancelar'/></div>
					<div style="float:right"><input type="button" name="btnGuardar" id="btnGuardar" value='Guardar'/></div>						
				</div>
			<!--</center>-->
		</form>	
	</body>
</html>