<?php

Class Estudiante {

    //Atributos para la conección a la base de datos
    protected $obj_bconn;
    protected $dbh;
    protected $flag = 'ENT_SUBSTITUTE';
    //Filtros
    protected $cedula = "like %%";
    protected $usuario_id = ">= 0"; // ID del profesor
    //Atributos propios de la clase
    protected $ID = array();
    protected $Nombre = array();
    protected $Cedula = array();
    protected $Seccion = array();
    protected $contador = 0;

    /*
     * Constructor de la clase el cual se encarga de establecer la conección con la base de datos directamente
     */

    function __construct() {
        require_once '../../../DB/class.DB.php';
        $this->obj_bconn = new DBConn();
        $this->dbh = $this->obj_bconn->get_conn();
    }

    function _Query() {
        $SQL = "Select
                sysdatabase.tbl_estudiantes.id,
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
            $this->ID[] = $row[0];
            $this->Cedula[] = $row[1];
            $this->Nombre[] = $row[2];
            $this->Seccion[] = $row[3];
        }

        $this->contador = count($this->ID);
        mysqli_free_result($result);
    }
    
    function _Query_Profesores() {
        $SQL = "Select
  sysdatabase.tbl_estudiantes.id,
  sysdatabase.tbl_estudiantes.cedula,
  sysdatabase.tbl_estudiantes.nombre,
  sysdatabase.tbl_estudiantes.seccion
From
  sysdatabase.tbl_estudiantes Inner Join
  sysdatabase.tbl_profesores_estudiantes On sysdatabase.tbl_profesores_estudiantes.estudiante_id =
  sysdatabase.tbl_estudiantes.id
Where
  sysdatabase.tbl_profesores_estudiantes.profesor_id {$this->usuario_id}";

        $this->_LIMPIAR();
        $result = MYSQLI_query($this->dbh, $SQL);

        while ($row = mysqli_fetch_array($result, MYSQLI_NUM)) {
            $this->ID[] = $row[0];
            $this->Cedula[] = $row[1];
            $this->Nombre[] = $row[2];
            $this->Seccion[] = $row[3];
        }

        $this->contador = count($this->ID);
        mysqli_free_result($result);
    }

    private function _LIMPIAR() {
        $this->ID = array();
        $this->Nombre = array();
        $this->Cedula = array();
        $this->Seccion = array();
        $this->contador = 0;
    }

    public function get_Contador() {
        return $this->contador;
    }

    public function get_ID($int) {
        if ($int < $this->contador)
            return $this->ID[$int];
    }

    public function get_Cedula($int) {
        if ($int < $this->contador)
            return $this->Cedula[$int];
    }

    public function get_Seccion($int) {
        if ($int < $this->contador)
            return $this->Seccion[$int];
    }

    public function get_Nombre($int, $FORMAT = "NORMAL") {
        if ($int < $this->contador) {
            switch ($FORMAT) {
                case "HTML" :
                    return htmlentities($this->Nombre[$int], (int) $this->flag, "Windows-1252", true);
                case "INPUT" :
                    return htmlspecialchars_decode(htmlspecialchars(htmlentities($this->Nombre[$int], (int) $this->flag, "Windows-1252", true)), ENT_NOQUOTES);
                default :
                    return $this->Nombre[$int];
            }
        }
    }

    public function set_Cedula($varchar) {
        if ($varchar == "") {
            $this->cedula = "like '%%'";
        } else {
            $this->cedula = "like '%$varchar%'";
        }
    }

    public function set_Usuario_id($int) {
        if (is_numeric($int) && $int > 0) {
            $this->usuario_id = "= $int";
        } else {
            $this->usuario_id = "> 0";
        }
    }

    public function GuardarNuevo($nombre, $cedula, $seccion) {
        $new_id = 0;
        $nombre = $this->_FREE($nombre);
        
        $SQL = "INSERT INTO sysdatabase.tbl_usuarios (nombre, clave, tipo) 
						values('$nombre','$nombre',3)"; // 3 es para estudiante
        $result = mysqli_query($this->dbh, $SQL);
        if ($result) {
            $new_id = mysqli_insert_id($this->dbh);
            $SQL = "INSERT INTO sysdatabase.tbl_estudiantes(id,cedula, nombre, seccion) 
				values($new_id,'$cedula','$nombre','$seccion');";
            $result2 = mysqli_query($this->dbh, $SQL);
            return ($result2) ? $new_id : 0;
        } else
            return 0;
    }
    
     public function GuardarModificar($id,$nombre, $cedula, $seccion) {
         
        $nombre = $this->_FREE($nombre);
        $SQL = "UPDATE sysdatabase.tbl_estudiantes SET cedula = '$cedula', nombre = '$nombre', seccion = '$seccion' 
                WHERE id = $id;";
        $result = mysqli_query($this->dbh, $SQL);
        if ($result) {
            $SQL = "UPDATE sysdatabase.tbl_usuarios SET nombre = '$nombre' WHERE id = $id;";
            $result2 = mysqli_query($this->dbh, $SQL);
            return ($result2) ? TRUE : FALSE;
        } else
            return FALSE;
    }

    public function Asignar($usuario_id, $estudiante_id) {
        $SQL = "INSERT INTO sysdatabase.tbl_profesores_estudiantes(profesor_id, estudiante_id) 
				values($usuario_id, $estudiante_id);";
        $result = mysqli_query($this->dbh, $SQL);
        if ($result)
            return TRUE;
        else
            return FALSE;
    }

    public function BusarEstudiante_Usuario($usuario_id, $estudiante_id) {
        $SQL = "Select
                    sysdatabase.tbl_estudiantes.id,
                    sysdatabase.tbl_estudiantes.cedula,
                    sysdatabase.tbl_estudiantes.nombre,
                    sysdatabase.tbl_estudiantes.seccion
                  From
                    sysdatabase.tbl_estudiantes,
                    sysdatabase.tbl_profesores_estudiantes
                  Where
                    sysdatabase.tbl_profesores_estudiantes.profesor_id = $usuario_id And
                    sysdatabase.tbl_profesores_estudiantes.estudiante_id = $estudiante_id;";
        $result = MYSQLI_query($this->dbh, $SQL);
        $row_cnt = mysqli_num_rows($result);
        if ($row_cnt > 0)
            return FALSE;
        else
            return TRUE;
    }
    
    public function EliminarAsignacion($id,$usuario_id)
    {
         $SQL = "DELETE FROM sysdatabase.tbl_profesores_estudiantes where profesor_id = $usuario_id AND estudiante_id = $id";
        $result = MYSQLI_query($this->dbh, $SQL);
        if ($result)
            return TRUE;
        else
            return FALSE;
        
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