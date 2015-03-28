<?php
error_reporting(E_ALL);
require_once $_SERVER['DOCUMENT_ROOT'].'/Sistema/modulos/login/modelo/sesion.php';


require_once 'clase.estudiantes.php';
$objEstudiante = new Estudiante;
//Solamente modifica

if(isset($eliAsig))
{
    if(!$objEstudiante -> EliminarAsignacion($id,$usuario_id))
        echo(0);
    echo(1);
    exit;
}

if( $soloModificar > 0){
    if(!$objEstudiante -> GuardarModificar($id,$nombre, $cedula, $seccion))
        echo(0);
    echo(1);
    exit;
}
//aregar Nuevo estudiante
if($id == 0){
	$resultado = $objEstudiante -> GuardarNuevo($nombre, $cedula, $seccion);
	if($resultado == 0)
		die(0);

	echo (int)$objEstudiante -> Asignar($usuario_id, $resultado);
	exit;
}
//Solo asignar el estudiante al profesor
else {
        if(!$objEstudiante -> GuardarModificar($id,$nombre, $cedula, $seccion))
                die(0);
	if(!$objEstudiante -> BusarEstudiante_Usuario($usuario_id, $id))
		die("-1");
	echo (int)$objEstudiante -> Asignar($usuario_id, $id);
	exit;
}
?>