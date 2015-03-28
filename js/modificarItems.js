var contRespuestas = 0;
var INITTYPE;
var INITTYPEEN;
jQuery(function($) {
	if(INITTYPE == 2)
    		var spinner = $( "#nRespuestas" ).spinner({ min: 0 });
    else
    		var spinner = $( "#nRespuestas" ).spinner({ min: contRespuestas });
    		
    		jQuery(".ui-icon").css('font-size', 24);	
    		$(".scheck").change(function(){
    			if($('#tipo').val() > 0 && $('#clasificacion').val() > 0){
    				if($( "#nRespuestas" ).spinner( "value" ) > 0)
    				{
    					if(contRespuestas == 0)
    						contRespuestas = $("#nRespuestas").spinner( "value" );
    						$('#areaRespuestas').load('interfaz.respuesta.multi.php?clasificacion='+$('#clasificacion').val() +'&cantR=' + $( "#nRespuestas" ).spinner( "value" ));
    				}
    				else{
    					$('#areaRespuestas').html("");
    				}
    			}else{
    				$('#areaRespuestas').html("");
    			}
    		});
    		
    		$("#tEnunciado").change(function(){
    			if($(this).val() == 0)
    			{
    				$('#tEnunciado').val("");
					$('#enunciadoImg').val("");
					$('#enunciadoTxt').val("");
					$('#tdEnunciado1').hide();
					$('#tdEnunciado2').hide();
					$('#tdEnunciado3').hide();
					$('#enunciadoImgT').val('');
					$('#img').hide();
					$('#enunciadoAudioT').val('');
					$('#audio').hide();
    			}
    			if($(this).val() == 1)
    			{
    				$('#enunciadoAudio').val("");
					$('#enunciadoImg').val("");
					$('#enunciadoTxt').val("");
					$('#tdEnunciado1').show();
					$('#tdEnunciado2').hide();
					$('#tdEnunciado3').hide();
					$('#enunciadoImgT').val('');
					$('#img').hide();
					$('#enunciadoAudioT').val('');
					$('#audio').hide();
    			}
    			if($(this).val() == 2)
    			{
    				$('#enunciadoAudio').val("");
					$('#enunciadoImg').val("");
					$('#enunciadoTxt').val("");
					$('#tdEnunciado1').hide();
					$('#tdEnunciado2').show();
					$('#tdEnunciado3').hide();
					$('#enunciadoImgT').val('');
					$('#img').hide();
					$('#enunciadoAudioT').val('');
					$('#audio').hide();
    			}
    			if($(this).val() == 3)
    			{
    				$('#enunciadoAudio').val("");
					$('#enunciadoImg').val("");
					$('#enunciadoTxt').val("");
					$('#tdEnunciado1').hide();
					$('#tdEnunciado2').hide();
					$('#tdEnunciado3').show();
					$('#enunciadoImgT').val('');
					$('#img').hide();
					$('#enunciadoAudioT').val('');
					$('#audio').hide();
    			}
    		});
    		
    		$('#nRespuestas').on("spinstop", function(){
    			if(contRespuestas < $(this).spinner( "value" )){
	  				if($('#tbRespuestas') != null)
	  				{
	  					$("#tbRespuestas tr:eq(0)").clone().removeClass('fila-base').show().attr("id", $(this).spinner( "value" )).appendTo("#tbRespuestas");
	  					$("#tbRespuestas tr:last input[type=checkbox]").attr("id", "chk_"+$(this).spinner( "value" ));
	  					$("#tbRespuestas tr:last input[type=text]").attr("id", "respuesta"+$(this).spinner( "value" ));
	  					$("#tbRespuestas tr:last input[type=hidden]").attr("id", "acierto"+$(this).spinner( "value" ));
	  				}
  				}else{
  					if($('#tbRespuestas') != null)
	  				{
	  					 $("#"+contRespuestas).remove();
	  				}
  				}
  				contRespuestas = $(this).spinner( "value" );
			});
			
			$("#btnGuardar").click(function(){
				var nom = $('#nombre').val();
				var dif = $('#dificultad').val();
				var tip = $('#tipo').val();
				var cla = $('#clasificacion').val();
				var ten = $('#tEnunciado').val();
				var en1 = $('#enunciadoImg').val();
				if(INITTYPEEN == 1)
					var en1T = $('#enunciadoImgT').val();
				var en2 = $('#enunciadoTxt').val();
				var en3 = $('#enunciadoAudio').val();
				if(INITTYPEEN == 3)
					var en3T = $('#enunciadoAudioT').val();
				var des = $('#descripcion').val();
				var are = $('#areaC').val();
				var bandera = true;
				var error = '';
				if($.trim(nom) == '' || nom.length == 0){
					bandera = false;
					error += "Por favor digite el nombre. \n";
				}
				if(dif == 0){
					bandera = false;
					error += "Por favor seleccione la dificultad. \n";
				}
				if(tip == 0){
					bandera = false;
					error += "Por favor seleccione el tipo. \n";
				}
				if(cla == 0){
					bandera = false;
					error += "Por favor seleccione la clasificación. \n";
				}
				if(ten == 0){
					bandera = false;
					error += "Por favor seleccione el tipo de enunciado. \n";
				}
				if(INITTYPEEN == 1)
					if(($.trim(en1) == '' || en1.length == 0) && ($.trim(en1T) == '' || en1T.length == 0) &&  ($.trim(en2) == '' || en2.length == 0) && ($.trim(en3) == '' || en3.length == 0)){
						bandera = false;
						error += "Por favor digitar o seleccionar el Enunciado. \n";
					}
				if(INITTYPEEN == 2)
					if(($.trim(en1) == '' || en1.length == 0)  &&  ($.trim(en2) == '' || en2.length == 0) && ($.trim(en3) == '' || en3.length == 0)){
						bandera = false;
						error += "Por favor digitar o seleccionar el Enunciado. \n";
					}
				if(INITTYPEEN == 3)
					if(($.trim(en1) == '' || en1.length == 0)  &&  ($.trim(en2) == '' || en2.length == 0) && ($.trim(en3) == '' || en3.length == 0)&& ($.trim(en3T) == '' || en3T.length == 0)){
						bandera = false;
						error += "Por favor digitar o seleccionar el Enunciado. \n";
					}
				if($.trim(des) == '' || des.length == 0){
					bandera = false;
					error += "Por favor digitar una descripción. \n";
				}
				if(are == 0){
					bandera = false;
					error += "Por favor seleccione el área de conocimiento. \n";
				}
				if(!validar_RespuestasDes()){
					bandera = false;
					error += "Las respuestas no pueden estar vacías. \n";
				}
				if(validar_respuestasAc() == 0){
					bandera = false;
					error += "Debe marcar al menos una respuesta como correcta. \n";
				}
				if(validar_respuestasAc() > 1){
					bandera = false;
					error += "No puede haber más de una respuesta correcta. \n";
				}
				if(!bandera){
					alert(error);
					return false;
				}
				$("#FRMItems").attr("enctype","multipart/form-data");
				document.getElementById('FRMItems').submit();
			});
			
				$("#btnCancelar").click(function(){
					if(confirm("¿Desea cancelar?"))
					window.location = "interfaz.listado.php";
				});	
			
			$(document).on("click",".chk",function(){
				var id = $(this).attr("id").split('_').pop();
				if(document.getElementById($(this).attr("id")).checked)
					
					document.getElementById("acierto" + id).value = 1;
				else
					document.getElementById("acierto" + id).value = 0;
			});
			
			$(document).on("click",".eliminarR",function(){
				var id = $(this).attr("id").split('_').pop();
				var itemID = $("#itemID").val();
				var descripcion = $("#descripcion_" + id).val();
				var request = jQuery.ajax({
						type: 'GET',
						url: '../modelo/control.respuesta.php',  //file name
						data: {'id':id,'itemID':itemID, 'descripcion': descripcion, 'tipo': $('#clasificacion').val()},//data
						async:false
					});
					
					request.done(function(msg){
					if($.trim(msg) == 1){
						alert("Eliminado completo");
						window.location = "interfaz.modificar.php?itemID="+itemID;
						return false;
					}
					else{
						alert("Error al eliminar, por favor intente de nuevo.");
						return false;
					}
					});
			});
			
			$('#EliminarI').click(function(){
				$('#enunciadoImgT').val('');
				$('#img').hide();
				$('#EliminarI').hide();
				$('#enunciadoImg').show();	
			});
			$('#EliminarA').click(function(){
				$('#enunciadoAudioT').val('');
				$('#audio').hide();
				$('#EliminarA').hide();
				$('#enunciadoAudio').show();	
			});
    		
});

function validar_RespuestasDes(){
	var descripciones = document.getElementsByName('respuesta[]');
	for(i = 1; i < descripciones.length; i++)
	{
		if(descripciones[i].value == '')
			return false;
	}
	return true;
}

function validar_respuestasAc(){
	var aciertos = document.getElementsByName('acierto[]');
	var contador = 0;
	for(i = 1; i < aciertos.length; i++)
	{
		if(aciertos[i].value == 1)
			contador = contador +1;
	}
	return contador;
}