<?php defined('BASEPATH') OR exit('No direct script access allowed');

class User_model extends MY_Model {

	public function get_user_by_user_id($arg) {

	}
	
	public function get_user_by_username($arg) {
		$this->db->where('username', $arg['username']);
		$result = $this->db->get('user')->row();
		return $result;
	}

	public function register($arg) {
		$this->db->set('username', $arg['username']);
		$this->db->set('password', $arg['password']);
		$this->db->set('type', $arg['type']);
		$this->db->set('date', 'NOW()', FALSE);
		$this->db->set('updated_date', 'NOW()', FALSE);
		$this->db->insert('user');
		return $this->db->insert_id();
	}
}