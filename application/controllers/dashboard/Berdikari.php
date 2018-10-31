<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Berdikari extends CI_Controller {
	public function __construct()
	{
		parent::__construct();
		$this->load->model(array('setting_m'));
	}
	public function index()
	{
		
	}
	public function tentang()
	{
		if (!$this->ion_auth->logged_in()){
			redirect('dashboard/auth/login', 'refresh');
		}elseif (!$this->ion_auth->is_admin() && !$this->ion_auth->in_group('editor')){
			return show_error('You must be an administrator to view this page.');
		}else{
			$web_id=(int)1;
			$setting=$this->setting_m->get_setting($web_id)->row();
	        if (empty($setting)) {
	        	show_404();
	        }else{
	        	$this->data['title']='Tentang PKPBerdikari';
	        	$setting=$this->setting_m->get_setting($web_id)->row();
	        	$this->data['web_id']= $setting->web_id;
	        	$this->data['web_title']= $setting->web_title;
	        	$this->data['web_content']= $setting->web_content;
				$this->backend->display('admin/berdikari/tentang',$this->data);
			}
		}
	}
	public function struktur_organisasi()
	{
		if (!$this->ion_auth->logged_in()){
			redirect('dashboard/auth/login', 'refresh');
		}elseif (!$this->ion_auth->is_admin() && !$this->ion_auth->in_group('editor')){
			return show_error('You must be an administrator to view this page.');
		}else{
			$web_id=(int)1;
			$setting=$this->setting_m->get_setting($web_id)->row();
	        if (empty($setting)) {
	        	show_404();
	        }else{
	        	$this->data['title']='Struktur Organisasi PKPBerdikari';
	        	$setting=$this->setting_m->get_setting($web_id)->row();
	        	$this->data['web_id']= $setting->web_id;
	        	$this->data['web_title']= $setting->web_title;
	        	$this->data['web_content']= $setting->web_content;
				$this->backend->display('admin/berdikari/struktur',$this->data);
			}
		}
	}
	public function program()
	{
		if (!$this->ion_auth->logged_in()){
			redirect('dashboard/auth/login', 'refresh');
		}elseif (!$this->ion_auth->is_admin() && !$this->ion_auth->in_group('editor')){
			return show_error('You must be an administrator to view this page.');
		}else{
			$web_id=(int)1;
			$setting=$this->setting_m->get_setting($web_id)->row();
	        if (empty($setting)) {
	        	show_404();
	        }else{
	        	$this->data['title']='Program PKPBerdikari';
	        	$setting=$this->setting_m->get_setting($web_id)->row();
	        	$this->data['web_id']= $setting->web_id;
	        	$this->data['web_title']= $setting->web_title;
	        	$this->data['web_content']= $setting->web_content;
				$this->backend->display('admin/berdikari/program',$this->data);
			}
		}
	}

}

/* End of file Berdikari.php */
/* Location: ./application/controllers/dashboard/Berdikari.php */