<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
* Name:  Home Controller
*
* Author:  Heru Sulistiono
* 		   mildlaser3@gmail.com
* Copyright © Heru Sulistiono
* Location: https://herusulistiono.net/
* Created:  08.02.2018
* Update:  12.04.2018
* Requirements: PHP5
*
*/
class Home extends CI_Controller {
	public function __construct()
	{
		parent::__construct();
		$this->load->library('Twitteroauth');
		$this->config->load('twitter');
		$this->load->model(array('news_m','grafis_m','gallery_m','story_m','category_m','comment_m'));
	}
	public function index()
	{
		$this->data['title']='PKPBerdikari, Berita Terkini,Info Grafis, Media Online - kerjakerja.id';
		$this->data['m_description']='Kerjakerja, Berdikari';
		$this->data['m_keyword']='PKPBerdikari, Berita Terkini,Info Grafis, Media';
		$this->data['breaking_news']=$this->news_m->get_breaking_news()->result();
		$this->data['news_headline']=$this->news_m->get_headline()->result();
		$this->data['info_grafis']=$this->grafis_m->get_info_grafis()->result();
		$this->data['news']=$this->news_m->get_news_post()->result();
		$this->data['video']=$this->gallery_m->get_video_home()->result();
		$this->data['story']=$this->story_m->get_your_story()->result();
		$this->data['popular_day']=$this->news_m->news_popular_day()->result();
		//Counter
		$tweet_count=(int)5;
		$keyword='kerjakerjadotid'; //keyword
		//Connect Twitter API
		$connection = $this->twitteroauth->create($this->config->item('twitter_consumer_token'), $this->config->item('twitter_consumer_secret'), $this->config->item('twitter_access_token'),$this->config->item('twitter_access_secret'));
		//get tweet
		$this->data['tweets']=$connection->get('search/tweets',['q'=>$keyword,'count'=>$tweet_count,'lang'=>'id']);
		$this->template->display('members/home',$this->data);
	}
}

/* End of file Home.php */
/* Location: ./application/controllers/Home.php */