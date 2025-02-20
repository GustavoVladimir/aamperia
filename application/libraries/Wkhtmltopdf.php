<?php
defined('BASEPATH') or exit('No direct script access allowed');

use mikehaertl\wkhtmlto\Pdf;

class Wkhtmltopdf
{
	public function crear_pdf($html = '', $nombre_archivo = '', $tipo_descarga = 1)
	{
		$pdf = new Pdf($html);

		// Ejecutable del Wkhtmltopdf, puede cambiar dependiendo del sistema y directorio
		$pdf->binary = APPPATH . 'third_party/usr/local/bin/./wkhtmltopdf';

		switch ($tipo_descarga) {
			case 1:
				// Descargar PDF directo
				if (!$pdf->send($nombre_archivo . '.pdf')) {
					$error = $pdf->getError();
					echo $error;
				}
				break;
			case 2:
				// Visualizar PDF en navegador
				if (!$pdf->send()) {
					$error = $pdf->getError();
					echo $error;
				}
				break;
			default:
				echo "Solamente se pueden elegir 2 tipos de descarga (1 = descarga directa / 2 = visualizar en navegador)";
		}
	}
}