<style type="text/css" media="screen">
  .picture-container{
    position: relative;
    cursor: pointer;
    text-align: center;
}
.picture{
    width: 208px;
    height: 208px;
    background-color: #999999;
    border: 4px solid #CCCCCC;
    color: #FFFFFF;
    border-radius: 50%;
    margin: 0px auto;
    overflow: hidden;
    transition: all 0.2s;
    -webkit-transition: all 0.2s;
}
.picture:hover{
    border-color: #ff0000;
}
.picture input[type="file"] {
    cursor: pointer;
    display: block;
    height: 100%;
    left: 0;
    opacity: 0 !important;
    position: absolute;
    top: 0;
    width: 100%;
}
.picture-src{
    width: 100%;
}
</style>

<div class="row">
  <div class="col-md-6">
    <div class="card">
      <div class="card-header bg-light"><?php echo $title; ?></div>
      <div class="card-body">
        <div id="message"></div>
          <?php echo form_open('dashboard/profile/',array('id'=>'form'));?>
            <div class="form-group">
              <div class="picture-container">
                <div class="picture">
                  <div id="avatar"></div>
                  <input type="file" name="txtPicture" id="wizard-picture" data-toggle="tooltip" title="Pilih file"/>
                </div>
              <h6>Allowed file (.jpg, .jpeg .png)</h6>
            </div>
            </div>
            <div class="form-group">
              <?php echo lang('edit_user_fname_label', 'first_name');?>
              <?php echo form_input($first_name);?>
            </div>
            <div class="form-group">
              <?php echo lang('edit_user_lname_label', 'last_name');?>
              <?php echo form_input($last_name);?>
            </div>
            <div class="form-group">
              <?php //echo form_submit('submit', lang('edit_user_submit_btn'),array('class'=>'btn btn-primary'));?>
              <button type="button" class="btn btn-primary" onclick="change_avatar()">Update</button>
              <?php echo anchor('dashboard/home', 'Cancel',array('class'=>'btn btn-warning')); ?>
            </div>
          <?php echo form_close();?>
      </div>
    </div>
  </div>
  <div class="col-md-6">
    <div class="card">
      <div class="card-header bg-light">Change Password</div>
      <div class="card-body">
        <?php echo form_open(uri_string());?>
        <div id="infoMessage"><?php echo $message;?></div>
          <div class="form-group">
            <?php echo lang('edit_user_password_label', 'password');?>
            <?php echo form_input($password);?>
          </div>
          <div class="form-group">
            <?php echo lang('edit_user_password_confirm_label', 'password_confirm');?>
            <?php echo form_input($password_confirm);?>
          </div>
          <div class="form-group">
              <?php echo form_submit('submit', lang('edit_user_submit_btn'),array('class'=>'btn btn-primary'));?>
            <?php echo anchor('dashboard/home', 'Cancel',array('class'=>'btn btn-warning')); ?>
          </div>
          <?php echo form_hidden('id', $user->id);?>
          <?php echo form_hidden($csrf); ?>
        <?php echo form_close();?>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript">
  function readURL(input) {
    if (input.files && input.files[0]) {
      var reader = new FileReader();
      reader.onload = function (e) {
        $('#preview').attr('src', e.target.result).fadeIn('slow');
      }
      reader.readAsDataURL(input.files[0]);
    }
  }
  $(document).ready(function() {
    $('#avatar').html('<img src="<?php echo base_url('images/avatar.png');?>" class="picture-src" id="preview"/>');
    $("#wizard-picture").change(function(){readURL(this);});
  });
  function change_avatar() {
    var data = new FormData($('#form')[0]);
    $.ajax({
      url: "<?php echo site_url('dashboard/profile/change_avatar/') ?>",
      type: 'POST',
      dataType: 'json',
      data: data,
      mimeType: 'multipart/form-data',
      secureuri:false,
      contentType:false,
      cache : false,
      processData:false,
      encode:true,
      success:function (data) {
        console.log(data);
        if (!data.success) {
          if (data.errors) {
            console.log(data.errors);
            $('#message').addClass('alert alert-danger').html(data.errors);
            return false;
          }
        }else{
          $('#message').removeClass('alert alert-danger');
          alert(data.message);
          window.location.href='<?php echo site_url('dashboard/home') ?>';
        }
      }
    })
  }
</script>