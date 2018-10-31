<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
* Name:  Dashboard Home Controller
*
* Author:  Heru Sulistiono
* 		   mildlaser3@gmail.com
* Copyright © Heru Sulistiono
* Website: https://herusulistiono.net/
* Created:  08.02.2018
* Update:  25.04.2018
* Requirements: PHP5
*
*/
class Home extends CI_Controller {
	public function __construct()
	{
		parent::__construct();
	}
	public function index()
	{
		if (!$this->ion_auth->logged_in()){
			redirect('dashboard/auth/login','refresh');
		}else{
			$this->data['title']='Home';
			$this->backend->display('admin/home',$this->data);
		}
	}
}

/* End of file Home.php */
/* Location: ./application/controllers/Home.php */