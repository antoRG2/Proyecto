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

Class Estudiante {

    //Atributos para la conección a la base de datos
    protected $obj_bconn;
    protected $dbh;
    protected $flag = 'ENT_SUBSTITUTE';
    //Filtros
    protected $cedula = "like %%";
    protected $usuario_id = "like %%"; // Cedula del profesor
    //Atributos propios de la clase
    protected $Nombre = array();
    protected $Cedula = array();
    protected $Seccion = array();
    protected $contador = 0;

    /*
     * Constructor de la clase el cual se encarga de establecer la conección 
     * con la base de datos directamente
     */

    function __construct() {
        require_once $_SERVER['DOCUMENT_ROOT'] . '/Sistema/DB/class.DB.php';
        $this->obj_bconn = new DBConn();
        $this->dbh = $this->obj_bconn->get_conn();
    }

    function _Query() {
        $SQL = "Select
                sysdatabase.tbl_estudiantes.cedula,
                sysdatabase.tbl_estudiantes.nombre,
                sysdatabase.tbl_estudiantes.seccion
              From
                sysdatabase.tbl_estudiantes
              Where
                sysdatabase.tbl_estudiantes.cedula {$this->cedula}";

        $this->_LIMPIAR();
        $result = MYSQLI_query($this->dbh, $SQL);

        while ($row = mysqli_fetch_array($result, MYSQLI_NUM)) {
            $this->Cedula[] = $row[0];
            $this->Nombre[] = $row[1];
            $this->Seccion[] = $row[2];
        }

        $this->contador = count($this->Cedula);
        mysqli_free_result($result);
    }
    
    function _Query_Profesores() {
        $SQL = "Select
      sysdatabase.tbl_estudiantes.cedula,
      sysdatabase.tbl_estudiantes.nombre,
      sysdatabase.tbl_estudiantes.seccion
      From
      sysdatabase.tbl_estudiantes Inner Join
      sysdatabase.tbl_profesores_estudiantes On 
      sysdatabase.tbl_profesores_estudiantes.estudiante_id =
      sysdatabase.tbl_estudiantes.cedula
      Where
     sysdatabase.tbl_profesores_estudiantes.profesor_id {$this->usuario_id}";
        $this->_LIMPIAR();
        $result = MYSQLI_query($this->dbh, $SQL);

        while ($row = mysqli_fetch_array($result, MYSQLI_NUM)) {
            $this->Cedula[] = $row[0];
            $this->Nombre[] = $row[1];
            $this->Seccion[] = $row[2];
        }

        $this->contador = count($this->Cedula);
        mysqli_free_result($result);
    }

    private function _LIMPIAR() {
        $this->Nombre = array();
        $this->Cedula = array();
        $this->Seccion = array();
        $this->contador = 0;
    }

    public function get_Contador() {
        return $this->contador;
    }

    public function get_Cedula($int) {
        if ($int < $this->contador){
            return $this->Cedula[$int];
        }
    }

    public function get_Seccion($int) {
        if ($int < $this->contador){
            return $this->Seccion[$int];
        }
    }

    public function get_Nombre($int, $FORMAT = "NORMAL") {
        if ($int < $this->contador) {
            switch ($FORMAT) {
                case "HTML" :
                    return htmlentities($this->Nombre[$int], (int) $this->flag,
                        "Windows-1252", true);
                
                    case "INPUT" :
                    return htmlspecialchars_decode(htmlspecialchars(htmlentities
                    ($this->Nombre[$int], (int) $this->flag, "Windows-1252",
                    true)), ENT_NOQUOTES);
                
                    default :
                    return $this->Nombre[$int];
            }
        }
    }

    public function set_Cedula($varchar) {
        if ($varchar == "") {
            $this->cedula = "like '%%'";
        } 
        else {
            $this->cedula = "like '%$varchar%'";
        }
    }

    public function set_Usuario_id($int) {
        if ($int == "") {
            $this->usuario_id = "like '%%'";
        } 
        else {
            $this->usuario_id = "like '%$int%'";
        }
    }

    public function GuardarNuevo($nombre, $cedula, $seccion) {
        $nombre = $this->_FREE($nombre);
        
        $SQL = "INSERT INTO sysdatabase.tbl_usuarios (cedula, clave, tipo) 
						values('$cedula','$nombre',3)"; // 3 es para estudiante
        $result = mysqli_query($this->dbh, $SQL);
        if ($result) {
            $SQL = "INSERT INTO sysdatabase.tbl_estudiantes(cedula, 
                    nombre, seccion) 
				    values('$cedula','$nombre','$seccion');";
            $result2 = mysqli_query($this->dbh, $SQL);
            return ($result2) ? 1 : 0;
        } 
        else{
            return 0;
        }
    }
        
     public function GuardarModificar($nombre, $cedula, $seccion) {
         
        $nombre = $this->_FREE($nombre);
        $SQL = "UPDATE sysdatabase.tbl_estudiantes SET nombre = '$nombre', 
        seccion = '$seccion' WHERE cedula = '$cedula';";
        
        $result = mysqli_query($this->dbh, $SQL);
        return ($result) ? TRUE : FALSE;
    }

    public function Asignar($usuario_id, $estudiante_id) {
        $SQL = "INSERT INTO sysdatabase.tbl_profesores_estudiantes
        (profesor_id, estudiante_id) values('$usuario_id', '$estudiante_id');";
        echo $SQL;
        $result = mysqli_query($this->dbh, $SQL);
        
        if ($result){
            return TRUE;
        }
        else{
            return FALSE;
        }
    }

    public function BusarEstudiante_Usuario($usuario_id, $estudiante_id) {
        $SQL = "Select
                    sysdatabase.tbl_estudiantes.cedula,
                    sysdatabase.tbl_estudiantes.nombre,
                    sysdatabase.tbl_estudiantes.seccion
                  From
                    sysdatabase.tbl_estudiantes,
                    sysdatabase.tbl_profesores_estudiantes
                  Where
                    sysdatabase.tbl_profesores_estudiantes.profesor_id 
                    = '$usuario_id' And
                    sysdatabase.tbl_profesores_estudiantes.estudiante_id
                    = '$estudiante_id';";
        
        $result = MYSQLI_query($this->dbh, $SQL);
        $row_cnt = mysqli_num_rows($result);
        
        if ($row_cnt > 0)
            return FALSE;
        else
            return TRUE;
    }
    
    public function EliminarAsignacion($cedula,$usuario){
         $SQL = "DELETE FROM sysdatabase.tbl_profesores_estudiantes where
         profesor_id = '$usuario' AND estudiante_id = '$cedula'";
        
         $result = MYSQLI_query($this->dbh, $SQL);
         if ($result){
             return TRUE;
         }
         else{
             return FALSE;
         }
        
    }
    
    public function AsignarConfiguraciones($profesor,$cedula,$dataJSON)	{
		$SQL = "DELETE FROM sysdatabase.tbl_estudiantes_configuraciones WHERE 
        estudiantes_id = '$cedula' AND profesor_id = '$profesor'";
		
        $result = mysqli_query($this->dbh, $SQL);
		
        if($result){
			
            $dataJSON = explode(",",$dataJSON);
			$values = "('$profesor','$cedula',{$dataJSON[0]},0,0)";
			for($i = 1; $i < count($dataJSON); $i++)
				$values .= ",('$profesor','$cedula',{$dataJSON[$i]},$i,0)";
			
			$SQL = "INSERT INTO sysdatabase.tbl_estudiantes_configuraciones
            (profesor_id,estudiantes_id,configuracion_id,posicion,finalizada) ";
			$SQL .= "VALUES $values;";

			$result2 = mysqli_query($this->dbh, $SQL);
			
            if($result2){
				RETURN TRUE;
            }
			RETURN FALSE;
		}
		RETURN FALSE;
	}

    private function _FREE($_VAR, $_UTF = true) {
        
        $_VAR = html_entity_decode($_VAR, (int) $this->flag);
        $_VAR = str_replace('&quot;', '"', $_VAR);
        $_VAR = mysqli_real_escape_string($this->dbh, $_VAR);
        $_VAR = mb_convert_encoding($_VAR, 'WINDOWS-1252', 'UTF-8');
        return $_VAR;
    }

}

?>



<!--//********************************************************************//-->