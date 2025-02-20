<?php
class ZonaHorariaModel extends CI_Model{
	public function __construct(){
		parent::__construct();
		$this->db->query("SET @@session.time_zone = '-05:00'");
	}
}
