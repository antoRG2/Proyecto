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
class Respuesta {
	//Atributos para la conección a la base de datos
	protected $obj_bconn;
	protected $dbh;
	protected $flag = 'ENT_SUBSTITUTE';

	//Filtros
	protected $id = "> 0 ";
	protected $item_id = "> 0";
	protected $acierto = ">= 0";
	

	//Atributos propios de la clase
	protected $ID = array();
	protected $item_ID = array();
	protected $Acierto = array();
	protected $Tipo = array();
	protected $Descripcion = array();
	protected $contador = 0;
	
	/*
	 * Constructor de la clase el cual se encarga de establecer la conección con 
     * la base de datos directamente
	 */
	function __construct() {
		require_once  '../../../DB/class.DB.php';
		$this -> obj_bconn = new DBConn();
		$this -> dbh = $this -> obj_bconn -> get_conn();
	}
	
	public function _QUERY()
	{
		$SQL = "Select
				  SysDataBase.Tbl_respuestas.id,
				  SysDataBase.Tbl_respuestas.item_id,
				  SysDataBase.Tbl_respuestas.acierto,
				  SysDataBase.Tbl_respuestas.tipo,
				  SysDataBase.Tbl_respuestas.descripcion
				From
				  SysDataBase.Tbl_respuestas
				Where
				  SysDataBase.Tbl_respuestas.id {$this -> id} And
				  SysDataBase.Tbl_respuestas.item_id {$this -> item_id} And
				  SysDataBase.Tbl_respuestas.acierto {$this -> acierto};";
						
		$this -> _LIMPIAR();
		$result = MYSQLI_query($this -> dbh, $SQL);

		while ($row = mysqli_fetch_array($result, MYSQLI_NUM)) {
			$this ->ID[] = $row[0];
			$this ->item_ID[] = $row[1];
			$this ->Acierto[] = $row[2];
			$this ->Tipo[] = $row[3];
			$this ->Descripcion[] = $row[4];
			
		}

		$this -> contador = count($this -> ID);
		mysqli_free_result($result);
	}
	
	private function _LIMPIAR() {
		$this ->ID = array();
		$this ->item_ID = array();
		$this ->Acierto = array();
		$this ->Tipo = array();
		$this ->Descripcion = array();
		$this ->contador = 0;
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
	
	public function get_Item_ID($int){
		if($int < $this -> contador)
			return $this -> item_ID[$int];
	}
	
	public function get_Acierto($int){
		if($int < $this -> contador)
			return $this -> Acierto[$int];
	}
		
	public function get_Tipo($int){
		if($int < $this -> contador)
			return $this -> Tipo[$int];
	}
		
	public function get_Descripcion($int, $FORMAT = "NORMAL") {
		if ($int < $this -> contador) {
			switch($FORMAT) {
				case "HTML" :
					return htmlentities($this -> Descripcion[$int], (int)$this ->
                        flag, "Windows-1252", true);
				case "INPUT" :
					return htmlspecialchars_decode(htmlspecialchars(htmlentities
                    ($this -> Descripcion[$int], (int)$this -> flag, 
                    "Windows-1252", true)), ENT_NOQUOTES);
				default :
					return $this -> Descripcion[$int];
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
	
	public function set_ItemID($int) {
		if (is_numeric($int) && $int > 0) {
			$this -> item_id = "= $int";
		} else {$this -> item_id = "> 0";
		}
	}
	
	public function set_Acierto($int) {
		if (is_numeric($int) && $int > 0) {
			$this -> acierto = "= $int";
		} else {$this -> acierto = ">= 0";
		}
	}
	
	public function _ELiminar_Respuesta($ID)
	{
		$SQL = "DELETE FROM SysDataBase.Tbl_respuestas WHERE id = $ID;";
		$result = mysqli_query($this->dbh, $SQL);
		if($result)
			return 1;
		return 0;
	}
	
	public function _Delete_FILE($_FILE) {
	    if (file_exists($_FILE)){
	  	  return unlink($_FILE);
	    }
		return true;
	}
}
?>

<!--//********************************************************************//-->