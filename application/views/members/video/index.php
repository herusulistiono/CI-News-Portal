<div class="container clearfix">
  <h1>VIDEO</h1>
  <div id="posts" class="post-grid grid-container clearfix" data-layout="fitRows">
    <?php foreach ($video_list as $show):?>
    <div class="entry clearfix">
      <div class="entry-image">
        <a href="<?php echo base_url('images/news/'.$show->news_picture);?>" data-lightbox="image">
          <img class="image_fade" src="<?php echo base_url('images/news/'.$show->news_picture);?>" alt=""/>
        </a>
      </div>
      <div class="entry-title">
        <h2>
          <?php 
            $link_title = $show->news_title;
            $getlength = strlen($link_title);
            $thelength = 32;
            echo anchor('video/read/'.$show->news_seo,substr($link_title, 0, $thelength));
            if ($getlength > $thelength) echo "...";?>
        </h2>
      </div>
      <ul class="entry-meta clearfix">
        <li><i class="icon-calendar"></i> <?php echo date('j M Y',strtotime($show->news_postdate)); ?></li>
        <li><i class="icon-eye"></i> <?php echo $show->news_view ?> Dibaca</li>
      </ul>
      <div class="entry-content">
        <p></p>
      </div>
    </div>
    <?php endforeach ?>
  </div>
</div>
<div class="container clearfix"><?php //echo $pagination; ?></div>