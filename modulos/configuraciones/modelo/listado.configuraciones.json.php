<?php
error_reporting(E_ALL ^ E_NOTICE);
require_once $_SERVER['DOCUMENT_ROOT'] . '/Sistema/modulos/login/modelo/sesion.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/Sistema/modulos/configuraciones/modelo/clase.configuracion.php';
$objConf = new Configuracion;
$objConf ->set_usuarioID($usuario_id);
$objConf -> _QUERY();
$array = array();
for($i = 0; $i < $objConf ->get_Contador(); $i++)
{	
	$array[] = array(
	"id" => $objConf ->get_ID($i),
        "nombre" => $objConf->get_Nombre($i, "HTML"),
        "descripcion" => $objConf->get_Descripcion($i, "HTML")
	);
}
echo json_encode($array);
?>