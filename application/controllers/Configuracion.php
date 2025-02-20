<?php 
	class Configuracion extends MY_Controller{
		private $data = array();
		
		public function __construct(){
			parent::__construct();
			$allowed = array(
				'actualizar_dolar'
			);
			$this->checar_acceso_privilegiado($allowed);
			$this->load->model('ConfiguracionModel');
			$this->data['datos_pagina']['seccion'] = "configuracion_general";
			$this->data['datos_pagina']['subseccion'] = "";
		}
		
		public function index(){
			$this->data['datos_pagina']['titulo_pagina'] = "Configuración general";
			$this->load->view('configuracion/configuracion_view', $this->data);
		}
		
		public function obtener_datos_generales() {
			$obj = $this->ConfiguracionModel->obtener_datos_generales();
			$this->output->set_content_type('application/json');
			$this->output->set_output(json_encode($obj));
		}
		
		public function obtener_costos_generales() {
			$obj = $this->ConfiguracionModel->obtener_costos_generales();
			$this->output->set_content_type('application/json');
			$this->output->set_output(json_encode($obj));
		}
		
		public function obtener_tasa_cambio() {
			$obj = $this->ConfiguracionModel->obtener_tasa_cambio();
			$this->output->set_content_type('application/json');
			$this->output->set_output(json_encode($obj));
		}
		
		public function obtener_tarifas_cfe() {
			$obj = $this->ConfiguracionModel->obtener_tarifas_cfe();
			$this->output->set_content_type('application/json');
			$this->output->set_output(json_encode($obj));
		}
		
		public function obtener_terminos() {
			$obj = $this->ConfiguracionModel->obtener_terminos();
			$this->output->set_content_type('application/json');
			$this->output->set_output(json_encode($obj));
		}
		
		public function obtener_config_piepagina() {
			$obj = $this->ConfiguracionModel->obtener_config_piepagina();
			$this->output->set_content_type('application/json');
			$this->output->set_output(json_encode($obj));
		}
		
		public function guardar_datos_generales() {
			$hps = $this->input->post("hps");
			$eficiencia = $this->input->post("eficiencia");
			$periodo = $this->input->post("periodo");
			$obj = $this->ConfiguracionModel->guardar_datos_generales($hps, $eficiencia, $periodo);
			$this->output->set_content_type('application/json');
			$this->output->set_output(json_encode($obj));
		}
		
		public function guardar_costos_generales() {
			$iva = $this->input->post("iva");
			$dap = $this->input->post("dap");
			$indice_utilidad = $this->input->post("indice_utilidad");
			$costo_metro = $this->input->post("costo_metro");
			$obj = $this->ConfiguracionModel->guardar_costos_generales($iva, $dap, $indice_utilidad, $costo_metro);
			$this->output->set_content_type('application/json');
			$this->output->set_output(json_encode($obj));
		}
		
		public function guardar_tasa_cambio() {
			$tasa_cambio = $this->input->post("tasa_cambio");
			$obj = $this->ConfiguracionModel->guardar_tasa_cambio($tasa_cambio);
			$this->output->set_content_type('application/json');
			$this->output->set_output(json_encode($obj));
		}
		
		public function guardar_forma_obtencion() {
			$obtencion_tasa = $this->input->post("obtencion_tasa");
			$obj = $this->ConfiguracionModel->guardar_forma_obtencion($obtencion_tasa);
			$this->output->set_content_type('application/json');
			$this->output->set_output(json_encode($obj));
		}
		
		public function guardar_tarifas_cfe() {
			$d1 = $this->input->post("d1");
			$d1_limite_inferior = $this->input->post("d1_limite_inferior");
			$d1_limite_superior = $this->input->post("d1_limite_superior");
			$d2 = $this->input->post("d2");
			$d2_limite_inferior = $this->input->post("d2_limite_inferior");
			$d2_limite_superior = $this->input->post("d2_limite_superior");
			$d3 = $this->input->post("d3");
			$d3_limite_inferior = $this->input->post("d3_limite_inferior");
			$d3_limite_superior = $this->input->post("d3_limite_superior");
			$dac = $this->input->post("dac");
			$pdbt = $this->input->post("pdbt");
			$suministro_residencial = $this->input->post("suministro_residencial");
			$suministro_comercial = $this->input->post("suministro_comercial");
			$obj = $this->ConfiguracionModel->guardar_tarifas_cfe($d1, $d1_limite_inferior, $d1_limite_superior, $d2, $d2_limite_inferior, $d2_limite_superior, $d3, $d3_limite_inferior, $d3_limite_superior, $dac, $pdbt, $suministro_residencial, $suministro_comercial);
			$this->output->set_content_type('application/json');
			$this->output->set_output(json_encode($obj));
		}
		
		public function guardar_terminos() {
			$terminos = $this->input->post("terminos");
			$obj = $this->ConfiguracionModel->guardar_terminos($terminos);
			$this->output->set_content_type('application/json');
			$this->output->set_output(json_encode($obj));
		}
		
		public function guardar_pie_pagina() {
			$pie_pagina_opcion = $this->input->post("pie_pagina_opcion");
			if($pie_pagina_opcion == TRUE) {
				if(!empty($_FILES["pie_pagina"]["name"])) {  
					$config['file_name'] = "pie_pagina";
					$config['upload_path'] = './img/';  
					$config['allowed_types'] = 'png';
					$config['overwrite'] = TRUE;
					$this->load->library('upload', $config); 
					if(!$this->upload->do_upload('pie_pagina')) {  
						$upload = false;
						$mensaje_upload = $this->upload->display_errors();  
						$obj['resultado'] = false;
					}
					else {
						$upload = true;
						$obj = $this->ConfiguracionModel->guardar_pie_pagina(1);
					}
				} 
			}
			else {
				$obj = $this->ConfiguracionModel->guardar_pie_pagina(0);
			}
				
			$this->output->set_content_type('application/json');
			$this->output->set_output(json_encode($obj));
		}
		
		public function obtener_tasa_dof() {
			$url = "https://sidofqa.segob.gob.mx/dof/sidof/indicadores/";
			$json = file_get_contents($url);
			$json_decode = json_decode($json);
			$this->output->set_content_type('application/json');
			$this->output->set_output($json);
		}
		
		public function actualizar_dolar() {
			$url = "https://sidofqa.segob.gob.mx/dof/sidof/indicadores/";
			$json = file_get_contents($url);
			$json_decode = json_decode($json);
			if($json_decode['response'] == "OK") {
				$indicador_dolar = $json_decode['ListaIndicadores'][0];
				if($indicador_dolar['codIndicador'] == 31523) {
					$dolar = floatval($indicador_dolar['valor']);
					$obj = $this->ConfiguracionModel->actualizar_dolar($dolar);
				}
				else {
					$obj['resultado'] = false;
					$obj['mensaje'] = "El servicio del DOF no está en funcionamiento en este horario, se utilizará la última tasa de cambio registrada";
				}
			}
			else {
				$obj['resultado'] = false;
				$obj['mensaje'] = "El servicio del DOF no está en funcionamiento en este horario, se utilizará la última tasa de cambio registrada";
			}
			return $obj;
		}
		
		public function obtener() {
			$obj = $this->obtener_tarifa_01();
			$this->output->set_content_type('application/json');
			$this->output->set_output(json_encode($obj));
		}
		
		public function tarifa_dac() {
			$target = "https://app.cfe.mx/Aplicaciones/CCFE/Tarifas/TarifasCRECasa/Tarifas/TarifaDAC.aspx";
			
			$user_agent = 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36';	
			
			$post = [
				'ctl00$ContentPlaceHolder1$Fecha1$ddMes' => date('n'),
				'ctl00$ContentPlaceHolder1$Fecha$ddAnio' => date('Y'),
				'__EVENTTARGET'   => 'ctl00$ContentPlaceHolder1$Fecha1$ddMes',
				'__VIEWSTATE' => '/6wYqlgKKv7xZ7H/Ihji710jQ9GfC3OVcMNQn7GcUEe7HuH+BW1xeGh3WOTQnHYb/IB3+TQFP6EsRl7WZV1PjLv2ZjwvC9hx3GIx2/+DCTOArkK50o93VaQBxcE7UAbthpBxV6H21C+LslYXmTxhq5puJmyH/54uMA0cK8kqbvbfRfFN7votG8wu2rCK6pW2lgKoxBqIcYIpK79SvJB9eCRdivwE4hE0yC18jGfqB4lC3iTqKAVcWF7qbkLTWwBA93yitbizuaE3LBbyK3TME2VPNoeZn1qiCdsVLj3AH7AecUr9SexgkJ5YmQAHNCSW2TQLLgr47U9i3SVEKr1jQRvHVtFKcrXRx5K1onuJn7Cr9wB81hu8hsi2EN3mCoT0DfWKFAzDFk/CiHYanK2gKeZcp+abEC9jin8hvvGmZsLLbntflycC7NHvMTPqdMGj/NvBaSzAxKKB+TPkBKymkhgWBq7TTXSjza1UE5//2OHd6p5iZiL+qO0VSIXRSmucpbOupPW7OtQIXX4n4TUqU/GSm15RGZ06262//G4x6Th6jPzTxNwr0flvyCpqTjUE9PExlSVK4fAnU3nZuKgcCQ0k+Lw=',
				'__EVENTVALIDATION' => 'QN2V0frycpYyahjJ4aG7wF/Rlxf49rcZCnHetjcs8m1a4tpY01j4VZYPrRSk2VKmAzgcrf3gXa2/Xc8QPzxo3W7F/E+Uxkc90pkAU7KDT1kUT26Ba2HeWQcOJfFpxhdF+PToKP32zdcKomTdjiqnciU4EhzZ/bxkptuDD/y9XBRxmylZjwm+CO+y0ieOvCvgi8sQkxepMGKkluVYt1JSq25U8qVO/Utv0Tdr/IjsH3hE6nU7kpMg5JEc4PEuI/tkSCW+uqPiib9/+WOEeKJDTSSCjkFaNZuZ6AhQ3h9aYfw9iH1tiBZmLQ6HDkhnWvUcWN4ksjuDyG1DTcNoqRo/MqfndrLcdpKZNBrYJOVJMvsSS7/IMENuixjiEgb1/yVq67LN87JMz1ZWjBWkCKdY6pFnqMUct1diUC33mcSq3mFBx57ad4W/nXFf+2fMCO0bFWY/Dqpq9mxju7GZw1spXQVMuIY='
			];

			$ch = curl_init($target);
			
			curl_setopt($ch, CURLOPT_USERAGENT, $user_agent);
			curl_setopt($ch, CURLOPT_URL, $target);
			curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
			curl_setopt($ch, CURLOPT_FAILONERROR, TRUE);
			curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
			curl_setopt($ch, CURLOPT_MAXREDIRS, 4);
			curl_setopt($ch, CURLOPT_COOKIESESSION, FALSE);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
			curl_setopt($ch, CURLOPT_ENCODING, "");	
			curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
			
			$initpage = curl_exec($ch);
			
			if($initpage === FALSE) {
				$curl_errno = curl_errno($ch);
				$curl_error = curl_error($ch);

				$obj["resultado"] = false;
				$obj["curl_error_no"] = $curl_errno;
				$obj["mensaje_error"] = $curl_error;
				$obj["error"] = "curl";
			}
			else {
				$doc = new DOMDocument;
				
				$internalErrors = libxml_use_internal_errors(true);
				
				$doc->preserveWhiteSpace = false;
				$doc->strictErrorChecking = false;
				$doc->recover = true;
				$doc->loadHTML($initpage);
				
				//libxml_clear_errors();
				
				if($doc->loadHTML($initpage)) {
					$xpath = new DOMXpath($doc);
					$query = "//table[@id='TarifaDacV']//tr";
					$items = $xpath->query($query);
					
					if($items === FALSE) {
						$obj["resultado"] = false;
						$obj["error"] = "pagina_externa";
						$obj["mensaje_error"] = "La consulta de XPath no está formulada correctamente";
					}
					else {
						if($items->length > 0) {
							$fila = $items->item(2);
							$celdas = $fila->getElementsByTagName('td');
							
							$tipo_tarifa = $celdas->item(0)->nodeValue;
							$cargo_fijo = floatval(preg_replace('/[^0-9.]/', '', $celdas->item(1)->nodeValue));
							$tarifa = floatval(preg_replace('/[^0-9.]/', '', $celdas->item(2)->nodeValue));
							
							if($tipo_tarifa == "Central" && $cargo_fijo>0.00 && $tarifa>0.00) {
								$obj["resultado"] = true;
								$obj["tipo_tarifa"] = $tipo_tarifa;
								$obj["cargo_fijo"] = $cargo_fijo;
								$obj["tarifa"] = $tarifa;
							}
							else {
								$obj["resultado"] = false;
								$obj["error"] = "pagina_externa";
								$obj["mensaje_error"] = "Los datos recabados de CFE no corresponden a los esperados";
								$obj['celdas'] = $celdas;
							}
						}
						else {
							$obj["resultado"] = false;
							$obj["error"] = "pagina_externa";
							$obj["mensaje_error"] = "No se encontró la fila de valores en CFE";
							$obj["xpath"] = $xpath;
						}
					}
				}
				else {
					$obj["resultado"] = false;
					$obj["error"] = "domdocument";
					$obj["mensaje_error"] = libxml_get_errors();
				}
			}
			
			curl_close($ch);
			$this->output->set_content_type('application/json');
			$this->output->set_output(json_encode($obj));
		}
		
		public function tarifas_01() {
			$target = "https://app.cfe.mx/Aplicaciones/CCFE/Tarifas/TarifasCRECasa/Tarifas/Tarifa1.aspx";
			
			$user_agent = 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36';	
			
			$post = [
				'ctl00$ContentPlaceHolder1$MesVerano1$ddMesConsulta' => date('n'),
				'ctl00$ContentPlaceHolder1$Fecha$ddAnio' => date('Y'),
				'ctl00$ContentPlaceHolder1$hdMes' => date('n'),
				'__VIEWSTATE' => 'Xopi227VviUGI2dPkOT2sqlwkRNBT2iLHzStwOsRUhvTNcpChNFIllD9v4cZCk2jpYzvurdcaRS/TWYhFOSeGMbB5m7yTeDIsn1CrIPFIHHGZWcSO4DtEzaX9cT2D6YATPNK/OGuVOS9rhknOWl/lgFmBSRqnCSdLmyJ0/ge8IW2JeY1+Oh6sc+cY8zjBMHQn9Sv8fxvmlOXbBGyRWW29e+bE4HHm5TZmLIhzv1sNaP0zKTZidP7G2rjzDDZ6AtA3eXNO5WMzWW0mrWFy64FSik0R3xvZC1byhyTAwaonHw7poXI',
				'__EVENTVALIDATION' => '3pQqvACqerf1cjfll0KNPYLjTYjpVlo7r69rToXu0QzKZGLmgo96zNQXyiQtPSXVIKsZNCOnUNHrUJr2O29wzHGAdvDQvg5qU0t++FwnD6zAnn3Xkl4XUZhC0I7PzkMh9v5zu5DQ6ZDyOIskhD4gUjjo0udqI/xl+LLG1S1Pq3zDQrVy7gGzz6FNHbkBqghtLSHXPcI+FrSBYUCo4WlFehyEatujtfBUdP8m/hO5yBmFafVQS7lvxbLE/ZMheO8HEXdSyg+Rk74W/fUpF+UXOd+c+fNWX9+6JwIn/pB3RUc3l0EIaTB/n5QHAcs0XZdIaeINg+jSURiVL30VWc5Vm5TXFCTpdLrTfpxpXN4BU92E5wjPcMdgVQsIpiqvZGRXccY401u/eObnyz4C0TwFfEJ7z+4mU9qt0Bm2PfuLiQbGWW0YpeYkEoRWe90lrkV+hZYVNjyHh0b1P6TiMCMQdEjTi7cTYO6YtETCuTtriJXQyMHynQQEWf2cmf+b9a8eqXfLB66Is3HdPmFVmRwSFeLIs1cliVNJ8KSVpRFdVQ6v2r7vL98rd7EQ3AK5wCwmfKmymQ==',
				'__VIEWSTATEGENERATOR' => '59724956'
			];

			$ch = curl_init($target);
			
			curl_setopt($ch, CURLOPT_USERAGENT, $user_agent);
			curl_setopt($ch, CURLOPT_URL, $target);
			curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
			curl_setopt($ch, CURLOPT_FAILONERROR, TRUE);
			curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
			curl_setopt($ch, CURLOPT_MAXREDIRS, 4);
			curl_setopt($ch, CURLOPT_COOKIESESSION, FALSE);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
			curl_setopt($ch, CURLOPT_ENCODING, "");	
			curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
			
			$initpage = curl_exec($ch);
			
			if($initpage === FALSE) {
				$curl_errno = curl_errno($ch);
				$curl_error = curl_error($ch);

				$obj["resultado"] = false;
				$obj["curl_error_no"] = $curl_errno;
				$obj["mensaje_error"] = $curl_error;
				$obj["error"] = "curl";
			}
			else {
				$doc = new DOMDocument;
				
				$internalErrors = libxml_use_internal_errors(true);
				
				$doc->preserveWhiteSpace = false;
				$doc->strictErrorChecking = false;
				$doc->recover = true;
				$doc->loadHTML($initpage);
				
				//libxml_clear_errors();
				
				if($doc->loadHTML($initpage)) {
					$xpath = new DOMXpath($doc);
					$query = "//table[@id='ContentPlaceHolder1_TemporadaFV']//table//tr";
					$items = $xpath->query($query);
					
					if($items === FALSE) {
						$obj["resultado"] = false;
						$obj["error"] = "pagina_externa";
						$obj["mensaje_error"] = "La consulta de XPath no está formulada correctamente";
					}
					else {
						if($items->length > 0) {
							$fila = $items->item(0);
							$celdas = $fila->getElementsByTagName('td');
							$tarifas['d1'] = floatval(preg_replace('/[^0-9.]/', '', $celdas->item(1)->nodeValue));
							
							$fila = $items->item(1);
							$celdas = $fila->getElementsByTagName('td');
							$tarifas['d2'] = floatval(preg_replace('/[^0-9.]/', '', $celdas->item(1)->nodeValue));
							
							$fila = $items->item(2);
							$celdas = $fila->getElementsByTagName('td');
							$tarifas['d3'] = floatval(preg_replace('/[^0-9.]/', '', $celdas->item(1)->nodeValue));
							
							$obj["resultado"] = true;
							$obj["tarifas"] = $tarifas;
						}
						else {
							$obj["resultado"] = false;
							$obj["error"] = "pagina_externa";
							$obj["mensaje_error"] = "No se encontró la fila de valores en CFE";
						}
					}
				}
				else {
					$obj["resultado"] = false;
					$obj["error"] = "domdocument";
					$obj["mensaje_error"] = libxml_get_errors();
				}
			}
			
			curl_close($ch);
			$this->output->set_content_type('application/json');
			$this->output->set_output(json_encode($obj));
		}
		
		public function tarifa_pdbt() {
			$target = "https://app.cfe.mx/Aplicaciones/CCFE/Tarifas/TarifasCRENegocio/Tarifas/PequenaDemandaBT.aspx";
			
			$user_agent = 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36';	
			
			$post = [
				'ctl00$ContentPlaceHolder1$Fecha2$ddMes' => date('n'),
				'ctl00$ContentPlaceHolder1$Fecha$ddAnio' => date('Y'),
				'ctl00$ContentPlaceHolder1$hdMes' => date('n'),
				'ctl00$ContentPlaceHolder1$EdoMpoDiv$ddEstado' => '22',
				'ctl00$ContentPlaceHolder1$EdoMpoDiv$ddMunicipio' => '1787',
				'ctl00$ContentPlaceHolder1$EdoMpoDiv$ddDivision' => '3',
				'__VIEWSTATE' => 'nP1ZF5b/5PyOOTeK9a7rFjrwLh9t3b6LceE9oiqCZBqdIBjJtxEDCkxCui9myqLvyKjrDBVCL0lfqo4d2CJVkv5wWvMNS6kcSuZBQXKm9Kob+tBRyndlGYulMvCnc2CliFlamhu3QKxaAlYHU1v8S9+uHtCwdJCLAqM2mhgTSx6EhAoCxp3MQQ0GDq1pzUofr8/eeIWG7S+Afdd4e2P5pIVnOvroMofWhlfBmBZEeWuxYvYSeZZYY/jgUT3JrkJIAW9vgL8D4uyX3ikuSnXHKoX06T83OVFTA/MImn62grCDtPj35j79G2glnXiTor6SnyVy1mLaZek10Z1XO2tFNreu1qpNhjFkntDDEZUdrf5lFSVxS8p92j+t9bz7GQpJpN5PtBUysUjkL9NDGdjy1OwqQmS4Wfyi2bASEd1HdXNDBbT1zwM5JcosRkPqV3OyNMCOdaV+0mk2xMwgcvF/b3m6icNbMUZdx+ugsaS+Hl0r5veA+I+oQjh3Lm0NzF4qPU0ZqrBowmRyJmyh25c5JzX3/PoJdy7AnC5/sXVK4cUMp+VVn5hV+dqa+Lp9Z9PKZdjT/mZbsv1eIvviWtpBmwOcd2mp9oK49wHQOYBb4TP9jnWAnXVyPELqNuu/paSPxMDvnCxlx+eX0Zu0/lrTJPnEaGM8bMTamLT3BJmwEaHVYpTR30Avu31q+qNnubZMuKxQTSORHrYBbBwX8LDOua5zRu6W+tixxLiGliX74cKi6gzYlyTGqbketwbgTXOX0I5PB6Jk0CWGczouIgsW4ST+rU1wLMrPShKFMGu2r5+PE0/vYO5b9Q0WFRKE7Cpd7DxoKuGpYM5R0gOZpnXJzlIwlBS5L4WTxAFnoaNSa12KDOj7i21JMHfURzqrrCf6gki3USaq0dI+j0Gvtr5xpuzqULirm7YpeOZyMm6DmLcIGBqcLYMRYXm4Br9TaIrQlBVwjzWFuuL0buUihWxXSOZUAcN6Tq/JR1Ya+E/VWxmcmK+wlX+FoMfUld0qPuODoVFOuLk1fVxYFEGILs5ivauMzzUUu65d4KHqyvg5ypXkBG9k7o7gS58IyhJBZ7EYCCjtnyA56BFcXMDl2pNvHYjj3iP2qaA43OCBfv93uyfa4wocqSS+7ySv6oJvFlTvwzR3NDm/P/o6x5fr7m3Llyocg6YgXLlGliOMyd9exuFwk+v6Ah4teIWoF5YmFcGppYAo4ZjoCUUD1hH1/hxdxMSV3DI4cFjC3gex/rJu7HUBKTLXjzoe2yhG+Z8bIVWtp1spmrh2aTqyUQiOKJEyMH9wElc5lxTgjMekJc/kTdQHhlB3KFjpdaoxAPuoNM0ckuK7PrgXioKhzoHkIJ1ktBZeJWIUMtQKuxmggEaXLjlU+7DzlE5o92T38Z1SbzMDF/0TpJM49wP073x8+zxPzvXoZHdXwbx7iclFxeIwkUjas+ZbW6WFL7bJDNi2q18cCN8aj+sFiRbtNksc1MpJGPDYOArk7PDUURuqbLkmVOe34DXN3cB1MHMQM555aWdwMCBINIqukqHEBMUtDudos4BLlyVovl0ni5jorsOV5g1ONfiOBRdMiJxkxKMTZrTNOZl2lrSWttET+jqMrXfOh9Q2F8p2Ot6NMR9EKkc7GXNfMF9R7rKoZ2MOVph4LevJsAyz/ZgJT0zMP7huApRx4cxglrJsRtgmOTp2dlqg29cmWd29uPihDCSzwJKH0FqHfx2YZS9mK/FDrE/FOWp56F4V0fzM4GzkkMEp7KDnhtZicPkPrQx88+oxIX+wfWvXfU1JMS8ndB4CTpOXHAk7U2w1UbhJ+mVfjzhYa13kVPOlXN3rxGntUXHD6ScvzHY44R0TacP4ylHs25CKhLCa5AAZ44SCVufb5yTnCmCt4w0C9Ju76v8P/fgHVUeGWL2lL9/jIq0dGd/hFehLZT3eJB3P3eE=',
				'__EVENTVALIDATION' => 'f0AGSqzEl5Thdr2Y3QyoYbMnC3Al1WZDLg9V8F90AN5Xe64LKvdCyXLkwePoqyjbr2coGzscVpYaQ43kWLEp8zUIztMydYUmetQh4WoOreKesVNC3o/DdV3GJq3Vud5WG9AljsWoU2DFKUpijzeZlqYYuHRjo6oaMI8cfyB0OH2QzjEHv77ILZV+SNpr/JEnKHrjbWQQ82Jo1KKOKjShJsXJiwDBLl28vMSD8YJ8vskXok5ptX6F6Pl4AeO6RR8zoGkR9CzoHKCyPTNokW/lLM4e2mECLsDB3VzlIu8fDHLKR4MN+EyudzUvt/xv36TNU6coz2OLbiql36CMmHtxLSyyo1O5gIFO6V9dMXQFQz7HcnY5Rxay9LPbXVgbVNiXwu9PSAcXzJxmiSRl8QQbqEXKAC5th2q2jOGShoi/6UgN6zbRTNcQm0yCHXaYjqhJhVY0q0Rj3bRk1RJEtnY54HnG2IkIg38DAsJtN2pW96NJAqJ8cnQkHtO8laghtFfEpuh4D1e0y5S3/tbThvtxBHxURtSTaqBn3U7XAL1EzfHUgXLK4+dCQgKSGRinS2AEyHCzbejNCA/oCTrSs4F2rvi0uJoqo4qb5wpK5rdfPr2ao9DjP8zkgtJQQzMAy+JuXg55s5Cpbc9zffPD6ESczlT/6VoL1RKkg9K38cUud2AZFF56wYZsMMOaepz/0jeGxj1o0xmkIy3YN86/jywFm75vw/AyukDEU8XPbzZY1wC1KqhgPZrHiBd+5wgtAzVdJqBenlydBskHD3xXiDxNn1vcM6PKhoYFg3etJCQqRQ0azqWXgvkkNEFzsp+3lln5/RBufWdBaAw2HcAzTVYPAFjPHebLoVuqkW8oy6XyR73qwve6nbAwdVrt4zdo5Tl4SznYZF8g3nd5cwm89Cp9iAAMzAgUTJE32Uz9FTBmv1Wmta97PPOnDUOYuGKiOG+qz8uDtw5HrecRm/EULhvnpe9nqTKlUGfv/Z36O2Kb5zfR3sXVni845cqckpn7pwtn9eCLcXCwFNx/AbZzEApuK+aZaSmY0g7cmZOpj1ZcTpLeShMORwGN7Yho3htKXjGq/TjurFdgdnByYyUZrBFbZEZKA1+1y8lsgbG7eKX+R2x7IBWAR5ir85lHi/HUxy+EcGxAhx3mel0ffZMXaARJf/TVOCaDMuSfqftYVMhKuRfYWY3mj6Mb58a4z/k38ui0hmNcSAZY80rfUsyhTZ+MI8xYTQcZzu9MKNAbhSNQ9sLbBxI8owDjLCV56/v+ylUPgZClvAs88KSmQahRI+bqLzltBGXRUyntnRdnVuKVRLNPujgTFzjTltAMEdrhNQDPrKnkjZhEea7VVb8GoDGxM8j7wAuKaersz7bRo6YMY6BebCy4SjC31mHAlXkYZGdYT+v1GYZsBoPiNr9jNLIy4qwrdBIUKCZHY3q50KwYuXTv3b4rF4mTAFpL1wMxqtZ6Y1b5Ow6Z/+B5gznF4szzrz616zrCisikIwaWj94/Ewmmrg5DGZwUkraqu0i1rhbLWfRlRmk1YaBG8mSsze7sN+pXVSkaPlC6IgwJwm8nQYlmQgGUYqt1/zT+hD6ErKAJECxJGcvcWI4Doa6y3acFg/1RQNc8ubglRUwrzjeptySu+4syRGR7oXFq2RKfOdf148K+RJ1yRZ+QIF0yx3RNWXIViBY=',
				'__VIEWSTATEGENERATOR' => 'B58804E8'
			];

			$ch = curl_init($target);
			
			curl_setopt($ch, CURLOPT_USERAGENT, $user_agent);
			curl_setopt($ch, CURLOPT_URL, $target);
			curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
			curl_setopt($ch, CURLOPT_FAILONERROR, TRUE);
			curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
			curl_setopt($ch, CURLOPT_MAXREDIRS, 4);
			curl_setopt($ch, CURLOPT_COOKIESESSION, FALSE);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
			curl_setopt($ch, CURLOPT_ENCODING, "");	
			curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
			
			$initpage = curl_exec($ch);
			
			if($initpage === FALSE) {
				$curl_errno = curl_errno($ch);
				$curl_error = curl_error($ch);

				$obj["resultado"] = false;
				$obj["curl_error_no"] = $curl_errno;
				$obj["mensaje_error"] = $curl_error;
				$obj["error"] = "curl";
			}
			else {
				$doc = new DOMDocument;
				
				$internalErrors = libxml_use_internal_errors(true);
				
				$doc->preserveWhiteSpace = false;
				$doc->strictErrorChecking = false;
				$doc->recover = true;
				$doc->loadHTML($initpage);
				
				//libxml_clear_errors();
				
				if($doc->loadHTML($initpage)) {
					$xpath = new DOMXpath($doc);
					$query = "/html[1]/body[1]/form[1]/section[1]/div[1]/div[1]/div[2]/table[1]/tbody[1]/tr[8]/td[1]/table[1]/tbody[1]/tr[2]/td[1]/table[1]/tbody[1]";
					$items = $xpath->query($query);

					if($items === FALSE) {
						$obj["resultado"] = false;
						$obj["error"] = "pagina_externa";
						$obj["mensaje_error"] = "La consulta de XPath no está formulada correctamente";
					}
					else {
						if($items->length > 0) {
							$fila = $items->item(2);
							$celdas = $fila->getElementsByTagName('td');
							
							$tipo_tarifa = $celdas->item(0)->nodeValue;
							$cargo_fijo = floatval(preg_replace('/[^0-9.]/', '', $celdas->item(1)->nodeValue));
							$tarifa = floatval(preg_replace('/[^0-9.]/', '', $celdas->item(2)->nodeValue));
							
							if($tipo_tarifa == "Central" && $cargo_fijo>0.00 && $tarifa>0.00) {
								$obj["resultado"] = true;
								$obj["tipo_tarifa"] = $tipo_tarifa;
								$obj["cargo_fijo"] = $cargo_fijo;
								$obj["tarifa"] = $tarifa;
							}
							else {
								$obj["resultado"] = false;
								$obj["error"] = "pagina_externa";
								$obj["mensaje_error"] = "Los datos recabados de CFE no corresponden a los esperados";
							}
						}
						else {
							$obj["resultado"] = false;
							$obj["error"] = "pagina_externa";
							$obj["mensaje_error"] = "No se encontró la fila de valores en CFE";
							$obj["xpath"] = $xpath;
						}
					}
				}
				else {
					$obj["resultado"] = false;
					$obj["error"] = "domdocument";
					$obj["mensaje_error"] = libxml_get_errors();
				}
			}
			
			curl_close($ch);
			$this->output->set_content_type('application/json');
			$this->output->set_output(json_encode($obj));
		}
		
	
	}