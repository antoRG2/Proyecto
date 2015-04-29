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



<script>
	$('document').ready(function(){
		$('.menu').fixedMenu();
	}); 
</script>
<div class="menu">
	<ul>
		<li>
			<a href="/Sistema/modulos/interfaz.inicio.php">Inicio</a>
		</li>
		<li class='has-sub'>
			<a href="#">Elementos de Prueba</a>
			<ul>
				<li><a href="/Sistema/modulos/items/interfaz/interfaz.listado.php">
                    Items</a></li>
				<li class='last'><a 
                    href="/Sistema/modulos/areaConocimiento/interfaz/interfaz.listado.php">
                    Area de Conocimiento</a></li>
			</ul>
		</li>
		<li class='has-sub'>
			<a href="#">Configuraciones</a>
			<ul>
				<li class='last'><a 
                    href="/Sistema/modulos/configuraciones/interfaz/interfaz.listado.php">
                    Configuraciones Disponibles</a></li>
			</ul>
		</li>
		<li class='has-sub'>
			<a href="#">Administraci&oacute;n</a>
			<ul>
                <li><a href="/Sistema/modulos/estudiantes/interfaz/interfaz.agregar.php">
                    Agregar Estudiantes</a></li>
                <li class='last'><a 
                    href="/Sistema/modulos/estudiantes/interfaz/interfaz.modificar.php">
                    Modificar Estudiantes</a></li>
			</ul>
		</li>
	</ul>
</div>

<!--//********************************************************************//-->