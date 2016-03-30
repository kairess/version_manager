<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Post_model extends MY_Model {

	public function upload($arg) {
		$this->db->set('post_type', 'post');
		$this->db->set('title', $arg['title']);
		$this->db->set('contents', $arg['contents']);
		$this->db->set('user_id', $arg['user_id']);
		$this->db->set('status', 2);
		$this->db->set('date', 'NOW()', FALSE);
		$this->db->set('updated_date', 'NOW()', FALSE);
		$this->db->insert('post');
		$insert_id = $this->db->insert_id();
		
		foreach($arg['file_names'] as $file_name) {
			$this->db->set('name', $file_name);
			$this->db->set('post_id', $insert_id);
			$this->db->set('date', 'NOW()', FALSE);
			$this->db->insert('uploads');
		}

		foreach($arg['tags'] as $tag) {
			$this->db->set('tag', $tag);
			$this->db->set('post_id', $insert_id);
			$this->db->set('date', 'NOW()', FALSE);
			$this->db->insert('tag');
		}

		if(isset($arg['version']) && $arg['version']) {
			add_postmeta('version', $arg['version'], $insert_id);
		}

		return $insert_id;
	}

	public function upload_comment($arg) {
		$this->db->set('post_type', 'comment');
		$this->db->set('contents', $arg['contents']);
		$this->db->set('user_id', $arg['user_id']);
		$this->db->set('post_id', $arg['post_id']);
		$this->db->set('status', 2);
		$this->db->set('date', 'NOW()', FALSE);
		$this->db->set('updated_date', 'NOW()', FALSE);
		$this->db->insert('post');
		$insert_id = $this->db->insert_id();
		
		foreach($arg['file_names'] as $file_name) {
			$this->db->set('name', $file_name);
			$this->db->set('post_id', $insert_id);
			$this->db->set('date', 'NOW()', FALSE);
			$this->db->insert('uploads');
		}

		return $insert_id;
	}

	public function get_posts($arg) {
		$this->db->select('post.*');
		$this->db->where('post.post_type', 'post');
		$this->db->where('post.status', 2);
		$this->db->order_by('post.updated_date', 'DESC');
		if(isset($arg['limit']) && isset($arg['page'])) {
			$this->db->limit($arg['limit'], $arg['limit']*($arg['page']-1));
		}

		if(isset($arg['tags']) && !empty($arg['tags'])) {
			$this->db->select('tag.tag');
			$this->db->where_in('tag.tag', $arg['tags']);
			$this->db->join('tag', 'tag.post_id = post.id');
			$this->db->group_by('tag.post_id');
		}

		return $this->db->get('post')->result();
	}

	public function get_post($arg) {
		$this->db->where('id', $arg['post_id']);
		return $this->db->get('post')->row();
	}

	public function get_comments($arg) {
		$this->db->where('post_id', $arg['post_id']);
		$this->db->where('status', 2);
		$this->db->where('post_type', 'comment');
		$this->db->order_by('date', 'DESC');
		return $this->db->get('post')->result();
	}

	public function get_files($arg) {
		$this->db->where('post_id', $arg['post_id']);
		return $this->db->get('uploads')->result();
	}

	public function get_tags($arg) {
		if(isset($arg['post_id']) && $arg['post_id']) {
			$this->db->where('post_id', $arg['post_id']);
		}
		$this->db->group_by('tag');
		return $this->db->get('tag')->result();
	}
}