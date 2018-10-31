<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Setting_m extends CI_Model {
	public function __construct()
	{
		parent::__construct();
	}
	public function get_setting($web_id)
	{
		if ($web_id===FALSE){
	        return $this->db->get('static_page');
	    }
	    $this->db->select('*');
	    $this->db->from('static_page');
	    $this->db->where(array('web_id'=>$web_id));
	    return $this->db->get();
	}
	public function change_update($data)
	{
		$this->db->where(array('web_id'=>$data['web_id']));
		$this->db->update('static_page', $data);
		return TRUE;
	}
	public function change_update_picture($data)
	{
		$this->db->select('picture');
		$this->db->from('static_page');
		$this->db->where(array('web_id'=>$data['web_id']));
		$this->db->limit(1);
		$query = $this->db->get();
		$q = $query->result_array();
		foreach ($q as $rows) {
			base_url(unlink('./images/about/'.$rows['picture']));
			$this->db->where(array('web_id'=>$data['web_id']));
			$this->db->update('static_page', $data);
			return TRUE;
		}
	}
}

/* End of file Setting_m.php */
/* Location: ./application/models/Setting_m.php */