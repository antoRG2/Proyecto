<?php
	class DBConn
	{
		protected $mysqli_host = "localhost";
		protected $mysqli_user = "root";
		protected $mysqli_pass = "root";
		protected $mysqli_dbas = "sysdatabase";
		private $mysqli;
		
		function __construct ()
		{			
			$this->mysqli = new mysqli($this->mysqli_host,$this->mysqli_user,$this->mysqli_pass,$this->mysqli_dbas);
			if ($this->mysqli->connect_error) {
				die('Connect Error: ' . $this->mysqli->connect_error);
			}
		}
		
		function get_conn ()
		{
			return $this->mysqli;
		}
		
		function __destruct()
		{
			$this->mysqli->close();
		}
	}
?>