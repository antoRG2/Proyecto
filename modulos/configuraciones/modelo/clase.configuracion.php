<?php
class Configuracion {
	//Atributos para la conección a la base de datos
	protected $obj_bconn;
	protected $dbh;
	protected $flag = 'ENT_SUBSTITUTE';

	//Filtros
	protected $id = "> 0 ";
	protected $profesorC = "like '%%'";
	protected $itemID = ">= 0";
        protected $cedula = "like %%"; // Cedula del estudiante
        protected $finalizada = ">= 0";
         
	//Atributos propios de la clase
	protected $ID = array();
	protected $Nombre = array();
	protected $Descripcion = array();
	protected $ItemsID = array();
	protected $ItemsName = array();
	protected $Publico = array();
	protected $UsuarioID = array();
	protected $contador = 0;
	protected $itemscontador = 0;
	protected $arrayJSON = array();
	protected $arrayJSONR = array(); // ARRAY para las respuestas de cada item
        protected $EstudiantesConfID = array();
	
	/*
	 * Constructor de la clase el cual se encarga de establecer la conección con la base de datos directamente
	 */
	function __construct() {
		require_once $_SERVER['DOCUMENT_ROOT'] . '/Sistema/DB/class.DB.php';
		$this -> obj_bconn = new DBConn();
		$this -> dbh = $this -> obj_bconn -> get_conn();
	}
	
	public function _QUERY()
	{
		$SQL = "
                    Select
			  sysdatabase.tbl_configuraciones.id,
			  sysdatabase.tbl_configuraciones.nombre,
			  sysdatabase.tbl_configuraciones.descripcion,
			  sysdatabase.tbl_configuraciones.publico,
			  sysdatabase. tbl_profesores_configuraciones.profesor_id
			From
			  sysdatabase.tbl_configuraciones Inner Join
			  sysdatabase. tbl_profesores_configuraciones On sysdatabase.tbl_configuraciones.id =
			    sysdatabase. tbl_profesores_configuraciones.configuracion_id
			Where
			  sysdatabase.tbl_configuraciones.id {$this -> id} And
			  sysdatabase. tbl_profesores_configuraciones.profesor_id {$this -> profesorC};";
			  			
                $this -> _LIMPIAR();
		$result = MYSQLI_query($this -> dbh, $SQL);

		while ($row = mysqli_fetch_array($result, MYSQLI_NUM)) {
			$this ->ID[] = $row[0];
			$this ->Nombre[] =  $row[1];
			$this ->Descripcion[] =  $row[2];
			$this -> Publico[] = $row[3];
			$this -> UsuarioID[] = $row[4];
		}

		$this -> contador = count($this -> ID);
		mysqli_free_result($result);
	}
	
	public function _QUERY4ITEMS()
	{
		$SQL = "Select
				  sysdatabase.tbl_item.id,
				  sysdatabase.tbl_item.nombre
				From
				  sysdatabase.tbl_configuracion_item Inner Join
				  sysdatabase.tbl_item On sysdatabase.tbl_configuracion_item.item_id = sysdatabase.tbl_item.id
				Where
				  sysdatabase.tbl_configuracion_item.configuracion_id {$this -> id}
				Order By
				  sysdatabase.tbl_configuracion_item.posicion";	
						
		$result = MYSQLI_query($this -> dbh, $SQL);

		while ($row = mysqli_fetch_array($result, MYSQLI_NUM)) {
			$this ->ItemsID[] = $row[0];
			$this ->ItemsName[] =  $row[1];
		}

		$this -> itemscontador = count($this -> ItemsID);
		mysqli_free_result($result);
	}
	
	public function _QUERY4EXC()
	{
		$SQL = "Select
				  sysdatabase.tbl_item.id,
				  sysdatabase.tbl_item.nombre,
				  sysdatabase.tbl_item.tipo,
				  sysdatabase.tbl_item.clasificacion,
				  sysdatabase.tbl_item.tipoenunciado,
				  sysdatabase.tbl_item.enunciado
				From
				  sysdatabase.tbl_item Inner Join
				  sysdatabase.tbl_configuracion_item On sysdatabase.tbl_configuracion_item.item_id = sysdatabase.tbl_item.id
				Where
				  sysdatabase.tbl_configuracion_item.configuracion_id {$this -> id};";
				  
		$result = MYSQLI_query($this -> dbh, $SQL);
		while ($row = mysqli_fetch_array($result, MYSQLI_NUM)) {
			$this -> arrayJSON[] = array($row[0],$row[1],$row[2],$row[3],$row[4],$row[5]);
				
		}

		mysqli_free_result($result);
		
	}
        
        public function _Query_Estudiante_Profesor()
        {
            $SQL = "Select
                tbl_estudiantes_configuraciones.id,
                tbl_configuraciones.id,
                tbl_configuraciones.nombre,
                tbl_configuraciones.descripcion,
                tbl_configuraciones.publico
              From
                tbl_estudiantes_configuraciones Inner Join
                tbl_configuraciones On tbl_estudiantes_configuraciones.configuracion_id =
                  tbl_configuraciones.id
              Where
                tbl_estudiantes_configuraciones.profesor_id {$this  -> profesorC} And
                tbl_estudiantes_configuraciones.estudiantes_id {$this -> cedula} And
                tbl_estudiantes_configuraciones.finalizada {$this -> finalizada}
              Order By
                tbl_estudiantes_configuraciones.posicion;";

            $this -> _LIMPIAR();
            $result = MYSQLI_query($this -> dbh, $SQL);

            while ($row = mysqli_fetch_array($result, MYSQLI_NUM)) {
                    $this -> EstudiantesConfID = $row[0];
                    $this ->ID[] = $row[1];
                    $this ->Nombre[] =  $row[2];
                    $this ->Descripcion[] =  $row[3];
                    $this -> Publico[] = $row[4];
            }

            $this -> contador = count($this -> ID);
            mysqli_free_result($result);
                
        }
	
	public function _QUERYRESP()
	{
		$this -> arrayJSONR = array();
		$SQL = "Select
				  sysdatabase.tbl_respuestas.id,
				  sysdatabase.tbl_respuestas.tipo,
				  sysdatabase.tbl_respuestas.descripcion
				From
				  sysdatabase.tbl_respuestas
				Where
				  sysdatabase.tbl_respuestas.item_id {$this -> itemID};";
				  
		$result = MYSQLI_query($this -> dbh, $SQL);
		while ($row = mysqli_fetch_array($result, MYSQLI_NUM)) {
			$this -> arrayJSONR[] = array("id" => $row[0], "tipo" => $row[1], "descripcion" => $row[2]);
				
		}

		mysqli_free_result($result);
		
	}
        
        public function _QUERYEstudiantes()
	{
		$SQL = "
                    Select
                        tbl_configuraciones.id,
                        tbl_configuraciones.nombre,
                        tbl_configuraciones.descripcion,
                        tbl_configuraciones.publico
                      From
                        tbl_configuraciones Inner Join
                        tbl_estudiantes_configuraciones
                          On tbl_estudiantes_configuraciones.configuracion_id = tbl_configuraciones.id
                      Where
                        tbl_estudiantes_configuraciones.estudiantes_id {$this -> cedula}";
			  			
		$this -> _LIMPIAR();
		$result = MYSQLI_query($this -> dbh, $SQL);

		while ($row = mysqli_fetch_array($result, MYSQLI_NUM)) {
			$this ->ID[] = $row[0];
			$this ->Nombre[] =  $row[1];
			$this ->Descripcion[] =  $row[2];
			$this -> Publico[] = $row[3];
			$this -> UsuarioID[] = $row[4];
		}

		$this -> contador = count($this -> ID);
		mysqli_free_result($result);
	}
	
	private function _LIMPIAR() {
		$this ->ID = array();
		$this ->Nombre = array();
		$this ->Descripcion = array();
		$this -> ItemsID = array();
		$this -> ItemsName = array();
		$this ->contador = 0;
		$this -> itemscontador = 0;
		$this -> arrayJSON = array();
		$this -> Publico = array();
		$this -> UsuarioID = array();
                $this -> EstudiantesConfID = array();
	}
	

	//GET DATA
	/*
	 * Funciones para obtener los datos de la clase
	 */
	public function get_Contador() {
		return $this -> contador;
	}
	
	public function get_ContadorItems() {
		return $this -> itemscontador;
	}
	
	public function get_ID($int){
		if($int < $this -> contador)
			return $this -> ID[$int];
	}
	
	public function get_UsuarioID($int){
		if($int < $this -> contador)
			return $this -> UsuarioID[$int];
	}
	
	public function get_Publico($int){
		if($int < $this -> contador)
			return $this -> Publico[$int];
	}
	
	public function get_ItemsID($int){
		if($int < $this -> itemscontador)
			return $this -> ItemsID[$int];
	}
	
	public function get_arrayJSON(){
			return $this -> arrayJSON;
	}
	
	public function get_arrayJSONR(){
			return $this -> arrayJSONR;
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
	
	public function get_ItemsName($int, $FORMAT = "NORMAL") {
		if ($int < $this -> itemscontador) {
			switch($FORMAT) {
				case "HTML" :
					return htmlentities($this -> ItemsName[$int], (int)$this -> flag, "Windows-1252", true);
				case "INPUT" :
					return htmlspecialchars_decode(htmlspecialchars(htmlentities($this -> ItemsName[$int], (int)$this -> flag, "Windows-1252", true)), ENT_NOQUOTES);
				default :
					return $this -> ItemsName[$int];
			}
		}
	}
	
	public function get_Descripcion($int, $FORMAT = "NORMAL") {
		if ($int < $this -> contador) {
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
        
        public function get_EstudianteConfID($int){
		if($int < $this -> contador)
			return $this -> EstudiantesConfID[$int];
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
			$this -> itemID = "= $int";
		} else {$this -> itemID = "> 0";
		}
	}
        
        public function set_Finalizada($int) {
		if (is_numeric($int)) {
			$this -> finalizada = "= $int";
		} else {$this -> finalizada = ">= 0";
		}
	}
	
	public function set_profesorC($varchar) {
            if ($varchar == "") {
                $this->profesorC = "like '%%'";
            } else {
                $this->profesorC = "like '%$varchar%'";
            }
	}
        
        public function set_Cedula($varchar) {
        if ($varchar == "") {
            $this->cedula = "like '%%'";
        } else {
            $this->cedula = "like '%$varchar%'";
        }
    }
			
	public function GUARDAR($nombre, $descripcion, $cedulaProfesor,$pub,$dataJSON){
		$nombre = $this->_FREE($nombre);
		$descripcion = $this->_FREE($descripcion);
				
		$SQL = "INSERT INTO sysdatabase.tbl_configuraciones(nombre,descripcion,publico) ";
		$SQL .= "VALUES('$nombre','$descripcion', $pub); ";
		
		$result = mysqli_query($this->dbh, $SQL);
                $configuracionID = mysqli_insert_id($this->dbh);
		if($result)
		{
			$id = mysqli_insert_id($this->dbh);
			$SQL = "INSERT INTO sysdatabase. tbl_profesores_configuraciones(profesor_id,configuracion_id) ";
                        $SQL .= "VALUES('{$cedulaProfesor}',$id); ";

			$result2 = mysqli_query($this->dbh, $SQL);
			if($result2)
				return $this -> GUARDAR_ITEMS($configuracionID,$dataJSON);
			else 
				return FALSE;
		}
			
		return FALSE;
		
	}
	
	private function GUARDAR_ITEMS($id,$dataJSON)
	{
		$dataJSON = explode(",",$dataJSON);
		$values = "($id,{$dataJSON[0]},0)";
		for($i = 1; $i < count($dataJSON); $i++)
			$values .= ",($id,{$dataJSON[$i]},$i)";
		
		$SQL = "INSERT INTO sysdatabase.tbl_configuracion_item(configuracion_id,item_id,posicion) ";
		$SQL .= "VALUES $values;";

		$result = mysqli_query($this->dbh, $SQL);
		if($result)
			RETURN TRUE;
		RETURN FALSE;
	}
	
	public function GUARDAR_EDITAR($id,$nombre, $descripcion, $pub,$dataJSON){
		$nombre = $this->_FREE($nombre);
		$descripcion = $this->_FREE($descripcion);
				
		$SQL = "UPDATE sysdatabase.tbl_configuraciones SET nombre = '$nombre',descripcion = '$descripcion', publico = $pub ";
		$SQL .= "WHERE id = $id; ";
		
		$result = mysqli_query($this->dbh, $SQL);
		if($result)
			return $this -> GUARDAR_EDITAR_ITEMS($id,$dataJSON);
		return FALSE;
		
	}
	
	private function GUARDAR_EDITAR_ITEMS($id,$dataJSON)
	{
		$SQL = "DELETE FROM sysdatabase.tbl_configuracion_item WHERE configuracion_id = $id";
		$result = mysqli_query($this->dbh, $SQL);
		if($result)
		{
			$dataJSON = explode(",",$dataJSON);
			$values = "($id,{$dataJSON[0]},0)";
			for($i = 1; $i < count($dataJSON); $i++)
				$values .= ",($id,{$dataJSON[$i]},$i)";
			
			$SQL = "INSERT INTO sysdatabase.tbl_configuracion_item(configuracion_id,item_id,posicion) ";
			$SQL .= "VALUES $values;";
			
			$result2 = mysqli_query($this->dbh, $SQL);
			if($result2)
				RETURN TRUE;
			RETURN FALSE;
		}
		RETURN FALSE;
	}
	
	public function Eliminar($id){
		$SQL = "DELETE FROM sysdatabase.tbl_configuracion_item WHERE configuracion_id = $id";
		$result = mysqli_query($this->dbh, $SQL);
		if($result)
		{
			$SQL = "DELETE FROM sysdatabase.tbl_configuraciones WHERE id = $id";
			$result2 = mysqli_query($this->dbh, $SQL);
			if($result2)
				RETURN TRUE;
			RETURN FALSE;
		}
		RETURN FALSE;
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