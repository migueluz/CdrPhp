<?php

class Result{
	public $vars;
	public $options;
	
	function __construct(array $vars, array $options){
		$this->vars = $vars;
		$this->options = $options;
	}
}

?>