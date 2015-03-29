<?php
class Guardar
{
    protected $obj_bconn;
    protected $dbh;
    protected $SQL;
    protected $flag = 'ENT_SUBSTITUTE';
    
    function __construct() 
    {
        $_SERVER['DOCUMENT_ROOT'].'/Sistema/DB/class.DB.php';
        $this -> obj_bconn = new DBConn();
        $this -> dbh = $this -> obj_bconn -> get_conn();
    }
    
    public function GuardarResultados($id,$itemID,$resultado)
    {
        /*
         * Si el estudiante falló la pregunta, el resultado es 0
         * en caso contrario es 1.
         */
        $SQL = "INSERT INTO sysdatabase.tbl_resultados (prueba_id, item_id, resultado) "
                . "VALUES($id,$itemID,$resultado)";
        
        $result = mysqli_query($this->dbh, $SQL);

        return ($result)?TRUE:FALSE;
    }
    
    public function EliminarAnterior($id)
    {
        $SQL = "DELETE FROM sysdatabase.tbl_resultados WHERE "
                . "prueba_id = $id;";
        
        $result = mysqli_query($this->dbh, $SQL);

        return ($result)?TRUE:FALSE;
    }
     public function MarcarFinalizada($id)
     {
        $SQL = "UPDATE sysdatabase.tbl_estudiantes_configuraciones SET "
                . "finalizada = 1 WHERE id = $id;";
        
        $result = mysqli_query($this->dbh, $SQL);

        return ($result)?TRUE:FALSE; 
     }
    private function _FREE($_VAR, $_UTF=true)
    {
        $_VAR = html_entity_decode ($_VAR, (int)$this->flag);
        $_VAR = str_replace('&quot;', '"', $_VAR);
        $_VAR = mysqli_real_escape_string($this->dbh,$_VAR);
        $_VAR = mb_convert_encoding($_VAR, 'WINDOWS-1252' , 'UTF-8');
        return $_VAR;
   }
}
?>

