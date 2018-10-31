<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
* Name:  Fgd Controller
*
* Author:  Heru Sulistiono
* 		   mildlaser3@gmail.com
* Copyright © Heru Sulistiono
* Website: https://herusulistiono.net/
* Created:  23.05.2018
* Updated:  23.05.2018
* Requirements: PHP5
*
*/
class Fgd extends CI_Controller {
	public function __construct()
	{
		parent::__construct();
		$this->load->library('Twitteroauth');
		$this->config->load('twitter');
		$this->load->model(array('fgd_m','news_m','grafis_m','story_m','category_m'));
	}
	public function index()
	{
		if (!$this->ion_auth->logged_in()){
			redirect('dashboard/auth/login', 'refresh');
		}elseif (!$this->ion_auth->is_admin() && !$this->ion_auth->in_group('editor')){
			return show_error('You must be an administrator to view this page.');
		}else{
			$this->data['title']='Focus Group Discussion';
			$this->backend->display('admin/fgd/index',$this->data);
		}
	}
	public function read($seo=NULL)
	{
		$news=$this->news_m->get_news($seo)->row();
	    if (empty($news)) {
	    	show_404();
	    }else{
	    	$news=$this->news_m->get_news($seo)->row();
	    	$this->data['news_id']= $news->news_id;
	    	$this->data['news_title']= $news->news_title;
	    	$this->data['category_name']= $news->category_name;
	    	$this->data['news_seo']= $news->news_seo;
	    	$this->data['news_content']= $news->news_content;
	    	$this->data['news_picture']= $news->news_picture;
	    	$this->data['news_postdate']= date('d M Y H:i:s',strtotime($news->news_postdate));
	    	$this->data['news_postby']= $news->first_name.' '.$news->last_name;
	    	$this->data['photo']= $news->photo;
	    	$this->data['news_media']= $news->media;
	    	$this->data['news_view']= $news->news_view;
	    	$this->data['title']= $news->news_title;
	    	$this->data['m_description']=$news->news_title.' - kerjakerja.id';
			$this->data['m_keyword']=$news->news_title .' - kerjakerja.id';
			$this->data['story']=$this->story_m->get_your_story()->result();// Your Story
	    	$this->data['popular_day']=$this->news_m->news_popular_day()->result(); //Latest Days
			$this->data['popular_weeks']=$this->news_m->news_popular_day()->result(); //Latest Weeks
	    	//Counter
			$tweet_count = (int)12;
			$keyword = 'kerjakerjadotid'; //keyword Hastag
			//Connect Twitter API
			$connection = $this->twitteroauth->create($this->config->item('twitter_consumer_token'), $this->config->item('twitter_consumer_secret'), $this->config->item('twitter_access_token'),$this->config->item('twitter_access_secret'));
				//get tweet
			$this->data['tweets']=$connection->get('search/tweets',['q'=>$keyword,'count'=>$tweet_count,'lang'=>'id']);
	    	$this->template->display('admin/fgd/view',$this->data);
	    }
	}
	public function add()
	{
		if (!$this->ion_auth->logged_in()){
			redirect('dashboard/auth/login', 'refresh');
		}
		elseif (!$this->ion_auth->is_admin() && !$this->ion_auth->in_group('editor')){
			return show_error('You must be an administrator to view this page.');
		}else{
			$this->data['categories']=$this->category_m->get_category()->result();
			$this->data['title']='Add Focus Group Discussion';
			$this->backend->display('admin/fgd/add',$this->data);
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
	        	$this->backend->display('admin/fgd/edit',$this->data);
	        }
		}
	}
	public function get_all_news()
	{
		if (!$this->ion_auth->logged_in()){
			redirect('dashboard/auth/login', 'refresh');
		}elseif (!$this->ion_auth->is_admin() && !$this->ion_auth->in_group('editor')){
			$id=$this->ion_auth->user()->row()->id;
			$news=$this->fgd_m->post_by($id)->result_array();
			$data=array();
			$no=1;
			foreach ($news as $rows) {
				if ($rows['news_status']=='Publish') {
					$publish='<a href="javascript:void(0)" onclick="unpublish('."'".$rows['news_id']."'".')">Publish</a>';
				}else{
					$publish='<a href="javascript:void(0)" onclick="publish('."'".$rows['news_id']."'".')">Draft</a>';
				}
				array_push($data,
					array(
						$no++,
						//$rows['news_title'],
						anchor('dashboard/fgd/read/'.$rows['news_seo'], $rows['news_title'],array('target'=>'_blank')),
						$rows['category_name'],
						$rows['first_name'].'&nbsp;'.$rows['last_name'],
						date('d M Y H:i:s',strtotime($rows['news_postdate'])),
						$rows['news_view'],
						$publish,
						anchor('dashboard/fgd/edit/'.$rows['news_id'],'<i class="fa fa-edit"></i>',array('class'=>''))
					)
				);
			}
			$this->output->set_content_type('application/json')->set_output(json_encode(array('data'=>$data)));
		}else{
			$news=$this->fgd_m->all_news()->result_array();
			$data=array();
			$no=1;
			foreach ($news as $rows) {
				if ($rows['news_status']=='Publish') :
					$publish='<a href="javascript:void(0)" onclick="unpublish('."'".$rows['news_id']."'".')">Publish</a>';
				else:
					$publish='<a href="javascript:void(0)" onclick="publish('."'".$rows['news_id']."'".')">Draft</a>';
				endif;
				array_push($data,
					array(
						$no++,
						anchor('dashboard/fgd/read/'.$rows['news_seo'], $rows['news_title'],array('target'=>'_blank')),
						$rows['category_name'],
						$rows['first_name'].'&nbsp;'.$rows['last_name'],
						date('d M Y H:i:s',strtotime($rows['news_postdate'])),
						$rows['news_view'],
						$publish,
						anchor('dashboard/fgd/edit/'.$rows['news_id'],'<i class="fa fa-edit"></i>',array('class'=>''))
						. '&nbsp;<a href="javascript:void(0)" onclick="deleted('."'".$rows['news_id']."'".')"><i class="fa fa-trash"></i></a>'
					)
				);
			}
			$this->output->set_content_type('application/json')->set_output(json_encode(array('data'=>$data)));
		}
	}
	public function save()
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
				//$this->resize_image($file['file_name']);
				//$this->watermark($file['file_name']);
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
					'category_id'=>$this->input->post('txtCategory'),
					'news_seo' =>  url_title($this->input->post('txtTitle'), 'dash', TRUE),
					'news_content' => $this->input->post('txtContent'),
					'news_picture' =>$file['file_name'],
					'news_status' => $this->input->post('txtStatus'),
					'news_postdate'=>date('Y-m-d H:i:s'),
					'news_postby'=>$this->input->post('news_postby'),
					'media'=>'FGD'
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
	public function update()
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
				$data=array(
					'news_id'=>$this->input->post('news_id'),
					'news_title' => $this->input->post('txtTitle'),
					'news_headline' => $this->input->post('txtHeadline'),
					'category_id'=>$this->input->post('txtCategory'),
					'news_seo' =>  url_title($this->input->post('txtTitle'), 'dash', TRUE),
					'news_content' => $this->input->post('txtContent'),
					'news_status'=>$this->input->post('txtStatus'),
					'news_picture' =>$file['file_name'],
					'media'=>'FGD'
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
					'media'=>'FGD'
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
	public function delete()
	{
		$this->form_validation->set_rules('news_id','Title','required');
		if ($this->form_validation->run()===TRUE) {
			$info['success'] = TRUE;
			$data = array('news_id' => $this->input->post('news_id'));
			$this->news_m->news_delete($data);
			$info['message'] ='Success to Delete';
		}else{
			$info['success'] = FALSE;
			$info['errorss']=validation_errors();
		}
		$this->output->set_content_type('application/json')->set_output(json_encode($info));
	}

}

/* End of file Fgd.php */
/* Location: ./application/controllers/dashboard/Fgd.php */