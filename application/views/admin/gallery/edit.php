<div class="row">
  <div class="col-md-12">
    <div class="card">
      <div class="card-header bg-light"><?php echo $title; ?></div>
      <div class="card-body">  
        <?php echo form_open('#', array('id'=>'form')); ?>
        <div id="info"></div>
          <?php echo form_hidden('gallery_id',$gallery_id); ?>
          <div class="form-group">
            <label for="">Title</label>
            <input type="text" name="txtTitle" class="form-control" value="<?php echo $gallery_title ?>"/>
          </div>
          <div class="form-group">
            <img src="<?php echo base_url('images/gallery/'.$gallery_file);?>" class=""/>
          </div>
          <div class="form-group">
            <label for="">Picture</label>
            <input type="file" name="txtPicture"/>
          </div>
          <!-- <div class="form-group">
            <label for=>Status</label>
            <select name="txtStatus" class="form-control">
              <option value="">--Choose Status--</option>
              <?php $status=array('Active','Inactive'); foreach ($status as $opt): ?>
              <?php 
                if ($gallery_status==$opt) {
                  $selected='selected="selected"';}
                else{
                  $selected='';}
                  echo '<option value="'.$opt.'" '.$selected.'>'.$opt.'</option>';
                ?>
              <?php endforeach ?>
            </select>
          </div> -->
          <div class="form-group">
            <button type="button" class="btn btn-primary" onclick="update()">Save Change</button>
            <?php echo anchor('dashboard/gallery', 'Cancel',array('class'=>'btn btn-warning')); ?>
          </div>
        <?php echo form_close();?>
      </div>
  </div>
</div>

<script type="text/javascript">
  function update() {
    var data = new FormData($('#form')[0]);
    $.ajax({
      url: "<?php echo site_url('dashboard/gallery/update/') ?>",
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
          window.location.href='<?php echo site_url('dashboard/gallery') ?>';
        }
      }
    })
  }
</script>