<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Rss extends CI_Controller {
	public function __construct()
	{
		parent::__construct();
		$this->load->model('news_m');
		 $this->load->helper('xml');
	}
	public function index()
	{
		/*$this->data['title'] = 'RSS FEED';
		$this->data['encoding'] = 'utf-8';
        $this->data['feed_name'] = 'kerjakerja.id';
        $this->data['feed_url'] = base_url();
        $this->data['page_description'] = 'Kerjakerja';
        $this->data['news']=$this->news_m->read_rss()->result();
        header("Content-Type: application/rss+xml");
        $this->load->view('members/rss',$this->data);*/
		//$path=base_url('./');
		$file=fopen('rss.xml','w');
		fwrite($file,'<?xml version="1.0"?> 
		<rss version="2.0"> 
		<channel> 
		<title>Kerjakerja Feed</title> 
		<link>https://kerjakerja.id</link> 
		<description>Feed Description</description> 
		<language>en-us</language>');
		$news=$this->news_m->read_rss()->result();
		foreach ($news as $rss) {
			$news_content=htmlentities(strip_tags(nl2br($rss->news_content)));
			$content=substr($news_content, 0,220);
			$content=substr($news_content,0,strrpos($content," "));
			fwrite($file, '<item>
                <title>'.$rss->news_title.'</title>
                <link>'.base_url('news/read/'.$rss->news_seo).'</link>
                <description>'.$content.'...</description>
                </item>');
		}
		fwrite($file, "</channel></rss>");
		fclose($file);
	}

}

/* End of file Rss.php */
/* Location: ./application/controllers/Rss.php */