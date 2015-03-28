<?php
/*
 * Este archivo recibe por parametros las variables del logeo y las procesa con ayuda de la clase clase.logeo.php
 *
 * En esta parte se reciben las variables que vienen tanto como POST y como GET
 * y las convierte en variables propias.
 * Ejemplo
 * En lugar de tener que poner$_POST['nombre'] basta con simplemente poner $nombre para utilizar la variable.
 */
foreach ($_GET as $key => $value)
	$$key = $value;
foreach ($_POST as $key => $value)
	$$key = $value;

require_once 'clase.respuesta.php';
$objR = new Respuesta;

	$resultado = $objR -> _ELiminar_Respuesta($id);
	if($resultado == 0)
	{
		echo "0";die();
	}
	if($tipo == 1)
		$file = "../../../Files/$itemID/IMG/$descripcion";
	if($tipo == 3)
		$file = "../../../Files/$itemID/AUDIO/$descripcion";
	$objR -> _Delete_FILE($file);
	echo "1";
	die();
?>