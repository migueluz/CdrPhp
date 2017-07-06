<?php
	
class Configurations extends Model{
	
	function getData($app){
		return $this->DB->queryObject("SELECT * FROM configuracion WHERE app = {app}", array("app"=>$app));
	}
	
	function resetSequenceNumber($app, $ultimaActualizacion){
		return $this->DB->update("UPDATE configuracion SET numero_secuencia = 1, ultima_actualizacion = {ultimaActualizacion} WHERE app = {app}", array("app"=>$app, "ultimaActualizacion"=>$ultimaActualizacion));
	}
	
	function increseSequenceNumber($app, $ultimaActualizacion){
		$configuration = self::getData($app);
		
		if($configuration->numero_secuencia + 1 < 1000){
			$newSequenceNumber = $configuration->numero_secuencia + 1;
		}else{
			$newSequenceNumber = 1;	
		}
		
		if($this->DB->update("UPDATE configuracion SET numero_secuencia = {sequenceNumber}, ultima_actualizacion = {ultimaActualizacion} WHERE app = {app}",array("sequenceNumber"=>$newSequenceNumber, "app"=>$app, "ultimaActualizacion"=>$ultimaActualizacion))){
			return $newSequenceNumber;			
		}else{
			return false;
		}
	}
}
?>