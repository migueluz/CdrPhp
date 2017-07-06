<?php

class Configuration extends Controller{
	
	function index($id, $name, $lastName){
		$result = $this->DB->query("SELECT * FROM configuracion");
		foreach ($result as $r) {
			echo $r->app;	
		}
		return new Result(array("configuracion"=>$result), array("view"=>"home"));
	}
	
	
}

?>