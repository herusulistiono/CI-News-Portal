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
    <link rel="stylesheet" href="<?php //echo base_url('assets/css/dark.css')?>" type="text/css"/>
    <link rel="stylesheet" href="<?php echo base_url('assets/css/font-icons.css')?>" type="text/css"/>
    <link rel="stylesheet" href="<?php echo base_url('assets/css/animate.css')?>" type="text/css"/>
    <link rel="stylesheet" href="<?php //echo base_url('assets/css/magnific-popup.css')?>" type="text/css" />
    <link rel="stylesheet" href="<?php echo base_url('assets/css/responsive.css')?>" type="text/css"/>
    <link rel="stylesheet" href="<?php echo base_url('assets/css/notify.css');?>"/>
    <script src="<?php echo base_url('assets/js/jquery.min.js');?>"></script>
  </head>
  <body>
    <section id="content">
		<div class="content-wrap">
			<div class="container clearfix">
				<div class="tabs divcenter nobottommargin clearfix" id="tab-login-register" style="max-width:450px; background-color:#fff;">
					<ul class="tab-nav tab-nav2 center clearfix">
						<li class="inline-block"><a href="#tab-login">SIGN IN</a></li>
						<li class="inline-block"><a href="#tab-register">SIGN UP</a></li>
					</ul>
					<div class="tab-container">
						<div class="tab-content clearfix" id="tab-login">
							<div class="card nobottommargin">
								<div class="card-body" style="padding: 40px;">
									<?php echo form_open('dashboard/auth/login',
										array(
											"class"=>"nobottommargin",
											"name"=>"login",
											"onSubmit"=>"return validate(this)",
											"autocomplete"=>"off")
										); ?>
										<h3><center><img src="<?php echo base_url('images/logo-dark.png');?>"/></center></h3>
										<p class="error"><?php echo $message;?></p>
										<div class="col_full">
											<label class="form-control-label">Email</label>
                  		<?php echo form_input($identity);?>
										</div>
										<div class="col_full">
											<label class="form-control-label">Password</label>
                  		<?php echo form_input($password);?>
										</div>
										<div class="col_full nobottommargin">
											<button type="submit" class="button button-3d button-black nomargin" name="login-form-submit">SIGN IN</button>
											<!-- <a href="#" class="fright">Forgot Password?</a> -->
											<?php echo anchor('dashboard/auth/forgot_password', 'Lost Password',array("class"=>"fright")); ?>
										</div>
									<?php echo form_close(); ?>
								</div>
							</div>
						</div>
						<div class="tab-content clearfix" id="tab-register">
						<div class="card nobottommargin">
							<div class="card-body" style="padding: 40px;">
							<h3><center><img src="<?php echo base_url('images/logo-dark.png');?>"/></center></h3>
								<?php echo form_open('',array("id"=>"register","class"=>"nobottommargin","autocomplete"=>"off")); ?>
								<div class="col_full">
									<label for="register-form-first_name">First Name:</label>
									<input type="text" name="first_name" id="first_name" class="form-control" placeholder="First Name (*)"/>
								</div>
								<div class="col_full">
									<label for="register-form-last_name">Last Name:</label>
									<input type="text" name="last_name" id="last_name" class="form-control" placeholder="Last Name (*)"/>
								</div>
								<div class="col_full">
									<label for="register-form-email">Email Address:</label>
									<input type="text" name="email" id="email" class="form-control" placeholder="Email (*)"/>
								</div>
								<div class="col_full">
									<label for="register-form-phone">Phone:</label>
									<input type="text" name="phone" id="phone" class="form-control" minlength="8" maxlength="20" class="form-control" placeholder="Phone (*)"/>
								</div>
								<div class="col_full">
									<label for="register-form-password">Password:</label>
									<input type="text" name="password" id="password" class="form-control" minlength="8" maxlength="20" placeholder="Password (*)"/>
								</div>
								<div class="col_full">
									<label for="register-form-password">Retype Password:</label>
									<input type="text" name="password_confirm" id="password_confirm" class="form-control" placeholder="Retype Password (*)"/>
								</div>

								<div class="col_full nobottommargin">
									<button type="button" class="button button-3d button-black nomargin" onclick="validate_register()">Register Now</button>
								</div>
								<?php echo form_close(); ?>
							</div>
						</div>
						</div>
					</div>
					<?php echo anchor('/', '<i class="fa fa-angle-double-right"></i> Back to Site'); ?>
				</div>
			</div>
		</div>
	</section>
  
  <script src="<?php echo base_url('assets/js/plugins.js');?>"></script>
  <script src="<?php echo base_url('assets/js/functions.js');?>"></script>
  <script src="<?php echo base_url('assets/js/bootstrap-notify.min.js');?>"></script>
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
    function validate_register(){
    $.ajax({
      url: "<?php echo site_url('register/create_account') ?>",
      type: 'POST',
      dataType: 'json',
      data: $('#register').serialize(),
      encode:true,
      success:function (data) {
        console.log(data);
        if (!data.success) {
          if (data.errors) {
            console.log(data.errors);
            var email = document.getElementById('email');
    				var filter = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
    				var numbers = /^[0-9]+$/;
            if ($('#first_name').val() == ""){
							$.notify({
						    message: "Please Enter Your First Name",
						    icon: 'fa fa-warning' 
						  },{
						    type: "danger"
						  });
						  $('#first_name').focus();
						  return false;
						}
						if ($('#last_name').val() == ""){
							$.notify({
						    message: "Please Enter Your Last Name",
						    icon: 'fa fa-warning' 
						  },{
						    type: "danger"
						  });
						  $('#last_name').focus();
						  return false;
						}
						if ($('#email').val() == ""){
							$.notify({
						    message: "Please Enter Your Email",
						    icon: 'fa fa-warning' 
						  },{
						    type: "danger"
						  });
						  $('#email').focus();
						  return false;
						}
						else if (!filter.test(email.value)) {
							$.notify({
						    message: "Please Enter Valid Email",
						    icon: 'fa fa-warning' 
						  },{
						    type: "danger"
						  });
							$('#email').focus();
							return false;
						}
						if ($('#phone').val() == ""){
							$.notify({
						    message: "Please Enter Your Phone Number",
						    icon: 'fa fa-warning' 
						  },{
						    type: "danger"
						  });
						  $('#phone').focus();
						  return false;
						}
						/*else if($('input[name="phone"]').val().match(numbers)){
      				$.notify({
						    message: "Please Enter a Valid Phone Number",
						    icon: 'fa fa-warning' 
						  },{
						    type: "danger"
						  });
						  $('#phone').focus();
						  return false;
      			}*/
						if ($('#password').val() == ""){
						  $.notify({
						    message: "Please Enter Password",
						    icon: 'fa fa-warning' 
						  },{
						    type: "danger"
						  });
						  $('#password').focus();
						  return false;
						}
						else if($('#password').val().length < 8){
						  $.notify({
						    message: "Password must be at least 8 characters long",
						    icon: 'fa fa-warning' 
						  },{
						    type: "danger"
						  });
						  $('#password').focus();
						  return false;
						}
						if ($('#password').val() != $('#password_confirm').val()){
						  $.notify({
						    message: "Passwords Don't Match",
						    icon: 'fa fa-warning' 
						  },{
						    type: "danger"
						  });
						  $('#password_confirm').focus();
						  return false;
						}
						return (true);
          }
        }else{
          alert(data.message);
          window.location.reload();
        }
      }
    })
  }
  </script>
  </body>
</html>