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


<?php
error_reporting(E_ALL ^ E_NOTICE);
require_once 'clase.configuracion.php';	

$objConf = new Configuracion;
$id = 3;
$objConf -> set_ID($id);
$objConf -> _QUERY4EXC();
$Ajson = $objConf -> get_arrayJSON();
$array = array();

for($i = 0; $i < count($Ajson); $i++)
{
	$objConf -> set_ItemID($Ajson[$i][0]);
	$objConf -> _QUERYRESP();
	
	$array[] = array(
	"id" => $Ajson[$i][0],
	"nombre" => $Ajson[$i][1],
	"tipo" => $Ajson[$i][2],
	"clasificacion" => $Ajson[$i][3],
	"tipoenunciado" => $Ajson[$i][4],
	"enunciado" => $Ajson[$i][5],
	"respuestas" => $objConf -> get_arrayJSONR()
	);
}

echo json_encode($array);
?>


<!--//********************************************************************//-->