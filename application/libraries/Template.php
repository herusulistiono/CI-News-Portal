<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Template {
	protected $_ci;
	function __construct(){
		$this->_ci=&get_instance();
	}
	function display($set, $data=null){
		$data['_content']=$this->_ci->load->view($set,$data,true);
		$this->_ci->load->view('template.php',$data);
	}
}