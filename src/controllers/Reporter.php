<?php

class Reporter extends Controller{
	
	const INDENTIFICADOR_COMPANIA_UNIDAD_GENERADORA = "CTC";
	const INDENTIFICADOR_COMPANIA_RECEPTORA = "110";
	const TIPO_REGISTRO = "D";

	function registrarLlamada($id_llamada, $aplicacion, $tipo_registro, $unidad, $tipo_insumo, $tipo_servicio, $abonado_a, $abonado_b, $abonado_c, $fecha_llamada, $hora_inicio_llamada, $duracion, $filler = "  "){
	
		if($id_llamada == null || $aplicacion == null || $tipo_insumo == null || $tipo_servicio == null || $abonado_a == null || $abonado_b == null || $abonado_c == null || $fecha_llamada == null || $hora_inicio_llamada == null || $duracion == null || $filler == null){
	
			return new Result(array("response"=>"MOV001", "description"=>"Parametros null"), array("view"=>"registro"));
		}else{
			try{
				if($tipo_registro == null){
					$tipo_registro = TIPO_REGISTRO;
				}
				if($unidad == null){
					$unidad = INDENTIFICADOR_COMPANIA_UNIDAD_GENERADORA;
				}
				$id_llamada = substr($id_llamada, 0, 8);
				
				$register = new Registers($this->DB);
				$register->create($id_llamada, $aplicacion, $tipo_registro, $unidad, $tipo_insumo, $tipo_servicio, $abonado_a, $abonado_b, $abonado_c, $fecha_llamada, $hora_inicio_llamada, $duracion, $filler);	
				
				return new Result(array("response"=>"MOV000", "description"=>"Exito en carga de registro"), array("view"=>"registro"));
			}catch(exception $e){
				return new Result(array("response"=>"MOV002", "description"=>$e), array("view"=>"registro"));
			}
			return new Result(array("response"=>"MOV000", "description"=>"Exito en carga de registro"), array("view"=>"registro"));
		}		
	}

	static public function completeString($string, $length, $char = null, $align = "r"){
                               
                               $newString = "";
                               for($i=1; $i<=$length-strlen($string);$i++){
                                               if($char == null){
                                                               $newString .= "0";          
                                               }else{
                                                               $newString .= $char;
                                               }
                                               
                               }
                               
                               if($align != "l" && $align != "r"){
                                               $align = "r";        
                               }
                               
                               if($align == "r"){
                                               return $newString.$string;
                               }else if($align == "l"){
                                               echo "entro a la izquierda \n";
                                               return $string.$newString;         
                               }
                }

	
	static public function sum(array $records, $fill){
		$sum = 0;
		foreach ($records as $record) {
			$sum += $record->$fill;
		}
		return $sum;
	}
	
	
	function reportGenerator($startDate, $endDate){
		if($startDate != null && $endDate != null){
			$startDate = substr($startDate,6,4).substr($startDate,3,2).substr($startDate,0,2);
			$endDate = substr($endDate,6,4).substr($endDate,3,2).substr($endDate,0,2);
			
			$register = new Registers($this->DB);
			$configuration = new Configurations($this->DB);
			
			$registers = $register->searchBetweenDates($startDate, $endDate);
			
			$stringDate = date("Ymd");	
			
			$sequenceNumber = "0001";
			
			if($registers){
				$conf = $configuration->getData("1");
				
				$newSequenceNumber = $configuration->increseSequenceNumber(1, date("Ymd"));
				$sequenceNumber = self::completeString($newSequenceNumber, 4);
				
				try{
					$fileName = self::INDENTIFICADOR_COMPANIA_UNIDAD_GENERADORA.self::INDENTIFICADOR_COMPANIA_RECEPTORA.$stringDate.$sequenceNumber.".ctc";	
					$file = fopen("/opt/CDR/".$fileName, "w");			
					if($file){
						$completeStartDate = substr($registers[0]->fecha_llamada.$registers[0]->hora_inicio_llamada, 2);
						$completeEndDate = substr($registers[count($registers)-1]->fecha_llamada.$registers[count($registers)-1]->hora_inicio_llamada, 2);
						$totalsRegisters = self::completeString(count($registers), 7);
						$totalDuration = self::completeString(self::sum($registers, "duracion"), 11);
						
						fwrite($file, "HDRCETCON".$completeStartDate.$completeEndDate.$totalsRegisters.$totalDuration.self::completeString("",56, " ")."\n");
	
						$tipoRegistro = "D";
						$identificacionUnidad = "CETCON";
						$tipoInsumo = "05";
						$tipoServicio = "01";					
	
						foreach ($registers as $register) {
							$abonadoA = self::completeString($register->abonado_a, 18, " ", "l");
							$abonadoB = self::completeString($register->abonado_b, 24, " ", "l");
							$abonadoC = self::completeString($register->abonado_c, 24, " ", "l");

							$fechaLlamada = $register->fecha_llamada;
							$horaLlamada = $register->hora_inicio_llamada;
							$duracion = self::completeString($register->duracion, 6);
							$idLlamada = $register->id_llamada;
							$filler = "  ";
							
							fwrite($file, $tipoRegistro.$identificacionUnidad.$tipoInsumo.$tipoServicio.$abonadoA.$abonadoB.$abonadoC.$fechaLlamada.$horaLlamada.$duracion.$idLlamada.$filler."\n");
						}					
						
						fclose($file);
						
						$fileDirectory = "@/opt/CDR/".$fileName;
						$post_data['file'] = $fileDirectory;
						
						$ch = curl_init();
						curl_setopt($ch, CURLOPT_URL, "http://10.120.18.101/transferFileCDR.php");
						curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
						curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
						curl_setopt($ch, CURLOPT_VERBOSE, 1);
						$curlResponse = curl_exec($ch);
						
						$error = curl_errno($ch);
						curl_close($ch);
						if($error == 0){
							return new Result(array("response"=>"Archivo generado con exito"), array("view"=>"home")); 
						}else{
							return new Result(array("response"=>"No se logro generar el archivo con CURL"), array("view"=>"home"));
						}
						
					}else{
						
						return new Result(array("response"=>"No se logro generar el archivo"), array("view"=>"home"));
						
					}					
				}catch(exception $e){
						
					return new Result(array("response"=>"Error: ".$e), array("view"=>"home"));
				
				}
			}else{
				return new Result(array("response"=>"Registros no disponibles para este rango de fechas"), array("view"=>"home"));
			}			
		}else{
			return new Result(array("response"=>""), array("view"=>"home"));
		}
	}
		
}

?>