<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Setting extends CI_Controller {
	public function __construct()
	{
		parent::__construct();
		$this->load->model(array('setting_m'));
	}
	public function index()
	{
		
	}
	public function change_update()
	{
		$this->form_validation->set_rules('txtTitle','Title','required');
		if ($this->form_validation->run()===TRUE) {
			$path_dir='./images/about/';
			if (!is_dir($path_dir)) {
				mkdir($path_dir, 0775);
				chmod($path_dir, 0777);
			}
			$config = array(
	            'upload_path' => $path_dir,
	            'allowed_types' => 'jpg|jpeg',
	            'file_name' => time(date('Y-m-d H:i:s')),
	            'max_size'=> 2000,
	            'overwrite'=> TRUE
	        );
      		$this->load->library('upload', $config);
      		if ($this->upload->do_upload('txtPicture')) {
				$file = $this->upload->data();
				//Image Resizing
				$config['source_image'] = $this->upload->upload_path.$this->upload->file_name;
				$config['maintain_ratio'] = FALSE;
				$config['create_thumb'] = FALSE;
				$config['width'] = 755;
				$config['height'] = 415;
				$this->load->library('image_lib', $config);
				if (!$this->image_lib->resize())
			        return show_error($this->image_lib->display_errors());
			    $this->image_lib->clear();
				$data=array(
					'web_id'=>$this->input->post('txtId'),
					'web_title'=>$this->input->post('txtTitle'),
					'web_content' => $this->input->post('txtContent'),
					'datepost' => date('Y-m-d H:i:s'),
					'dateupdate' => date('Y-m-d H:i:s'),
					'picture' =>$file['file_name'],
				);
				$this->setting_m->change_update_picture($data);
				$info['success']=TRUE;
				$info['message']='Successfully';
			}else{
				$data=array(
					'web_id'=>$this->input->post('txtId'),
					'web_title'=>$this->input->post('txtTitle'),
					'web_content' => $this->input->post('txtContent'),
					'datepost' => date('Y-m-d H:i:s'),
					'dateupdate' => date('Y-m-d H:i:s'),
				);
				$this->setting_m->change_update($data);
				$info['success']=TRUE;
				$info['message']='Successfully';
			}
		}else{
			$info['success']=FALSE;
			$info['errors']=validation_errors();
		}
		$this->output->set_content_type('application/json')->set_output(json_encode($info));

	}

}

/* End of file Setting.php */
/* Location: ./application/controllers/dashboard/Setting.php */