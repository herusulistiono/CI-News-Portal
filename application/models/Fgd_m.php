<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Fgd_m extends CI_Model {
	public function __construct()
	{
		parent::__construct();
	}
	public function get_paged_list($limit=10, $offset=0)
	{
		$this->db->select('n.*,u.first_name,u.last_name,u.photo');
		$this->db->from('news n');
		$this->db->join('users u','n.news_postby=u.id','INNER');
		$this->db->where('n.news_status','Publish');
		$this->db->where('n.media','FGD');
		$this->db->limit($limit, $offset);
		$this->db->order_by('news_postdate', 'DESC');
		return $this->db->get();
	}
	public function all_news()
	{
		$this->db->select('n.*, c.category_name,u.first_name,u.last_name,u.photo');
		$this->db->from('news n');
		$this->db->join('category c','n.category_id=c.category_id', 'INNER');
		$this->db->join('users u','n.news_postby=u.id','INNER');
		$this->db->order_by('news_postdate', 'desc');
		$this->db->where('n.media','FGD');
		return $this->db->get();
	}

}

/* End of file Fgd_m.php */
/* Location: ./application/models/Fgd_m.php */