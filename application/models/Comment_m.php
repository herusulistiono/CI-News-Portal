<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Comment_m extends CI_Model {
	public function __construct()
	{
		parent::__construct();
	}
	public function get_comment()
	{
		$this->db->select('c.*,n.news_title,n.news_picture');
		$this->db->from('comments c');
		$this->db->join('news n', 'c.comment_post_id=n.news_id','INNER');
		$this->db->limit(5);
		$this->db->order_by('c.comment_date', 'DESC');
		return $this->db->get();
	}
	public function insert($data)
	{
		$this->db->insert('comments', $data);
		return TRUE;
	}
}

/* End of file Comment_m.php */
/* Location: ./application/models/Comment_m.php */