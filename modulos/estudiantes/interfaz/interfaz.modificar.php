<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/Sistema/modulos/login/modelo/sesion.php';
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
            $(function () {
                $("#catalog").accordion();
                $("#catalog li").draggable({
                    appendTo: "body",
                    helper: "clone"
                });
                $("#drop ol").droppable({
                    activeClass: "ui-state-default",
                    hoverClass: "ui-state-hover",
                    accept: ":not(.ui-sortable-helper)",
                    drop: function (event, ui) {
                        $(this).find(".placeholder").remove();
                        $("<li id='" + ui.draggable.prop('id') + "'></li>").text(ui.draggable.text()).appendTo(this);
                    }
                }).sortable({
                    items: "li:not(.placeholder)",
                    sort: function () {
                        $(this).removeClass("ui-state-default");
                    }
                });

                $("#cedula").mask("9-9999-9999");

                $('#estudiantes').empty()
                //JSON DATA///////////////////////////////////////////////////////////////////////////////////////////////////////////
                var request = jQuery.ajax({
                    type: 'POST',
                    url: '../modelo/busqueda.estudiantes_profesor.json.php', //file name
                    data: 'profesor=' + <?= $usuario_id ?>, //data
                    async: false
                });

                request.done(function (msg) {
                    json = JSON.parse(msg);
                });
                var options = "";
                if (json.length == 0) {
                    data = '0,,,';
                    options += "<option value='" + data + "'>No Hubieron resultados</option>"
                }
                for (i = 0; i < json.length; i++) {
                    data = json[i]['id'] + ',' + json[i]['cedula'] + ',' + json[i]['nombre'] + ',' + json[i]['seccion'];
                    options += "<option value='" + data + "'>" + json[i]['cedula'] + ": " + json[i]['nombre'] + "</option>"
                }

                $('#estudiantes').append(options);
                
                var contentToRemove = document.querySelectorAll("#catalog");
		
                $(contentToRemove).remove(); 
                
                var request = jQuery.ajax({
                    type: 'POST',
                    url: '../../configuraciones/modelo/listado.configuraciones.json.php',  //file name
                    async:false
		});
                
                request.done(function(msg){
                    json = JSON.parse(msg);
		});
                var catalog= '<div id="catalog"><ul>';
                for(i = 0; i < json.length; i++){
                    catalog += '<li id="'+ json[i]['id'] +'">'+ json[i]['nombre']  +'</li>';
		}
		catalog +='</ul></div>';
                
                $('#draggable').append(catalog);
                    $( "#catalog li" ).draggable({
                        appendTo: "body",
                        helper: "clone"
                    });
				
		$(".ui-droppable li").dblclick(function(){
                    $(this).remove();
		});	
                 //END JSON DATA///////////////////////////////////////////////////////////////////////////////////////////////////               
                $("#btnEliminarEstudiante").click(function () {
                    var data = $('#estudiantes').val().split(',');
                    var id = data[0]; // Obtengo el Id del Estudiante

                    var request = jQuery.ajax({
                        type: 'POST',
                        url: '../modelo/control.estudiante.php', //file name
                        data: 'id=' + id + '&eliAsig=1', //data
                        async: false
                    });

                    request.done(function (msg) {
                        if (msg == 0)
                        {
                            alert("Error al guardar");
                        }
                        if (msg == 1)
                        {
                            alert("Éxito al guardar");
                            location.reload();
                        }
                    });
                });
            });
        </script>
    </head>
    <body>
        <?php require_once '../../interfaz.menu.php'; ?>
        <br />
        <div class="transBack">
            <div class="displayData">
                <div class="title">
                    <h2>Estudiantes</h2>
                </div>	
                <br />
                <br />
                <div class="displayTable">
                    <br />
                    <label for="estudiantes">Estudiantes Asignados:</label>
                    <br />
                    <br />
                    <select id="estudiantes" name="estudiantes" size="10"></select>
                    <br />
                    <br />
                    <input type="button" value="Eliminar Estudiante de la Lista" id="btnEliminarEstudiante"/>
                </div>
                <h2>Asignar Configuraciones al Estudiante</h2>
                <br />
                <br />
                <div class="dragDropContainer">

                    <div id="drop">
                        <h3 class="ui-widget-header">Configuraci&oacute;n de Prueba</h3>
                        <div class="ui-widget-content">
                            <ol>
                                <li class="placeholder">Arrastre las configuraciones aqui</li>
                            </ol>
                        </div>
                    </div>

                    <div id="draggable">
                        <h3 class="ui-widget-header">Configuraciones Disponibles</h3>
                        <div id="catalog"></div>
                    </div>			
                </div>
                <br />
                <br />
                <input type="button" value="Guardar configuracion" id="btnGuardar"/>
            </div>
        </div>
    </body>
</html>