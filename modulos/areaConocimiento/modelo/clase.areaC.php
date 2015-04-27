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
class AreaC {
	//Atributos para la conección a la base de datos
	protected $obj_bconn;
	protected $dbh;
	protected $SQL;
	protected $flag = 'ENT_SUBSTITUTE';

	//Filtros
	protected $id = "> 0 ";

	//Atributos propios de la clase
	protected $ID = array();
	protected $Nombre = array();
	protected $contador = 0;
	
	/*
	 * Constructor de la clase el cual se encarga de establecer la conexión 
     * con la base de datos directamente
	 */
	function __construct() {
		$_SERVER['DOCUMENT_ROOT'].'/Sistema/DB/class.DB.php';
		$this -> obj_bconn = new DBConn();
		$this -> dbh = $this -> obj_bconn -> get_conn();
	}
	
	public function _QUERY()
	{
		$SQL = "SELECT 
				    SysDataBase.tbl_areaconocimiento.id, 
                    SysDataBase.tbl_areaconocimiento.nombre
				FROM
				    SysDataBase.tbl_areaconocimiento
				WHERE
				    SysDataBase.tbl_areaconocimiento.id {$this -> id}";
						
		$this -> _LIMPIAR();
		$result = MYSQLI_query($this -> dbh, $SQL);

		while ($row = mysqli_fetch_array($result, MYSQLI_NUM)) {
			$this -> ID[] = $row[0];
			$this -> Nombre[] = $row[1];
		}

		$this -> contador = count($this -> Nombre);
		mysqli_free_result($result);
	}
	
	private function _LIMPIAR() {
		$this ->ID = array();
		$this ->Nombre = array();
		$this ->contador = 0;
	}
	
	public function Guardar($id,$nombre,$modificar = 0)
	{
		$nombre = $this -> _FREE($nombre);
		if($modificar == 0)
			$SQL = "INSERT INTO SysDataBase.tbl_areaconocimiento(nombre) 
            VALUES ('$nombre');";
		else 
			$SQL = "UPDATE SysDataBase.tbl_areaconocimiento set nombre =
            '$nombre' WHERE id = $id;";
		
		$result = mysqli_query($this->dbh, $SQL);
		if($result)
			return 1;
		return 0;
	}
	
	public function Eliminar($id)
	{
		$SQL = "DELETE FROM SysDataBase.tbl_areaconocimiento WHERE id = $id;";
		$result = mysqli_query($this->dbh, $SQL);
		if($result)
			return 1;
		return 0;
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
					return htmlentities($this -> Nombre[$int], 
                        (int)$this -> flag, "Windows-1252", true);
				
                case "INPUT" :
					return htmlspecialchars_decode(htmlspecialchars
                    (htmlentities($this -> Nombre[$int], (int)$this -> flag, 
                    "Windows-1252", true)), ENT_NOQUOTES);
				
                default :
					return $this -> Nombre[$int];
			}
		}
	}
	
	public function _HTML_SELECT($int = 0)
	{
		$_html = "<select name='areaC' id='areaC'>";
		if($int == 0)
			$_html .="<option value='0' selected>...</option>";
		else
			$_html .="<option value='0'>...</option>";
		for($i = 0; $i < $this -> contador; $i++){
			
            if($int == $this -> get_ID($i)){
				$_html .= "<option value='".$this -> get_ID($i)."' selected>"
                .$this -> get_Nombre($i,"INPUT")."</option>";
            }
			else{
				$_html .= "<option value='".$this -> get_ID($i)."'>"
                .$this -> get_Nombre($i,"INPUT")."</option>";
            }
		}
        
		$_html .= "</select>";
		return $_html;
	}
	
	//SET DATA
	/*
	 * Funciones para Setiar los filtros
	 */
	public function set_ID($int) {
		
        if (is_numeric($int) && $int > 0) {
			$this -> id = "= $int";
		} 
        else {
            $this -> id = "> 0";
		}
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

<!--//********************************************************************//-->   