<?php

# La variable $usuario viene de la pagina de sesión y se refiere al numero de usuario del profesor.
error_reporting(E_ALL);
require_once $_SERVER['DOCUMENT_ROOT'].'/Sistema/modulos/login/modelo/sesion.php';


require_once 'clase.estudiantes.php';
$objEstudiante = new Estudiante;
if(isset($eliAsig))
{
    if(!$objEstudiante -> EliminarAsignacion($cedula,$usuario))
        echo(0);
    echo(1);
    exit;
}
if(isset($asignar))
{
  if(!$objEstudiante -> AsignarConfiguraciones($usuario,$cedula,$dataJSON))
  {
    echo(0);
    exit;
  }
  echo(1);
  exit;
}
//Solamente modifica
if( $soloModificar > 0){
    if(!$objEstudiante -> GuardarModificar($nombre, $cedula, $seccion))
    {
        echo(0);
        exit;
    }
    echo(1);
    exit;
}
//aregar Nuevo estudiante
if($existente == 0){
	$resultado = $objEstudiante -> GuardarNuevo($nombre, $cedula, $seccion);
	if($resultado == 0)
		die(0);

	echo (int)$objEstudiante -> Asignar($usuario, $cedula);
	exit;
}
//Solo asignar el estudiante al profesor
else {
        /*if(!$objEstudiante -> GuardarModificar($nombre, $cedula, $seccion))
                die(0);*/
	if(!$objEstudiante -> BusarEstudiante_Usuario($usuario, $cedula))
		die("-1");
	echo (int)$objEstudiante -> Asignar($usuario, $cedula);
	exit;
}
?>