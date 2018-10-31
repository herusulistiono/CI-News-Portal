<!-- BREAKING NEWS -->
<div class="section header-stick bottommargin-lg clearfix">
  <div>
    <div class="container clearfix">
      <span class="badge badge-danger bnews-title">Breaking News:</span>
      <div class="fslider bnews-slider nobottommargin" data-speed="800" data-pause="6000" data-arrows="false" data-pagi="false">
        <div class="flexslider">
          <div class="slider-wrap">
            <?php foreach ($breaking_news as $bn): ?>
              <div class="slide">
                <?php if ($bn->media==='NEWS'): ?>
                  <?php echo anchor('news/read/'.$bn->news_seo,'<strong>'.$bn->news_title.'</strong>');?>
                <?php elseif ($bn->media==='VIDEO'): ?>
                  <?php echo anchor('video/read/'.$bn->news_seo,'<strong>'.$bn->news_title.'</strong>');?>
                <?php elseif ($bn->media==='HOAX or NOT'): ?>
                  <?php echo anchor('news/read/'.$bn->news_seo,'<strong>'.$bn->news_title.'</strong>');?>
                <?php elseif ($bn->media==='INFO GRAFIS'): ?>
                  <?php echo anchor('infografis/read/'.$bn->news_seo,'<strong>'.$bn->news_title.'</strong>');?>
                <?php else: ?>
                <?php endif ?>
              </div>
            <?php endforeach ?>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- END BREAKING NEWS -->
<!-- HEADLINE ACTIVE -->
<div id="oc-images" class="owl-carousel owl-carousel-full news-carousel header-stick carousel-widget" data-margin="3" data-loop="true" data-stage-padding="50" data-pagi="false" data-items-sm="1" data-items-xl="2">
<?php foreach ($news_headline as $headline): if ($headline->media==='NEWS'): ?>
  <div class="oc-item">
    <a href="<?php echo site_url('news/read/'.$headline->news_seo);?>">
      <?php echo '<img src="'.base_url('images/news/'.$headline->news_picture).'" alt="'.$headline->news_title.'" class="img-responsive"/>'; ?>
    </a>
    <div class="overlay">
      <div class="text-overlay">
        <span class="badge badge-danger"><?php echo $headline->media; ?></span>
        <div class="text-overlay-title">
          <h2><?php echo $headline->news_title;?></h2>
        </div>
        <div class="text-overlay-meta">
          <span><?php echo date('j M Y - G:i:s T',strtotime($headline->news_postdate));?></span>
        </div>
        <a href="<?php echo site_url('news/read/'.$headline->news_seo);?>" class="button button-reveal button-border button-light button-small button-rounded uppercase tright noleftmargin topmargin-sm"><span>Selengkapnya</span><i class="icon-angle-right"></i></a>
      </div>
      <!-- <div class="rounded-skill" data-color="#e74c3c" data-trackcolor="rgba(0,0,0,0.1)" data-size="80" data-percent="75" data-width="7" data-animate="3000">7.5</div> -->
    </div>
  </div>
<?php else: ?>
  <div class="oc-item">
    <a href="<?php echo site_url('video/read/'.$headline->news_seo);?>">
      <?php echo '<img src="'.base_url('images/news/'.$headline->news_picture).'" alt="'.$headline->news_title.'" class="img-responsive"/>'; ?>
    </a>
    <div class="overlay">
      <div class="text-overlay">
        <span class="badge badge-danger"><?php echo $headline->media; ?></span>
        <div class="text-overlay-title">
          <h2><?php echo $headline->news_title;?></h2>
        </div>
        <div class="text-overlay-meta">
          <span><?php echo date('j M Y - G:i:s T',strtotime($headline->news_postdate));?></span>
        </div>
        <a href="<?php echo site_url('video/read/'.$headline->news_seo);?>" class="button button-reveal button-border button-light button-small button-rounded uppercase tright noleftmargin topmargin-sm"><span>Selengkapnya</span><i class="icon-angle-right"></i></a>
      </div>
      <!-- <div class="rounded-skill" data-color="#e74c3c" data-trackcolor="rgba(0,0,0,0.1)" data-size="80" data-percent="75" data-width="7" data-animate="3000">7.5</div> -->
    </div>
  </div>
<?php endif ?>
<?php endforeach ?>
</div>
<div class="clear"></div>
<!-- END HEADLINE ACTIVE -->

<!-- INFO GRAFIS -->
<div class="section dark">
  <div class="container clearfix">
    <h3>INFO GRAFIS:</h3>
    <div id="oc-images2" class="owl-carousel image-carousel carousel-widget" data-margin="20" data-pagi="false" data-rewind="true" data-items-xs="1" data-items-sm="2" data-items-md="3" data-items-lg="4" data-items-xl="5">
      <?php foreach ($info_grafis as $show):?>
        <div class="oc-item">
          <div class="ipost clearfix">
            <div class="entry-image">
              <a href="<?php echo site_url('infografis/read/'.$show->news_seo) ?>">
                <img src="<?php echo base_url('images/news/grafis/'.$show->news_picture) ?>" class="img-rounded img-responsive" alt="<?php echo $show->news_title;?>">
              </a>
            </div>
            <div class="entry-title">
              <h4><?php echo anchor('infografis/read/'.$show->news_seo, $show->news_title);?></h4>
            </div>
            <ul class="entry-meta clearfix">
              <li><i class="icon-calendar3"></i> <?php echo date('j M Y - G:i:s T',strtotime($show->news_postdate));?></li>
              <li><i class="icon-eye"></i> <?php echo $show->news_view;?>&nbsp;Dibaca</li>
            </ul>
          </div>
        </div>
      <?php endforeach ?>
    </div>
  </div>
</div>
<!-- END INFO GRAFIS -->
<!-- TRENDING NEWS-->
<div class="container clearfix">
  <div class="postcontent clearfix">
    <h3>BERITA TERKINI</h3>
    <?php foreach ($news as $show): ?>
      <div id="posts" class="small-thumbs">
        <div class="entry clearfix">
          <div class="entry-image">
            <a href="<?php echo base_url('images/news/'.$show->news_picture);?>" data-lightbox="image">
              <img class="image_fade" src="<?php echo base_url('images/news/'.$show->news_picture);?>" alt="<?php echo $show->news_title ?>">
            </a>
            <?php //echo anchor('news/read/'.$show->news_seo, '<img class="image_fade" src="'.base_url('images/news/'.$show->news_picture).'" alt="'.$show->news_title.'">', array("data-lightbox"=>"image")); ?>
          </div>

          <div class="entry-c">
            <div class="entry-title">
              <h2><?php echo anchor('news/read/'.$show->news_seo,$show->news_title); ?></h2>
            </div>
            <ul class="entry-meta clearfix">
              <li><i class="icon-calendar3"></i> <?php echo date('j M Y',strtotime($show->news_postdate));?></li>
              <li><i class="icon-user"></i> <?php echo $show->first_name.'&nbsp;'.$show->last_name ?></li>
              <li><i class="icon-folder-open"></i><?php echo $show->media; ?></li>
              <!-- <li><a href="blog-single.html#comments"><i class="icon-comments"></i> 13</a></li> -->
              <!-- <li><a href="#"><i class="icon-camera-retro"></i></a></li> -->
            </ul>
            <!-- <ul class="entry-content clearfix">
              <li>
                <a href="#" class="social-icon si-small si-rounded si-facebook">
                  <i class="icon-facebook"></i>
                  <i class="icon-facebook"></i>
                </a>
              </li>
            </ul> -->
            <div class="entry-content">
              <?php //echo '<p>'.$show->news_headline.'</p>' ?>
              <?php //echo anchor('news/read/'.$show->news_seo, 'Selengkapnya',array("class"=>"more-link")); ?>
            </div>
          </div>
        </div>
      </div>
    <?php endforeach ?>
  </div>
  <div class="sidebar nobottommargin col_last clearfix">
    <div class="sidebar-widgets-wrap clearfix">
      <div class="widget widget_links clearfix">
        <h4>YOUR STORY</h4>
        <?php foreach ($story as $ys):?>
          <div class="spost clearfix">
            <div class="entry-image">
              <a href="#" class="nobg">
                <img class="rounded-circle" src="<?php echo base_url('images/avatar/'.$ys->photo); ?>"/>
              </a>
            </div>
            <div class="entry-c">
              <div class="entry-title">
                <h4><?php echo anchor('story/read/'.$ys->news_seo, $ys->news_title); ?></h4>
                <small><?php echo date('M j Y',strtotime($ys->news_postdate)) ?></small>
              </div>
              <ul class="entry-meta">
                <li><i class="icon-user">&nbsp;<?php echo $ys->first_name.'&nbsp;'.$ys->last_name;?></i></li>
              </ul>
            </div>
          </div>
        <?php endforeach ?>
      </div>
      <div class="widget widget_links clearfix">
        <h4>Terpopuler</h4>
        <div class="spost clearfix faq">
          <div class="entry-c">
            <div class="entry-title">
              <dl class="faq">
                <?php foreach ($popular_day as $pd):?>
                  <?php if ($pd->media==='NEWS'): ?>
                    <dt><h4><?php echo anchor('news/read/'.$pd->news_seo,$pd->news_title); ?></h4></dt>
                  <?php elseif ($pd->media==='INFO GRAFIS'): ?>
                    <dt><h4><?php echo anchor('infografis/read/'.$pd->news_seo,$pd->news_title);?></h4></dt>
                  <?php elseif ($pd->media==='VIDEO'): ?>
                    <dt><h4><?php echo anchor('video/read/'.$pd->news_seo,$pd->news_title);?></h4></dt>
                  <?php elseif ($pd->media==='HOAX or NOT'): ?>
                    <dt><h4><?php echo anchor('hoaxornot/read/'.$pd->news_seo,$pd->news_title);?></h4></dt>
                  <?php elseif ($pd->media==='YOUR STORY'): ?>
                    <dt><h4><?php echo anchor('story/read/'.$pd->news_seo,$pd->news_title);?></h4></dt>
                  <?php else: ?>
                    <dt><h4><?php echo anchor('news/read/'.$pd->news_seo,$pd->news_title); ?></h4></dt>
                  <?php endif ?>
                  <dd><small>Dibaca:&nbsp;<?php echo $pd->news_view ?>&nbsp;kali</small></dd>
                <?php endforeach ?>
              </dl>
            </div>
          </div>
        </div>
      </div>
      <div class="widget widget_links clearfix">
        <h4>Tweet</h4>
        <?php foreach ($tweets->statuses as $tweet) { ?>
          <div class="spost clearfix">
            <div class="entry-image">
              <a class="nobg" href="https://twitter.com/<?php echo $tweet->user->screen_name; ?>" target="_blank">
                <img class="rounded-circle" src="<?php echo $tweet->user->profile_image_url; ?>"/>
              </a>
            </div>
            <div class="entry-c">
              <div class="entry-title">
                <h4><?php echo anchor('https://twitter.com/'.$tweet->user->screen_name,htmlspecialchars('@'.$tweet->user->name),array('target'=>'_blank')); ?></h4>
                <?php 
                $tUrl=$tweet->text;
                echo $tUrl=preg_replace('@(https?://([-\w\.]+)+(/([\w/_\.]*(\?\S+)?(#\S+)?)?)?)@', '<a href="$1" target="_blank">$1</a>', $tUrl); ?>
                <small><br>at <?php echo date('d-m-Y h:i:s',strtotime($tweet->created_at));?></small>
              </div>
            </div>
          </div>
        <?php } ?>
      </div>
      <div class="widget clearfix">
        <div id="fb-root"></div>
        <script>(function(d, s, id) {
          var js, fjs = d.getElementsByTagName(s)[0];
          if (d.getElementById(id)) return;
          js = d.createElement(s); js.id = id;
          js.src = 'https://connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.12&appId=605903289755200&autoLogAppEvents=1';
          fjs.parentNode.insertBefore(js, fjs);
        }(document, 'script', 'facebook-jssdk'));</script>
        <div class="fb-page" data-href="https://www.facebook.com/PKPBerdikari.id/" data-small-header="true" data-adapt-container-width="true" data-hide-cover="false" data-show-facepile="true"><blockquote cite="https://www.facebook.com/PKPBerdikari.id" class="fb-xfbml-parse-ignore"><a href="https://www.facebook.com/PKPBerdikari.id">Kerjakerja</a></blockquote></div>        
      </div>
    </div>
  </div>
</div>
<!-- END NEWS -->
<!-- VIDEO -->
<div class="section dark">
  <div class="container clearfix">
    <h3>VIDEO:</h3>
    <div id="oc-images2" class="owl-carousel image-carousel carousel-widget" data-margin="20" data-pagi="false" data-rewind="true" data-items-xs="1" data-items-sm="2" data-items-md="3" data-items-lg="4" data-items-xl="5">
      <?php foreach ($video as $featured):?>
        <div class="oc-item">
          <div class="ipost clearfix">
            <div class="entry-image">
              <a href="<?php echo site_url('video/read/'.$featured->news_seo) ?>">
                <img src="<?php echo base_url('images/news/'.$featured->news_picture) ?>" class="img-rounded img-responsive" alt="<?php echo $featured->news_title;?>">
              </a>
            </div>
            <div class="entry-title">
              <h4><?php echo anchor('video/read/'.$featured->news_seo, $featured->news_title);?></h4>
            </div>
            <ul class="entry-meta clearfix">
              <li><i class="icon-calendar3"></i> <?php echo date('j M Y - G:i:s T',strtotime($featured->news_postdate));?></li>
              <li><i class="icon-eye"></i> <?php echo $featured->news_view;?>&nbsp;Dibaca</li>
            </ul>
          </div>
        </div>
      <?php endforeach ?>
    </div>
  </div>
</div>
<!-- END VIDEO -->