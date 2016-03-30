<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends MY_Controller {
	function __construct() {
		parent::__construct();
		$this->load->model('user_model');
	}

	public function index() {
		exit();
	}

	public function logout() {
		$this->session->sess_destroy();
		redirect(base_url());
	}

	public function login_action() {
		$username = $this->input->post('username', TRUE);
		$password = $this->input->post('password', TRUE);

		$user = $this->user_model->get_user_by_username(array(
			'username' => $username,
		));

		if(empty($user)) {
			$this->alert(array(
				'message' => 'Username not exist',
				'url' => '',
			));
			return false;
		}

		if($user->type <= 1) {
			$this->alert(array(
				'message' => 'Please let me know you have no permission, Brad',
				'url' => '',
			));

			return false;
		}

		if($user->password != md5($password)) {
			$this->alert(array(
				'message' => 'Password is wrong',
				'url' => '',
			));
			return false;
		}

		$this->db->where('id', $user->id);
		$this->db->set('updated_date', 'NOW()', FALSE);
		$this->db->update('user');

		$this->session->set_userdata('is_logged_in', true);
		$this->session->set_userdata('user_id', $user->id);
		$this->session->set_userdata('username', $user->username);
		$this->session->set_userdata('type', $user->type);

		redirect(base_url('main'));
	}

	public function register() {
		$this->_header(array(
			'title' => 'Register',
		));
		$this->load->view('auth/register');
		$this->_footer();
	}

	public function register_action() {
		$username = $this->input->post('username', TRUE);
		$password = $this->input->post('password', TRUE);
		$password_confirm = $this->input->post('password_confirm', TRUE);

		if($password != $password_confirm) {
			$this->alert(array(
				'message' => 'Two passwords are different',
				'url' => 'auth/register',
			));
			return false;
		}

		$user = $this->user_model->get_user_by_username(array(
			'username' => $username,
		));

		if(!empty($user)) {
			$this->alert(array(
				'message' => 'Username is duplicated',
				'url' => 'auth/register',
			));
			return false;
		}

		$user_id = $this->user_model->register(array(
			'username' => $username,
			'password' => md5($password),
			'type' => 1,
		));

		$this->alert(array(
			'message' => 'Please wait until Brad approve your account',
			'url' => '',
		));
		return false;
	}

	public function settings() {
		$this->_header(array(
			'title' => 'Settings',
		));
		$this->load->view('auth/settings');
		$this->_footer();
	}


	public function settings_action() {
		$password = $this->input->post('password', TRUE);
		$password_confirm = $this->input->post('password_confirm', TRUE);

		if($password && $password_confirm) {
			if($password != $password_confirm) {
				$this->alert(array(
					'message' => 'Two passwords are different',
					'url' => 'auth/register',
				));
				return false;
			}

			$this->db->where('id', $this->user_id);
			$this->db->set('password', md5($password));
			$this->db->set('updated_date', 'NOW()', FALSE);
			$this->db->update('user');
		}

		$file_names = array();

		$config['upload_path'] = './uploads/profile';
		$config['allowed_types'] = '*';

		$this->load->library('upload', $config);

		if($this->upload->do_upload('file')) {
			$upload_data = $this->upload->data();
			add_usermeta('profile_picture', $upload_data['file_name'], $this->user_id);
		}

		$this->alert(array(
			'message' => 'Saved',
			'url' => 'auth/settings',
		));
	}
}