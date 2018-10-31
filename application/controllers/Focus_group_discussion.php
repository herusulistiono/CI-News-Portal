<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Focus_group_discussion extends CI_Controller {
	private $limit=10;
	public function __construct()
	{
		parent::__construct();
		$this->form_validation->set_error_delimiters($this->config->item('error_start_delimiter', 'ion_auth'), $this->config->item('error_end_delimiter', 'ion_auth'));
		$this->lang->load('auth');
		$this->load->library('Twitteroauth');
		$this->config->load('twitter');
		$this->load->model(array('fgd_m','news_m','grafis_m','story_m','category_m'));
	}
	public function index()
	{
		if (empty($offset)) $offset = 0;
		$this->data['news']=$this->fgd_m->get_paged_list($this->limit, $offset)->result();
		$this->data['title']='Focus Group Discussion';
		$this->data['m_description']='PKPBerdikari - Kerjakerja';
		$this->data['m_keyword']='Berita Terkini,Info Grafis, Media';
		$this->template->display('members/fgd/index',$this->data);
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
	    	$view = array('news_id'=>$news->news_id,'news_view'=>$news->news_view+1);
	    	$this->news_m->update_view($view);
	    	$this->data['title']= $news->news_title;
	    	$this->data['m_description']=$news->news_title.' - kerjakerja.id';
			$this->data['m_keyword']=$news->news_title .' - kerjakerja.id';
			$this->data['story']=$this->story_m->get_your_story()->result();// Your Story
	    	$this->data['popular_day']=$this->news_m->news_popular_day()->result(); //Latest Days
	    	//Counter
			$tweet_count = (int)12;
			$keyword = 'kerjakerjadotid'; //keyword Hastag
			//Connect Twitter API
			$connection = $this->twitteroauth->create($this->config->item('twitter_consumer_token'), $this->config->item('twitter_consumer_secret'), $this->config->item('twitter_access_token'),$this->config->item('twitter_access_secret'));
				//get tweet
			$this->data['tweets']=$connection->get('search/tweets',['q'=>$keyword,'count'=>$tweet_count,'lang'=>'id']);
	    	$this->template->display('members/fgd/detail',$this->data);
	    }
	}

}

/* End of file Focus_group_discussion.php */
/* Location: ./application/controllers/dashboard/Focus_group_discussion.php */