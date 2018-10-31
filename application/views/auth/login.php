<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <title><?php echo $title; ?></title>
    <link rel="shortcut icon" href="<?php echo base_url('images/favicon.ico') ?>" type="image/x-icon">
    <link rel="icon" href="<?php echo base_url('images/favicon.ico') ?>" type="image/x-icon">
    <!-- Main CSS-->
    <link rel="stylesheet" href="<?php echo base_url('assets/js/font-awesome/css/font-awesome.min.css');?>">
    <link rel="stylesheet" href="<?php echo base_url('dist/css/styles.css');?>"/>
    <link rel="stylesheet" href="<?php echo base_url('dist/css/notify.css');?>"/>
    <style type="text/css">
      .error{color: red;}
    </style>
  </head>
  <body onload="document.login.identity.focus();">
    <div class="page-wrapper flex-row align-items-center">
      <div class="container">
        <div class="row justify-content-center">
          <div class="col-md-5">
            <div class="card p-4">
              <div class="card-header text-center text-uppercase h4 font-weight-light"><img src="<?php echo base_url('images/logo.png');?>" alt="logo"></div>
              <?php echo form_open('dashboard/auth/login',array("name"=>"login","onSubmit"=>"return validate(this)","autocomplete"=>"off")); ?>
              <div class="card-body">
                <p class="error"><?php echo $message;?></p>
                <div class="form-group">
                  <label class="form-control-label">Email</label>
                  <?php echo form_input($identity);?>
                </div>
                <div class="form-group">
                  <label class="form-control-label">Password</label>
                  <?php echo form_input($password);?>
                </div>
                <div class="custom-control custom-checkbox mt-4">
                  <input type="checkbox" name="remember" value="1" class="custom-control-input" id="login"/>
                  <label class="custom-control-label" for="login">Remember Me</label>
                  <?php echo anchor('dashboard/auth/forgot_password', 'Lost Password',array("class"=>"float-right")); ?>
                </div>
              </div>
              <div class="card-footer">
                <div class="row">
                  <div class="col-12"><button type="submit" class="btn btn-primary btn-block">Login</button></div>
                  <div class="custom-control custom-checkbox mt-4">
                    <?php echo anchor('/', '<i class="fa fa-angle-double-right"></i> Back to Site', 'attributes'); ?>
                  </div>
                </div>
              </div>
              <?php echo form_close(); ?>
            </div>
          </div>
        </div>
      </div>
    </div>
    <script src="<?php echo base_url('dist/vendor/jquery/jquery.min.js');?>"></script>
    <script src="<?php echo base_url('dist/vendor/popper.js/popper.min.js');?>"></script>
    <script src="<?php echo base_url('dist/vendor/bootstrap/js/bootstrap.min.js');?>"></script>
    <script src="<?php echo base_url('dist/vendor/bootstrap/js/bootstrap-notify.min.js');?>"></script>
    <script src="<?php echo base_url('dist/js/sweetalert.min.js');?>"></script>

    <script type="text/javascript">
      function validate(form){
        if (form.identity.value == ""){
          $.notify({
            message: "Please Enter Your E-mail",
            icon: 'fa fa-warning' 
          },{
            type: "danger"
          });
          form.identity.focus();
          return false;
        }
        if (form.password.value == ""){
          $.notify({
            message: "Please Enter Your Password",
            icon: 'fa fa-warning' 
          },{
            type: "danger"
          });
          form.password.focus();
          return false;
        }
        return (true);
      }
  </script>
  </body>
</html>