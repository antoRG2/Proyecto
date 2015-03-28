<?php
error_reporting(E_ALL);

// Notificar todos los errores de PHP
error_reporting(-1);

// Lo mismo que error_reporting(E_ALL);
ini_set('error_reporting', E_ALL);
/*
 * Este archivo recibe por parametros las variables del logeo y las procesa con ayuda de la clase clase.logeo.php
 *
 * En esta parte se reciben las variables que vienen tanto como POST y como GET
 * y las convierte en variables propias.
 * Ejemplo
 * En lugar de tener que poner$_POST['nombre'] basta con simplemente poner $nombre para utilizar la variable.
 */
require_once $_SERVER['DOCUMENT_ROOT'].'/Sistema/modulos/login/modelo/sesion.php';

require_once 'clase.configuracion.php';

$object = New Configuracion;
if(isset($eliminar))
	$result = $object -> Eliminar($Confid);
else{
	if(isset($editar))
		$result = $object -> GUARDAR_EDITAR($id,$nombre, $descripcion, $pub,$dataJSON);
	else
		$result = $object -> GUARDAR($nombre, $descripcion, $usuario_id,$pub,$dataJSON);
}
if($result)
	echo "1";
else 
	echo "0";
?>