<?php $user_id=$this->ion_auth->user()->row()->id; ?>
<div class="row">
  <div class="col-md-12">
   <div class="card">
      <div class="card-header bg-light"><?php echo $title; ?></div>
      <div class="card-body">
        <?php echo form_open('dashboard/video/save_video/', array('id'=>'form')); ?>
        <?php echo form_hidden('news_postby', $user_id); ?>
        <div id="info"></div>
          <div class="form-group">
            <label>Title</label>
            <input type="text" name="txtTitle" class="form-control" placeholder="Title" autofocus/>
          </div>
           <div class="form-group">
              <label>Headline</label>
              <input type="text" name="txtHeadline" class="form-control" placeholder="Headline (Max 200 char)"/>
            </div>
          <div class="form-group">
            <label>Content</label>
            <textarea name="txtContent" class="form-control"></textarea>
          </div>
          <div class="form-group">
            <label>Picture Headline:</label>
            <input type="file" name="txtPicture"/>
            <p><small><strong>Resolusi Gambar minimum 800x600 (Width x Height) .jpg .jpeg</strong></small></p>
          </div>
          <div class="form-group">
            <label>Active on Headline</label>
            <?php $status=array('Active','Inactive'); foreach ($status as $opt):?>
                <?php if ($opt=='Inactive'): ?>
                  <?php echo '<div class="radio"><label><input type="radio" name="txtStatus" value="'.$opt.'" checked>'.$opt.'</label></div>'; ?>
                <?php else: ?>
                  <?php echo '<div class="radio"><label><input type="radio" name="txtStatus" value="'.$opt.'">'.$opt.'</label></div>'; ?>
                <?php endif ?>
              <?php endforeach ?>
          </div>
          <div class="form-group">
            <button type="button" class="btn btn-primary" onclick="save()">Posting</button>
            <?php echo anchor('dashboard/video','Cancel',array('class'=>'btn btn-warning')); ?>
          </div>
        <?php echo form_close();?>
      </div>
  </div>
</div>
<script type="text/javascript">
  tinymce.init({
    selector: 'textarea',
    theme : "modern",
    skin : "lightgray",
    height: 10,
    menubar: false,
    plugins: ['wordcount lists media image link responsivefilemanager code'],
    toolbar: 'bold italic backcolor blockquote | alignleft aligncenter alignright | bullist numlist | superscript | subscript |  removeformat | media image link | code',
    image_advtab: false,
    external_filemanager_path:"<?php echo base_url('filemanager/');?>",
    filemanager_title:"Kerjakerja Disk" ,
    external_plugins: { "filemanager" : "<?php echo base_url('filemanager/plugin.min.js');?>"}
  });
  function save() {
    tinymce.triggerSave();
    //var data = $('#form').serialize();
    var data = new FormData($('#form')[0]);
    $.ajax({
      url: "<?php echo site_url('dashboard/video/save_video/') ?>",
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
          window.location.href='<?php echo site_url('dashboard/video') ?>';
        }
      }
    })
      
  }
</script>