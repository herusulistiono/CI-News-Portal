<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Grafis_m extends CI_Model {
	public function __construct()
	{
		parent::__construct();
	}
	public function get_paged_list($limit=10,$offset=0)
	{
		/*$this->db->where('news_status','Publish');
		$this->db->where('media','INFO GRAFIS');
		$this->db->order_by('news_id', 'desc');
		return $this->db->get('news', $limit, $offset);*/
		$this->db->select('n.*,u.first_name,u.last_name');
		$this->db->from('news n');
		$this->db->join('users u','n.news_postby=u.id','INNER');
		$this->db->where('n.news_status','Publish');
		$this->db->where('n.media','INFO GRAFIS');
		$this->db->limit($limit, $offset);
		$this->db->order_by('news_postdate', 'DESC');
		return $this->db->get();
	}
	public function count_all()
	{
		return $this->db->count_all('news');
	}
	//show infografis on right three middle
	public function get_info_grafis()
	{
		$this->db->select('n.*,u.first_name,u.last_name');
		$this->db->from('news n');
		$this->db->join('users u','n.news_postby=u.id','INNER');
		$this->db->where('n.news_status','Publish');
		$this->db->where('n.media','INFO GRAFIS');
		$this->db->limit(8);
		$this->db->order_by('news_postdate', 'DESC');
		return $this->db->get();
	}
	//GET DATA READ GRAFIS
	public function read_grafis($seo=FALSE)
	{
	    if ($seo===FALSE){return $this->db->get('news');}
	    $this->db->select('n.*, c.category_name,u.first_name,u.last_name,u.photo');
		$this->db->from('news n');
		$this->db->join('category c','n.category_id=c.category_id', 'INNER');
		$this->db->join('users u','n.news_postby=u.id','INNER');
		$this->db->where(array('news_seo'=>$seo));
		return $this->db->get();
	}
	//UPDATE READ (VIEWS)
	public function update_view($view)
	{
		$this->db->where(array('news_id'=>$view['news_id']));
		$this->db->update('news', $view);
		return TRUE;
	}
	//SHOW DATATABLES
	public function show_in_datatable()
	{
		$this->db->select('n.*, c.category_name,u.first_name,u.last_name');
		$this->db->from('news n');
		$this->db->join('category c','n.category_id=c.category_id', 'INNER');
		$this->db->join('users u','n.news_postby=u.id','INNER');
		$this->db->where('n.media','INFO GRAFIS');
		$this->db->order_by('news_postdate', 'desc');
		return $this->db->get();
	}
	//GET BY NEWS ID
	public function get_id($news_id=FALSE)
	{
		if ($news_id===FALSE){return $this->db->get('news');}
	    $this->db->select('*');
	    $this->db->from('news');
	    $this->db->where(array('news_id'=>$news_id));
	    return $this->db->get();
	}
	//GET INFOGRAFIS BY USER
	public function post_by($id)
	{
		$this->db->select('n.*, c.category_name,u.first_name,u.last_name');
		$this->db->from('news n');
		$this->db->join('category c','n.category_id=c.category_id', 'INNER');
		$this->db->join('users u','n.news_postby=u.id','INNER');
		$this->db->where('n.news_postby', $id);
		$this->db->where('n.media','INFO GRAFIS');
		$this->db->order_by('news_postdate', 'desc');
		return $this->db->get();
	}
	//INSERT INTO NEWS
	public function insert($data)
	{
		$this->db->insert('news', $data);
		return TRUE;
	}
	//UPDATE SET NEWS
	public function update($data)
	{
		$this->db->where(array('news_id'=>$data['news_id']));
		$this->db->update('news', $data);
		return TRUE;
	}
	public function update_picture($data)
	{
		$this->db->select('news_picture');
		$this->db->from('news');
		$this->db->where(array('news_id'=>$data['news_id']));
		$this->db->limit(1);
		$query = $this->db->get();
		$q = $query->result_array();
		foreach ($q as $rows) {
			base_url(unlink('./images/news/grafis/'.$rows['news_picture']));
			$this->db->where(array('news_id'=>$data['news_id']));
			$this->db->update('news', $data);
			return TRUE;
		}
	}
	public function delete($data)
	{
		$this->db->select('news_picture');
		$this->db->from('news');
		$this->db->where(array('news_id'=>$data['news_id']));
		$this->db->limit(1);
		$query = $this->db->get();
		$q = $query->result_array();
		foreach ($q as $rows) {
			base_url(unlink('./images/news/grafis/'.$rows['news_picture']));
			$this->db->where(array('news_id'=>$data['news_id']));
			$this->db->delete('news');
			return TRUE;
		}
	}
}

/* End of file Grafis_m.php */
/* Location: ./application/models/Grafis_m.php */