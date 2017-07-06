<?php

class Model{
	
	protected $DB;
	
	function __construct(DB $db){
		$this->DB = $db;
	}
	
}
?>