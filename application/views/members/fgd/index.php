<div class="container">
  <h3>Focus Group Discussion</h3>
  <div class="col_full">
    <div class="fslider flex-thumb-grid grid-6" data-animation="fade" data-arrows="true" data-thumbs="true">
      <div class="flexslider">
        <div class="slider-wrap">
          
          <?php foreach ($news as $fgd): ?>
            <div class="slide" data-thumb="<?php echo base_url('images/news/'.$fgd->news_picture);?>">
              <a href="<?php echo base_url('images/news/'.$fgd->news_picture);?>" data-lightbox="image">
                <img class="image_fade" src="<?php echo base_url('images/news/'.$fgd->news_picture);?>"/>
                <div class="overlay">
                  <div class="text-overlay">
                    <div class="text-overlay-title">
                      <h3><?php echo anchor('focus_group_discussion/read/'.$fgd->news_seo, $fgd->news_title);?></h3>
                    </div>
                    <div class="text-overlay-meta">
                      <span></span>
                    </div>
                  </div>
                </div>
              </a>
            </div>
          <?php endforeach ?>

        </div>
      </div>
    </div>
  </div>
</div>
<div class="clear"></div>