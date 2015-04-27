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
class Ejecucion {
	//Atributos para la conección a la base de datos
	protected $obj_bconn;
	protected $dbh;
	protected $flag = 'ENT_SUBSTITUTE';

	//Filtros
	protected $configuracionid = ">= 0";
        protected $pos = ">= 0";
         
	//Atributos propios de la clase
        protected $itemID = 0;
        protected $itemEnunciado = "";
        protected $itemTipoEnunciado = "";
        protected $itemTipo = 0; //Selección multiple o única
        
	protected $respuestaID = array();
        protected $respuestaDesc = array();
        protected $respuestaTipo = array();
        protected $respuestaAcierto = array();
        
        protected $respuestasCont = 0;
	
	/*
	 * Constructor de la clase el cual se encarga de establecer la conección
     * con la base de datos directamente
	*/
        
    function __construct() {
        require_once $_SERVER['DOCUMENT_ROOT'] . '/Sistema/DB/class.DB.php';
        $this -> obj_bconn = new DBConn();
        $this -> dbh = $this -> obj_bconn -> get_conn();
    }
	
    public function _QUERY_ITEMS()
    {
        $SQL = "Select
                tbl_item.id,
                tbl_item.tipo,
                tbl_item.tipoenunciado,
                tbl_item.enunciado
                From
                tbl_configuracion_item Inner Join
                tbl_item On tbl_configuracion_item.item_id = tbl_item.id
                Where
                tbl_configuracion_item.configuracion_id {$this -> configuracionid} And
                tbl_configuracion_item.posicion {$this -> pos}";
            
                   
        $this -> _LIMPIAR();
		
        $result = MYSQLI_query($this -> dbh, $SQL);

        while ($row = mysqli_fetch_array($result, MYSQLI_NUM)) 
        {
                $this -> itemID = $row[0];
                $this -> itemTipo = $row[1];
                $this -> itemTipoEnunciado = $row[2];
                $this -> itemEnunciado = $row[3];
        }

        mysqli_free_result($result);
                        
    }
        
    public function _QUERY_RESPUESTAS()
    {
        $SQL = "Select
            tbl_respuestas.id,
            tbl_respuestas.acierto,
            tbl_respuestas.tipo,
            tbl_respuestas.descripcion
            From
            tbl_respuestas
            Where
            tbl_respuestas.item_id = {$this -> itemID}";
                
        $result = MYSQLI_query($this -> dbh, $SQL);

        while ($row = mysqli_fetch_array($result, MYSQLI_NUM)) 
        {
                $this -> respuestaID[] = $row[0];
                $this -> respuestaAcierto[]= $row[1];
                $this -> respuestaTipo[] = $row[2];
                $this -> respuestaDesc[] = $row[3];
        }

        mysqli_free_result($result);
            
        $this -> respuestasCont = count($this -> respuestaID);
            
    }
        
    private function _LIMPIAR()
    {
        $this -> itemID = 0;
        $this -> itemEnunciado = "";
        $this -> itemTipoEnunciado = "";
        $this -> itemTipo = 0; //Selección multiple o única

        $this -> respuestaID = array();
        $this -> respuestaDesc = array();
        $this -> respuestaTipo = array();
        $this -> respuestaAcierto = array();
            
        $this -> respuestasCont = array();
    }
        
    public function SET_CONFIGURACIONID($int)
    {
            $this -> configuracionid = (is_numeric($int) && $int > 0)?
                "= $int":"> 0";
    }
        
    public function SET_POSICION($int)
    {
            $this -> pos = (is_numeric($int))?"= $int":">= 0";
    }
        
    public function GET_ITEMID()
    {
        return $this -> itemID;
    }
        
    public function GET_ITEMTIPO()
    {
        return $this -> itemTipo;
    }
        
    public function GET_ITEMTIPOENUNCIADO()
    {
        return $this -> itemTipoEnunciado;
    }
        
    public function GET_RESPUESTACONT()
    {
        return $this -> respuestasCont;
    }
        
    public function GET_RESPUESTAID($int)
    {
        if($int < $this -> respuestasCont)
            return $this -> respuestaID[$int];
    }
        
    public function GET_RESPUESTATIPO($int)
    {
        if($int < $this -> respuestasCont)
            return $this -> respuestaTipo[$int];
    }
        
    public function GET_RESPUESTAACIERTO($int){
    if($int < $this -> respuestasCont)
	    return $this -> respuestaAcierto[$int];
    }
        
    public function GET_RESPUESTADESC($int, $FORMAT = "NORMAL") {
        if ($int < $this -> respuestasCont) {
			
            switch($FORMAT) {
				
                case "HTML" :
			        return htmlentities($this -> respuestaDesc[$int], 
                        (int)$this -> flag, "Windows-1252", true);
				
                case "INPUT" :
			        return htmlspecialchars_decode(htmlspecialchars
                    (htmlentities($this -> respuestaDesc[$int], (int)$this -> 
                    flag, "Windows-1252", true)), ENT_NOQUOTES);
				
                default :
			        return $this -> respuestaDesc[$int];
	        }
        }
    }
        
    public function GET_ITEMENUNCIADO($FORMAT = "NORMAL") {
        switch($FORMAT) {
                case "HTML" :
                        return htmlentities($this -> itemEnunciado,
                            (int)$this -> flag, "Windows-1252", true);
                
                case "INPUT" :
                        return htmlspecialchars_decode(htmlspecialchars
                        (htmlentities($this -> itemEnunciado, (int)$this -> flag,
                        "Windows-1252", true)), ENT_NOQUOTES);
                
                default :
                        return $this -> itemEnunciado;
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