<?php
class Logeo {
	//Atributos para la conección a la base de datos
	protected $obj_bconn;
	protected $dbh;
	protected $SQL;
	protected $flag = 'ENT_SUBSTITUTE';

	//Filtros
	protected $cedula = "LIKE '%%'";
	protected $clave = "LIKE '%%'";

	//Atributos propios de la clase
	protected $Cedula = array();
	protected $Clave = array();
	protected $ID = array();
        protected $Tipo = array();
	protected $contador = 0;
	
	/*
	 * Constructor de la clase el cual se encarga de establecer la conección con la base de datos directamente
	 */
	function __construct() {
		require_once  $_SERVER['DOCUMENT_ROOT'].'/Sistema/DB/class.DB.php';
		$this -> obj_bconn = new DBConn();
		$this -> dbh = $this -> obj_bconn -> get_conn();
	}
	
	public function _CONSULTAR_USUARIO()
	{
		$SQL = "Select
                            sysdatabase.tbl_usuarios.id,
                            sysdatabase.tbl_usuarios.cedula,
                            sysdatabase.tbl_usuarios.clave,
                            sysdatabase.tbl_usuarios.tipo
                          From
                            sysdatabase.tbl_usuarios
                          Where
                            sysdatabase.tbl_usuarios.cedula {$this -> cedula} And
                            sysdatabase.tbl_usuarios.clave {$this -> clave}";
                          
		$this -> _LIMPIAR();
		$result = MYSQLI_query($this -> dbh, $SQL);

		while ($row = mysqli_fetch_array($result, MYSQLI_NUM)) {
			$this -> Cedula[] = $row[0];
			$this -> Clave[] = $row[1];
			$this -> ID[] = $row[2];
                        $this -> Tipo[] = $row[3];
		}

		$this -> contador = count($this -> Cedula);
		mysqli_free_result($result);
	}
	
	private function _LIMPIAR() {
		$this -> Cedula = array();
		$this -> Clave = array();
		$this -> ID = array();
                $this -> Tipo = array();
		$this -> contador = 0;
	}

	//GET DATA
	/*
	 * Funciones para obtener los datos de la clase
	 */
	public function get_Contador() {
		return $this -> contador;
	}
	public function get_ID($int)
	{
		if ($int < $this -> contador) {
			return $this -> ID[$int];
		}
	}

	public function get_Cedula($int, $FORMAT = "NORMAL") {
		if ($int < $this -> contador) {
			return $this -> Cedula[$int];
		}
	}

	public function get_Clave($int, $FORMAT = "NORMAL") {
		if ($id < $this -> contador) {
			switch($FORMAT) {
				case "HTML" :
					return htmlentities($this -> Clave[$int], (int)$this -> flag, "Windows-1252", true);
				case "INPUT" :
					return htmlspecialchars_decode(htmlspecialchars(htmlentities($this -> Clave[$int], (int)$this -> flag, "Windows-1252", true)), ENT_NOQUOTES);
				default :
					return $this -> Clave[$int];
			}
		}
	}
        
        public function get_Tipo($int){
            if ($int < $this -> contador)
                return $this -> Tipo[$int];
        }

	//SET DATA
	/*
	 * Funciones para Setiar los filtros
	 */
	public function set_Cedula($string) {
		if ($string != '') {
			$this -> cedula = "= '{$this -> _FREE($string)}'";
		} else {
			$this -> cedula = "LIKE '%%'";
		}
	}

	public function set_Clave($string) {
		if ($string != '') {
			$this -> clave = "= '{$this -> _FREE($string)}'";
		} else {
			$this -> clave = "LIKE '%%'";
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