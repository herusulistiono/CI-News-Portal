<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Comment extends CI_Controller {
	public function __construct()
	{
		parent::__construct();
		$this->load->model(array('comment_m'));
	}
	public function index()
	{
		if (!$this->ion_auth->logged_in()){
			redirect('auth/login', 'refresh');
		}else{
			$this->data['title']='Comment';
			$this->backend->display('admin/comment',$this->data);
		}
	}
	public function get_comment()
	{
		# code...
	}
	public function save_comment()
	{
		$this->form_validation->set_rules('newsID','ID', 'required');
		$this->form_validation->set_rules('txtName','Name', 'required');
		$this->form_validation->set_rules('txtEMail','Email', 'required');
		if ($this->form_validation->run()===TRUE) {
			$data=array(
				'comment_post_id'=>$this->input->post('newsID'),
				'comment_author'=>$this->input->post('txtName'),
				'comment_author_email'=>$this->input->post('txtEMail'),
				'comment_subject'=>$this->input->post('txtSubject'),
				'comment_content'=>$this->input->post('txtContent'),
				'comment_date'=>date('Y-m-d H:i:s')
			);
			$this->comment_m->insert($data);
			$info['success']=TRUE;
			$info['message']='Successfully';
		}else{
			$info['success']=FALSE;
			$info['errors']=validation_errors();
		}
		$this->output->set_content_type('application/json')->set_output(json_encode($info));
	}

}

/* End of file Comment.php */
/* Location: ./application/controllers/Comment.php */