<?php
/*
 * Este archivo recibe por parametros las variables del logeo y las procesa con ayuda de la clase clase.logeo.php
 *
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

require_once 'clase.logeo.php';
$obj = new Logeo;
$obj -> set_Cedula($cedula);
$obj -> set_Clave($clave);
$obj -> _CONSULTAR_USUARIO();
if ($obj -> get_Contador() > 0) {
	/*
	 * Se inicia todo el proceso de creación de la sesión actual
	 * SS = Session Sistema
	 */
	session_name ('SS');
	session_start();
	$_SESSION['user'] = $cedula;
	$_SESSION['pass'] = $clave;
	$_SESSION['userID'] = $obj -> get_ID(0);
        $_SESSION['tipoUsuario'] = $obj -> get_Tipo(0);
	echo "1";
	exit ;
} else {
	echo "0";
	exit ;
}
?>