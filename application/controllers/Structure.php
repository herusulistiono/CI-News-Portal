<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Structure extends CI_Controller {
	public function __construct()
	{
		parent::__construct();
	}
	public function index()
	{
		$this->data['title']='Struktur PKPBerdikari';
		$this->data['m_description']='PKPBerdikari';
		$this->data['m_keyword']= 'PKPBerdikari';
        $this->template->display('members/pkpberdikari/struktur',$this->data);
	}

}

/* End of file Structure.php */
/* Location: ./application/controllers/Structure.php */