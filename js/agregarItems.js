//***************************************************************************//   
//                                                                           //
//                                                                           //       
//                                                                           //  
//                                                                           //
//                                                                           //
//                                                                           //
//                                                                           //
//                                                                           //   
//                                                                           //
//***************************************************************************//

var contRespuestas = 0;

jQuery(function($) {

    jQuery('#FRMItems').trigger('reset');
	var spinner = $( "#nRespuestas" ).spinner({ min: 2 });
	jQuery(".ui-icon").css('font-size', 24);
	
    $(".scheck").change(function(){
	
	    if($('#tipo').val() > 0 && $('#clasificacion').val() > 0){
		    if($( "#nRespuestas" ).spinner( "value" ) > 0)
		    {
			    if(contRespuestas == 0)
				    contRespuestas = $("#nRespuestas").spinner( "value" );
			    $('#areaRespuestas').load('interfaz.respuesta.multi.' +
                    'php?clasificacion=' + $('#clasificacion').val()
                    + '&cantR=' + $("#nRespuestas").spinner("value"));
					
				    var heightDisplayData= $('.displayData').height();    						

				    heightDisplayData = heightDisplayData +
                        (40 * $("#nRespuestas").spinner("value"));

				    $('.displayData').height(heightDisplayData);
		    }
		    else{
				    $('#areaRespuestas').html(""); 
		    }
	    }
	    else{
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
	    }
	    if($(this).val() == 1)
	    {
		    $('#enunciadoAudio').val("");
		    $('#enunciadoImg').val("");
		    $('#enunciadoTxt').val("");
		    $('#tdEnunciado1').show();
		    $('#tdEnunciado2').hide();
		    $('#tdEnunciado3').hide();
	    }
	    if($(this).val() == 2)
	    {
		    $('#enunciadoAudio').val("");
		    $('#enunciadoImg').val("");
		    $('#enunciadoTxt').val("");
		    $('#tdEnunciado1').hide();
		    $('#tdEnunciado2').show();
		    $('#tdEnunciado3').hide();
	    }
	    if($(this).val() == 3)
	    {
		    $('#enunciadoAudio').val("");
		    $('#enunciadoImg').val("");
		    $('#enunciadoTxt').val("");
		    $('#tdEnunciado1').hide();
		    $('#tdEnunciado2').hide();
		    $('#tdEnunciado3').show();
	    }
    });
	
    $('#nRespuestas').on("spinstop", function(){
	    if(contRespuestas < $(this).spinner( "value" )){
		    if($('#tbRespuestas') != null)
		    {
		        $("#tbRespuestas tr:eq(0)").clone().removeClass('fila-base')
                    .show().attr("id", $(this).spinner("value"))
                    .appendTo("#tbRespuestas");

		        $("#tbRespuestas tr:last input[type=checkbox]").attr("id", "chk_"
                    + $(this).spinner("value"));

		        $("#tbRespuestas tr:last input[type=text]")
                    .attr("id", "respuesta" + $(this).spinner("value"));

		        $("#tbRespuestas tr:last input[type=hidden]")
                    .attr("id", "acierto" + $(this).spinner("value"));
				
				    var heightDisplayData= $('.displayData').height();    						
				    heightDisplayData= heightDisplayData + 30 ; 
				    $('.displayData').height(heightDisplayData);				
		    }

	    }
	    else {
		    var respuestas= $('#tbRespuestas').find('tr').length;
		    if($('#tbRespuestas') != null && respuestas > 3)
		    {
                $("#"+contRespuestas).remove();
                var heightDisplayData= $('.displayData').height();    						
                heightDisplayData= heightDisplayData - 30 ; 
                $('.displayData').height(heightDisplayData);  
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
	    var en2 = $('#enunciadoTxt').val();
	    var en3 = $('#enunciadoAudio').val(); 
	    var des = $('#descripcion').val();
	    var are = $('#areaC').val();
	    var bandera = true;
	    var error = '';

	    if ($.trim(nom) == '' || nom.length == 0) {
		    bandera = false;
		    error += "Por favor digite el nombre. \n";
	    }

	    if (dif == 0) {
		    bandera = false;
		    error += "Por favor seleccione la dificultad. \n";
	    }

	    if (tip == 0) {
		    bandera = false;
		    error += "Por favor seleccione el tipo. \n";
	    }

	    if (cla == 0) {
		    bandera = false;
		    error += "Por favor seleccione la clasificación. \n";
	    }

	    if (ten == 0) {
		    bandera = false;
		    error += "Por favor seleccione el tipo de enunciado. \n";
	    }

	    if (($.trim(en1) == '' || en1.length == 0) && ($.trim(en2) == ''
            || en2.length == 0) && ($.trim(en3) == '' || en3.length == 0)) {
		    bandera = false;
		    error += "Por favor digitar o seleccionar el Enunciado. \n";
	    }

	    if ($.trim(des) == '' || des.length == 0) {
		    bandera = false;
		    error += "Por favor digitar una descripción. \n";
	    }

	    if ($.trim(des) == '' || des.length == 0) {
		    bandera = false;
		    error += "Por favor digitar una descripción. \n";
	    }

	    if (are == 0) {
		    bandera = false;
		    error += "Por favor seleccione el área de conocimiento. \n";
	    }

	    if (!validar_RespuestasDes()) {
		    bandera = false;
		    error += "Las respuestas no pueden estar vacías. \n";
	    }

	    if (validar_respuestasAc() == 0) {
		    bandera = false;
		    error += "Debe marcar al menos una respuesta como correcta. \n";
	    }

	    if (validar_respuestasAc() > 1) {
		    bandera = false;
		    error += "No puede haber más de una respuesta correcta. \n";
	    }

	    if (!bandera) {
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
	    if (document.getElementById($(this).attr("id")).checked) {

	        document.getElementById("acierto" + id).value = 1;
	    }
	    else {
	        document.getElementById("acierto" + id).value = 0;
	    }

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

	for (i = 1; i < aciertos.length; i++){
		if(aciertos[i].value == 1)
			contador = contador +1;
	}

	return contador;
}

//***************************************************************************//