$(document).ready(function() {
    var table = $('#tlistado').DataTable();
 
    $('#tlistado tbody').on( 'click', 'tr', function () {
        if ( $(this).hasClass('selected') ) {
            $(this).removeClass('selected');
        }
        else {
            table.$('tr.selected').removeClass('selected');
            $(this).addClass('selected');
        }
    } );
 
   $(".delete").hide();
} );

function Eliminar(id){
	if(confirm("¿Desea eliminar la configuración? (Esta acción no se puede deshacer)"))
	{
		var request = jQuery.ajax({
			type: 'GET',
			url: '../modelo/control.configuracion.php',  //file name
			data: {
				Confid : id,
				eliminar : 1
			},//data
			async:false
		});
					
		request.done(function(msg){
			if($.trim(msg) == 1){
				alert("Eliminación completa");
				location.reload();
				return false;
			}
			else{
				alert("Error al eliminar, por favor intente de nuevo.");
				return false;
			}
		});
	}
}
