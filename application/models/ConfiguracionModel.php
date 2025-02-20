<?php 
	class ConfiguracionModel extends CI_Model{
		public function obtener_datos_generales(){
			$query = $this->db->query("SELECT * FROM datos_generales");
			
			if($query->num_rows() > 0) {
				$obj['datos_generales'] = $query->row();
				$obj['resultado'] = true;
			}
			else {
				$obj['resultado'] = false;
			}
			
			return $obj;
		}
		
		public function obtener_costos_generales(){
			$query = $this->db->query("SELECT * FROM costos_generales");
			
			if($query->num_rows() > 0) {
				$obj['costos_generales'] = $query->row();
				$obj['resultado'] = true;
			}
			else {
				$obj['resultado'] = false;
			}
			
			return $obj;
		}
		
		public function obtener_tasa_cambio(){
			$query = $this->db->query("SELECT *, DATE_FORMAT(fecha_tasa,'%d/%m/%Y') as solo_fecha_tasa, TIME_FORMAT(fecha_tasa, '%h:%i %p') as solo_hora_tasa FROM tasa_cambio");
			
			if($query->num_rows() > 0) {
				$obj['tasa_cambio'] = $query->row();
				$obj['resultado'] = true;
			}
			else {
				$obj['resultado'] = false;
			}
			
			return $obj;
		}
		
		public function obtener_tarifas_cfe(){
			$query = $this->db->query("SELECT *, DATE_FORMAT(fecha_actualizacion,'%d/%m/%Y') as solo_fecha_cfe, TIME_FORMAT(fecha_actualizacion, '%H:%i %p') as solo_hora_cfe FROM tarifas_cfe");
			
			if($query->num_rows() > 0) {
				$obj['tarifas_cfe'] = $query->row();
				$obj['resultado'] = true;
			}
			else {
				$obj['resultado'] = false;
			}
			
			return $obj;
		}
		
		public function obtener_terminos(){
			$query = $this->db->query("SELECT terminos FROM datos_generales");
			
			if($query->num_rows() > 0) {
				$obj['terminos'] = $query->row()->terminos;
				$obj['resultado'] = true;
			}
			else {
				$obj['resultado'] = false;
			}
			
			return $obj;
		}
		
		public function obtener_config_piepagina(){
			$query = $this->db->query("SELECT pie_pagina_opcion FROM configuracion");
			
			if($query->num_rows() > 0) {
				$obj['pie_pagina_opcion'] = $query->row()->pie_pagina_opcion;
				if($obj['pie_pagina_opcion'] == 1) {
					$obj['resultado'] = true;
				}
				else {
					$obj['resultado'] = false; 
				}
			}
			else {
				$obj['resultado'] = false;
			}
			
			return $obj;
		}
		
		public function guardar_pie_pagina($opcion){
			$query = $this->db->query("UPDATE configuracion SET pie_pagina_opcion = ?", $opcion);
			
			if($this->db->affected_rows() >= 0) {
				$obj['resultado'] = true;
			}
			else {
				$obj['resultado'] = false;
			}
			
			return $obj;
		}
		
		public function guardar_terminos($terminos){
			$query = $this->db->query("UPDATE datos_generales SET terminos = ?", $terminos);
			
			if($this->db->affected_rows() >= 0) {
				$obj['resultado'] = true;
			}
			else {
				$obj['resultado'] = false;
			}
			
			return $obj;
		}
		
		
		public function guardar_datos_generales($hps, $eficiencia, $periodo){
			$query = $this->db->query("UPDATE datos_generales SET hps = ?, eficiencia = ?, periodo = ?", array($hps, $eficiencia, $periodo));
			
			if($this->db->affected_rows() >= 0) {
				$obj['resultado'] = true;
			}
			else {
				$obj['resultado'] = false;
			}
			
			return $obj;
		}
		
		public function guardar_costos_generales($iva, $dap, $indice_utilidad, $costo_metro){
			$query = $this->db->query("UPDATE costos_generales SET iva = ?, dap = ?, indice_utilidad = ?, costo_metro = ?", array($iva, $dap, $indice_utilidad, $costo_metro));
			
			if($this->db->affected_rows() >= 0) {
				$obj['resultado'] = true;
			}
			else {
				$obj['resultado'] = false;
			}
			
			return $obj;
		}
		
		public function guardar_tasa_cambio($tasa_cambio) {
			$query = $this->db->query("UPDATE tasa_cambio SET tasa_cambio = ?, fecha_tasa = NOW()", array($tasa_cambio));
			
			if($this->db->affected_rows() >= 0) {
				$obj['resultado'] = true;
			}
			else {
				$obj['resultado'] = false;
			}
			
			return $obj;
		}
		
		public function guardar_forma_obtencion($obtencion_tasa) {
			$query = $this->db->query("UPDATE tasa_cambio SET tipo_obtencion = ?", array($obtencion_tasa));
			
			if($this->db->affected_rows() >= 0) {
				$obj['resultado'] = true;
			}
			else {
				$obj['resultado'] = false;
			}
			
			return $obj;
		}

		public function guardar_tarifas_cfe($d1, $d1_limite_inferior, $d1_limite_superior, $d2, $d2_limite_inferior, $d2_limite_superior, $d3, $d3_limite_inferior, $d3_limite_superior, $dac, $pdbt, $suministro_residencial, $suministro_comercial) {
			$query = $this->db->query("UPDATE tarifas_cfe SET d1 = ?, d1_limite_inferior = ?, d1_limite_superior = ?, d2 = ?, d2_limite_inferior = ?, d2_limite_superior = ?, d3 = ?, d3_limite_inferior = ?, d3_limite_superior = ?, dac = ?, pdbt = ?, suministro_residencial = ?, suministro_comercial = ?", array($d1, $d1_limite_inferior, $d1_limite_superior, $d2, $d2_limite_inferior, $d2_limite_superior, $d3, $d3_limite_inferior, $d3_limite_superior, $dac, $pdbt, $suministro_residencial, $suministro_comercial));
			
			if($this->db->affected_rows() >= 0) {
				$obj['resultado'] = true;
			}
			else {
				$obj['resultado'] = false;
			}
			
			return $obj;
		}
		
		public function actualizar_dolar() {
			$query = $this->db->query("SELECT tipo_obtencion, DATE_FORMAT(fecha_tasa,'%d/%m/%Y') as solo_fecha_tasa, IF(DATE(NOW()) = DATE(fecha_tasa), 'SI', 'NO') AS vigente FROM tasa_cambio");
			$result = $query->row();
			if($result->tipo_obtencion == "automatica") {
				if($result->vigente == "SI") {
					$obj['resultado'] = true;
				}
				else {
					$obj['tipo_obtencion'] = "automatica";
					$url = "https://sidofqa.segob.gob.mx/dof/sidof/indicadores/";
					$json = file_get_contents($url);
					$json_decode = json_decode($json, true);
					if($json_decode['response'] == "OK") {
						$indicador_dolar = $json_decode['ListaIndicadores'][0];
						if($indicador_dolar['codIndicador'] == 31523) {
							$dolar = floatval($indicador_dolar['valor']);
							$query = $this->db->query("UPDATE tasa_cambio SET tasa_cambio = ?, fecha_tasa = NOW()", array($dolar));
					
							if($this->db->affected_rows() >= 0) {
								$obj['resultado'] = true;
							}
							else {
								$obj['resultado'] = false;
								$obj['mensaje'] = "No se pudo actualizar la tasa de cambio, se utilizará la última tasa de cambio registrada (".$result->solo_fecha_tasa.")";
							}
						}
						else {
							$obj['resultado'] = false;
							$obj['mensaje'] = "El servicio del DOF no está en funcionamiento en este horario, se utilizará la última tasa de cambio registrada (".$result->solo_fecha_tasa.")";
						}
					}
					else {
						$obj['resultado'] = false;
						$obj['mensaje'] = "El servicio del DOF no está en funcionamiento en este horario, se utilizará la última tasa de cambio registrada (".$result->solo_fecha_tasa.")";
					}
				}
			}
			else {
				$obj['resultado'] = false;
				$obj['tipo_obtencion'] = "manual";
				$obj['mensaje'] = "La tasa de cambio está configurada de manera manual, así que se tomará la última tasa de cambio registrada (".$result->solo_fecha_tasa.")";
			}
			return $obj;
		}
			
	}