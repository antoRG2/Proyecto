var agregar = null;
var t = null;
var activeID = null;
 var nRow = null;
$(document).ready(function() {
   t = $('#tlistado').DataTable();
   $('.agregar').on( 'click', function () {
   	if(agregar == null){
        t.row.add( [
           "<input type='text' id='new' />",
           '<a class="GuardarN" title="Guardar"><img src="../../../CSS/img/Editar.png" /></a>',
           '<a class="EliminarN" title="Cancelar"><img src="../../../CSS/img/Eliminar.png" /></a>'
        ] ).draw();
        agregar = 1;
    }
    } );
    
    $('.editar').click(function(){
   		if(agregar == null){
   			nRow = $(this).parents('tr')[0];
   			activeID = nRow.id;
   			agregar = 1;
   			var aData =  $('#tlistado').dataTable().fnGetData( nRow );
			var jqTds = $('td', nRow);
			jqTds[0].innerHTML = '<input type="text" name="new" id="new" value="'+aData[0]+'" />';
			jqTds[1].innerHTML = '<a class="GuardarE" title="Guardar"><img src="../../../CSS/img/Editar.png" /></a>';
			jqTds[2].innerHTML = '<a class="EliminarN" title="Cancelar"><img src="../../../CSS/img/Eliminar.png" /></a>';
			
   		}else
   		{
   			if(confirm('¿Desea cancelar la Inserción?'))
    		location.reload();
   		}
    	
    });
    
    $(document).on('click','.EliminarN',function(){
    	if(confirm('¿Desea cancelar la Inserción?'))
    		location.reload();
    });
    $(document).on('click','.GuardarN',function(){
    	var nom = $("#new").val();
		var id = 0;
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
    
    $(document).on('click','.GuardarE',function(){
    	var nom = $("#new").val();
		var id = activeID;
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
    
     $(".delete").hide();
});

function Eliminar(AreaID){
		var id = AreaID;
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
				location.reload();
			} else {
				alert("Error al eliminar, por favor inténtelo más tarde.");
			}
		});
	
	}
