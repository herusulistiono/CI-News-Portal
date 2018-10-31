<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
* Name:  Story Controller
*
* Author:  Heru Sulistiono
* 		   mildlaser3@gmail.com
* Copyright © Heru Sulistiono
* Website: https://herusulistiono.net/
* Created:  08.02.2018
* Updated:  25.04.2018
* Requirements: PHP5, jQuery,Bootstrap,Datatable
*
*/
class Story extends CI_Controller {
	public function __construct()
	{
		parent::__construct();
		$this->load->model(array('story_m','news_m','category_m'));
	}
	public function index()
	{
		if (!$this->ion_auth->logged_in()){
			redirect('dashboard/auth/login', 'refresh');
		}/*elseif (!$this->ion_auth->is_admin() && !$this->ion_auth->in_group('editor')){
			return show_error('You must be an administrator/editor to view this page.');
		}*/else{
			$this->data['title']='Your Story';
			$this->backend->display('admin/story/index',$this->data);
		}
	}
	public function story_data()
	{
		if (!$this->ion_auth->logged_in()){
			redirect('dashboard/auth/login', 'refresh');
		}elseif (!$this->ion_auth->is_admin() && !$this->ion_auth->in_group('editor')){
			$id=$this->ion_auth->user()->row()->id;
			$story=$this->story_m->post_by($id)->result_array();
			$data=array();
			$no=1;
			foreach ($story as $rows) {
				if ($rows['news_status']=='Publish'):
					$status='<a href="javascript:void(0)" onclick="unpublish('."'".$rows['news_id']."'".')">Publish</a>';
				else:
					$status='<a href="javascript:void(0)" onclick="publish('."'".$rows['news_id']."'".')">Draft</a>';
				endif;
				array_push($data,
					array(
						$no++,
						$rows['news_title'],
						$rows['first_name'].'&nbsp;'.$rows['last_name'],
						date('d M Y H:i:s',strtotime($rows['news_postdate'])),
						$rows['news_view'],
						$status,
						anchor('dashboard/story/edit/'.$rows['news_id'],'<i class="fa fa-edit"></i>',array('class'=>'')). '&nbsp;<a href="javascript:void(0)" onclick="deleted('."'".$rows['news_id']."'".')"><i class="fa fa-trash"></i></a>'
					)
				);
			}
			$this->output->set_content_type('application/json')->set_output(json_encode(array('data'=>$data)));
		}else{
			$story=$this->story_m->story_data()->result_array();
			$data=array();
			$no=1;
			foreach ($story as $rows) {
				if ($rows['news_status']=='Publish') :
					$status='<a href="javascript:void(0)" onclick="unpublish('."'".$rows['news_id']."'".')">Publish</a>';
				else:
					$status='<a href="javascript:void(0)" onclick="publish('."'".$rows['news_id']."'".')">Draft</a>';
				endif;
				array_push($data,
					array(
						$no++,
						$rows['news_title'],
						$rows['first_name'].'&nbsp;'.$rows['last_name'],
						date('d M Y H:i:s',strtotime($rows['news_postdate'])),
						$rows['news_view'],
						$status,
						anchor('dashboard/story/edit/'.$rows['news_id'],'<i class="fa fa-edit"></i>',array('class'=>'')). '&nbsp;<a href="javascript:void(0)" onclick="deleted('."'".$rows['news_id']."'".')"><i class="fa fa-trash"></i></a>'
					)
				);
			}
			$this->output->set_content_type('application/json')->set_output(json_encode(array('data'=>$data)));
		}
	}
	public function create_story()
	{
		if (!$this->ion_auth->logged_in()){
			redirect('dashboard/auth/login', 'refresh');
		}/*elseif (!$this->ion_auth->is_admin() && !$this->ion_auth->in_group('editor')){
			return show_error('You must be an administrator/editor to view this page.');
		}*/else{
			$this->data['title']='Your Story';
			$this->backend->display('admin/story/add',$this->data);
		}
	}
	public function save_story()
	{
		$this->form_validation->set_rules('txtTitle','Title','required');
		if ($this->form_validation->run()===TRUE) {
			$path_dir='./images/news/story/';
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
				$this->watermark($file['file_name']);
				$data=array(
					'news_title' => $this->input->post('txtTitle'),
					'news_headline'=>$this->input->post('txtHeadline'),
					'category_id'=>'5',
					'news_seo' =>  url_title($this->input->post('txtTitle'), 'dash', TRUE),
					'news_content' => $this->input->post('txtContent'),
					'news_picture' =>$file['file_name'],
					'news_postdate'=>date('Y-m-d H:i:s'),
					'news_postby'=>$this->input->post('news_postby'),
					'media'=>'YOUR STORY'
				);
				$this->story_m->insert($data);
				$info['success']=TRUE;
				$info['message']='Successfully';
			}
		}else{
			$info['success']=FALSE;
			$info['errors']=validation_errors();
		}
		$this->output->set_content_type('application/json')->set_output(json_encode($info));
	}
	public function edit($news_id=NULL)
	{
		if (!$this->ion_auth->logged_in()){
			redirect('dashboard/auth/login', 'refresh');
		}else{
			$story=$this->story_m->get_id($news_id)->row();
	        if (empty($story)) {
	        	show_404();
	        }else{
	        	$this->data['categories']=$this->category_m->get_category()->result();
	        	$story=$this->story_m->get_id($news_id)->row();
	        	$this->data['news_id']= $story->news_id;
	        	$this->data['news_title']= $story->news_title;
	        	$this->data['news_headline']= $story->news_headline;
	        	//$this->data['category_id']= $story->category_id;
	        	$this->data['news_content']= $story->news_content;
	        	$this->data['news_picture']= $story->news_picture;
	        	$this->data['news_status']= $story->news_status;
	        	$this->data['title']='Edit';
	        	$this->backend->display('admin/story/edit',$this->data);
	        }
		}
	}
	public function update_story()
	{
		$this->form_validation->set_rules('txtTitle','Title','required');
		if ($this->form_validation->run()===TRUE) {
			$path_dir='./images/news/story/';
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
				$config['width'] = 750;
				$config['height'] = 450;
				$this->load->library('image_lib', $config);
				if (!$this->image_lib->resize())
			        return show_error($this->image_lib->display_errors());
			    $this->image_lib->clear();
				$this->watermark($file['file_name']);
				
				$data=array(
					'news_id'=>$this->input->post('news_id'),
					'news_title' => $this->input->post('txtTitle'),
					//'category_id'=>$this->input->post('txtCategory'),
					'news_seo' =>  url_title($this->input->post('txtTitle'), 'dash', TRUE),
					'news_content' => $this->input->post('txtContent'),
					'news_status'=>$this->input->post('txtStatus'),
					'news_picture' =>$file['file_name'],
					'media'=>'YOUR STORY'
				);
				$this->story_m->update_picture($data);
				$info['success']=TRUE;
				$info['message']='Successfully';
			}else{
				$data=array(
					'news_id'=>$this->input->post('news_id'),
					'news_title' => $this->input->post('txtTitle'),
					//'category_id'=>$this->input->post('txtCategory'),
					'news_seo' =>  url_title($this->input->post('txtTitle'), 'dash', TRUE),
					'news_content' => $this->input->post('txtContent'),
					'news_status'=>$this->input->post('txtStatus'),
					'media'=>'YOUR STORY'
				);
				$this->story_m->update($data);
				$info['success']=TRUE;
				$info['message']='Successfully';
			}
		}else{
			$info['success']=FALSE;
			$info['errors']=validation_errors();
		}
		$this->output->set_content_type('application/json')->set_output(json_encode($info));
	}
	public function delete_story()
	{
		$this->form_validation->set_rules('news_id','Title','required');
		if ($this->form_validation->run()===TRUE) {
			$info['success'] = TRUE;
			$data = array('news_id' => $this->input->post('news_id'));
			$this->story_m->story_delete($data);
			$info['message'] ='Success to Delete';
		}else{
			$info['success'] = FALSE;
			$info['errorss']=validation_errors();
		}
		$this->output->set_content_type('application/json')->set_output(json_encode($info));
	}
	public function publish()
	{
		$this->form_validation->set_rules('news_id','Title','required');
		if ($this->form_validation->run()===TRUE) {
			$info['success'] = TRUE;
			$data = array(
				'news_id' => $this->input->post('news_id'),
				'news_status' => 'Publish'
			);
			$this->news_m->publish($data);
			$info['message'] ='Success to Publish';
		}else{
			$info['success'] = FALSE;
			$info['errorss']=validation_errors();
		}
		$this->output->set_content_type('application/json')->set_output(json_encode($info));
	}
	public function unpublish()
	{
		$this->form_validation->set_rules('news_id','Title','required');
		if ($this->form_validation->run()===TRUE) {
			$info['success'] = TRUE;
			$data = array(
				'news_id' => $this->input->post('news_id'),
				'news_status' =>'Draft'
			);
			$this->news_m->unpublish($data);
			$info['message'] ='Success to Unpublish';
		}else{
			$info['success'] = FALSE;
			$info['errorss']=validation_errors();
		}
		$this->output->set_content_type('application/json')->set_output(json_encode($info));
	}
}

/* End of file Story.php */
/* Location: ./application/controllers/dashboard/Story.php */