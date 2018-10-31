<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Programs extends CI_Controller {
	public function __construct()
	{
		parent::__construct();
	}
	public function index()
	{
		$this->data['title']='Program PKPBerdikari';
		$this->data['m_description']='PKPBerdikari';
		$this->data['m_keyword']= 'PKPBerdikari';
        $this->template->display('members/pkpberdikari/program',$this->data);
	}

}

/* End of file Programs.php */
/* Location: ./application/controllers/Programs.php */