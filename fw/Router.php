<?php 

class Router{
	
	private $url; 
	public $routes;
	private $vars;
	
	 function __construct(array $routes){
		$this->routes = $routes;
		$this->url = isset($_SERVER['PATH_INFO'])? $_SERVER['PATH_INFO']:"/";
	 }
	 
	 function extractVars($pattern){
	 	preg_match_all('#\{([^}]+)\}#', $pattern, $m);
	 	return (array) @$m[1];
	 }
	
	
	function replaceParameters($pattern){
		return "#^".preg_replace('#\{([^}]+)\}#', '([\w-]+)', $pattern)."$#";
	}
	
	function processRoutes(array &$data){
		foreach ($this->routes as $route => $action) {
			if(preg_match($this->replaceParameters($route), $this->url, $m)){
				$vars = $this->extractVars($route);
				foreach ($vars as $i=>$var) {
					$data[$var] = $m[$i+1];
				}
				return $action;
			}
		}
		return false;
	}
}

?>