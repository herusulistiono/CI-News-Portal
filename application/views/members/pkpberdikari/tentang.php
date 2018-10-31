<div class="container">
  <div class="col_full">
    <div class="fslider flex-thumb-grid grid-6" data-animation="fade" data-arrows="true" data-thumbs="true">
      <div class="flexslider">
        <div class="slider-wrap">
          <?php $slide=array('SLIDE-1.jpg','SLIDE-2.jpg','SLIDE-3.jpg','SLIDE-4.jpg','SLIDE-5.jpg');?>
          <?php foreach ($slide as $img): ?>
            <div class="slide" data-thumb="<?php echo base_url('images/pkpberdikari/tentang/'.$img);?>">
              <a href="<?php echo base_url('images/pkpberdikari/tentang/'.$img);?>" data-lightbox="image">
                <img class="image_fade" src="<?php echo base_url('images/pkpberdikari/tentang/'.$img);?>"/>
                <div class="overlay">
                  <div class="text-overlay">
                    <div class="text-overlay-title">
                      <h3></h3>
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