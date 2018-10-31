<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
* Name:  Category  Controller
*
* Author:  Heru Sulistiono
* 		   mildlaser3@gmail.com
* Copyright © Heru Sulistiono
* Website: https://herusulistiono.net/
* Created:  08.02.2018
* Requirements: PHP5, jQuery,Bootstrap,Datatable
*
*/
class Category extends CI_Controller {
	public function __construct()
	{
		parent::__construct();
		$this->load->model(array('category_m','news_m','gallery_m'));
	}
	public function index()
	{
		if (!$this->ion_auth->logged_in())
		{
			$this->data['title']='Category';
			$this->data['gallery']=$this->gallery_m->get_gallery_active()->result();
			$this->template->display('front/gallery/index',$this->data);
		}else{
			$this->data['title']='Categories';
			$this->backend->display('admin/category',$this->data);
		}
	}
	public function get_categories($seo=NULL)
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
        	$this->data['news_postby']= $news->first_name.''.$news->last_name;
        	$this->data['news_view']= $news->news_view;
        	/*$view = array('news_id'=>$news->news_id,'news_view'=>$news->news_view+1);
        	$this->news_m->update_view($view);*/
        	$this->data['title']= $news->news_title;
        	$this->data['news_popular']=$this->news_m->news_popular()->result();
        	$this->template->display('front/news/detail_categories',$this->data);
        }
	}

	public function get_category()
	{
		$categories=$this->category_m->get_category()->result_array();
		$data=array();
		$no=1;
		foreach ($categories as $rows) {
			array_push($data, 
				array(
					$no++,
					$rows['category_name'],
					$rows['category_seo'],
					$rows['rec_count'],
					'<a href="javascript:void(0)" onclick="edit('."'".$rows['category_id']."'".')"><i class="fa fa-edit"></i></a>'
				)
			);
		}
		$this->output->set_content_type('application/json')->set_output(json_encode(array('data'=>$data)));
	}
	public function get_by_id()
	{
		$category_id=$this->input->post('category_id');
		$data=$this->category_m->get_by_id($category_id)->row_array();
		$this->output->set_content_type('application/json')->set_output(json_encode($data));
	}
	public function save()
	{
		$this->form_validation->set_rules('txtName','Name', 'required');
		if ($this->form_validation->run()===TRUE) {
			$data=array(
				'category_name'=>$this->input->post('txtName'),
				'category_seo'=>url_title($this->input->post('txtName'), 'dash', TRUE)
			);
			$this->category_m->insert($data);
			$info['success']=TRUE;
			$info['message']='Successfully';
		}else{
			$info['success']=FALSE;
			$info['errors']=validation_errors();
		}
		$this->output->set_content_type('application/json')->set_output(json_encode($info));
	}
	public function update()
	{
		$this->form_validation->set_rules('txtId','ID', 'required');
		$this->form_validation->set_rules('txtName','Name', 'required');
		if ($this->form_validation->run()===TRUE) {
			$data=array(
				'category_id'=>$this->input->post('txtId'),
				'category_name'=>$this->input->post('txtName'),
				'category_seo'=>url_title($this->input->post('txtName'), 'dash', TRUE)
			);
			$this->category_m->update($data);
			$info['success']=TRUE;
			$info['message']='Successfully';
		}else{
			$info['success']=FALSE;
			$info['errors']=validation_errors();
		}
		$this->output->set_content_type('application/json')->set_output(json_encode($info));
	}
}

/* End of file Category.php */
/* Location: ./application/controllers/Category.php */