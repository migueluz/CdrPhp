<?php

class Controller{
	
	protected $DB;
	
	function __construct(DB $db){
		$this->DB = $db;
	}
	
}
?>