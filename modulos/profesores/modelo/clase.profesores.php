<?php

Class Profesor {

    //Atributos para la conección a la base de datos
    protected $obj_bconn;
    protected $dbh;
    protected $flag = 'ENT_SUBSTITUTE';
    //Filtros
    protected $cedula = "like %%";
    protected $estudiante_id = "like %%"; // Cedula del estudiante
    //Atributos propios de la clase
    protected $Nombre = array();
    protected $Cedula = array();
    protected $contador = 0;

    /*
     * Constructor de la clase el cual se encarga de establecer la conección con la base de datos directamente
     */

    function __construct() {
        require_once $_SERVER['DOCUMENT_ROOT'] . '/Sistema/DB/class.DB.php';
        $this->obj_bconn = new DBConn();
        $this->dbh = $this->obj_bconn->get_conn();
    }

    function _Query() {
        $SQL = "Select
                sysdatabase.tbl_profesores.cedula,
                sysdatabase.tbl_profesores.nombre,
              From
                sysdatabase.tbl_profesores
              Where
                sysdatabase.tbl_profesores.cedula {$this->cedula}";

        $this->_LIMPIAR();
        $result = MYSQLI_query($this->dbh, $SQL);

        while ($row = mysqli_fetch_array($result, MYSQLI_NUM)) {
            $this->Cedula[] = $row[0];
            $this->Nombre[] = $row[1];
        }

        $this->contador = count($this->Cedula);
        mysqli_free_result($result);
    }
    
    function _Query_Estudiantes() { //Busca por medio de la cédula del Estudiante
        $SQL = "Select
                tbl_profesores.cedula,
                tbl_profesores.nombre
              From
                tbl_profesores Inner Join
                tbl_profesores_estudiantes On tbl_profesores_estudiantes.profesor_id =
                  tbl_profesores.cedula
              Where
                tbl_profesores_estudiantes.estudiante_id {$this -> estudiante_id};";
        $this->_LIMPIAR();
        $result = MYSQLI_query($this->dbh, $SQL);

        while ($row = mysqli_fetch_array($result, MYSQLI_NUM)) {
            $this->Cedula[] = $row[0];
            $this->Nombre[] = $row[1];
        }

        $this->contador = count($this->Cedula);
        mysqli_free_result($result);
    }

    private function _LIMPIAR() {
        $this->Nombre = array();
        $this->Cedula = array();
        $this->contador = 0;
    }

    public function get_Contador() {
        return $this->contador;
    }

    public function get_Cedula($int) {
        if ($int < $this->contador)
            return $this->Cedula[$int];
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

    public function set_Estudiante_id($varchar) {
        if ($varchar == "") {
            $this->estudiante_id = "like '%%'";
        } else {
            $this->estudiante_id = "like '%$varchar%'";
        }
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