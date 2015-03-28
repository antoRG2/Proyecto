jQuery(function($) {
	jQuery('#FRMARC').trigger('reset');
	$("#areaC").change(function(){
		if($(this).val() == 0)
		{
			$("#nombre").val("");
			$("#btnEliminar").hide();
		}
		else
		{
			$("#nombre").val($("#areaC option:selected").text());
			$("#btnEliminar").show();
		}
	});
	
	$("#btnGuardar").click(function(){
		var nom = $("#nombre").val();
		var id = $("#areaC").val();
		var bandera = true;
		var error = '';
		if($.trim(nom) == '' || nom.length == 0){
			bandera = false;
			error += "Por favor digite el nombre. \n";
		}
		if(!bandera){
			alert(error);
			return false;
		}
		var request = jQuery.ajax({
			type : 'POST',
			url : '../../../modulos/areaConocimiento/modelo/control.areaC.php', //file name
			data : 'id=' + id + '&nombre=' + encodeURIComponent(nom), //data
			async : false
		});
		request.done(function(msg) {
			if (jQuery.trim(msg) == 1) {
				alert("Éxito al guardar");
				$("#nombre").val("");
				location.reload();
			} else {
				alert("Error al guardar, por favor inténtelo más tarde.");
			}
		});
	});
	
	$("#btnEliminar").click(function(){
		var id = $("#areaC").val();
		var bandera = true;
		var error = '';
		if(!confirm("¿Desea eliminar el elemento seleccionado?"))
		{
			return false;
		}
		var request = jQuery.ajax({
			type : 'POST',
			url : '../../../modulos/areaConocimiento/modelo/control.areaC.php', //file name
			data : 'id=' + id + '&del=1', //data
			async : false
		});
		request.done(function(msg) {
			if (jQuery.trim(msg) == 1) {
				alert("Éxito al eliminar");
				$("#nombre").val("");
				location.reload();
			} else {
				alert("Error al eliminar, por favor inténtelo más tarde.");
			}
		});
	
	});
});

