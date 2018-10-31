<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
* Name:  Gallery  Model
*
* Author:  Heru Sulistiono
* 		   mildlaser3@gmail.com
* Copyright © Heru Sulistiono
* Location: https://herusulistiono.net/
* Created:  31.03.2018
* Updated:  27.04.2018
* Requirements: PHP5, jQuery,Bootstrap,Datatable
*
*/
class Gallery_m extends CI_Model {
	public function __construct()
	{
		parent::__construct();
	}
	//VIDEO GET VIDEO ON SIX GRID
	public function video_list()
	{
		$this->db->select('*');
		$this->db->from('news');
		$this->db->where('media','VIDEO');
		$this->db->where('news_status', 'Publish');
		$this->db->order_by('news_postdate', 'DESC');
		return $this->db->get();
	}
	//VIDEO GET VIDEO ON SIX GRID
	public function get_video_home()
	{
		$this->db->select('*');
		$this->db->from('news');
		$this->db->where('media','VIDEO');
		$this->db->where('news_status', 'Publish');
		$this->db->limit(6);
		$this->db->order_by('news_postdate', 'DESC');
		return $this->db->get();
	}
	//VIDEO GET EDIT
	public function get_video_id($news_id=FALSE)
	{
		if ($news_id===FALSE){
	        return $this->db->get('news');
	    }
	    $this->db->select('*');
	    $this->db->from('news');
	    $this->db->where(array('news_id'=>$news_id));
	    return $this->db->get();
	}
	//VIDEO GET DATA
	public function video_data()
	{
		$this->db->select('n.*, c.category_name,u.first_name,u.last_name');
		$this->db->from('news n');
		$this->db->join('category c','n.category_id=c.category_id', 'INNER');
		$this->db->join('users u','n.news_postby=u.id','INNER');
		$this->db->order_by('news_postdate', 'desc');
		$this->db->where('n.media','VIDEO');
		return $this->db->get();
	}
	public function insert($data)
	{
		$this->db->insert('news', $data);
		return TRUE;
	}
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
			base_url(unlink('./images/news/'.$rows['news_picture']));
			$this->db->where(array('news_id'=>$data['news_id']));
			$this->db->update('news', $data);
			return TRUE;
		}
	}
	//VIDEO DELETE
	public function video_delete($data)
	{
		$this->db->select('news_picture');
		$this->db->from('news');
		$this->db->where(array('news_id'=>$data['news_id']));
		$this->db->limit(1);
		$query = $this->db->get();
		$q = $query->result_array();
		foreach ($q as $rows) {
			base_url(unlink('./images/news/'.$rows['news_picture']));
			$this->db->where(array('news_id'=>$data['news_id']));
			$this->db->delete('news');
			return TRUE;
		}
	}
	public function active($data)
	{
		$this->db->where(array('news_id'=>$data['news_id']));
		$this->db->update('news', $data);
		return TRUE;
	}
	public function inactive($data)
	{
		$this->db->where(array('news_id'=>$data['news_id']));
		$this->db->update('news', $data);
		return TRUE;
	}
}

/* End of file Gallery_m.php */
/* Location: ./application/models/Gallery_m.php */