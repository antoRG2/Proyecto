<?php
/*
 * Se busca si el número de cédula digitado existe como profesor
 */
foreach ($_GET as $key => $value)
	$$key = $value;
foreach ($_POST as $key => $value)
	$$key = $value;

require_once $_SERVER['DOCUMENT_ROOT'].'Sistema/modulos/login/modelo/clase.logeo.php';
$obj = new Logeo;
$obj -> set_Cedula($cedula);
$obj -> _CONSULTAR_USUARIO();
if ($obj -> get_Contador() > 0) {
	echo "1";
	exit ;
} else {
	echo "0";
	exit ;
}
?>