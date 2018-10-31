<div class="row">
  <div class="col-md-6">
    <div class="card">
      <div class="card-header bg-light"><?php echo $title; ?></div>
      <div class="card-body">
        <div id="infoMessage"><?php echo $message;?></div>
          <?php echo form_open("dashboard/users/create_user",array("onSubmit"=>"return validate(this)"));?>
          <div class="form-group">
            <?php echo lang('create_user_fname_label', 'first_name');?>
            <?php echo form_input($first_name);?>
          </div>
          <div class="form-group">
            <?php echo lang('create_user_lname_label', 'last_name');?>
            <?php echo form_input($last_name);?>
          </div>
          <?php
          if($identity_column!=='email') {
            echo '<div class="form-group">';
            echo lang('create_user_identity_label', 'identity');
            echo form_error('identity');
            echo form_input($identity);
            echo '</div>';
          }?>
          <div class="form-group">
            <?php echo lang('create_user_company_label', 'company');?>
            <?php echo form_input($company);?>
          </div>
          <div class="form-group">
            <?php echo lang('create_user_email_label', 'email');?>
            <?php echo form_input($email);?>
          </div>
          <div class="form-group">
            <?php echo lang('create_user_phone_label', 'phone');?>
            <?php echo form_input($phone);?>
          </div>
          <div class="form-group">
            <?php echo lang('create_user_password_label', 'password');?>
            <?php echo form_input($password);?>
          </div>
          <div class="form-group">
            <?php echo lang('create_user_password_confirm_label', 'password_confirm');?>
            <?php echo form_input($password_confirm);?>
          </div>
          <div class="form-group">
            <?php echo form_submit('submit', lang('create_user_submit_btn'),array('class'=>'btn btn-primary'));?>
            <?php echo anchor('dashboard/users', 'Cancel',array('class'=>'btn btn-warning')); ?>
          </div>
        <?php echo form_close();?>
      </div>
    </div>
  </div>
  <div class="col-md-6"></div>
</div>
<script type="text/javascript">
  function validate(form){
    if (form.first_name.value == ""){
      $.notify({
        message: "Please Enter Firstname",
        icon: 'fa fa-warning' 
      },{
        type: "danger"
      });
      form.first_name.focus();
      return false;
    }
    if (form.last_name.value == ""){
      $.notify({
        message: "Please Enter Lastname",
        icon: 'fa fa-warning' 
      },{
        type: "danger"
      });
      form.last_name.focus();
      return false;
    }
    if (form.email.value == ""){
      $.notify({
        message: "Please Enter Email",
        icon: 'fa fa-warning' 
      },{
        type: "danger"
      });
      form.email.focus();
      return false;
    }
    if (form.password.value == ""){
      $.notify({
        message: "Please Enter Password",
        icon: 'fa fa-warning' 
      },{
        type: "danger"
      });
      form.password.focus();
      return false;
    }
    if (form.password_confirm.value == ""){
      $.notify({
        message: "Please Enter Confirm Password",
        icon: 'fa fa-warning' 
      },{
        type: "danger"
      });
      form.password_confirm.focus();
      return false;
    }
    return (true);
  }
</script>