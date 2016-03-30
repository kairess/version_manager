<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MY_Model extends CI_Model {
	function __construct() {
		parent::__construct();
		// $this->set_timezone('+0:00');	// UTC
	}

	// set timezone UTC(GMT +0) to default when insert or update
	public function set_timezone($time_zone) {
		$this->db->query("SET time_zone='$time_zone'");
	}
}