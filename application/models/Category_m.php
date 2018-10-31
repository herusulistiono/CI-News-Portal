<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
* Name:  Category  Model
*
* Author:  Heru Sulistiono
* 		   mildlaser3@gmail.com
* Copyright © Heru Sulistiono
* Location: https://herusulistiono.net/
* Created:  31.03.2018
* Requirements: PHP5, jQuery,Bootstrap,Datatable
*
*/
class Category_m extends CI_Model {
	public function __construct()
	{
		parent::__construct();
	}
	public function get_news_category()
	{
		# code...
	}
	public function get_category()
	{
		$this->db->select('COUNT(n.category_id) AS rec_count,c.category_id,c.category_name,c.category_seo');
		$this->db->from('category c');
		$this->db->join('news n','c.category_id=n.category_id','LEFT');
		$this->db->group_by('c.category_id');
		return $this->db->get();
	}
	public function get_by_id($category_id)
	{
		$this->db->where('category_id',$category_id);
	    return $this->db->get('category');
	}
	public function insert($data)
	{
		$this->db->insert('category', $data);
		return TRUE;
	}
	public function update($data)
	{
		$this->db->where(array('category_id'=>$data['category_id']));
		$this->db->update('category', $data);
		return TRUE;
	}
}

/* End of file Category_m.php */
/* Location: ./application/models/Category_m.php */