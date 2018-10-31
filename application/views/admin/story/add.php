<?php $user_id=$this->ion_auth->user()->row()->id; ?>
<div class="row">
  <div class="col-md-12">
    <div class="card">
      <div class="card-header bg-light"><?php echo $title; ?></div>
        <div class="card-body">
          <?php echo form_open('#', array('id'=>'form')); ?>
          <?php echo form_hidden('news_postby', $user_id); ?>
            <div id="info"></div>
            <div class="form-group">
              <label for="">Title</label>
              <input type="text" name="txtTitle" class="form-control" placeholder="Your Story Title" autofocus/>
            </div>
            <div class="form-group">
              <label for="">Headline</label>
              <input type="text" name="txtHeadline" class="form-control" placeholder="Headline (Max 200 char)"/>
              <p><strong><span class="char_input">0</span> character</strong></p>
            </div>
            <div class="form-group">
              <label for="">Content</label>
              <textarea name="txtContent" class="form-control"></textarea>
            </div>
            <div class="form-group">
              <div id="preview_pict" class="picture-src"></div>
            </div>
            <div class="form-group">
              <label for="">Picture</label>
              <input type="file" name="txtPicture" id="wizard-picture"/>
              <p><small><strong>Resolusi Gambar minimum 800x600 (Width x Height => jpg &amp; jpeg)</strong></small></p>
            </div>
            <div class="form-group">
              <button type="button" class="btn btn-primary" onclick="save()">Posting</button>
              <?php echo anchor('dashboard/story', 'Cancel',array('class'=>'btn btn-warning')); ?>
            </div>
          <?php echo form_close();?>
        </div>
  </div>
</div>

<script type="text/javascript">
  count = 0;
  $('input[name="txtHeadline"]').keypress(function(){
    $("span.char_input").text(count += 1);
  });
  tinymce.init({
    selector: 'textarea',
    theme : "modern",
    skin : "lightgray",
    height: 10,
    menubar: false,
    plugins: ['wordcount lists media link image responsivefilemanager code'],
    toolbar: 'bold italic backcolor blockquote | alignleft aligncenter alignright | bullist numlist | superscript | subscript |  removeformat | link |  code',
    image_advtab: false,
    external_filemanager_path:"<?php echo base_url('filemanager/');?>",
    filemanager_title:"Kerjakerja Disk" ,
    external_plugins: { "filemanager" : "<?php echo base_url('filemanager/plugin.min.js');?>"}
  });
  $('#preview_pict').html('<img src="<?php echo base_url('images/no_image.jpg');?>" class="picture-src" id="preview"/>');
  $("#wizard-picture").change(function(){readURL(this);});
  function readURL(input) {
    if (input.files && input.files[0]) {
      var reader = new FileReader();
      reader.onload = function (e) {$('#preview').attr('src', e.target.result).fadeIn('slow').width(1024).height(768);}
      reader.readAsDataURL(input.files[0]);
    }
  }
  function save() {
    tinymce.triggerSave();
    var data = new FormData($('#form')[0]);
    $.ajax({
      url: "<?php echo site_url('dashboard/story/save_story/') ?>",
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
          window.location.href='<?php echo site_url('dashboard/story') ?>';
        }
      }
    })
  }
</script>