<?php
/**
* Author:  Heru Sulistiono
*        mildlaser3@gmail.com
* Copyright © Heru Sulistiono
* Website: https://herusulistiono.net/
* Created:  31.03.2018
* Updated:  31.05.2018
* Requirements: PHP5
*
*/
defined('BASEPATH') OR exit('No direct script access allowed');
$id=$this->ion_auth->user()->row()->id;
$fullname = $this->ion_auth->user()->row()->first_name.'&nbsp;'.$this->ion_auth->user()->row()->last_name;
$photo = $this->ion_auth->user()->row()->photo;
?><!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <!-- <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no' name='viewport'/> -->
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <title><?php echo $title; ?></title>
    <!-- Main CSS-->
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/main.css') ?>"/>
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/font-awesome.min.css'); ?>"/>

    <script src="<?php echo base_url('assets/js/jquery-3.2.1.min.js');?>"></script>
    <script src="<?php echo base_url('assets/popper/popper.min.js');?>"></script>
    <script src="<?php echo base_url('assets/js/bootstrap.min.js'); ?>"></script>
    <script src="<?php echo base_url('assets/js/bootstrap-notify.min.js');?>"></script>
    <script src="<?php echo base_url('assets/js/plugins/tinymce/tinymce.min.js');?>"></script>
    <script src="<?php echo base_url('assets/js/sweetalert.min.js');?>"></script>
    <script src="<?php echo base_url('assets/js/plugins/jquery.dataTables.min.js'); ?>"></script>
    <script src="<?php echo base_url('assets/js/plugins/dataTables.bootstrap.min.js'); ?>"></script>
  </head>
  <body class="app sidebar-mini">
    
    <!-- Navbar-->
    <header class="app-header"><a class="app-header__logo" href="">PKPBerdikari</a>
      <!-- Sidebar toggle button--><a class="app-sidebar__toggle" href="#" data-toggle="sidebar"></a>
      <!-- Navbar Right Menu-->
      <ul class="app-nav">
        <li class="app-search">
          <?php echo form_open('url', ''); ?>
          <input class="app-search__input" type="search" placeholder="Search">
          <button class="app-search__button"><i class="fa fa-search"></i></button>
          <?php echo form_close(); ?>
        </li>
        <li>
          <a href="<?php echo site_url('/') ?>" class="app-nav__item" target="_blank">
            <i class="fa fa-home fa-lg"></i>
          </a>
        </li>
        <!-- User Menu-->
        <li>
          <a href="<?php echo site_url('dashboard/profile/index/'.$id) ?>" class="app-nav__item">
            <i class="fa fa-user fa-lg"></i>
          </a>
        </li>
        <li><a class="app-nav__item" href="<?php echo site_url('dashboard/auth/logout');?>"><i class="fa fa-power-off fa-lg"></i></a></li>
        <!-- <li class="dropdown"><a class="app-nav__item" href="#" data-toggle="dropdown"><i class="fa fa-user fa-lg"></i></a> -->
          <!-- <ul class="dropdown-menu settings-menu dropdown-menu-right"> -->
            <!-- <li><?php echo anchor('auth/edit_user/'.$user_id,'<i class="fa fa-user fa-lg"></i> Profile',array('class'=>'dropdown-item'));?></li> -->
            <!-- <li><a class="dropdown-item" href="<?php echo site_url('auth/logout') ?>"><i class="fa fa-sign-out fa-lg"></i> Logout</a></li> -->
          <!-- </ul> -->
        <!-- </li> -->
      </ul>
    </header>
    <!-- Sidebar menu-->
    <div class="app-sidebar__overlay" data-toggle="sidebar"></div>
    <aside class="app-sidebar">
      <div class="app-sidebar__user"><img class="app-sidebar__user-avatar" width="48px" height="48px" src="<?php echo base_url('images/avatar/'.$photo) ?>" alt="<?php echo $fullname;?>"/>
        <div>
          <p class="app-sidebar__user-name"><?php echo $fullname;?></p>
          <p class="app-sidebar__user-designation"></p>
        </div>
      </div>
      <ul class="app-menu">
        <?php if ($this->ion_auth->is_admin()): ?>
          <li><a class="app-menu__item <?php echo activate_dashboard('home'); ?>" href="<?php echo site_url('dashboard/home');?>">
            <i class="app-menu__icon fa fa-dashboard"></i><span class="app-menu__label">Dashboard</span></a></li>
          <!-- <li class="treeview is-expanded"><a class="app-menu__item" href="#" data-toggle="treeview"><i class="app-menu__icon fa fa-tags"></i><span class="app-menu__label">Posts</span><i class="treeview-indicator fa fa-angle-right"></i></a> -->
          <li class="treeview"><a class="app-menu__item" href="#" data-toggle="treeview"><i class="app-menu__icon fa fa-tags"></i><span class="app-menu__label">Posts</span><i class="treeview-indicator fa fa-angle-right"></i></a>
            <ul class="treeview-menu">
              <li><a class="treeview-item <?php echo activate_dashboard('news');?>" href="<?php echo site_url('dashboard/news');?>"><i class="icon fa fa-circle-o"></i> All Posts</a></li>
              <li><a class="treeview-item <?php echo activate_dashboard('grafis'); ?>" href="<?php echo site_url('dashboard/grafis');?>"><i class="icon fa fa-circle-o"></i> Info Grafis</a></li>
              <li><a class="treeview-item <?php echo activate_dashboard('fgd'); ?>" href="<?php echo site_url('dashboard/fgd');?>"><i class="icon fa fa-circle-o"></i> Focus Group Discussion</a></li>
              <li><a class="treeview-item <?php echo activate_dashboard('video'); ?>" href="<?php echo site_url('dashboard/video');?>"><i class="icon fa fa-circle-o"></i> Video</a></li>
            </ul>
          </li>
          <li><a class="app-menu__item <?php echo activate_dashboard('users'); ?>" href="<?php echo site_url('dashboard/users');?>"><i class="app-menu__icon fa fa-users"></i><span class="app-menu__label">Users</span></a></li>
        <?php else: ?>
        <?php return show_error('You must login.'); ?>
        <?php endif ?>
      </ul>
    </aside>
    <main class="app-content">
      <div class="app-title">
        <div>
          <h1><?php echo $title ?></h1>
          <!-- <p>A free and modular admin template</p> -->
        </div>
        <ul class="app-breadcrumb breadcrumb">
          <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
          <li class="breadcrumb-item"><a href="#"><?php echo $title ?></a></li>
        </ul>
      </div>
      <?php echo $_content; ?>
    </main>
    <script src="<?php echo base_url('assets/main.js'); ?>"></script>
    <script src="<?php echo base_url('assets/js/pace.min.js');?>"></script>
  </body>
</html>
<!-- Copyright © 2018 Heru Sulistiono -->