<?php

class Dispatch{
	
	private $DB;
	private $router;
	private $actionClass;
	private $actionMethod;
	private $data;
	public  $path;
	
	
	function __construct(Router $router, array $options){
		$this->data = isset($_REQUEST)? $_REQUEST:array();
		$this->router = $router;
		$this->path = $_SERVER['DOCUMENT_ROOT']."/".$options["appName"]."/";
		$this->DB = new DB($options["host"], $options["user"], $options["password"], $options["dataBase"]);
		$this->resolveAction();	
	}
	
	function resolveAction(){
		$this->parseAction($this->router->processRoutes($this->data));
		$this->dispatchView($this->execute());
	}
	
	function parseAction($action){
		preg_match('#^([\w]+):([\w]+)$#', $action, $match);
		$this->actionClass = @$match[1];
		$this->actionMethod = @$match[2];		
	}
	
	function execute(){
		$controllerClass = new ReflectionClass($this->actionClass);
		$controllerInstance = $controllerClass->newInstance($this->DB);
		$methodInstance = new ReflectionMethod($controllerInstance, $this->actionMethod);
		return $methodInstance->invokeArgs($controllerInstance, $this->buildParametersList($methodInstance));		
	}
	
	function buildParametersList(ReflectionMethod $method){
		foreach($method->getParameters() as $parameter){
			if(isset($this->data[$parameter->getName()])){	
				$parameters[$parameter->getName()] = $this->data[$parameter->getName()];	
			}else{
				$parameters[$parameter->getName()] = null;
			}
			
		}		
		return $parameters;
	}
	
	function dispatchView(Result $result){
		$options = $result->options;
		$options["path"] = $this->path;
		$options = (object)$options;
		extract($result->vars);		
		include $this->path."src/views/".$options->view.".php";
	}
	
}


?>