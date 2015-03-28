<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8" />
    <title>Sistema</title>
    <script  src="../../../js/jquery.js"></script>
    <link rel="stylesheet" type="text/css" href="../../../CSS/login.css" media="screen" />
    <script  src="../../../js/mascara.js"></script>
    <script type="text/javascript">
    	jQuery.noConflict();
    	jQuery(document).ready(function($){
                $("#cedula").mask("9-9999-9999");
                /*
    		 * Comienza la acción de cuando se hace click al botón ingresar
    		 * Pasos:
    		 * Primero valida que se hayan ingresado el nombre y la contraseña.
    		 * Si la validación es correcta, entonces procede a realizar el proceso de logeo.
    		 * EN caso de que los campos no estén ingresados o de que no se haya logrado validar el logeo, 
    		 * se muestra una alerta de error
    		 */
    		$("#ingresar").click(function(){
    			var cedula = $("#cedula").val();
    			var clave = $("#clave").val();
    			var error = "";
    			var flag = true;
    			if($.trim(cedula).length == 0 || $.trim(cedula) == "")
    			{
    				error += "Por favor ingrese su cedula.\n";
    				flag = false;
    			}
    			if($.trim(clave).length == 0 || $.trim(clave) == "")
    			{
    				error += "Por favor ingrese su contraseña.\n";
    				flag = false;
    			}
    			if(!flag)
    			{
    				alert(error);
    				return false;
    			}
    			var request = jQuery.ajax({
					type: 'GET',
					url: '../modelo/control.logeo.php',  //file name
					data: jQuery('#frmLogeo').serialize(),//data
					async:false
				});
				request.done(function(msg){
					if($.trim(msg) == 1){
						location.href = '../../interfaz.inicio.php';
					}
					else{
						alert("Usuario o contraseña no validos.");
						return false;
					}
				});
    		});
    	});
    </script>
</head>
<body>
	<div class="transBack">
		<div class="loginForm" >
			<form id="frmLogeo" name="frmLogeo" method="post">
			<table>
				<tr>
					<td>
						<div class="field">
							<label for="cedula">
                                                            C&eacute;dula:
							</label>
						</div>					
					</td>
					<td>
						<div >
							<input type="text" name="cedula" id="cedula"/>
						</div>
					</td>
					
				</tr>
				<tr>
					<td>
						<div class="field">
							<label for="clave">
								Contrase&ntilde;a:
							</label>
						</div>
					</td>
					<td>
						<div >
							<input type="password" name="clave" id="clave" maxlength="50" />
						</div>
					</td>
				</tr>
				<tr>
					<td colspan="2">
						<br />
						<div class="acceptButton">
							<input type="button" id="ingresar" value="Ingresar" />
						</div>
					</td>
				</tr>
			</table>		
			</form>
		</div>
	</div>
</body>
</html>