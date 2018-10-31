<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
* Name:  News Controller
*
* Author:  Heru Sulistiono
* 		   mildlaser3@gmail.com
* Copyright © Heru Sulistiono
* Website: https://herusulistiono.net/
* Created:  25.04.2018
* Requirements: PHP5
*
*/
class Infografis extends CI_Controller {
	private $limit=10;
	public function __construct()
	{
		parent::__construct();
		$this->form_validation->set_error_delimiters($this->config->item('error_start_delimiter', 'ion_auth'), $this->config->item('error_end_delimiter', 'ion_auth'));
		$this->lang->load('auth');
		$this->load->library('Twitteroauth');
		$this->config->load('twitter');
		$this->load->model(array('grafis_m','news_m','story_m','category_m'));
	}
	public function index()
	{
		if (empty($offset)) $offset = 0;
		$this->data['grafis']=$this->grafis_m->get_paged_list($this->limit, $offset)->result();
		// generate pagination
		$this->load->library('pagination');
		$config['base_url'] = site_url('infografis/index/');
		$config['total_rows'] = $this->grafis_m->count_all();
		$config['per_page'] = $this->limit;
		$config['uri_segment'] = 3;
		$config['attributes']=array('class'=>'page-link');
		$config['full_tag_open']='<ul class="pagination nobottommargin">';
		$config['full_tag_close']='</ul>';
		$config['prev_tag_open']='<li>';
		$config['prev_tag_close']='</li>';
		$config['next_tag_open']='<li>';
		$config['next_tag_close']='</li>';
		$config['cur_tag_open']='<li class="page-item"><a class="page-link" href="">';
		$config['cur_tag_close']='</a></li>';
		$config['num_tag_open']='<li>';
		$config['num_tag_close']='</li>';
		$this->pagination->initialize($config);
		$this->data['pagination'] = $this->pagination->create_links();
		$this->data['title']='Info Grafis - kerjakerja.id';
		$this->data['m_description']='Kerjakerja, Berdikari';
		$this->data['m_keyword']='Info Grafis, Media, Berita Terkini, Joko Widodo, Jokowi';	
		$this->template->display('members/grafis/index',$this->data);
	}
	//Read Grafis
	public function read($seo=NULL)
	{
		$grafis=$this->grafis_m->read_grafis($seo)->row();
	    if (empty($grafis)) {
	    	show_404();
	    }else{
	     	$grafis=$this->grafis_m->read_grafis($seo)->row();
	     	$this->data['news_id']= $grafis->news_id;
	     	$this->data['news_title']= $grafis->news_title;
	     	$this->data['category_name']= $grafis->category_name;
	     	$this->data['news_seo']= $grafis->news_seo;
	     	$this->data['news_content']= $grafis->news_content;
	     	$this->data['news_picture']= $grafis->news_picture;
	     	$this->data['news_postdate']= date('d M Y H:i:s',strtotime($grafis->news_postdate));
	     	$this->data['news_postby']= $grafis->first_name.' '.$grafis->last_name;
	     	$this->data['photo']= $grafis->photo;
	     	$this->data['news_media']= $grafis->media;
	     	$this->data['news_view']= $grafis->news_view;
	    	$view = array('news_id'=>$grafis->news_id,'news_view'=>$grafis->news_view+1);
	     	$this->grafis_m->update_view($view);
	     	$this->data['title']= $grafis->news_title;
	     	$this->data['m_description']=$grafis->news_title.' - kerjakerja.id';
			$this->data['m_keyword']=$grafis->news_title .' - kerjakerja.id';
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
	      	$this->template->display('members/grafis/detail',$this->data);
	    }
	}

}

/* End of file Infografis.php */
/* Location: ./application/controllers/Infografis.php */