<div class="container">
  <div class="col_full">
    <div class="fslider flex-thumb-grid grid-6" data-animation="fade" data-arrows="true" data-thumbs="true">
      <div class="flexslider">
        <div class="slider-wrap">
          <?php $slide=array('EXT_006.jpg','EXT_007.jpg','EXT_008.jpg','EXT_009.jpg','EXT_010.jpg','EXT_011.jpg','EXT_012.jpg','EXT_013.jpg','EXT_014.jpg','EXT_015.jpg','EXT_016.jpg'
        );?>
          <?php foreach ($slide as $img): ?>
            <div class="slide" data-thumb="<?php echo base_url('images/pkpberdikari/program/'.$img);?>">
              <a href="<?php echo base_url('images/pkpberdikari/program/'.$img);?>" data-lightbox="image">
                <img class="image_fade" src="<?php echo base_url('images/pkpberdikari/program/'.$img);?>"/>
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