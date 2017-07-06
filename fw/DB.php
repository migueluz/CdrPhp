<?php

include 'Statement.php';

class DB{
	
	private $connection;
	private $user;
	private $password;
	private $host;
	private $dataBase;
	private $statement;
	
	function __construct($host, $user, $password, $dataBase){
		$this->host 	= $host;
		$this->user 	= $user;
		$this->password = $password;
		$this->dataBase = $dataBase;
		$this->connect();
	}
	
	private function connect(){
		$this->connection = new mysqli($this->host, $this->user, $this->password, $this->dataBase);
		if(!$this->connection->connect_error){
			return true;
		}else{
			return false;
		}
	}
	
	function query($query, array $parameters = array()){
		$statement = new Statement($this->connection, $query, $parameters);
		$var = $statement->run($query);
		
		if($var){
			$var->data_seek(0);
				while ($row = $var->fetch_assoc()) {
				    $result[] = (object)$row;
				}
			return $result;			
		}

		return false;
	}
	
	function insert($query, array $parameters = array()){
		$statement = new Statement($this->connection, $query, $parameters);
		$var = $statement->run($query);
		if(!$this->connection->error){
			return true;
		}else{
			throw new Exception("Error en insert", $this->connection->error);
		}
	}
	
	function queryObject($query, array $parameters = array()){
		$result = $this->query($query, $parameters);
		if(count($result) == 1){
			return $result[0]; 
		}else{
			return false;
		}
	}

	function update($query, array $parameters = array()){
		$statement = new Statement($this->connection, $query, $parameters);
		$var = $statement->run($query);
		if(!$this->connection->error){
			return true;
		}else{
			throw new Exception("Error en update: ".$this->connection->error);
		}
	}
	
		
}

?>
