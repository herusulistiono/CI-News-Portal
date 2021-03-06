<div class="row">
  <div class="col-md-12">
    <div class="tile">
      <?php echo form_open('dashboard/grafis/update/', array('id'=>'form')); ?>
      <div id="info"></div>
        <?php echo form_hidden('news_id',$news_id); ?>
        <div class="form-group">
          <label for="">Title</label>
          <input type="text" name="txtTitle" class="form-control" value="<?php echo $news_title ?>"/>
        </div>
        <div class="form-group">
          <label for=>Category</label>
          <select name="txtCategory" class="form-control">
            <option value="">--Choose Categories--</option>
            <?php foreach ($categories as $opt): ?>
            <?php 
              if ($category_id==$opt->category_id) {
                $selected='selected="selected"';}
              else{
                $selected='';}
                echo '<option value="'.$opt->category_id.'" '.$selected.'>'.$opt->category_name.'</option>';
              ?>
            <?php endforeach ?>
          </select>
        </div>
        <div class="form-group">
          <label for="">Content</label>
          <textarea name="txtContent" class="form-control"><?php echo $news_content; ?></textarea>
        </div>
        <div class="form-group">
          <img src="<?php echo base_url('images/news/grafis/'.$news_picture);?>" class="img-thumbnail" id="preview"/>
        </div>
        <div class="form-group">
          <label for="">Picture</label>
          <input type="file" name="txtPicture" id="wizard-picture"/>
          <p><small><strong>Resolusi Gambar minimum 600x800 (Width x Height)</strong></small></p>
        </div>
        <div class="form-group">
          <label for=>Status</label>
          <select name="txtStatus" class="form-control">
            <option value="">--Choose Status--</option>
            <?php $status=array('Draft','Publish'); foreach ($status as $opt): ?>
            <?php 
              if ($news_status==$opt) {
                $selected='selected="selected"';}
              else{
                $selected='';}
                echo '<option value="'.$opt.'" '.$selected.'>'.$opt.'</option>';
              ?>
            <?php endforeach ?>
          </select>
        </div>
        <div class="form-group">
          <button type="button" class="btn btn-primary" onclick="update()">Save Change</button>
          <?php echo anchor('dashboard/grafis', 'Cancel',array('class'=>'btn btn-warning')); ?>
        </div>
      <?php echo form_close(); ?>
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
    plugins: ['wordcount lists media image link code'],
    toolbar: 'bold italic backcolor  | alignleft aligncenter alignright | bullist numlist | superscript | subscript |  removeformat | link | code',
    image_advtab: false,
  });
  $("#wizard-picture").change(function(){readURL(this);});
  function readURL(input) {
    if (input.files && input.files[0]) {
      var reader = new FileReader();
      reader.onload = function (e) {$('#preview').attr('src', e.target.result).fadeIn('slow').width(768).height(1024);}
      reader.readAsDataURL(input.files[0]);
    }
  }
  function update() {
    tinymce.triggerSave();
    var data = new FormData($('#form')[0]);
    $.ajax({
      url: "<?php echo site_url('dashboard/grafis/update/') ?>",
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
          window.location.href='<?php echo site_url('dashboard/grafis') ?>';
        }
      }
    })
  }
</script>