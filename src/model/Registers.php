<?php

class Registers extends Model{
	
	function create($id_llamada, $aplicacion, $tipo_registro, $unidad, $tipo_insumo, $tipo_servicio, $abonado_a, $abonado_b, $abonado_c, $fecha_llamada, $hora_inicio_llamada, $duracion, $filler = ""){	
		$this->DB->insert("INSERT INTO registros (id_llamada, aplicacion, tipo_registro, unidad, tipo_insumo, tipo_servicio, abonado_a, abonado_b, abonado_c, fecha_llamada, hora_inicio_llamada, duracion, filler) VALUES ({id_llamada}, {aplicacion}, {tipo_registro}, {unidad}, {tipo_insumo}, {tipo_servicio}, {abonado_a}, {abonado_b}, {abonado_c}, {fecha_llamada}, {hora_inicio_llamada}, {duracion}, {filler})", 
		array(
			"id_llamada"=>$id_llamada, 
			"aplicacion"=>$aplicacion, 
			"tipo_registro"=>$tipo_registro, 
			"unidad"=>$unidad, 
			"tipo_insumo"=>$tipo_insumo, 
			"tipo_servicio"=>$tipo_servicio, 
			"abonado_a"=>$abonado_a, 
			"abonado_b"=>$abonado_b, 
			"abonado_c"=>$abonado_c, 
			"fecha_llamada"=>$fecha_llamada, 
			"hora_inicio_llamada"=>$hora_inicio_llamada, 
			"duracion"=>$duracion, 
			"filler"=>$filler
		));
	}
	
	function searchBetweenDates($startDate, $endDate){
		return $this->DB->query("SELECT * FROM registros WHERE fecha_llamada >= {startDate} AND fecha_llamada <= {endDate}", array("startDate"=>$startDate, "endDate"=>$endDate));
	}
}

?>