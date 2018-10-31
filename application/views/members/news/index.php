<!-- <section id="page-title">
  <div class="container clearfix">
    <h1>Blog</h1>
    <span>Our Latest News in Grid Layout</span>
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="#">Home</a></li>
      <li class="breadcrumb-item active" aria-current="page">Blog</li>
    </ol>
  </div>
</section> -->
<div class="container clearfix">
  <div id="posts" class="post-grid grid-container clearfix" data-layout="fitRows">
  <?php foreach ($news as $show): ?>
  <div class="entry clearfix">
    <div class="entry-image">
      <a href="<?php echo base_url('images/news/'.$show->news_picture);?>" data-lightbox="image">
        <img class="image_fade" src="<?php echo base_url('images/news/'.$show->news_picture);?>" alt="Standard Post with Image">
      </a>
    </div>
    <div class="entry-title">
      <h2><?php echo anchor('news/read/'.$show->news_seo, $show->news_title);?></h2>
    </div>
    <ul class="entry-meta clearfix">
      <li><i class="icon-calendar3"></i> <?php echo date('j M Y',strtotime($show->news_postdate));?></li>
      <li><i class="icon-eye"></i> <?php echo $show->news_view ?> Dibaca</li>
      <!-- <li><a href="#"><i class="icon-camera-retro"></i></a></li> -->
    </ul>
    <div class="entry-content">
      <?php 
        $description = $show->news_content;
        $getlength = strlen($description);
        $thelength = 220;
        echo substr($description, 0, $thelength);
        if ($getlength > $thelength) echo ".....";?><!-- <br/>   -->
      <?php echo anchor('news/read/'.$show->news_seo, 'Selengkapnya',array('class'=>'more-link')); ?>
    </div>
  </div>
  <?php endforeach ?>
</div>
</div>
<div class="container clearfix"><?php echo $pagination; ?></div>