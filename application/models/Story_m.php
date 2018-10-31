<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
* Name:  Stort Model
*
* Author:  Heru Sulistiono
* 		   mildlaser3@gmail.com
* Copyright © Heru Sulistiono
* Website: https://herusulistiono.net/
* Created:  25.04.2018
* Requirements: PHP5, jQuery,Bootstrap,Datatable
*
*/
class Story_m extends CI_Model {
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
		$this->db->where('n.media','YOUR STORY');
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
	public function get_story($seo=FALSE)
	{
	    if ($seo===FALSE){return $this->db->get('news');}
	    $this->db->select('n.*, c.category_name,u.first_name,u.last_name,u.photo');
		$this->db->from('news n');
		$this->db->join('category c','n.category_id=c.category_id', 'INNER');
		$this->db->join('users u','n.news_postby=u.id','INNER');
		$this->db->where(array('news_seo'=>$seo));
		return $this->db->get();
	}
	public function get_your_story()
	{
		$this->db->select('n.*,u.first_name,u.last_name,u.photo');
		$this->db->from('news n');
		$this->db->join('users u','n.news_postby=u.id','INNER');
		$this->db->where('n.news_status','Publish');
		$this->db->where('n.media','YOUR STORY');
		$this->db->order_by('n.news_postdate', 'DESC');
		$this->db->limit(5);
		return $this->db->get();
	}
	//ALL TO DASHBOARAD
	public function get_id($news_id)
	{
	  $this->db->select('*');
	  $this->db->from('news');
	  $this->db->where(array('news_id'=>$news_id,'media'=>'YOUR STORY'));
	  return $this->db->get();
	}
	public function story_data()
	{
		$this->db->select('n.*, c.category_name,u.first_name,u.last_name');
		$this->db->from('news n');
		$this->db->join('category c','n.category_id=c.category_id', 'INNER');
		$this->db->join('users u','n.news_postby=u.id','INNER');
		$this->db->order_by('news_postdate', 'desc');
		$this->db->where('n.media','YOUR STORY');
		return $this->db->get();
	}
	public function post_by($id)
	{
		$this->db->select('n.*, c.category_name,u.first_name,u.last_name');
		$this->db->from('news n');
		$this->db->join('category c','n.category_id=c.category_id', 'INNER');
		$this->db->join('users u','n.news_postby=u.id','INNER');
		$this->db->where('n.news_postby', $id);
		$this->db->where('n.media','YOUR STORY');
		$this->db->order_by('news_postdate', 'desc');
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
			base_url(unlink('./images/news/story/'.$rows['news_picture']));
			$this->db->where(array('news_id'=>$data['news_id']));
			$this->db->update('news', $data);
			return TRUE;
		}
	}
	public function story_delete($data)
	{
		$this->db->select('news_picture');
		$this->db->from('news');
		$this->db->where(array('news_id'=>$data['news_id']));
		$this->db->limit(1);
		$query = $this->db->get();
		$q = $query->result_array();
		foreach ($q as $rows) {
			base_url(unlink('./images/news/story/'.$rows['news_picture']));
			$this->db->where(array('news_id'=>$data['news_id']));
			$this->db->delete('news');
			return TRUE;
		}
	}
}

/* End of file Story_m.php */
/* Location: ./application/models/Story_m.php */