<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MY_Controller extends CI_Controller {
	function __construct() {
		parent::__construct();

		$class_name = $this->router->fetch_class();
		$method_name = $this->router->fetch_method();

		$allow_classes = array(
			'auth',
			'welcome',
		);

		if(!in_array($class_name, $allow_classes)) {
			if(!$this->session->userdata('is_logged_in')) {
				$this->alert(array(
					'message' => 'Login required',
					'url' => ''
				));
			}
		}

		if($this->session->userdata('is_logged_in')) {
			$this->user_id = $this->session->userdata('user_id');
		} else {
			$this->user_id = false;
		}
	}

	public function _header($arg = array()) {
		$this->load->model('post_model');
		$arg['tags'] = $this->post_model->get_tags(array());

		if(isset($arg['title'])) {
			$arg['title'] = $arg['title'] . ' :: Ecubelabs Version Manager';
		} else {
			$arg['title'] = 'Ecubelabs Version Manager';
		}

		$this->load->view('header', $arg);
	}

	public function _footer($arg = array()) {
		$this->load->view('footer', $arg);
	}

	public function alert($arg) {
		$this->session->set_flashdata('message', $arg['message']);
		redirect(base_url($arg['url']));
	}

	public function insert_db($arg) {
		if(isset($arg['table'])) {
			$table = $arg['table'];
			unset($arg['table']);
		} else {
			return false;
		}

		if(isset($arg['date'])) {
			$this->db->set('date', $arg['date'], FALSE);
			unset($arg['date']);
		}

		if(isset($arg['last_login'])) {
			$this->db->set('last_login', $arg['last_login'], FALSE);
			unset($arg['last_login']);
		}

		$this->db->set($arg);
		$this->db->insert($table);
	}
}