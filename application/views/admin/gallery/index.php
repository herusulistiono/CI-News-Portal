<div class="row">
  <div class="col-md-12">
    <div class="card">
      <div class="card-header bg-light">
        <?php echo $title; ?>
        <div class="text-right"><?php echo anchor('dashboard/gallery/add','Add Gallery',array('class'=>'btn btn-primary btn-rounded'));?></div>
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <table id="gallery_data" class="table table-hover" width="100%">
            <thead>
              <tr>
                <th width="5%">No</th>
                <th>Picture</th>
                <th>Title</th>
                <th>Uploaded</th>
                <!-- <th>Status</th> -->
                <th class="no-sort">#</th>
              </tr>
            </thead>
            <tbody></tbody>
          </table>
        </div>
      </div>
  </div>
</div>
<script type="text/javascript">
  function active(gallery_id) {
    if (confirm('Are you sure want to Activated ?')) {
      $.ajax({
        url: '<?php echo site_url('dashboard/gallery/active_slider') ?>',
        type: 'POST',
        dataType: 'json',
        data: 'gallery_id='+gallery_id,
        encode:true,
        success:function (data) {
          if (!data.success) {
            if (data.errors) {setTimeout(function () {$('#info').html(data.errors);},1000);}
          }else{
            $('#info').addClass('alert alert-success').html(data.message);
            window.location.reload();
          }
        }
      });
    }
  }
  function inactive(gallery_id) {
    if (confirm('Are you sure want to Inactivate ?')) {
      $.ajax({
        url: '<?php echo site_url('dashboard/gallery/inactive_slider') ?>',
        type: 'POST',
        dataType: 'json',
        data: 'gallery_id='+gallery_id,
        encode:true,
        success:function (data) {
          if (!data.success) {
            if (data.errors) {setTimeout(function () {$('#info').html(data.errors);},1000);}
          }else{
            $('#info').addClass('alert alert-success').html(data.message);
            window.location.reload();
          }
        }
      });
    }
  }
  $('#gallery_data').DataTable({
    "processing": true,
    "ajax": {
      "url": "<?php echo site_url('dashboard/gallery/get_gallery/') ?>",
      "type": "POST"
    },
    "sPaginationType": "full_numbers",
  "lengthMenu": [[15,50,100,500, -1], [15,50,100,500, "All"]],
  "order":[[0,"asc" ]],
    "columnDefs": [
      {"className":"hidden-phone","aTargets":[0]},
      {"bVisible": true,},
      {"bSortable": false,"aTargets": ["no-sort"]},
    ]
  });
</script>