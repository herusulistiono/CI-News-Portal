<div class="section header-stick bottommargin-lg clearfix" style="padding: 20px 0;">
  <div>
    <div class="container clearfix">
      <span class="badge badge-danger bnews-title">Breaking News:</span>

      <div class="fslider bnews-slider nobottommargin" data-speed="800" data-pause="6000" data-arrows="false" data-pagi="false">
        <div class="flexslider">
          <div class="slider-wrap">
            <div class="slide"><a href="#"><strong>Russia hits back, says US acts like a 'bad surgeon'..</strong></a></div>
            <div class="slide"><a href="#"><strong>'Sulking' Narayan Rane needs consolation: Uddhav reacts to Cong leader's attack..</strong></a></div>
            <div class="slide"><a href="#"><strong>Rane needs consolation. I pray to God that he gets mental peace in a political party..</strong></a></div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<div id="oc-images" class="owl-carousel owl-carousel-full news-carousel header-stick bottommargin-lg carousel-widget" data-margin="3" data-loop="true" data-stage-padding="50" data-pagi="false" data-items-sm="1" data-items-xl="2">
  <?php foreach ($news_headline as $slide): ?>
    <div class="oc-item">
      <a href="#"><img src="<?php echo base_url('images/news/'.$slide->news_picture) ?>" alt="Image 1"></a>
      <div class="overlay">
        <div class="text-overlay">
          <span class="badge badge-danger">World</span>
          <div class="text-overlay-title">
            <h2><?php echo $slide->news_title ?></h2>
          </div>
          <div class="text-overlay-meta">
            <span>14th Sep 2014</span>
          </div>
          <a href="#" class="button button-reveal button-border button-light button-small button-rounded uppercase tright noleftmargin topmargin-sm"><span>Read Story</span><i class="icon-angle-right"></i></a>
        </div>
        <div class="rounded-skill" data-color="#e74c3c" data-trackcolor="rgba(0,0,0,0.1)" data-size="80" data-percent="75" data-width="7" data-animate="3000">7.5</div>
      </div>
    </div>
  <?php endforeach ?>
</div>


<div class="container clearfix">
  <div class="row">
    <div class="col-lg-8 bottommargin">
      <div class="fancy-title title-border">
        <h3>BERITA TERKINI</h3>
      </div>
      <?php $i=(int)0; foreach ($news as $show): if ($i==0): ?>

          <div class="ipost clearfix">
            <div class="col_half bottommargin-sm">
              <div class="entry-image">
                <a href="#"><img class="image_fade" src="<?php echo base_url('images/news/'.$show->news_picture) ?>" alt="Image"></a>
              </div>
            </div>
            <div class="col_half bottommargin-sm col_last">
              <div class="entry-title">
                <h3><?php echo anchor('news/read/'.$show->news_seo, $show->news_title);?></h3>
              </div>
              <ul class="entry-meta clearfix">
                <li><i class="icon-calendar3"></i> <?php echo date('D M j Y - G:i:s T',strtotime($show->news_postdate));?></li>
                <li><a href=""><i class="icon-comments"></i> 21</a></li>
                <li><a href="#"><i class="icon-camera-retro"></i></a></li>
              </ul>
              <div class="entry-content">
                <?php 
                  echo '<p>'.$show->news_headline.'</p>';
                  $description = $show->news_content; 
                  $getLength=strlen($description);
                  $setLength=110;
                  echo substr($description,0,$setLength);
                  if($getLength > $setLength) echo "....";
                ?>
              </div>
            </div>
          </div>
          <div class="clear"></div>

      <?php else: ?>
        <div class="col_half nobottommargin">
          <div class="spost clearfix">
            <div class="entry-image">
              <a href="#"><img src="<?php echo base_url('images/news/'.$show->news_picture) ?>" alt=""></a>
            </div>
            <div class="entry-c">
              <div class="entry-title">
                <h4><?php echo anchor('news/read/'.$show->news_seo, $show->news_title);?></h4>
              </div>
              <ul class="entry-meta">
                <li><i class="icon-calendar3"></i> 1st Aug 2014</li>
                <li><a href="#"><i class="icon-comments"></i> 32</a></li>
              </ul>
            </div>
          </div>
        </div>
      <?php endif ?>
      <?php $i++; endforeach ?>
    </div>
    <div class="col-lg-4">
      <div class="line d-block d-lg-none d-xl-block"></div>
      <div class="sidebar-widgets-wrap clearfix">
        <div class="widget clearfix">
         </div>
      </div>
    </div>
  </div>
</div>

<div class="section dark">
  <div class="container clearfix">
    <h3>Featured News:</h3>
    
      <div id="oc-images2" class="owl-carousel image-carousel carousel-widget" data-margin="20" data-pagi="false" data-rewind="true" data-items-xs="1" data-items-sm="2" data-items-md="3" data-items-lg="4" data-items-xl="5">
        <?php foreach ($news_headline as $slide): ?>
              <div class="oc-item">
                <div class="ipost clearfix">
                  <div class="entry-image">
                    <a href="#"><img class="image_fade" src="<?php echo base_url('images/news/'.$slide->news_picture)?>" alt="Image"></a>
                  </div>
                  <div class="entry-title">
                    <h4><a href="blog-single.html"><?php echo $slide->news_title ?></a></h4>
                  </div>
                  <ul class="entry-meta clearfix">
                    <li><i class="icon-calendar3"></i> 17th Feb 2014</li>
                    <li><a href="blog-single.html#comments"><i class="icon-comments"></i> 32</a></li>
                  </ul>
                </div>
              </div>
              <?php endforeach ?>
      </div>
    
  </div>
</div>