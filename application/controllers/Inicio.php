<?php
	defined('BASEPATH') OR exit('No direct script access allowed');

	class Inicio extends CI_Controller {
		public function index() {
			$this->load->view('inicio_view');
		}
		
		public function menu_ejemplo() {
			$this->load->view('menu_ejemplo');
		}
		
		public function menu_ejemplo2() {
			$this->load->view('menu_ejemplo2');
		}
		
		public function agregar_ejemplo(){
			$this->load->view('agregar_ejemplo');
		}
		
		public function editar_ejemplo(){
			$this->load->view('editar_ejemplo');
		}
		
		public function visualizar_ejemplo(){
			$this->load->view('visualizar_ejemplo');
		}
		
		public function cotizador_ejemplo(){
			$this->load->view('cotizador_ejemplo');
		}
		
		public function menu_costos_ejemplo(){
			$this->load->view('menu_costos_ejemplo');
		}
		
		public function checarphp() {
			phpinfo();
		}
		
		public function obtener_dolar() {
			$url = "https://sidofqa.segob.gob.mx/dof/sidof/indicadores/";
			
			$json = file_get_contents($url);
			$this->output->set_content_type('application/json');
			$this->output->set_output($json);
		}
		
		public function obtener_tarifa_dac() {
			$target = "https://app.cfe.mx/Aplicaciones/CCFE/Tarifas/TarifasCRECasa/Tarifas/TarifaDAC.aspx";
			
			$user_agent = 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36';	
			
			$post = [
				'ctl00$ContentPlaceHolder1$Fecha1$ddMes' => date('n'),
				'ctl00$ContentPlaceHolder1$Fecha$ddAnio' => date('Y'),
				'__EVENTTARGET'   => 'ctl00$ContentPlaceHolder1$Fecha1$ddMes',
				'__VIEWSTATE' => 'FTyAWC5k2V23Bly7/mT1bPN535ZYu+1cGOp8+zvn6UMc47iZUmCJIfxcRv8qOGQz+Esasg76WNNl33TKfGirxvsL40HY+M8/IvF8ctmo2x5l+vrNylCeigzrz114l2gGIRtQweXuaN2Xd2yalOOnUjagTziAAqmvXf9Ga17Mtt55KRm4ZYxEhUrI1j+dhB7YAFRQeNDL2FoQh0UKK7olzw2Sm8lScVTFWDVGUSn/Vrl3mjmz1ZmkAobJfivRhD2eI4CFc7Bc4nyoXeKsGml3wIq/bc1g7PThj08CtrkHoCUya8vlEbqLoP6oq7/rmJ1Bbz/Xr5xyBtS63j2CTfxJhgOCWu0UXmaIXiOFg7tqLsbsQiRLJ/4D/E4iVmMRIt4Dqkj1Q7v7a9OYSiNpxUmb0NLQe/JRFSJlIJqGduK84HrKApr/XatrCI2dk84hBhTYITVSwq49lHgr+CmNpIg/3q9SlH4SqYOjvKzvpcRGcFOEeaIa8PSoxEhEDaPgix/lYeKXZinEhfjYzyWAqAAvovxp3jek+Wxqi0MAp8E1lddFZQ7y',
				'__EVENTVALIDATION' => 'of3V+zTuV0v+A2GdHOn4GqqpCXmulLEUNu6ANqZX3+cCjnWH6QSqRKsP61F1aC1wfkVMOY6ZLS4PS0v1/a/x6FD/gfNMXsoAPZ4rtuTA6gtTXKB7ZaYv5Q7holOao1Y5tOiECkn9kkZGrvmFEFC4uwo3/ZyWww4E2X4Ow8mjvvEIQU7IWJMZ7EfA9s7t6qQU9ddoJgNX8HP/p4Hz8LM9NJmeiy5c9LBtZMwfw9HJcGNjVvcYhCHhoAuLAEQP8r18pF+Vdfn5sKGcenz8DjHc0x/HpuDLPVTaAkhlIS+JQYh5KQ9vzhRh2WwruAJOest0opsetlyZF4lzNUPh81wBkscjbXNBY7n24f+DI9ggtDgZGx+ph5PhtZV4QJ6copavyPusLQ4Xkb0RbVd3NWLddyM2lvM='
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
					$query = "//table[@id='TarifaDacV']/tr";
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
		
		public function obtener_tarifa_01() {
			$target = "https://app.cfe.mx/Aplicaciones/CCFE/Tarifas/TarifasCRECasa/Tarifas/Tarifa1.aspx";
			
			$user_agent = 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36';	
			
			$post = [
				'ctl00$ContentPlaceHolder1$MesVerano1$ddMesConsulta' => date('n'),
				'ctl00$ContentPlaceHolder1$Fecha$ddAnio' => date('Y'),
				'__VIEWSTATE' => 'FJNh0/mro9Too+d+2PpVmA4VU+nbXs2JJZkkz2E5IZ+mMTzdtl+t5ojPHQF2oG5VwVC3GwAjX+AYFwNndosiVHKGZb8j+0cq8sK9nYO7+SCxNNX3uHtk+heS2f1/805aCxWeRFwIhUTaIybJ7b4KJdC+jHQw/xT2zA57HzAcxZARJg6Ximv/6j5BxxyBmT3JHDBFfsp+QJBpESy7gMRqxpdI2a9cgrM29KZoVDmXm5x2qlRCkgJrNtMHA2CUPSP86rt5Y8p+DqR110+FiW3JKQS0yWJw0jhJX21AkZAuBHyZGcY0',
				'__EVENTVALIDATION' => 'GQA83kmdXUaX6R9L5xIwAs3XtwbNYDZxyjk/ObYhY6bmEbp2KsvXrsIVJb5XlSHFD6WIMvxYNXxevgq4emUX/atGviw+if1sfOAaP1PfPdUgXOdzqmAS9jTXDZ524nB1sGFYqn0oPtZ2GkaTgheuHDbCSH2+1tQw9ZiSoqVkDZ/dHgOZlcfhLZ8VNWvmj+8b0LQb4e7iEzyS+z7RwsWanoUAXd+0ptC1BU3EVgULS4FYSQp7uoTgwSE1SezyF5izzZ47l7bJO7DYVH+hPiqgvRvaiNy2HVah8v0ONIJr+GdduoBDZAynPMCcYTV6PLfJ4AGQLe/76Ea72KN8rXpRnk96SYUGCRx8yHgtFqLwk4Oha1JAP2P4HlbTAEICwnzra4ALhtGHeLFQ3HVwUDThn8AmJXLlI8w3bRM+kXO8qvIgjZsbpmECt4EvP8iRbbbhli3d1zgBQibHNWDQUjenw5fbu/KT+F9B/zY3YC4kXUGWYDWqJrOAVxPWVJVaCSBlaK8UMjJfA4yZ9pJQLQFNiVz6GlqYBHZEON3v5UsuLjgH+bbpk0rKrGSlpqKVTW/5kWOM8g=='
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
	}
