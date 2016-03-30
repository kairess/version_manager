<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Main extends MY_Controller {
	function __construct() {
		parent::__construct();
		$this->load->model('post_model');
	}
	public function index() {
		

		$this->_header(array(
			'title' => 'Feed',
		));
		$this->load->view('main/index', array(
		));
		$this->_footer();
	}

	public function get_list() {
		$page = $this->input->post('page', TRUE)?:1;
		$tags = $this->input->post('selected_tags', TRUE)?:array();

		$posts = $this->post_model->get_posts(array(
			'tags' => $tags,
			'page' => $page,
			'limit' => 15,
		));

		foreach($posts as $post) {
			$files = $this->post_model->get_files(array(
				'post_id' => $post->id,
			));

			$post->exist_files = false;
			$post->file_size = 0;
			if(!empty($files)) {
				$post->exist_files = true;
				$post->file_size = sizeof($files);
			}
			$post->tags = $this->post_model->get_tags(array(
				'post_id' => $post->id,
			));
		}

		echo $this->load->view('main/elements/list', array(
			'posts' => $posts,
		), TRUE);
	}

	public function detail() {
		$post_id = $this->input->get('post_id', TRUE);

		$post = $this->post_model->get_post(array(
			'post_id' => $post_id,
		));

		$post->files = $this->post_model->get_files(array(
			'post_id' => $post_id,
		));

		$post->tags = $this->post_model->get_tags(array(
			'post_id' => $post_id,
		));

		$post->comments = $this->post_model->get_comments(array(
			'post_id' => $post_id,
		));

		foreach($post->comments as $comment) {
			$comment->files = $this->post_model->get_files(array(
				'post_id' => $comment->id,
			));
		}

		$this->load->view('main/elements/detail', array(
			'post' => $post,
		));
	}

	public function upload() {
		$tags = $this->post_model->get_tags(array(
		));

		$this->_header(array(
			'title' => 'Upload',
		));
		$this->load->view('main/upload', array(
			'tags' => $tags,
		));
		$this->_footer();
	}

	public function upload_action() {
		$title = $this->input->post('title', TRUE);
		$contents = $this->input->post('contents', TRUE);
		$version = $this->input->post('version', TRUE);
		$tags = $this->input->post('tags', TRUE)?:array();

		$file_names = array();

		$config['upload_path'] = './uploads/';
		$config['allowed_types'] = '*';

		$this->load->library('upload', $config);

		if($this->upload->do_upload('file')) {
			$upload_data = $this->upload->data();
			$file_names = array($upload_data['file_name']);
			// echo $this->upload->display_errors();
			// return false;
		}

		$post_id = $this->post_model->upload(array(
			'title' => $title,
			'contents' => $contents,
			'version' => $version,
			'user_id' => $this->user_id,
			'file_names' => $file_names,
			'tags' => $tags,
		));

		redirect(base_url('main'));
	}

	public function comment_action() {
		$post_id = $this->input->post('post_id', TRUE);
		$contents = $this->input->post('contents', TRUE);

		$file_names = array();

		$config['upload_path'] = './uploads/comment';
		$config['allowed_types'] = '*';

		$this->load->library('upload', $config);

		if($this->upload->do_upload('file')) {
			$upload_data = $this->upload->data();
			$file_names = array($upload_data['file_name']);
			// echo $this->upload->display_errors();
			// return false;
		}

		$post_id = $this->post_model->upload_comment(array(
			'contents' => $contents,
			'post_id' => $post_id,
			'user_id' => $this->user_id,
			'file_names' => $file_names,
		));

		redirect(base_url('main'));
	}
}