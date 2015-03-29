<?php
error_reporting(E_ALL ^ E_NOTICE);
require_once 'clase.estudiantes.php';
$objEstudiante = new Estudiante;

$objEstudiante -> set_Cedula($_POST['bcedula']);
$objEstudiante -> _Query();
$array = array();
for($i = 0; $i < $objEstudiante -> get_Contador(); $i++)
{
	$array[] = array('nombre' => $objEstudiante -> get_Nombre($i,"INPUT"), 'cedula' =>$objEstudiante -> get_Cedula($i),'seccion' =>$objEstudiante -> get_Seccion($i));
}
echo json_encode($array);
?>	