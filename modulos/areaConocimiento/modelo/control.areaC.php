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

error_reporting(E_ALL);

// Notificar todos los errores de PHP
error_reporting(-1);

// Lo mismo que error_reporting(E_ALL);
ini_set('error_reporting', E_ALL);
/*
 * Este archivo recibe por parametros las variables del logeo y las procesa con 
 * ayuda de la clase clase.logeo.php
 *
 * En esta parte se reciben las variables que vienen tanto como POST y como GET
 * y las convierte en variables propias.
 * Ejemplo
 * En lugar de tener que poner$_POST['nombre'] basta con simplemente poner 
 * $nombre para utilizar la variable.
 */

foreach ($_GET as $key => $value)
	$$key = $value;

foreach ($_POST as $key => $value)
	$$key = $value;

require_once '../../areaConocimiento/modelo/clase.areaC.php';
$objArea = new AreaC;
$objArea -> _QUERY();
if(isset($del)){
   
    $result = $objArea -> Eliminar($id);
    echo (int)$result;
    exit();
}
if($id == 0){
	$result = $objArea -> Guardar($id,$nombre);
}
else {
	$result = $objArea -> Guardar($id,$nombre,1);
}
echo (int)$result;
exit();
?>

<!--//********************************************************************//-->  