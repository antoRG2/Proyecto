<?php
foreach ($_GET as $key => $value)
	$$key = $value;
foreach ($_POST as $key => $value)
	$$key = $value;
require_once '../../items/modelo/clase.item.php';
$objItem = new Item;
$objItem -> _QUERY_4_CONFIGURACIONES($id,$selected);

$array = array();
for($i = 0; $i < $objItem -> get_Contador();$i++){
	$array[] = array('id' => $objItem -> get_ID($i),'nombre' => $objItem -> get_Nombre($i,"INPUT"), 'dificultad' =>$objItem -> _TXTDIFICULTAD($objItem -> get_Dificultad($i)),'area' =>$objItem -> get_AreaConocimiento($i,"INPUT"));
}

echo json_encode($array);
?>