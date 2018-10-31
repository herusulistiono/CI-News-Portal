<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class About extends CI_Controller {
	public function __construct()
	{
		parent::__construct();
		$this->load->model(array('setting_m'));
	}
	public function index()
	{
		$this->data['title']='Tentang PKPBerdikari';
		$this->data['m_description']='PKPBerdikari';
		$this->data['m_keyword']= 'PKPBerdikari';
        $this->template->display('members/pkpberdikari/tentang',$this->data);
		//$web_id=(int)1;
		//$setting=$this->setting_m->get_setting($web_id)->row();
        /*if (empty($setting)) {
        	show_404();
        }else{
        	$setting=$this->setting_m->get_setting($web_id)->row();
        	$this->data['title']=$setting->web_title;
        	$this->data['web_id']= $setting->web_id;
        	$this->data['web_title']= $setting->web_title;
        	$this->data['web_content']= $setting->web_content;
        	$this->data['picture']= $setting->picture;
        	$this->data['m_description']=$setting->web_title.' - kerjakerja.id';
			$this->data['m_keyword']=$setting->web_title .' - kerjakerja.id';
			//$this->template->display('members/about',$this->data);
			$this->template->display('members/pkpberdikari/tentang/',$this->data);
		}*/
	}

}

/* End of file About.php */
/* Location: ./application/controllers/About.php */