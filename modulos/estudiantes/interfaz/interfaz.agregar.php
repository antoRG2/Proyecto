<?php
	require_once $_SERVER['DOCUMENT_ROOT'].'/Sistema/modulos/login/modelo/sesion.php';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8" />
    <title>Sistema</title>
    
     <script  src="../../../js/jquery.js"></script>
	 <script  src="../../../js/jquery.ui.js"></script>
	 <script  src="../../../js/menu.js"></script>
	  <script  src="../../../js/mascara.js"></script>
	 
	 <script>
	 	$(function() {
	 		$("#cedula").mask("9-9999-9999");
                        $("#bcedula").mask("9-9999-9999");
                        
	 		$("#buscar").click(function(){
	 			$('#estudiantes').empty();
	 			$('#cedula').attr('readonly', false);
                                $("#div_cedula_error").hide();
	 			var request = jQuery.ajax({
					type: 'POST',
					url: '../modelo/busqueda.estudiantes.json.php',  //file name
					data: $("#FRMbusqueda").serialize(),//data
					async:false
				});
				
				request.done(function(msg){
					json = JSON.parse(msg);
				});
				var options = "";
				if(json.length == 0){
					data = '0,,,';
					options += "<option value='"+data+"'>No Hubieron resultados</option>";
				}
                                else{
				for(i = 0; i < json.length; i++){
					data = '1,'+json[i]['cedula']+','+json[i]['nombre']+','+json[i]['seccion'];
					options += "<option value='"+data+"'>"+ json[i]['cedula'] +": "+json[i]['nombre']+"</option>";
				}
				data = '0,,,';
					options += "<option value='"+data+"'>Nuevo</option>";
                                }
				$('#estudiantes').append(options);
                                $('#validador').val(1);
	 		});
                        
                        $("#cedula").keyup(function(){	 			
	 			var request = jQuery.ajax({
					type: 'POST',
					url: '../modelo/busqueda.usuarios.php',  //file name
					data: "cedula=" + $(this).val(),//data
					async:false
				});
				
				request.done(function(msg){
                                    if(msg == 0)
                                    {
                                        $('#validador').val(1);
                                        $("#div_cedula_error").hide();  
                                    }
                                    else{
                                        $('#validador').val(0);
                                        $("#div_cedula_error").show();                                       
                                    }
				});
	 		});
	 		
	 		$('#estudiantes').change(function(){
	 			var data= $(this).val().split(',');
                                $("#div_cedula_error").hide();
                                if(data[0] != 0)
                                {
                                    $('#btnModificar').show();
                                    $('#cedula').attr('readonly', true);
                                }else{
                                     $('#btnModificar').hide();
                                     $('#cedula').attr('readonly', false);
                                }
                                $('#existente').val(data[0]);
                                $('#cedula').val(data[1]);
                                $('#nombre').val(data[2]);
                                $('#seccion').val(data[3]);
                                $('#nombre_org').val(data[2]);
                                $('#validador').val(1);
	 		});
	 		
	 		$("#btnGuardar").click(function(){
                                if($('#validador').val() == 1)
                                {
                                $('#soloModificar').val(0);
                                var id= $('#existente').val();
	 			var nom = $('#nombre').val();
                                var nomORG = $('#nombre_org').val();
				var ced = $('#cedula').val();
				var sec = $('#seccion').val();
				var bandera = true;
				var error = '';
				if($.trim(nom) == '' || nom.length == 0){
					bandera = false;
					error += "Por favor digite el nombre. \n";
				}
				if($.trim(ced) == '' || ced.length == 0){
					bandera = false;
					error += "Por favor digite la cédula. \n";
				}
				if($.trim(sec) == '' || sec.length == 0){
					bandera = false;
					error += "Por favor digite la sección. \n";
				}
				if(!bandera){
					alert(error);
					return false;
				}
				
                                if(id > 0){
                                    if(nomORG != nom){
                                        if(!confirm("Al cambiar el nombre del estudiante, se cambia tambien el nombre de usuario aisgnado al mismo. \n\n\
                                                    ¿Desea continuar?"))
                                                    return false;
                
                                    }
                                }
				var request = jQuery.ajax({
					type: 'POST',
					url: '../modelo/control.estudiante.php',  //file name
					data: $("#FRMAgregar").serialize(),//data
					async:false
				});
				
				request.done(function(msg){
					if(msg == 0){
						alert("Error al guardar");
					}
					if(msg == 1)
					{
						alert("Éxito al guardar");
						$('#id').val(0);
			 			$('#cedula').val("");
			 			$('#nombre').val("");
			 			$('#seccion').val("");
					}
					if(msg == -1)
					{
						alert("El estudiante seleccionado ya se encuentra registrado para su usuario.");
                                                $('#id').val(0);
			 			$('#cedula').val("");
			 			$('#nombre').val("");
			 			$('#seccion').val("");
					}
				});
                                //Oculta el botón de modificar en caso de que no se haya
                                // seleccionado ningún estudiante o que sea un registro nuevo.
                                $('#btnModificar').hide();
                            }
	 		});
                        
                        $("#btnModificar").click(function(){
                                $('#soloModificar').val(1);
                                var id= $('#existente').val();
	 			var nom = $('#nombre').val();
                                var nomORG = $('#nombre_org').val();
				var ced = $('#cedula').val();
				var sec = $('#seccion').val();
				var bandera = true;
				var error = '';
				if($.trim(nom) == '' || nom.length == 0){
					bandera = false;
					error += "Por favor digite el nombre. \n";
				}
				if($.trim(ced) == '' || ced.length == 0){
					bandera = false;
					error += "Por favor digite la cédula. \n";
				}
				if($.trim(sec) == '' || sec.length == 0){
					bandera = false;
					error += "Por favor digite la sección. \n";
				}
				if(!bandera){
					alert(error);
					return false;
				}
				
                                if(id > 0){
                                    if(nomORG != nom){
                                        if(!confirm("Al cambiar el nombre del estudiante, se cambia tambien el nombre de usuario aisgnado al mismo. \n\n\
                                                    ¿Desea continuar?"))
                                                    return false;
                
                                    }
                                }
				var request = jQuery.ajax({
					type: 'POST',
					url: '../modelo/control.estudiante.php',  //file name
					data: $("#FRMAgregar").serialize(),//data
					async:false
				});
				
				request.done(function(msg){
					if(msg == 0){
						alert("Error al guardar");
					}
					if(msg == 1)
					{
						alert("Éxito al guardar");
						$('#existente').val(0);
			 			$('#cedula').val("");
			 			$('#nombre').val("");
			 			$('#seccion').val("");
                                                $('#btnModificar').hide();
					}
				});
				
	 		});
                        //Oculta el botón de modificar en caso de que no se haya
                        // seleccionado ningún estudiante o que sea un registro nuevo.
                        $('#btnModificar').hide();
	 	});
	 </script>
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
			<form name="FRMbusqueda"  id="FRMbusqueda" >
			<table>
				<tr>
					<td><label for="bcedula">C&eacute;dula:</label></td>
					<td><input type="text" name="bcedula" id="bcedula"/></td>
				</tr>
				<tr>
					<td colspan="2" align="rigth"><input type="button" name="buscar" id="buscar" value="Buscar" /></td>
				</tr>
			</table>
			</form>
			<br />
			<label for="estudiantes">Resultados:</label>
			<select id="estudiantes" name="estudiantes" size="10"></select>
			<br />
			<form name="FRMAgregar" id="FRMAgregar">
				<input type="hidden" id="existente" name="existente" value='0'/>
                                <input type="hidden" id="nombre_org" name="nombre_org" value="" />
                                <input type="hidden" id="soloModificar" name="soloModificar" value="0" />
                                <input type="hidden" id="validador" value="1" />
				<table>
					<tr>
						<td>Nombre:</td>
						<td><input type="text" name="nombre" id="nombre" value="" /></td>
					</tr>
					<tr>
						<td>C&eacute;dula:</td>
						<td>
                                                    <input type="text" name="cedula" id="cedula" value="" />
                                                    <div id="div_cedula_error" style="display: none">
                                                        <br />
                                                        **Este N&uacute;mero de C&eacute;dula ya se ecuentra en uso.
                                                    </div>
                                                </td>
					</tr>
					<tr>
						<td>Secci&oacute;n:</td>
						<td><input type="text" name="seccion" id="seccion" value="" /></td>
					</tr>
				</table>
			</form>
			<br />
			<input type="button" value="Agregar" id="btnGuardar"/>
                        <input type="button" value="Modificar" id="btnModificar"/>
		</div>
	</div>
</div>
</body>
</html>