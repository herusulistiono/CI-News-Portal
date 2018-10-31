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
            <input type="text" name="txtTitle" class="form-control" placeholder="Title" autofocus/>
          </div>
          <div class="form-group">
            <label for="">Picture</label>
            <input type="file" name="txtPicture"/>
          </div>
          <div class="form-group">
            <button type="button" class="btn btn-primary" onclick="save()">Posting</button>
            <?php echo anchor('dashboard/gallery','Cancel',array('class'=>'btn btn-warning')); ?>
          </div>
        <?php echo form_close();?>
      </div>
  </div>
</div>
<script type="text/javascript">
  function save() {
    var data = new FormData($('#form')[0]);
    $.ajax({
      url: "<?php echo site_url('dashboard/gallery/save/') ?>",
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
          window.location.reload();
        }
      }
    })
  }
</script>