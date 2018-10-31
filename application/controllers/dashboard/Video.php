<?php
	defined('BASEPATH') OR exit('No direct script access allowed');
	
	class Video extends CI_Controller {
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
			$this->data['title']='Gallery Video';
			$this->backend->display('admin/video/index',$this->data);
		}
	}
	public function get_video()
	{
		if (!$this->ion_auth->logged_in()){
			redirect('dashboard/auth/login', 'refresh');
		}elseif (!$this->ion_auth->is_admin() && !$this->ion_auth->in_group('editor')){
			return show_error('You must be an administrator/editor to view this page.');
		}else{
			$video=$this->gallery_m->video_data()->result_array();
			$data=array();
			$no=1;
			foreach ($video as $rows) {
				if ($rows['news_status']=='Publish') :
					$publish='<a href="javascript:void(0)" onclick="unpublish('."'".$rows['news_id']."'".')">Publish</a>';
				else:
					$publish='<a href="javascript:void(0)" onclick="publish('."'".$rows['news_id']."'".')">Draft</a>';
				endif;

				if ($rows['status']=='Active') :
					$status='<a href="javascript:void(0)" onclick="inactive('."'".$rows['news_id']."'".')">Active</a>';
				else:
					$status='<a href="javascript:void(0)" onclick="active('."'".$rows['news_id']."'".')">Inactive</a>';
				endif;
				array_push($data, 
					array(
						$no++,
						/*'<iframe title="YouTube" class="youtube-player" type="text/html" width="150" height="100" src="'.$rows['news_picture'].'" frameborder="0" allowFullScreen></iframe>',*/
						$rows['news_title'],
						date('d M Y H:i:s',strtotime($rows['news_postdate'])),
						$publish,
						$status,
						anchor('dashboard/video/edit_video/'.$rows['news_id'], '<i class="fa fa-edit"></i>')
						. '&nbsp;<a href="javascript:void(0)" onclick="deleted('."'".$rows['news_id']."'".')"><i class="fa fa-trash"></i></a>'
					)
				);
			}
			$this->output->set_content_type('application/json')->set_output(json_encode(array('data'=>$data)));
		}
	}

	public function add_video()
	{
		if (!$this->ion_auth->logged_in()){
			redirect('dashboard/auth/login', 'refresh');
		}elseif (!$this->ion_auth->is_admin() && !$this->ion_auth->in_group('editor')){
			return show_error('You must be an administrator/editor to view this page.');
		}else{
			$this->data['title']='Add Video';
			$this->backend->display('admin/video/add',$this->data);
		}
	}
	public function save_video()
	{
		$this->form_validation->set_rules('txtTitle','Title','required');
		if ($this->form_validation->run()===TRUE) {
			$path_dir='./images/news/';
			if (!is_dir($path_dir)) {
				mkdir($path_dir, 0775);
				chmod($path_dir, 0777);
			}
			$config = array(
	            'upload_path' => $path_dir,
	            'allowed_types' => 'jpg|jpeg',
	            'file_name' => time(date('Y-m-d H:i:s')),
	            'max_size'=> '2000',
	            'overwrite'=> TRUE
	        );
      		$this->load->library('upload', $config);
      		if (!$this->upload->do_upload('txtPicture')) {
				$info['success'] = FALSE;
				$info['errors'] = $this->upload->display_errors();
			}else{
				$file = $this->upload->data();
				//Image Resizing
				$config['source_image'] = $this->upload->upload_path.$this->upload->file_name;
				$config['maintain_ratio'] = FALSE;
				$config['create_thumb'] = FALSE;
				$config['width'] = 750;
				$config['height'] = 450;
				$this->load->library('image_lib', $config);
				if (!$this->image_lib->resize())
			        return show_error($this->image_lib->display_errors());
			    $this->image_lib->clear();
				$data=array(
					'news_title' => $this->input->post('txtTitle'),
					'news_headline' => $this->input->post('txtHeadline'),
					'category_id'=> '3',
					'news_seo' =>  url_title($this->input->post('txtTitle'), 'dash', TRUE),
					'news_content' => $this->input->post('txtContent'),
					'news_picture' =>$file['file_name'],
					'news_status'=>'Publish',
					'status' => $this->input->post('txtStatus'),
					'news_postdate'=>date('Y-m-d H:i:s'),
					'news_postby'=>$this->input->post('news_postby'),
					'media'=>'VIDEO'
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
	public function edit_video($news_id)
	{
		if (!$this->ion_auth->logged_in()){
			redirect('dashboard/auth/login', 'refresh');
		}else{
			$video=$this->gallery_m->get_video_id($news_id)->row();
	        if (empty($video)) {
	        	show_404();
	        }else{
	        	$video=$this->gallery_m->get_video_id($news_id)->row();
	        	$this->data['news_id']= $video->news_id;
	        	$this->data['news_title']= $video->news_title;
	        	$this->data['news_headline']= $video->news_headline;
	        	$this->data['news_content']= $video->news_content;
	        	$this->data['news_status']= $video->news_status;
	        	$this->data['status']= $video->status;
	        	$this->data['news_picture']= $video->news_picture;
	        	$this->data['title']= 'Edit Video';
	        	$this->backend->display('admin/video/edit',$this->data);
	        }
		}
	}
	public function update_video()
	{
		$this->form_validation->set_rules('txtTitle','Title','required');
		if ($this->form_validation->run()===TRUE) {
			$path_dir='./images/news/';
			if (!is_dir($path_dir)) {
				mkdir($path_dir, 0775);
				chmod($path_dir, 0777);
			}
			$config = array(
	            'upload_path' => $path_dir,
	            'allowed_types' => 'jpg|jpeg',
	            'file_name' => time(date('Y-m-d H:i:s')),
	            'max_size'=> '2000',
	            'overwrite'=> TRUE
	        );
      		$this->load->library('upload', $config);
      		if ($this->upload->do_upload('txtPicture')) {
				$file = $this->upload->data();
				//Image Resizing
				$config['source_image'] = $this->upload->upload_path.$this->upload->file_name;
				$config['maintain_ratio'] = FALSE;
				$config['create_thumb'] = FALSE;
				$config['width'] = 750;
				$config['height'] = 450;
				$this->load->library('image_lib', $config);
				if (!$this->image_lib->resize())
			        return show_error($this->image_lib->display_errors());
			    $this->image_lib->clear();
				$data=array(
					'news_id'=>$this->input->post('news_id'),
					'news_title' => $this->input->post('txtTitle'),
					'news_headline' => $this->input->post('txtHeadline'),
					'category_id'=>'3',
					'news_seo' =>  url_title($this->input->post('txtTitle'), 'dash', TRUE),
					'news_content' => $this->input->post('txtContent'),
					'news_status'=>$this->input->post('txtStatus'),
					'news_picture' =>$file['file_name'],
					'media'=>'VIDEO'
				);
				$this->gallery_m->update_picture($data);
				$info['success']=TRUE;
				$info['message']='Successfully';
			}else{
				$data=array(
					'news_id'=>$this->input->post('news_id'),
					'news_title' => $this->input->post('txtTitle'),
					'news_headline' => $this->input->post('txtHeadline'),
					'category_id'=>'3',
					'news_seo' =>  url_title($this->input->post('txtTitle'), 'dash', TRUE),
					'news_content' => $this->input->post('txtContent'),
					'news_status'=>$this->input->post('txtStatus'),
					'media'=>'VIDEO'
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
	public function video_delete()
	{
		if (!$this->ion_auth->logged_in()){
			redirect('dashboard/auth/login', 'refresh');
		}elseif (!$this->ion_auth->is_admin() && !$this->ion_auth->in_group('editor')){
			return show_error('You must be an administrator/editor to view this page.');
		}else{
			$this->form_validation->set_rules('news_id','Title','required');
			if ($this->form_validation->run()===TRUE) {
				$info['success'] = TRUE;
				$data = array('news_id' => $this->input->post('news_id'));
				$this->gallery_m->video_delete($data);
				$info['message'] ='Success to Delete';
			}else{
				$info['success'] = FALSE;
				$info['errorss']=validation_errors();
			}
			$this->output->set_content_type('application/json')->set_output(json_encode($info));
		}
	}
	public function active()
	{
		$this->form_validation->set_rules('news_id','Title','required');
		if ($this->form_validation->run()===TRUE) {
			$info['success'] = TRUE;
			$data = array(
				'news_id' => $this->input->post('news_id'),
				'status' => 'Active'
			);
			$this->gallery_m->active($data);
			$info['message'] ='Success to Active';
		}else{
			$info['success'] = FALSE;
			$info['errorss']=validation_errors();
		}
		$this->output->set_content_type('application/json')->set_output(json_encode($info));
	}
	public function inactive()
	{
		$this->form_validation->set_rules('news_id','Title','required');
		if ($this->form_validation->run()===TRUE) {
			$info['success'] = TRUE;
			$data = array(
				'news_id' => $this->input->post('news_id'),
				'status' =>'Inactive'
			);
			$this->gallery_m->inactive($data);
			$info['message'] ='Success to Inactive';
		}else{
			$info['success'] = FALSE;
			$info['errorss']=validation_errors();
		}
		$this->output->set_content_type('application/json')->set_output(json_encode($info));
	}
	public function valid_url($str)
	{
	    return (filter_var($str, FILTER_VALIDATE_URL) !== FALSE);
	}
	
}
	
/* End of file Video.php */
/* Location: ./application/controllers/Video.php */	