<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
* Name: HoaxorNot Controller
*
* Author:  Heru Sulistiono
* 		   mildlaser3@gmail.com
* Copyright © Heru Sulistiono
* Website: https://herusulistiono.net/
* Created:  10.05.2018
* Requirements: PHP5
*
*/
class HoaxorNot extends CI_Controller {
	public function __construct()
	{
		parent::__construct();
		$this->form_validation->set_error_delimiters($this->config->item('error_start_delimiter', 'ion_auth'), $this->config->item('error_end_delimiter', 'ion_auth'));
		$this->lang->load('auth');
		$this->load->model(array('HoaxorNot_m','news_m','category_m'));
	}
	public function index()
	{
		if (!$this->ion_auth->logged_in()){
			redirect('dashboard/auth/login', 'refresh');
		}elseif (!$this->ion_auth->is_admin() && !$this->ion_auth->in_group('editor')){
			return show_error('You must be an administrator/editor to view this page.');
		}else{
			$this->data['title']='Hoax or Not';
			$this->backend->display('admin/hoaxornot/index',$this->data);
		}
	}
	public function read_data()
	{
		if (!$this->ion_auth->logged_in()){
			redirect('dashboard/auth/login', 'refresh');
		}elseif (!$this->ion_auth->is_admin() && !$this->ion_auth->in_group('editor')){
			$id=$this->ion_auth->user()->row()->id;
			$news=$this->HoaxorNot_m->post_by($id)->result_array();
			$data=array();
			$no=1;
			foreach ($news as $rows) {
				if ($rows['news_status']=='Publish') {
					$status='<a href="javascript:void(0)" onclick="unpublish('."'".$rows['news_id']."'".')">Publish</a>';
				}else{
					$status='<a href="javascript:void(0)" onclick="publish('."'".$rows['news_id']."'".')">Draft</a>';
				}
				array_push($data,
					array(
						$no++,
						$rows['news_title'],
						$rows['category_name'],
						$rows['first_name'].'&nbsp;'.$rows['last_name'],
						date('d M Y H:i:s',strtotime($rows['news_postdate'])),
						$rows['news_view'],
						$status,
						anchor('dashboard/HoaxorNot/edit/'.$rows['news_id'],'<i class="fa fa-edit"></i>',array('class'=>''))
					)
				);
			}
			$this->output->set_content_type('application/json')->set_output(json_encode(array('data'=>$data)));
		}else{
			$news=$this->HoaxorNot_m->all_news()->result_array();
			$data=array();
			$no=1;
			foreach ($news as $rows) {
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
						$rows['news_title'],
						$rows['category_name'],
						$rows['first_name'].'&nbsp;'.$rows['last_name'],
						date('d M Y H:i:s',strtotime($rows['news_postdate'])),
						$rows['news_view'],
						$publish,
						anchor('dashboard/HoaxorNot/edit/'.$rows['news_id'],'<i class="fa fa-edit"></i>',array('class'=>''))
						. '&nbsp;<a href="javascript:void(0)" onclick="deleted('."'".$rows['news_id']."'".')"><i class="fa fa-trash"></i></a>'
					)
				);
			}
			$this->output->set_content_type('application/json')->set_output(json_encode(array('data'=>$data)));
		}
	}
	public function create()
	{
		if (!$this->ion_auth->logged_in()){
			redirect('dashboard/auth/login', 'refresh');
		}/*elseif (!$this->ion_auth->is_admin() && !$this->ion_auth->in_group('editor')){
			return show_error('You must be an administrator/editor to view this page.');
		}*/else{
			$this->data['title']='Hoax or Not';
			$this->backend->display('admin/hoaxornot/add',$this->data);
		}
	}
	public function edit($news_id=NULL)
	{
		if (!$this->ion_auth->logged_in()){
			redirect('dashboard/auth/login', 'refresh');
		}else{
			$news=$this->news_m->get_news_id($news_id)->row();
	        if (empty($news)) {
	        	show_404();
	        }else{
	        	$this->data['categories']=$this->category_m->get_category()->result();
	        	$news=$this->news_m->get_news_id($news_id)->row();
	        	$this->data['news_id']= $news->news_id;
	        	$this->data['news_title']= $news->news_title;
	        	$this->data['news_headline']= $news->news_headline;
	        	$this->data['category_id']= $news->category_id;
	        	$this->data['news_content']= $news->news_content;
	        	$this->data['news_picture']= $news->news_picture;
	        	$this->data['news_status']= $news->news_status;

	        	$this->data['title']= 'Edit';
	        	$this->backend->display('admin/hoaxornot/edit',$this->data);
	        }
		}
	}
	public function save_data()
	{
		$this->form_validation->set_rules('txtTitle','Title','required');
		$this->form_validation->set_rules('txtHeadline','Headline','required');
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
				$config['width'] = 755;
				$config['height'] = 415;
				$this->load->library('image_lib', $config);
				if (!$this->image_lib->resize())
			        return show_error($this->image_lib->display_errors());
			    $this->image_lib->clear();
				$data=array(
					'news_title' => $this->input->post('txtTitle'),
					'news_headline' => $this->input->post('txtHeadline'),
					'category_id'=> 6,
					'news_seo' =>  url_title($this->input->post('txtTitle'), 'dash', TRUE),
					'news_content' => $this->input->post('txtContent'),
					'news_picture' =>$file['file_name'],
					'news_status' => $this->input->post('txtStatus'),
					'news_postdate'=>date('Y-m-d H:i:s'),
					'news_postby'=>$this->input->post('news_postby'),
					'status'=>'Inactive',
					'media'=>'HOAX or NOT'
				);
				$this->news_m->insert($data);
				$info['success']=TRUE;
				$info['message']='Successfully';
			}
		}else{
			$info['success']=FALSE;
			$info['errors']=validation_errors();
		}
		$this->output->set_content_type('application/json')->set_output(json_encode($info));
	}
	public function update_data()
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
	            'file_name' => 'news_'.time(date('Y-m-d H:i:s')),
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
					'news_id'=>$this->input->post('news_id'),
					'news_title' => $this->input->post('txtTitle'),
					'news_headline' => $this->input->post('txtHeadline'),
					'category_id'=>$this->input->post('txtCategory'),
					'news_seo' =>  url_title($this->input->post('txtTitle'), 'dash', TRUE),
					'news_content' => $this->input->post('txtContent'),
					'news_status'=>$this->input->post('txtStatus'),
					'news_picture' =>$file['file_name'],
					'media'=>'HOAX or NOT'
				);
				$this->news_m->update_picture($data);
				$info['success']=TRUE;
				$info['message']='Successfully';
			}else{
				$data=array(
					'news_id'=>$this->input->post('news_id'),
					'news_title' => $this->input->post('txtTitle'),
					'news_headline' => $this->input->post('txtHeadline'),
					'category_id'=>$this->input->post('txtCategory'),
					'news_seo' =>  url_title($this->input->post('txtTitle'), 'dash', TRUE),
					'news_content' => $this->input->post('txtContent'),
					'news_status'=>$this->input->post('txtStatus'),
					'media'=>'HOAX or NOT'
				);
				$this->news_m->update($data);
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

/* End of file HoaxorNot.php */
/* Location: ./application/controllers/dashboard/HoaxorNot.php */