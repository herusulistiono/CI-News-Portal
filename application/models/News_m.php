<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
* Name:  News  Model
*
* Author:  Heru Sulistiono
* 		   mildlaser3@gmail.com
* Copyright © Heru Sulistiono
* Location: https://herusulistiono.net/
* Created:  31.03.2018
* Requirements: PHP5, jQuery,Bootstrap,Datatable
*
*/
class News_m extends CI_Model {
	public function __construct()
	{
		parent::__construct();
	}
	public function get_paged_list($limit=10, $offset=0)
	{
		$this->db->select('n.*,u.first_name,u.last_name');
		$this->db->from('news n');
		$this->db->join('users u','n.news_postby=u.id','INNER');
		$this->db->where('n.news_status','Publish');
		$this->db->where('n.media','NEWS');
		$this->db->limit($limit, $offset);
		$this->db->order_by('news_postdate', 'DESC');
		return $this->db->get();
	}
	public function count_all()
	{
		return $this->db->count_all('news');
	}
	//Read RSS
	public function read_rss()
	{
		$this->db->select('n.*, c.category_name,u.first_name,u.last_name');
		$this->db->from('news n');
		$this->db->join('category c','n.category_id=c.category_id', 'INNER');
		$this->db->join('users u','n.news_postby=u.id','INNER');
		$this->db->where('n.news_status','Publish');
		$this->db->order_by('n.news_id', 'DESC');
		$this->db->limit(10);
		return $this->db->get();
	}
	public function get_breaking_news()
	{
		$this->db->select('n.*, c.category_name,u.first_name,u.last_name,u.photo');
		$this->db->from('news n');
		$this->db->join('category c','n.category_id=c.category_id', 'INNER');
		$this->db->join('users u','n.news_postby=u.id','INNER');
		/*$this->db->where('n.media','NEWS');
		$this->db->where('n.media','VIDEO');
		$this->db->where('n.media !=','INFO GRAFIS');
		$this->db->where('n.media !=','YOUR STORY');
		$this->db->where('n.status', 'Active');*/
		$this->db->where('n.news_status', 'Publish');
		$this->db->order_by('news_postdate', 'desc');
		return $this->db->get();
	}
	public function get_headline()
	{
		$this->db->select('n.*, c.category_name,u.first_name,u.last_name,u.photo');
		$this->db->from('news n');
		$this->db->join('category c','n.category_id=c.category_id', 'INNER');
		$this->db->join('users u','n.news_postby=u.id','INNER');
		//$this->db->where('n.media','NEWS');
		//$this->db->where('n.media','VIDEO');
		$this->db->where('n.media !=','INFO GRAFIS');
		$this->db->where('n.media !=','YOUR STORY');
		$this->db->where('n.status', 'Active');
		$this->db->order_by('news_postdate', 'desc');
		return $this->db->get();
	}

	public function get_news_post()
	{
		$this->db->select('n.*, c.category_name,u.first_name,u.last_name');
		//$this->db->select('COUNT(com.comment_post_id) AS comment_hit');
		$this->db->from('news n');
		$this->db->join('category c','n.category_id=c.category_id', 'INNER');
		//$this->db->join('comments com','com.comment_post_id=n.news_id','RIGHT');
		$this->db->join('users u','n.news_postby=u.id','INNER');
		$this->db->where('n.news_status','Publish');
		$this->db->where('n.media','NEWS');
		$this->db->order_by('n.news_id', 'DESC');
		$this->db->limit(12);
		return $this->db->get();
	}

	public function news_popular_day()
	{
		$this->db->select('n.*,u.first_name,u.last_name');
		$this->db->from('news n');
		$this->db->join('users u','n.news_postby=u.id','INNER');
		$this->db->where('news_status','Publish');
		$this->db->order_by('n.news_view', 'DESC');
		$this->db->limit(10);
		return $this->db->get();
	}
	public function news_popular_weeks()
	{
		$this->db->select('n.*, c.category_name,u.first_name,u.last_name');
		$this->db->from('news n');
		$this->db->join('category c','n.category_id=c.category_id', 'INNER');
		$this->db->join('users u','n.news_postby=u.id','INNER');
		$this->db->where('news_status','Publish');
		$this->db->order_by('n.news_view', 'DESC');
		$this->db->limit(5);
		return $this->db->get();
	}

	public function get_news($seo=FALSE)
	{
	    if ($seo===FALSE){return $this->db->get('news');}
	    $this->db->select('n.*, c.category_name,u.first_name,u.last_name,u.photo');
		$this->db->from('news n');
		$this->db->join('category c','n.category_id=c.category_id', 'INNER');
		$this->db->join('users u','n.news_postby=u.id','INNER');
		$this->db->where(array('news_seo'=>$seo));
		return $this->db->get();
	}
	public function update_view($view)
	{
		$this->db->where(array('news_id'=>$view['news_id']));
		$this->db->update('news', $view);
		return TRUE;
	}
	//Get news by post User
	public function post_by($id)
	{
		$this->db->select('n.*, c.category_name,u.first_name,u.last_name');
		$this->db->from('news n');
		$this->db->join('category c','n.category_id=c.category_id', 'INNER');
		$this->db->join('users u','n.news_postby=u.id','INNER');
		$this->db->where('n.news_postby', $id);
		$this->db->where('n.media','NEWS');
		$this->db->order_by('news_postdate', 'desc');
		return $this->db->get();
	}
	//administrator model
	public function all_news()
	{
		$this->db->select('n.*, c.category_name,u.first_name,u.last_name');
		$this->db->from('news n');
		$this->db->join('category c','n.category_id=c.category_id', 'INNER');
		$this->db->join('users u','n.news_postby=u.id','INNER');
		$this->db->order_by('news_postdate', 'desc');
		$this->db->where('n.media','NEWS');
		return $this->db->get();
	}
	public function get_news_id($news_id=FALSE)
	{
		if ($news_id===FALSE){
	        return $this->db->get('news');
	    }
	    $this->db->select('*');
	    $this->db->from('news');
	    $this->db->where(array('news_id'=>$news_id));
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
			//base_url(unlink('./images/news/medium_'.$rows['news_picture']));
			$this->db->where(array('news_id'=>$data['news_id']));
			$this->db->update('news', $data);
			return TRUE;
		}
	}
	public function news_delete($data)
	{
		$this->db->select('news_picture');
		$this->db->from('news');
		$this->db->where(array('news_id'=>$data['news_id']));
		$this->db->limit(1);
		$query = $this->db->get();
		$q = $query->result_array();
		foreach ($q as $rows) {
			base_url(unlink('./images/news/'.$rows['news_picture']));
			//base_url(unlink('./images/news/medium_'.$rows['news_picture']));
			$this->db->where(array('news_id'=>$data['news_id']));
			$this->db->delete('news');
			return TRUE;
		}
	}
	public function publish($data)
	{
		$this->db->where(array('news_id'=>$data['news_id']));
		$this->db->update('news', $data);
		return TRUE;
	}
	public function unpublish($data)
	{
		$this->db->where(array('news_id'=>$data['news_id']));
		$this->db->update('news', $data);
		return TRUE;
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

/* End of file News_m.php */
/* Location: ./application/models/News_m.php */