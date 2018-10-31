<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <!-- <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0"> -->
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <title><?php echo $title; ?></title>
    <link rel="shortcut icon" href="<?php echo base_url('images/favicon.ico') ?>" type="image/x-icon">
    <link rel="icon" href="<?php echo base_url('images/favicon.ico') ?>" type="image/x-icon">
    <!-- Main CSS-->
    <style type="text/css">
      .error{color: red;}
    </style>
    <link rel="stylesheet" href="<?php echo base_url('assets/css/font-awesome.min.css')?>" type="text/css"/>
    <link rel="stylesheet" href="<?php echo base_url('assets/css/bootstrap.css')?>" type="text/css"/>
    <link rel="stylesheet" href="<?php echo base_url('assets/style.css')?>" type="text/css"/>
    <link rel="stylesheet" href="<?php echo base_url('assets/css/font-icons.css')?>" type="text/css"/>
    <link rel="stylesheet" href="<?php echo base_url('assets/css/animate.css')?>" type="text/css"/>
    <link rel="stylesheet" href="<?php echo base_url('assets/css/responsive.css')?>" type="text/css"/>
    <link rel="stylesheet" href="<?php echo base_url('assets/css/notify.css');?>"/>
    <script src="<?php echo base_url('assets/js/jquery.min.js');?>"></script>
  </head>
  <body onload="document.login.identity.focus();">
	<section id="content">
      <div class="content-wrap">
        <div class="container clearfix">
          <div class="divcenter nobottommargin clearfix col-md-5">
            <div class="card p-4">
              <div class="text-center"><img src="<?php echo base_url('images/logo-dark.png');?>"/></div>
              <?php echo form_open('dashboard/auth/reset_password/' . $code);?>
              <?php //echo form_open('dashboard/auth/forgot_password',array("name"=>"login","onSubmit"=>"return validate(this)","autocomplete"=>"off")); ?>
              <div class="card-body">
                <p class="error"><?php echo $message;?></p>
                <div class="col_full">
                  <label for="new_password"><?php echo sprintf(lang('reset_password_new_password_label'), $min_password_length);?></label>
					<?php echo form_input($new_password);?>
                </div>
                <div class="col_full">
                	<?php echo lang('reset_password_new_password_confirm_label', 'new_password_confirm');?>
					<?php echo form_input($new_password_confirm);?>
                </div>
                <div class="col_full nobottommargin">
                  <button type="submit" class="button button-3d button-black nomargin btn-block"><i class="fa fa-unlock fa-lg fa-fw"></i>CHANGE</button>
                </div>
              </div>
              <?php echo form_close(); ?>
            </div>
          </div>
        </div>
      </div>
    </section>
  <script src="<?php echo base_url('assets/js/plugins.js');?>"></script>
  <script src="<?php echo base_url('assets/js/functions.js');?>"></script>
  <script src="<?php echo base_url('assets/js/bootstrap-notify.min.js');?>"></script>

</body>
</html>