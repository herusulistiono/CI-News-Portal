<div class="card">
  <div class="card-header bg-light"><?php echo $title; ?></div>
  <div class="card-body">
    <div id="message"></div>
      <?php echo form_open('dashboard/setting/save/',array('id'=>'form'));?>
        <?php echo form_hidden('txtId',$web_id); ?>
        <div class="form-group">
          <label>Title:</label>
          <input type="text" name="txtTitle" class="form-control" value="<?php echo $web_title ?>" autofocus="autofocus"/>
        </div>
        <div class="form-group">
          <label>Content:</label>
          <textarea name="txtContent" class="form-control"><?php echo $web_content ?></textarea>
        </div>
        <div class="form-group">
          <label>Picture</label>
          <input type="file" name="txtPicture"/>
        </div>
        <div class="form-group">
          <button type="button" class="btn btn-primary" onclick="change_update()">Update</button>
          <?php echo anchor('dashboard/home', 'Cancel',array('class'=>'btn btn-warning')); ?>
        </div>
      <?php echo form_close();?>
  </div>
</div>
<script type="text/javascript">
  tinymce.init({
    selector: 'textarea',
    theme : "modern",
    skin : "lightgray",
    height: 25,
    menubar: false,
    plugins: ['wordcount lists media image link responsivefilemanager code'],
    toolbar: 'bold italic backcolor blockquote | alignleft aligncenter alignright | bullist numlist | superscript | subscript |  removeformat | link responsivefilemanager | code',
    image_advtab: false,
    external_filemanager_path:"<?php echo base_url('filemanager/');?>",
    filemanager_title:"Kerjakerja Disk" ,
    external_plugins: { "filemanager" : "<?php echo base_url('filemanager/plugin.min.js');?>"}
  });
  function change_update() {
    tinymce.triggerSave();
    var data = new FormData($('#form')[0]);
    $.ajax({
      url: "<?php echo site_url('dashboard/setting/change_update/') ?>",
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
            $('#info').addClass('alert alert-danger').html(data.errors);
            return false;
          }
        }else{
          $('#info').removeClass('alert alert-danger');
          alert(data.message);
          window.location.href='<?php echo site_url('dashboard/setting/') ?>';
        }
      }
    })
  }
</script>