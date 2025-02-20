<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| Configuración de correo
|--------------------------------------------------------------------------
|
| Este archivo se crea para la configuración de acceso al correo.
|
*/

$config['protocol'] = 'mail';
$config['smtp_host'] = 'smtp.ionos.mx';
$config['smtp_port'] = '587'; 
$config['smtp_crypto'] = 'tls';
$config['smtp_user'] = 'atencion@agctecnologias.com';
$config['smtp_pass'] = 'Aamperia2021@@';
$config['charset'] = 'utf-8';
$config['mailtype'] = 'html';