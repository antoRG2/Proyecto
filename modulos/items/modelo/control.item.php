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
 * Este archivo recibe por parametros las variables del logeo y las procesa
 * con ayuda de la clase clase.logeo.php
 *
 * En esta parte se reciben las variables que vienen tanto como POST y 
 * como GET
 * y las convierte en variables propias.
 * Ejemplo
 * En lugar de tener que poner$_POST['nombre'] basta con simplemente 
 * poner $nombre para utilizar la variable.
 */

foreach ($_GET as $key => $value)
	$$key = $value;
foreach ($_POST as $key => $value)
	$$key = $value;

require_once 'clase.item.php';
$objItem = new Item;

if(isset($editar)){
		
	if($clasificacion == 2)#Las respuestas son texto
	{
		if($tEnunciado == 1)
		{
			if(isset($enunciadoImgT) && $enunciadoImgT != ''){
				$enunciado = $enunciadoImgT;
			}ELSE{
				$enunciado = basename($_FILES['enunciadoImg']['name']);
				$directorio = "../../../Files/$itemID/IMG";
				if(!file_exists($directorio))
					mkdir($directorio, 0777, true);
				$uploadfile = $directorio ."/". 
                    basename($_FILES['enunciadoImg']['name']);
				if (!move_uploaded_file($_FILES['enunciadoImg']['tmp_name'],
                    $uploadfile))
				{
					echo "0";
					die();
				}
			}
		}
		if($tEnunciado == 2)
		{
			$enunciado = $enunciadoTxt;
		}
		if($tEnunciado == 3)
		{
			if(isset($enunciadoAudiot) && $enunciadoAudiot != ''){
				$enunciado = $enunciadoAudiot;
			}else{
				$enunciado = basename($_FILES['enunciadoAudio']['name']);
				$directorio = "../../../Files/$itemID/AUDIO";
				if(!file_exists($directorio))
					mkdir($directorio, 0777, true);
				$uploadfile = $directorio ."/". basename
                ($_FILES['enunciadoAudio']['name']);
				if (!move_uploaded_file($_FILES['enunciadoAudio']
                    ['tmp_name'], $uploadfile))
				{
					echo "0";
					die();
				}
			}
		}
		
		$resultado = $objItem -> _GUARDAR_EDITAR($itemID,$nombre, $dificultad,
            $tipo, $clasificacion, $tEnunciado, $descripcion, $areaC,$enunciado);
		if($resultado == 0)
		{
			echo $resultado;
			die();
		}
		if($objItem -> _ELIMINAR_RESPUESTAS($itemID) == 0)
		{
			echo $resultado;
			die();
		}
		$resultado = $objItem -> _GUARDAR_RESPUESTAS_NUEVO($itemID, $respuesta,
            $acierto, $clasificacion);
		if($resultado > 1)
		{
			header("location:../interfaz/interfaz.listado.php");
		}
	}
	if($clasificacion == 3 || $clasificacion == 1)#Las respuestas son Audio
	{
		if($tEnunciado == 1)
		{
			$enunciado = basename($_FILES['enunciadoImg']['name']);
			$directorio = "../../../Files/$itemID/IMG";
			if(!file_exists($directorio))
				mkdir($directorio, 0777, true);
			$uploadfile = $directorio ."/". basename($_FILES['enunciadoImg']['name']);
			if (!move_uploaded_file($_FILES['enunciadoImg']['tmp_name'][$i],
                $uploadfile))
			{
				echo "0";
				die();
			}
		}
		if($tEnunciado == 2)
		{
			$enunciado = $enunciadoTxt;
		}
		if($tEnunciado == 3)
		{
			$enunciado = basename($_FILES['enunciadoAudio']['name']);
			$directorio = "../../../Files/$itemID/AUDIO";
			if(!file_exists($directorio))
				mkdir($directorio, 0777, true);
			$uploadfile = $directorio ."/". basename($_FILES['enunciadoAudio']
                ['name']);
			if (!move_uploaded_file($_FILES['enunciadoAudio']['tmp_name'][$i],
                $uploadfile)){
				echo "0";
				die();
			}
		}
		$descripcionR = array();
		$descripcionR[] = '';
		$resultado =  $objItem -> _GUARDAR_EDITAR($itemID,$nombre, $dificultad,
            $tipo, $clasificacion, $tEnunciado, $descripcion, $areaC, $enunciado);
		if($objItem -> _ELIMINAR_RESPUESTAS($itemID) == 0)
		{
			echo $resultado;
			die();
		}
		if($clasificacion == 1)
			$directorio = "../../../Files/$itemID/IMG";
		if($clasificacion == 3)
			$directorio = "../../../Files/$itemID/AUDIO";
		if(!file_exists($directorio))
			mkdir($directorio, 0777, true);
		for($i = 1; $i < count($_FILES['respuesta']['name']); $i++){
			$uploadfile = $directorio ."/". basename($_FILES['respuesta']['name'][$i]);
			$descripcionR[] = basename($_FILES['respuesta']['name'][$i]);
			if (!move_uploaded_file($_FILES['respuesta']['tmp_name'][$i], $uploadfile))
			{
				echo "0";
				die();
			}
		}
		if(count($descripcionR)> 1 && count($acierto) > 1)
		{
			$resultado = $objItem -> _GUARDAR_RESPUESTAS_NUEVO($itemID, 
                $descripcionR, $acierto, $clasificacion,0);
			if($resultado == 0)
			{
				echo "0";
				die();
			}
		}
		$resultado = $objItem -> _GUARDAR_RESPUESTAS_NUEVO($itemID,
            $descripcionRM, $aciertoRM, $clasificacion,1);
		if($resultado == 1)	{
			header("location:../interfaz/interfaz.listado.php");
		}
		//print_r($respuesta);
	}
	
}else{
	if(isset($eliminar))
	{
		$resultado = $objItem -> _ELiminar_ITEM($itemID);
		if($resultado == 0)
		{
			echo "0";die();
		}
		$directorio = "../../../Files/$itemID";
		$objItem -> _Delete_DIRECTORY($directorio);
		echo "1";
		die();
	}
	
	if($clasificacion == 2)#Las respuestas son texto
	{
		if($tEnunciado == 1)
		{
			$enunciado = basename($_FILES['enunciadoImg']['name']);
		}
		if($tEnunciado == 2)
		{
			$enunciado = $enunciadoTxt;
		}
		if($tEnunciado == 3)
		{
			$enunciado = basename($_FILES['enunciadoAudio']['name']);
		}
		$ITEM_ID = $objItem -> _Guardar_NUEVO($nombre, $dificultad, $tipo, 
            $clasificacion, $tEnunciado, $descripcion, $areaC, $respuesta, 
            $acierto, $enunciado);
		
        if($tEnunciado == 1){
			$directorio = "../../../Files/$ITEM_ID/IMG";
			if(!file_exists($directorio))
				mkdir($directorio, 0777, true);
			$uploadfile = $directorio ."/". basename($_FILES['enunciadoImg']
                ['name']);
			if (!move_uploaded_file($_FILES['enunciadoImg']['tmp_name'],
                $uploadfile)){
				echo "0";
				die();
			}
		}
		if($tEnunciado == 3)
		{
			$directorio = "../../../Files/$ITEM_ID/AUDIO";
			if(!file_exists($directorio))
				mkdir($directorio, 0777, true);
			$uploadfile = $directorio ."/". basename($_FILES['enunciadoAudio']
                ['name']);
			if (!move_uploaded_file($_FILES['enunciadoAudio']['tmp_name'],
                $uploadfile))
			{
				echo "0";
				die();
			}
		}
		if($ITEM_ID > 0)
		{
			header("location:../interfaz/interfaz.listado.php");
		}
	}
	if($clasificacion == 3 || $clasificacion == 1)#Las respuestas son Audio
	{
		if($tEnunciado == 1)
		{
			$enunciado = basename($_FILES['enunciadoImg']['name']);
		}
		if($tEnunciado == 2)
		{
			$enunciado = $enunciadoTxt;
		}
		if($tEnunciado == 3)
		{
			$enunciado = basename($_FILES['enunciadoAudio']['name']);
		}
		
		$descripcionR = array();
		$descripcionR[] = '';
		$ITEM_ID =  $objItem -> _Guardar_NUEVO_W_FILES($nombre, $dificultad, $tipo,
            $clasificacion, $tEnunciado, $descripcion, $areaC,$enunciado);
		if($tEnunciado == 1)
		{
			$directorio = "../../../Files/$ITEM_ID/IMG";
			if(!file_exists($directorio))
				mkdir($directorio, 0777, true);
			$uploadfile = $directorio ."/". basename($_FILES['enunciadoImg']['name']);
			if (!move_uploaded_file($_FILES['enunciadoImg']['tmp_name'], $uploadfile))
			{
				echo "0";
				die();
			}
		}
		if($tEnunciado == 3)
		{
			$directorio = "../../../Files/$itemID/AUDIO";
			if(!file_exists($directorio))
				mkdir($directorio, 0777, true);
			$uploadfile = $directorio ."/". basename($_FILES['enunciadoAudio']['name']);
			if (!move_uploaded_file($_FILES['enunciadoAudio']['tmp_name'], $uploadfile))
			{
				echo "0";
				die();
			}
		}
		if($clasificacion == 1)
			$directorio = "../../../Files/$ITEM_ID/IMG";
		if($clasificacion == 3)
			$directorio = "../../../Files/$ITEM_ID/AUDIO";
		if(!file_exists($directorio))
			mkdir($directorio, 0777, true);
		for($i = 1; $i < count($_FILES['respuesta']['name']); $i++){
			$uploadfile = $directorio ."/". basename($_FILES['respuesta']['name'][$i]);
			$descripcionR[] = basename($_FILES['respuesta']['name'][$i]);
			if (!move_uploaded_file($_FILES['respuesta']['tmp_name'][$i], $uploadfile))
			{
				echo "0";
				die();
			}
		}
		$resultado = $objItem -> _GUARDAR_RESPUESTAS_NUEVO($ITEM_ID, $descripcionR, 
            $acierto, $clasificacion);
		if($resultado > 0){
			header("location:../interfaz/interfaz.listado.php");
		}
		//print_r($respuesta);
	}
}
?>

<!--//********************************************************************//-->