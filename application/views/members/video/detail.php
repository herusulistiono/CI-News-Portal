<div class="container clearfix">
  <div class="postcontent nobottommargin clearfix">
    <div class="single-post nobottommargin">
      <div class="entry clearfix">
        <div class="entry-title">
          <h2><?php echo $news_title;?></h2>
        </div>
        <ul class="entry-meta clearfix">
          <li><i class="icon-calendar"></i> <?php echo $news_postdate; ?></li>
          <li><i class="icon-user"></i> <?php echo $news_postby; ?></li>
          <li><i class="icon-folder-open"></i><?php echo $news_media; ?></li>
          <li><i class="icon-eye"></i> <?php echo $news_view ?> Dibaca</li>
        </ul>
        <div class="entry-content notopmargin">
          <!-- <div class="entry-image">
            <a class="" href="<?php echo base_url('images/news/'.$news_picture);?>" data-lightbox="image">
              <img class="image_fade img-responsive" src="<?php echo base_url('images/news/'.$news_picture);?>"/>
            </a>
          </div> -->
          <?php echo $news_content; ?>
          <div class="clear"></div>
          <div class="si-share clearfix">
          <span>Share this Post:</span>
            <div>
              <?php 
                $facebookURL='https://www.facebook.com/sharer/sharer.php?u='.base_url('news/read/'.$news_seo); 
                $twitterURL='https://twitter.com/intent/tweet?text='.$news_title.'&amp;url='.base_url('news/read/'.$news_seo);
                $whatsappURL = 'whatsapp://send?text='.$news_title. ' ' . base_url('news/read/'.$news_seo);
                $emailURL='mailto:?subject='.$news_title.'&body='.base_url('news/read/'.$news_seo);
                $lineURL ='http://www.addtoany.com/add_to/line?linkurl='.$news_title.'';
                $instagramURL ='https://www.instagram.com/Kerjakerjadotid/'.$news_seo;
                $telegramURL ='https://telegram.me/share/url?url='.base_url('news/read/'.$news_seo).'&text='.$news_title;
                $gplusURL ='https://plus.google.com/share?url='.$news_seo.'';
              ?>
              <a href="javascript:void(0)" onclick="SocialShare('<?php echo $facebookURL ?>')" class="social-icon si-rounded si-facebook"><i class="icon-facebook"></i><i class="icon-facebook"></i></a>
              <a href="javascript:void(0)" onclick="SocialShare('<?php echo $twitterURL ?>')" class="social-icon si-rounded si-twitter"><i class="icon-twitter"></i><i class="icon-twitter"></i></a>
              <a href="javascript:void(0)" onclick="SocialShare('<?php echo $whatsappURL ?>')" class="social-icon si-rounded si-call"><i class="icon-call"></i><i class="icon-call"></i></a>
              <a href="javascript:void(0)" onclick="SocialShare('<?php echo $telegramURL ?>')" class="social-icon si-rounded si-telegram"><i class="icon-telegram"></i><i class="icon-telegram"></i></a>
            </div>
          </div>
          <div class="line"></div>
          <div class="card">
            <div class="card-header"><strong>Penulis <a href="#"><?php echo $news_postby; ?></a></strong></div>
              <div class="card-body">
                <div class="author-image">
                  <img src="<?php echo base_url('images/avatar/'.$photo); ?>" alt="" class="rounded-circle">
                </div>
              </div>
          </div>
          <div class="line"></div>
        </div>
      </div>
    </div>
  </div>
  <div class="sidebar nobottommargin col_last clearfix">
    <div class="sidebar-widgets-wrap">
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
                <?php //echo $tweet->text ?>
                <?php 
                $tUrl=$tweet->text;
                echo $tUrl=preg_replace('@(https?://([-\w\.]+)+(/([\w/_\.]*(\?\S+)?(#\S+)?)?)?)@', '<a href="$1" target="_blank">$1</a>', $tUrl); ?>
                <small><br>at <?php echo date('d-m-Y h:i:s',strtotime($tweet->created_at));?></small>
              </div>
            </div>
          </div>
        <?php } ?>
      </div>
      <div class="widget widget_links clearfix">
        <div id="fb-root"></div>
        <script>(function(d, s, id) {
          var js, fjs = d.getElementsByTagName(s)[0];
          if (d.getElementById(id)) return;
          js = d.createElement(s); js.id = id;
          js.src = 'https://connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.12&appId=605903289755200&autoLogAppEvents=1';
          fjs.parentNode.insertBefore(js, fjs);
        }(document, 'script', 'facebook-jssdk'));</script>
        <div class="fb-page" data-href="https://www.facebook.com/KerjakerjadotidKerjakerja-112760239580644/" data-small-header="true" data-adapt-container-width="true" data-hide-cover="false" data-show-facepile="true"><blockquote cite="https://www.facebook.com/Kerjakerja-112760239580644/" class="fb-xfbml-parse-ignore"><a href="https://www.facebook.com/Kerjakerja-112760239580644/">Kerjakerja</a></blockquote></div>
      </div>
    </div>
  </div>
</div>
<script type="text/javascript">
  function SocialShare(url){
    window.open(url,'sharer','toolbar=0,status=0,width=648,height=395');
    return true;
  }
</script>