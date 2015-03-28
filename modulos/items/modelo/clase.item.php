<?php
class Item {
	//Atributos para la conección a la base de datos
	protected $obj_bconn;
	protected $dbh;
	protected $flag = 'ENT_SUBSTITUTE';

	//Filtros
	protected $id = "> 0 ";
	protected $areaconocimiento_id = "> 0";
	protected $dificultad = "> 0";
	protected $tipo = "> 0";
	protected $clasificacion = "> 0";
	protected $tipoenunciado = "> 0";
	

	//Atributos propios de la clase
	protected $ID = array();
	protected $Nombre = array();
	protected $Dificultad = array();
	protected $Tipo = array();
	protected $Clasificacion = array();
	protected $Tipoenunciado = array();
	protected $Descripcion = array();
	protected $areaconocimiento_ID = array();
	protected $areaconocimiento = array();//Nombre del Área de Conocimiento
	protected $Enunciado = array();
	protected $contador = 0;
	
	/*
	 * Constructor de la clase el cual se encarga de establecer la conección con la base de datos directamente
	 */
	function __construct() {
		require_once  '../../../DB/class.DB.php';
		$this -> obj_bconn = new DBConn();
		$this -> dbh = $this -> obj_bconn -> get_conn();
	}
	
	public function _QUERY()
	{
		$SQL = "SELECT 
				    sysdatabase.tbl_item.id,
				    sysdatabase.tbl_item.nombre,
				    sysdatabase.tbl_item.dificultad,
				    sysdatabase.tbl_item.tipo,
				    sysdatabase.tbl_item.clasificacion,
				    sysdatabase.tbl_item.tipoenunciado,
				    sysdatabase.tbl_item.descripcion,
				    sysdatabase.tbl_item.areaconocimiento_id,
				    sysdatabase.tbl_areaconocimiento.nombre AS AreaConocimiento,
				    sysdatabase.tbl_item.enunciado
				FROM
				    sysdatabase.tbl_item
				        INNER JOIN
				    sysdatabase.tbl_areaconocimiento ON sysdatabase.tbl_item.areaconocimiento_id = sysdatabase.tbl_areaconocimiento.id
				WHERE
				    sysdatabase.tbl_item.id {$this -> id}
				    AND sysdatabase.tbl_item.dificultad {$this -> dificultad}
				    AND sysdatabase.tbl_item.tipo {$this -> tipo}
				    AND sysdatabase.tbl_item.clasificacion {$this -> clasificacion}
				    AND sysdatabase.tbl_item.tipoenunciado {$this -> tipoenunciado}
				    AND sysdatabase.tbl_item.areaconocimiento_id {$this-> areaconocimiento_id}";
						
		$this -> _LIMPIAR();
		$result = MYSQLI_query($this -> dbh, $SQL);

		while ($row = mysqli_fetch_array($result, MYSQLI_NUM)) {
			$this ->ID[] = $row[0];
			$this ->Nombre[] =  $row[1];
			$this ->Dificultad[] =  $row[2];
			$this ->Tipo[] =  $row[3];
			$this ->Clasificacion[] =  $row[4];
			$this ->Tipoenunciado[] =  $row[5];
			$this ->Descripcion[] =  $row[6];
			$this ->areaconocimiento_ID[] =  $row[7];
			$this ->areaconocimiento[] =  $row[8];//Nombre del Área de Conocimiento
			$this -> Enunciado[] = $row[9];
		}

		$this -> contador = count($this -> Nombre);
		mysqli_free_result($result);
	}
	
	public function _QUERY_4_CONFIGURACIONES($CONFID, $ORDER_FILTER = 0)
	{
		$SQL = "SELECT 
				    sysdatabase.tbl_item.id,
				    sysdatabase.tbl_item.nombre,
				    sysdatabase.tbl_item.dificultad,
				    sysdatabase.tbl_item.tipo,
				    sysdatabase.tbl_item.clasificacion,
				    sysdatabase.tbl_item.tipoenunciado,
				    sysdatabase.tbl_item.descripcion,
				    sysdatabase.tbl_item.areaconocimiento_id,
				    sysdatabase.tbl_areaconocimiento.nombre AS AreaConocimiento,
				    sysdatabase.tbl_item.enunciado
				FROM
				    sysdatabase.tbl_item
				        INNER JOIN
				    sysdatabase.tbl_areaconocimiento ON sysdatabase.tbl_item.areaconocimiento_id = sysdatabase.tbl_areaconocimiento.id
				WHERE
				    (item.id NOT IN (SELECT 
				            sysdatabase.tbl_item.item_id
				        FROM
				            sysdatabase.tbl_configuracion_item
				        WHERE
				            sysdatabase.tbl_configuracion_item.configuracion_id = $CONFID)
				        AND sysdatabase.tbl_item.id {$this -> id})
				        AND sysdatabase.tbl_item.dificultad {$this -> dificultad}
				        AND sysdatabase.tbl_item.tipo {$this -> tipo}
				        AND sysdatabase.tbl_item.clasificacion {$this -> clasificacion}
				        AND sysdatabase.tbl_item.tipoenunciado {$this -> tipoenunciado}
				        AND sysdatabase.tbl_item.areaconocimiento_id {$this-> areaconocimiento_id} ";
		if($ORDER_FILTER == 1)
			$SQL .= "ORDER BY sysdatabase.tbl_item.dificultad;";
		if($ORDER_FILTER == 2)
			$SQL .= "ORDER BY sysdatabase.tbl_item.areaconocimiento_id;";
						
		$this -> _LIMPIAR();
		$result = MYSQLI_query($this -> dbh, $SQL);

		while ($row = mysqli_fetch_array($result, MYSQLI_NUM)) {
			$this ->ID[] = $row[0];
			$this ->Nombre[] =  $row[1];
			$this ->Dificultad[] =  $row[2];
			$this ->Tipo[] =  $row[3];
			$this ->Clasificacion[] =  $row[4];
			$this ->Tipoenunciado[] =  $row[5];
			$this ->Descripcion[] =  $row[6];
			$this ->areaconocimiento_ID[] =  $row[7];
			$this ->areaconocimiento[] =  $row[8];//Nombre del Área de Conocimiento
			$this -> Enunciado[] = $row[9];
		}

		$this -> contador = count($this -> Nombre);
		mysqli_free_result($result);
	}
	private function _LIMPIAR() {
		$this ->ID = array();
		$this ->Nombre = array();
		$this ->Dificultad = array();
		$this ->Tipo = array();
		$this ->Clasificacion = array();
		$this ->Tipoenunciado = array();
		$this -> Enunciado = array();
		$this ->Descripcion = array();
		$this ->areaconocimiento_ID = array();
		$this ->areaconocimiento = array();//Nombre del Área de Conocimiento
		$this ->contador = 0;
	}
	
	public function _TXTDIFICULTAD($int)
	{
		switch ($int) {
			case 1:
				return "F&aacute;cil";
				break;
			case 2:
				return "Medio";
				break;
			case 3:
				return "Dificil";
				break;
			default:
				return "N/A";
				break;
		}
	}
	
	public function _TXTTIPO($int)
	{
		switch ($int) {
			case 1:
				return "Seleci&oacute;n &Uacute;nica";
				break;
			case 2:
				return "Drag / Drop";
				break;
			default:
				return "N/A";
				break;
		}
	}
	
	public function _TXTCLASIFICACION($int)
	{
		switch ($int) {
			case 1:
				return "Imagenes";
				break;
			case 2:
				return "Texto";
				break;
			case 3:
				return "Audio";
				break;
			default:
				return "N/A";
				break;
		}
	}

	//GET DATA
	/*
	 * Funciones para obtener los datos de la clase
	 */
	public function get_Contador() {
		return $this -> contador;
	}
	
	public function get_ID($int){
		if($int < $this -> contador)
			return $this -> ID[$int];
	}
	
	public function get_Nombre($int, $FORMAT = "NORMAL") {
		if ($int < $this -> contador) {
			switch($FORMAT) {
				case "HTML" :
					return htmlentities($this -> Nombre[$int], (int)$this -> flag, "Windows-1252", true);
				case "INPUT" :
					return htmlspecialchars_decode(htmlspecialchars(htmlentities($this -> Nombre[$int], (int)$this -> flag, "Windows-1252", true)), ENT_NOQUOTES);
				default :
					return $this -> Nombre[$int];
			}
		}
	}
	
	public function get_Dificultad($int){
		if($int < $this -> contador)
			return $this -> Dificultad[$int];
	}
	
	public function get_Tipo($int){
		if($int < $this -> contador)
			return $this -> Tipo[$int];
	}
	
	public function get_Clasificacion($int){
		if($int < $this -> contador)
			return $this -> Clasificacion[$int];
	}
	
	public function get_Tipoenunciado($int){
		if($int < $this -> contador)
			return $this -> Tipoenunciado[$int];
	}
	
	public function get_Enunciado($int, $FORMAT = "NORMAL") {
		if ($int < $this -> contador) {
			switch($FORMAT) {
				case "HTML" :
					return htmlentities($this -> Enunciado[$int], (int)$this -> flag, "Windows-1252", true);
				case "INPUT" :
					return htmlspecialchars_decode(htmlspecialchars(htmlentities($this -> Enunciado[$int], (int)$this -> flag, "Windows-1252", true)), ENT_NOQUOTES);
				default :
					return $this -> Enunciado[$int];
			}
		}
	}
	
	public function get_Descripcion($int, $FORMAT = "NORMAL") {
		if ($id < $this -> contador) {
			switch($FORMAT) {
				case "HTML" :
					return htmlentities($this -> Descripcion[$int], (int)$this -> flag, "Windows-1252", true);
				case "INPUT" :
					return htmlspecialchars_decode(htmlspecialchars(htmlentities($this -> Descripcion[$int], (int)$this -> flag, "Windows-1252", true)), ENT_NOQUOTES);
				default :
					return $this -> Descripcion[$int];
			}
		}
	}
	
	public function get_AreaConocimiento_ID($int){
		if($int < $this -> contador)
			return $this -> areaconocimiento_ID[$int];
	}
	
	public function get_AreaConocimiento($int, $FORMAT = "NORMAL") {
		if ($id < $this -> contador) {
			switch($FORMAT) {
				case "HTML" :
					return htmlentities($this -> areaconocimiento[$int], (int)$this -> flag, "Windows-1252", true);
				case "INPUT" :
					return htmlspecialchars_decode(htmlspecialchars(htmlentities($this -> areaconocimiento[$int], (int)$this -> flag, "Windows-1252", true)), ENT_NOQUOTES);
				default :
					return $this -> areaconocimiento[$int];
			}
		}
	}
	
	//SET DATA
	/*
	 * Funciones para Setiar los filtros
	 */
	public function set_ID($int) {
		if (is_numeric($int) && $int > 0) {
			$this -> id = "= $int";
		} else {$this -> id = "> 0";
		}
	}
	
	public function set_Areaconocimiento_ID($int) {
		if (is_numeric($int) && $int > 0) {
			$this -> areaconocimiento_id = "= $int";
		} else {$this -> areaconocimiento_id = "> 0";
		}
	}
	
	public function set_Dificultad($int) {
		if (is_numeric($int) && $int > 0) {
			$this -> dificultad = "= $int";
		} else {$this -> dificultad = "> 0";
		}
	}
	
	public function set_Tipo($int) {
		if (is_numeric($int) && $int > 0) {
			$this -> tipo = "= $int";
		} else {$this -> tipo = "> 0";
		}
	}
	
	public function set_Clasificacion($int) {
		if (is_numeric($int) && $int > 0) {
			$this -> clasificacion = "= $int";
		} else {$this -> clasificacion = "> 0";
		}
	}
	
	public function set_Tipoenunciado($int) {
		if (is_numeric($int) && $int > 0) {
			$this -> tipoenunciado = "= $int";
		} else {$this -> tipoenunciado = "> 0";
		}
	}
		
	public function _Guardar_NUEVO($nombre, $dificultad, $tipo, $clasificacion, $tEnunciado, $descripcion, $areaC, $respuesta, $acierto,$enunciado){
		
		$nombre = $this->_FREE($nombre);
		$descripcion = $this->_FREE($descripcion);
		$enunciado = $this->_FREE($enunciado);
		
		$SQL = "INSERT INTO sysdatabase.tbl_item(nombre,dificultad,tipo, clasificacion,tipoenunciado,descripcion,areaconocimiento_id,enunciado) ";
		$SQL .= "VALUES('$nombre',$dificultad,$tipo,$clasificacion,$tEnunciado,'$descripcion',$areaC,'$enunciado'); ";
		
		$result = mysqli_query($this->dbh, $SQL);
		if($result)
			return $this -> _GUARDAR_RESPUESTAS_NUEVO(mysqli_insert_id($this->dbh), $respuesta, $acierto,$clasificacion);
		else
			return '0';
	}
	
	public function _Guardar_NUEVO_W_FILES($nombre, $dificultad, $tipo, $clasificacion, $tEnunciado, $descripcion, $areaC,$enunciado){
		
		$nombre = $this->_FREE($nombre);
		$descripcion = $this->_FREE($descripcion);
		$enunciado = $this->_FREE($enunciado);
		
		$SQL = "INSERT INTO sysdatabase.tbl_item(nombre,dificultad,tipo, clasificacion,tipoenunciado,descripcion,areaconocimiento_id,enunciado) ";
		$SQL .= "VALUES('$nombre',$dificultad,$tipo,$clasificacion,$tEnunciado,'$descripcion',$areaC,'$enunciado'); ";
		
		$result = mysqli_query($this->dbh, $SQL);
		if($result)
			return mysqli_insert_id($this->dbh);
		else
			return '0';
	}
	
	public function _GUARDAR_EDITAR($itemID,$nombre, $dificultad, $tipo, $clasificacion, $tEnunciado, $descripcion, $areaC,$enunciado){
		
		$nombre = $this->_FREE($nombre);
		$descripcion = $this->_FREE($descripcion);
		$enunciado = $this->_FREE($enunciado);
		$SQL = "UPDATE sysdatabase.tbl_item SET nombre = '$nombre',dificultad = $dificultad,tipo = $tipo, clasificacion = $clasificacion,tipoenunciado = $tEnunciado,descripcion = '$descripcion',areaconocimiento_id = $areaC, enunciado = '$enunciado'";
		$SQL .= " WHERE id = $itemID; ";
		
		$result = mysqli_query($this->dbh, $SQL);
		if($result)
			return 1;
		else
			return 0;
	}
	
	public function _GUARDAR_RESPUESTAS_NUEVO($itemID, $respuesta, $acierto,$clasificacion,$modificar = 0){
		if($modificar == 0)	
		{
			$value = "VALUES($itemID,".$acierto[1].",$clasificacion,'".$this -> _FREE($respuesta[1])."')";	
			for($i = 2; $i < count($respuesta); $i++)
			{
				$value .= ",($itemID,".$acierto[$i].",$clasificacion,'".$this -> _FREE($respuesta[$i])."')";
			}
		}
		else{
			$value = "VALUES($itemID,".$acierto[0].",$clasificacion,'".$this -> _FREE($respuesta[0])."')";	
			for($i = 1; $i < count($respuesta); $i++)
			{
				$value .= ",($itemID,".$acierto[$i].",$clasificacion,'".$this -> _FREE($respuesta[$i])."')";
			}
		}
		$SQL = "INSERT INTO sysdatabase.tbl_respuestas (item_id, acierto, tipo, descripcion) ";
		$SQL .= "$value;";
		$result = mysqli_query($this->dbh, $SQL);
		if($result)
			return $itemID;
		else
			return 0;
	}
	
	public function _ELiminar_ITEM($ITEM_ID)
	{
		$SQL = "DELETE  FROM sysdatabase.tbl_respuestas WHERE item_id = $ITEM_ID";
		$result = mysqli_query($this->dbh, $SQL);
		if($result)
		{
			$SQL = "DELETE  FROM sysdatabase.tbl_item WHERE id = $ITEM_ID";
			$result2 = mysqli_query($this->dbh, $SQL);
			if($result2)
				return 1;
			return 0;
		}
		else
			return 0;
	}
	
	public function _ELIMINAR_RESPUESTAS($ITEM_ID){
		$SQL = "DELETE  FROM sysdatabase.tbl_respuestas WHERE item_id = $ITEM_ID";
		$result = mysqli_query($this->dbh, $SQL);
		if($result)
			return 1;
		return 0;
	}
	
	public function _Delete_DIRECTORY($dir) {
	    if (!file_exists($dir)) return true;
	    if (!is_dir($dir)) return unlink($dir);
	    foreach (scandir($dir) as $item) {
	        if ($item == '.' || $item == '..') continue;
	        if (!$this -> _Delete_DIRECTORY($dir.DIRECTORY_SEPARATOR.$item)) return false;
	    }
	    return rmdir($dir);
	}
	
	private function _FREE($_VAR, $_UTF=true){
			 $_VAR = html_entity_decode ($_VAR, (int)$this->flag);
			 $_VAR = str_replace('&quot;', '"', $_VAR);
			 $_VAR = mysqli_real_escape_string($this->dbh,$_VAR);
			 $_VAR = mb_convert_encoding($_VAR, 'WINDOWS-1252' , 'UTF-8');
			 return $_VAR;
		}

}
?>