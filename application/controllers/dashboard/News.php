<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
* Name:  News Controller
*
* Author:  Heru Sulistiono
* 		   mildlaser3@gmail.com
* Copyright © Heru Sulistiono
* Website: https://herusulistiono.net/
* Created:  08.02.2018
* Requirements: PHP5
*
*/
class News extends CI_Controller {
	public function __construct()
	{
		parent::__construct();
		$this->form_validation->set_error_delimiters($this->config->item('error_start_delimiter', 'ion_auth'), $this->config->item('error_end_delimiter', 'ion_auth'));
		$this->lang->load('auth');
		$this->load->library('Twitteroauth');
		$this->config->load('twitter');
		$this->load->model(array('news_m','grafis_m','story_m','category_m'));
	}
	public function index()
	{
		if (!$this->ion_auth->logged_in()){
			redirect('dashboard/auth/login', 'refresh');
		}elseif (!$this->ion_auth->is_admin() && !$this->ion_auth->in_group('editor')){
			return show_error('You must be an administrator to view this page.');
		}else{
			$this->data['title']='News';
			$this->backend->display('admin/news/index',$this->data);
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
	    	$this->template->display('admin/news/view',$this->data);
	    }
	}

	// Dashboard => Administrator
	public function get_all_news()
	{
		if (!$this->ion_auth->logged_in()){
			redirect('dashboard/auth/login', 'refresh');
		}elseif (!$this->ion_auth->is_admin() && !$this->ion_auth->in_group('editor')){
			$id=$this->ion_auth->user()->row()->id;
			$news=$this->news_m->post_by($id)->result_array();
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
						//$rows['news_title'],
						anchor('dashboard/news/read/'.$rows['news_seo'], $rows['news_title'],array('target'=>'_blank')),
						$rows['category_name'],
						$rows['first_name'].'&nbsp;'.$rows['last_name'],
						date('d M Y H:i:s',strtotime($rows['news_postdate'])),
						$rows['news_view'],
						$status,
						anchor('dashboard/news/edit/'.$rows['news_id'],'<i class="fa fa-edit"></i>',array('class'=>''))
					)
				);
			}
			$this->output->set_content_type('application/json')->set_output(json_encode(array('data'=>$data)));
		}else{
			$news=$this->news_m->all_news()->result_array();
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
						anchor('dashboard/news/read/'.$rows['news_seo'], $rows['news_title'],array('target'=>'_blank')),
						$rows['category_name'],
						$rows['first_name'].'&nbsp;'.$rows['last_name'],
						date('d M Y H:i:s',strtotime($rows['news_postdate'])),
						$rows['news_view'],
						$publish,
						$status,
						anchor('dashboard/news/edit/'.$rows['news_id'],'<i class="fa fa-edit fa-lg"></i>',array('class'=>''))
						. '&nbsp;&nbsp;<a href="javascript:void(0)" onclick="deleted('."'".$rows['news_id']."'".')"><i class="fa fa-trash fa-lg"></i></a>'
					)
				);
			}
			$this->output->set_content_type('application/json')->set_output(json_encode(array('data'=>$data)));
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
			$this->data['title']='Add News';
			$this->backend->display('admin/news/add',$this->data);
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
	        	$this->backend->display('admin/news/edit',$this->data);
	        }
		}
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
	public function active()
	{
		$this->form_validation->set_rules('news_id','Title','required');
		if ($this->form_validation->run()===TRUE) {
			$info['success'] = TRUE;
			$data = array(
				'news_id' => $this->input->post('news_id'),
				'status' => 'Active'
			);
			$this->news_m->active($data);
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
			$this->news_m->inactive($data);
			$info['message'] ='Success to Inactive';
		}else{
			$info['success'] = FALSE;
			$info['errorss']=validation_errors();
		}
		$this->output->set_content_type('application/json')->set_output(json_encode($info));
	}
	public function save()
	{
		$this->form_validation->set_rules('txtTitle','Title','required');
		$this->form_validation->set_rules('txtCategory','Category','required|callback_categories');
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
					'media'=>'NEWS'
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

				//$this->resize_image($file['file_name']);
				//$this->watermark($file['file_name']);
				//$this->cropped_images($file['file_name']);
				$data=array(
					'news_id'=>$this->input->post('news_id'),
					'news_title' => $this->input->post('txtTitle'),
					'news_headline' => $this->input->post('txtHeadline'),
					'category_id'=>$this->input->post('txtCategory'),
					'news_seo' =>  url_title($this->input->post('txtTitle'), 'dash', TRUE),
					'news_content' => $this->input->post('txtContent'),
					'news_status'=>$this->input->post('txtStatus'),
					'news_picture' =>$file['file_name'],
					'media'=>'NEWS'
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
					'media'=>'NEWS'
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
	public function categories($cat)
	{
		if($cat=="none"){
			$this->form_validation->set_message('select_validate', 'Please Select Categories.');
			return false;
		}else{
			return true;
		}
	}
	public function resize_image($file){
	    $path_source='./images/news/';
    	$img_file=$path_source.$file;
    	move_uploaded_file($_FILES["txtPicture"]["tmp_name"], $img_file);
    	$im_src = imagecreatefromjpeg($img_file);
		$src_width = imageSX($im_src);
		$src_height = imageSY($im_src);
		//755 pixel tos set size
		$dst_width = 230;
		$dst_height = ($dst_width/$src_width)*$src_height;
		//procces change size
		$im = imagecreatetruecolor($dst_width,$dst_height);
		imagecopyresampled($im, $im_src, 0, 0, 0, 0, $dst_width, $dst_height, $src_width, $src_height);
		//create new medium_
		imagejpeg($im,$path_source . "medium_" . $file);
		imagedestroy($im_src);
		imagedestroy($im);
	}
	public function resize_imagess($file)
	{
		$path_source='./images/news/'. $file;
    	$path_target='./images/news/';
	    $this->load->library('image_lib');

	    //$im_src = imagecreatefromjpeg($path_source);
	    //$w = imageSX($im_src);//['max_width']; // original image's width
	    //$h = imageSY($im_src);//['max_height']; // original images's height
	    $w = $image_data['image_width']; // original image's width
    	$h = $image_data['image_height']; // original images's height
	    $n_w = 800; // destination image's width
	    $n_h = 600; // destination image's height
	    $source_ratio = $w / $h;
	    $new_ratio = $n_w / $n_h;
	    if($source_ratio != $new_ratio){
	        $config['image_library'] = 'gd2';
	        $config['source_image'] = $path_source;
	        $config['maintain_ratio'] = FALSE;
	        if($new_ratio > $source_ratio || (($new_ratio == 1) && ($source_ratio < 1))){
	            $config['width'] = $w;
	            $config['height'] = round($w/$new_ratio);
	            $config['y_axis'] = round(($h - $config['height'])/2);
	            $config['x_axis'] = 0;
	        } else {
	            $config['width'] = round($h * $new_ratio);
	            $config['height'] = $h;
	            $size_config['x_axis'] = round(($w - $config['width'])/2);
	            $size_config['y_axis'] = 0;
	        }

	        $this->image_lib->initialize($config);
	        $this->image_lib->crop();
	        $this->image_lib->clear();
	    }
	    $config['image_library'] = 'gd2';
	    $config['source_image'] = $path_source;
	    $config['new_image'] = $path_target;
	    $config['maintain_ratio'] = TRUE;
	    $config['width'] = $n_w;
	    $config['height'] = $n_h;
	    $this->image_lib->initialize($config);
	    if (!$this->image_lib->resize())
	        return show_error($this->image_lib->display_errors());
	    $this->image_lib->clear();
	}
	public function watermark($file)
	{
		$path_dir='./images/news/';
		$imgConfig = array();
		$imgConfig['image_library']   = 'GD2';
		$imgConfig['source_image']    = $path_dir.$file;
		$imgConfig['wm_text']         = 'Copyright ' .date('Y'). ' - Kerjakerja.id';
		$imgConfig['wm_type']         = 'text';
		$imgConfig['wm_font_size']    = '10';
		$this->load->library('image_lib', $imgConfig);
		$this->image_lib->initialize($imgConfig);
		$this->image_lib->watermark(); 
	}
	public function cropped_images($file)
	{
		$path_dir='./images/news/';
		$imgConfig = array();
		$imgConfig['image_library']= 'GD2';
		$imgConfig['source_image'] = $path_dir.$file;
		$imgConfig['new_image']    = $path_dir.'crop_'.$file;
		$imgConfig['height'] = '360';
		$imgConfig['width']  = '570';
		$imgConfig['x_axis'] = '150';
		$imgConfig['y_axis'] = '150';
		$this->load->library('image_lib', $imgConfig);
		$this->image_lib->initialize($imgConfig);
		$this->image_lib->crop();
	}
}

/* End of file News.php */
/* Location: ./application/controllers/News.php */