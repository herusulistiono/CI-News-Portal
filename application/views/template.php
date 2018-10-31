<?php
/**
* Author:  Heru Sulistiono
*        mildlaser3@gmail.com
* Copyright © Heru Sulistiono
* Location: https://herusulistiono.net/
* Created:  12.05.2018
* Requirements: PHP5
*
*/
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <meta name="description" content="<?php echo $m_description; ?>"/>
    <meta name="keywords" content="<?php echo $m_keyword; ?>"/>
    <meta name="author" content="https://kerjakerja.id"/>
    <meta content='kerjakerjadotid' name='twitter:site'/>
    <meta content='kerjakerjadotid' name='twitter:creator'/>
    <!-- <meta name="robots" content="index, follow"/> -->
    <title><?php echo $title ?></title>
    <link rel="shortcut icon" href="<?php echo base_url('images/favicon.ico') ?>" type="image/x-icon">
    <link rel="icon" href="<?php echo base_url('images/favicon.ico') ?>" type="image/x-icon">
    <link rel="alternate" type="application/rss+xml" title="RSS 2.0" href="<?php echo base_url('rss.xml');?>"/>
    <!-- CSS -->
    <link href="https://fonts.googleapis.com/css?family=Lato:300,400,400i,700|Raleway:300,400,500,600,700|Crete+Round:400i" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="<?php echo base_url('assets/css/font-awesome.min.css')?>" type="text/css"/>
    <link rel="stylesheet" href="<?php echo base_url('assets/css/bootstrap.css')?>" type="text/css"/>
	<link rel="stylesheet" href="<?php echo base_url('assets/style.css')?>" type="text/css"/>
	<link rel="stylesheet" href="<?php echo base_url('assets/css/dark.css')?>" type="text/css"/>
	<link rel="stylesheet" href="<?php echo base_url('assets/css/font-icons.css')?>" type="text/css"/>
	<link rel="stylesheet" href="<?php echo base_url('assets/css/animate.css')?>" type="text/css"/>
	<link rel="stylesheet" href="<?php echo base_url('assets/css/magnific-popup.css')?>" type="text/css" />
	<link rel="stylesheet" href="<?php echo base_url('assets/css/responsive.css')?>" type="text/css"/>
    <script src="<?php echo base_url('assets/js/jquery.min.js');?>"></script>
    
  </head>
  <body class="stretched">
    <div id="wrapper" class="clearfix">

		<!-- Header -->
		<header id="header" class="dark">
			<div id="header-wrap">
				<div class="container clearfix">
					<div id="primary-menu-trigger"><i class="icon-reorder"></i></div>
					<div id="logo">
						<a href="<?php echo site_url('/');?>" class="standard-logo" data-dark-logo="<?php echo base_url('images/logo-dark.png');?>"><img src="<?php echo base_url('images/logo.png');?>" alt="Kerjakerja.id"/></a>
						<a href="<?php echo site_url('/') ?>" class="retina-logo" data-dark-logo="<?php echo base_url('images/logo-dark@2x.png');?>"><img src="<?php echo base_url('images/logo@2x.png');?>" alt="Kerjakerja.id"/></a>
					</div>

					<nav id="primary-menu">
						<ul>
							<li class="<?php echo activate_menu('home'); ?>">
								<?php echo anchor('home', '<div>Home</div>'); ?>
							</li>
							<li class=""><a href="#"><div>PKPBerdikari</div></a>
								<ul>
									<li><?php echo anchor('about','<div>Tentang PKPBerdikari</div>'); ?></li>
									<li><?php echo anchor('structure', '<div>Struktur Organisasi</div>'); ?></li>
									<li><?php echo anchor('programs', '<div>Program PKPBerdikari</div>'); ?></li>
								</ul>
							</li>

							<!-- <li class="<?php echo activate_menu('about'); ?>"><?php echo anchor('about', '<div>PKPBerdikari</div>'); ?></li> -->
							<li class="<?php echo activate_menu('infografis'); ?>"><?php echo anchor('infografis', '<div>Infografis</div>'); ?></li>
							<li class="<?php echo activate_menu('news'); ?>"><?php echo anchor('news', '<div>News</div>'); ?></li>
							<li class="<?php echo activate_menu('video'); ?>"><?php echo anchor('video', '<div>Video</div>'); ?></li>
							<li class="<?php echo activate_menu('focus_group_discussion'); ?>"><?php echo anchor('focus_group_discussion', '<div>FGD</div>'); ?></li>
							<li class="<?php echo activate_menu('story'); ?>"><?php echo anchor('story', '<div>Your Story</div>'); ?></li>
							<li><?php echo anchor('dashboard/auth', '<div>Sign In/Up</div>'); ?></li>
						</ul>
						<!-- Top Search -->
						<div id="top-search">
							<a href="#" id="top-search-trigger"><i class="icon-search3"></i><i class="icon-line-cross"></i></a>
							<form action="" method="get">
								<input type="text" name="q" class="form-control" value="" placeholder="Type &amp; Hit Enter..">
							</form>
						</div><!-- #top-search end -->
					</nav>
				</div>
			</div>
		</header><!-- #header end -->

		<section id="content">
			<div class="content-wrap">
				<?php echo $_content; ?>
			</div>
		</section>

		<!-- Footer
		============================================= -->
		<footer id="footer" class="dark">

			<!-- Copyrights
			============================================= -->
			<div id="copyrights">

				<div class="container clearfix">

					<div class="col_half">
						Copyrights &copy; <?php echo date('Y') ?> All Rights Reserved by Kerjakerja.id<br>
						<!-- <div class="copyright-links"><a href="#">Terms of Use</a> / <a href="#">Privacy Policy</a></div> -->
					</div>

					<div class="col_half col_last tright">
						<div class="fright clearfix">
							<a href="https://www.facebook.com/Kerjakerjadotid" target="_blank" class="social-icon si-small si-borderless si-facebook">
								<i class="icon-facebook"></i>
								<i class="icon-facebook"></i>
							</a>

							<a href="https://twitter.com/kerjakerjadotid" target="_blank" class="social-icon si-small si-borderless si-twitter">
								<i class="icon-twitter"></i>
								<i class="icon-twitter"></i>
							</a>

							<a href="https://www.instagram.com/kerjakerjadotid/" target="_blank" class="social-icon si-small si-borderless si-instagram">
								<i class="icon-instagram"></i>
								<i class="icon-instagram"></i>
							</a>
							<a href="https://www.youtube.com/channel/UCfvatqIuOybP_epMCK6soPg/featured" target="_blank" class="social-icon si-small si-borderless si-youtube">
								<i class="icon-youtube"></i>
								<i class="icon-youtube"></i>
							</a>
						</div>

						<div class="clear"></div>

						<i class="icon-envelope2"></i> berdikari@kerjakerja.id<span class="middot">&middot;</span>
						<i class="icon-headphones"></i> +6221-727-88934 <span class="middot">&middot;</span>
					</div>

				</div>

			</div><!-- #copyrights end -->

		</footer><!-- #footer end -->

    </div><!-- #wrapper end -->
    <div id="gotoTop" class="icon-angle-up"></div>
    <script src="<?php echo base_url('assets/js/plugins.js');?>"></script>
  	<script src="<?php echo base_url('assets/js/functions.js');?>"></script>
  </body>
</html>