<?php

	class db{
		//Propriedades
		private $dbhost     = 'localhost';
		private $dbdatabase = 'sistema';
		private $dbuser     = 'root';
		private $dbpass     = 'vagrant';

		public function connection(){
			try{
				$connection_str = "mysql:host=$this->dbhost;dbname=$this->dbdatabase";
				$conn = new PDO ($connection_str, $this->dbuser, $this->dbpass);
				$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			    return $conn;

			}catch(PDOException $exc){
				echo "error".$exc->getMessage();
			}
		}
	}
?>