<?php

class Statement {
	
	private $db;
	private $sql;
	private $params;
	
	function __construct(mysqli $db, $sql, $params) {
		$this->db = $db;
		$this->sql = $sql;
		$this->params = $params;
	}
	
	function run() {
		return $this->db->query($this->fill());
	}
	
	function fill() {
		return preg_replace_callback('/\{([^}]+)\}/', array($this, 'escapeToken'), $this->sql);
	}
	
	function escapeToken($m) {
		return $this->escape($this->params[$m[1]]);
	}
	
	function escape($v) {
		if (is_string($v))
			return "'".$this->db->escape_string($v)."'";
		else
			return $v;
	}
}

?>
