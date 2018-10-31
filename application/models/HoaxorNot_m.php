<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class HoaxorNot_m extends CI_Model {
	public function __construct()
	{
		parent::__construct();
	}
	public function get_paged_list($limit=10,$offset=0)
	{
		$this->db->select('n.*,u.first_name,u.last_name');
		$this->db->from('news n');
		$this->db->join('users u','n.news_postby=u.id','INNER');
		$this->db->where('n.news_status','Publish');
		$this->db->where('n.media','HOAX or NOT');
		$this->db->limit($limit, $offset);
		$this->db->order_by('n.news_postdate', 'DESC');
		return $this->db->get();
	}
	public function count_all()
	{
		return $this->db->count_all('news');
	}
	public function update_view($view)
	{
		$this->db->where(array('news_id'=>$view['news_id']));
		$this->db->update('news', $view);
		return TRUE;
	}
	public function get_data($seo=FALSE)
	{
	    if ($seo===FALSE){return $this->db->get('news');}
	    $this->db->select('n.*, c.category_name,u.first_name,u.last_name,u.photo');
		$this->db->from('news n');
		$this->db->join('category c','n.category_id=c.category_id', 'INNER');
		$this->db->join('users u','n.news_postby=u.id','INNER');
		$this->db->where(array('news_seo'=>$seo));
		return $this->db->get();
	}
	//READ POST BY USER
	public function post_by($id)
	{
		$this->db->select('n.*, c.category_name,u.first_name,u.last_name,u.photo');
		$this->db->from('news n');
		$this->db->join('category c','n.category_id=c.category_id', 'INNER');
		$this->db->join('users u','n.news_postby=u.id','INNER');
		$this->db->where('n.news_postby', $id);
		$this->db->where('n.media','HOAX or NOT');
		$this->db->order_by('news_postdate', 'desc');
		return $this->db->get();
	}
	//READ ALL DATATATABLE
	public function all_news()
	{
		$this->db->select('n.*, c.category_name,u.first_name,u.last_name');
		$this->db->from('news n');
		$this->db->join('category c','n.category_id=c.category_id', 'INNER');
		$this->db->join('users u','n.news_postby=u.id','INNER');
		$this->db->order_by('news_postdate', 'desc');
		$this->db->where('n.media','HOAX or NOT');
		return $this->db->get();
	}
}

/* End of file HoaxorNot_m.php */
/* Location: ./application/models/HoaxorNot_m.php */