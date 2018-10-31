<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Gallery extends CI_Controller {
	public function __construct()
	{
		parent::__construct();
		$this->load->model(array('gallery_m'));
	}
	public function index()
	{
		if (!$this->ion_auth->logged_in()){
			redirect('dashboard/auth/login', 'refresh');
		}else{
			$this->data['title']='Gallery';
			$this->backend->display('dashboard/gallery/index',$this->data);
		}
	}
	public function all_video()
	{
		# code...video_data
	}
	public function get_gallery()
	{
		$gallery=$this->gallery_m->get_gallery()->result_array();
		$data=array();
		$no=1;
		foreach ($gallery as $rows) {
			/*if ($rows['gallery_status']=='Active') {
				$status='<a href="javascript:void(0)" onclick="inactive('."'".$rows['gallery_id']."'".')">Active</a>';
			}else{
				$status='<a href="javascript:void(0)" onclick="active('."'".$rows['gallery_id']."'".')">Inactive</a>';
			}*/
			array_push($data, 
				array(
					$no++,
					'<img src="'.base_url('images/gallery/'.$rows['gallery_file']).'" width="70" height="70">',
					$rows['gallery_title'],
					$rows['gallery_datepost'],
					//$status,
					anchor('dashboard/gallery/edit/'.$rows['gallery_id'], '<i class="fa fa-edit"></i>')
				)
			);
		}
		$this->output->set_content_type('application/json')->set_output(json_encode(array('data'=>$data)));
	}
	public function add()
	{
		if (!$this->ion_auth->logged_in())
		{
			redirect('auth/login', 'refresh');
		}else{
			$this->data['title']='Add Gallery';
			$this->backend->display('admin/gallery/add',$this->data);
		}
	}
	public function save()
	{
		$this->form_validation->set_rules('txtTitle','Title','required');
		if ($this->form_validation->run()===TRUE) {
			$path_dir='./images/gallery/';
			if (!is_dir($path_dir)) {
				mkdir($path_dir, 0775);
				chmod($path_dir, 0777);
			}
			$config = array(
	            'upload_path' => $path_dir,
	            'allowed_types' => 'jpg',
	            'file_name' => time(date('Y-m-d H:i:s')),
	            //'quality'=>'90%',
	            //'create_thumb' => TRUE,
	            //'maintain_ratio' => FALSE,
				'overwrite'=> TRUE
	        );
      		$this->load->library('upload', $config);
      		if (!$this->upload->do_upload('txtPicture')) {
				$info['success'] = FALSE;
				$info['errors'] = $this->upload->display_errors();
			}else{
				$file = $this->upload->data();
				$data=array(
					'gallery_title' => $this->input->post('txtTitle'),
					'gallery_seo' =>  url_title($this->input->post('txtTitle'), 'dash', TRUE),
					'gallery_file' =>$file['file_name'],
					'gallery_datepost'=>date('Y-m-d H:i:s'),
					'gallery_status'=> 'Photo'
				);
				$this->gallery_m->insert($data);
				$info['success']=TRUE;
				$info['message']='Successfully';
			}
		}else{
			$info['success']=FALSE;
			$info['errors']=validation_errors();
		}
		$this->output->set_content_type('application/json')->set_output(json_encode($info));
	}
	public function edit($gallery_id)
	{
		if (!$this->ion_auth->logged_in()){
			redirect('auth/login', 'refresh');
		}else{
			$gallery=$this->gallery_m->get_by_ID($gallery_id)->row();
	        if (empty($gallery)) {
	        	show_404();
	        }else{
	        	$gallery=$this->gallery_m->get_by_ID($gallery_id)->row();
	        	$this->data['gallery_id']= $gallery->gallery_id;
	        	$this->data['gallery_title']= $gallery->gallery_title;
	        	//$this->data['gallery_status']= $gallery->gallery_status;
	        	$this->data['gallery_file']= $gallery->gallery_file;
	        	$this->data['title']= 'Edit';
	        	$this->backend->display('admin/gallery/edit',$this->data);
	        }
		}
	}
	public function update()
	{
		$this->form_validation->set_rules('txtTitle','Title','required');
		if ($this->form_validation->run()===TRUE) {
			$path_dir='./images/gallery/';
			if (!is_dir($path_dir)) {
				mkdir($path_dir, 0775);
				chmod($path_dir, 0777);
			}
			$config = array(
	            'upload_path' => $path_dir,
	            'allowed_types' => 'jpg',
	            'file_name' => time(date('Y-m-d H:i:s')),
	            //'create_thumb' => TRUE,
	            //'maintain_ratio' => TRUE,
	            'overwrite'=> TRUE
	        );
      		$this->load->library('upload', $config);
      		if ($this->upload->do_upload('txtPicture')) {
				$file = $this->upload->data();
				$data=array(
					'gallery_id'=>$this->input->post('gallery_id'),
					'gallery_title' => $this->input->post('txtTitle'),
					'gallery_seo' =>  url_title($this->input->post('txtTitle'), 'dash', TRUE),
					//'gallery_status'=>$this->input->post('txtStatus'),
					'gallery_file' =>$file['file_name']
				);
				$this->gallery_m->update($data);
				$info['success']=TRUE;
				$info['message']='Successfully';
			}else{
				$data=array(
					'gallery_id'=>$this->input->post('gallery_id'),
					'gallery_title' => $this->input->post('txtTitle'),
					'gallery_seo' =>  url_title($this->input->post('txtTitle'), 'dash', TRUE),
					//'gallery_status'=>$this->input->post('txtStatus'),
				);
				$this->gallery_m->update($data);
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

/* End of file Gallery.php */
/* Location: ./application/controllers/Gallery.php */