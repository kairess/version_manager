<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends MY_Controller {
	public function index() {
		$this->_header();
		$this->load->view('welcome_message');
		$this->_footer();
	}
}