<?php
	defined('BASEPATH') OR exit('No direct script access allowed');
	
class Video extends CI_Controller {
	public function __construct()
	{
		parent::__construct();
		$this->form_validation->set_error_delimiters($this->config->item('error_start_delimiter', 'ion_auth'), $this->config->item('error_end_delimiter', 'ion_auth'));
		$this->lang->load('auth');
		$this->load->library('Twitteroauth');
		$this->config->load('twitter');
		$this->load->model(array('gallery_m','news_m','grafis_m','story_m','category_m'));
	}
	public function index()
	{
		$this->data['title']='Gallery Video';
		$this->data['m_description']='Kerjakerja, Berdikari';
		$this->data['m_keyword']='Media Video, Berita Terkini, Info Grafis, Joko Widodo, Jokowi';
		$this->data['video_list']=$this->gallery_m->video_list()->result();
		$this->template->display('members/video/index',$this->data);
	}
	public function get_video_list()
	{
		$video_list=$this->gallery_m->video_list()->result_array();
		$data=array();
		foreach ($video_list as $rows) {
			array_push($data,
				array(
					$rows['news_id'],
					$rows['news_title'],
					$rows['news_headline'],
					$rows['news_picture'],
				)
			);
		}
		$this->output->set_content_type('application/json')->set_output(json_encode($data));
		//echo json_encode(array('data'=>$data));
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
	    	$this->data['news_media']= $news->media;
	    	$this->data['photo']= $news->photo;
	    	$this->data['news_view']= $news->news_view;
	    	$view = array('news_id'=>$news->news_id,'news_view'=>$news->news_view+1);
	    	$this->news_m->update_view($view);
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
	    	$this->template->display('members/video/detail',$this->data);
	    }
	}
}
	
/* End of file Video.php */
/* Location: ./application/controllers/Video.php */	