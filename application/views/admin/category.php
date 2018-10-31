<div class="row">
  <div class="col-md-6">
    <div class="card">
      <div class="card-header bg-light">Add New Category</div>
      <div class="card-body">
        <?php echo form_open('dashboard/category/save',array('id'=>'form')); ?>
        <div id="info"></div>
        <?php echo form_hidden('txtId'); ?>
        <div class="form-group">
          <label>Name</label>
          <input type="text" name="txtName" class="form-control" placeholder="Name" autofocus="autofocus"/>
        </div>
        <button type="button" class="btn btn-primary btn-block save" onclick="save()">Add New Category</button>
        <button type="button" class="btn btn-warning btn-block update" onclick="update()">Change Category</button>
        <?php echo form_close(); ?>
      </div>
    </div>
  </div>
  <div class="col-md-6">
    <div class="card">
      <div class="card-header bg-light">Categories</div>
      <div class="card-body">
        <table id="category_data" class="table table-hover">
          <thead>
            <tr>
              <th width="5%">No</th>
              <th>Name</th>
              <th>Slug</th>
              <th>Count</th>
              <th width="3%" class="no-sort">#</th>
            </tr>
          </thead>
          <tbody></tbody>
        </table>
      </div>
    </div>
  </div>
</div>
<script type="text/javascript">
  $('.update').hide();
  function edit(category_id) {
    $.ajax({
      url: '<?php echo site_url('dashboard/category/get_by_id/') ?>',
      type: 'POST',
      dataType: 'json',
      data: 'category_id='+category_id,
      encode:true,
      success:function(data) {
        $('.update').show();
        $('.save').hide();
        $('input[name="txtId"]').val(data.category_id);
        $('input[name="txtName"]').val(data.category_name);
      }
    });
  }
  function save() {
    $.ajax({
      url: '<?php echo site_url('dashboard/category/save/') ?>',
      type: 'POST',
      dataType: 'json',
      data:$('#form').serialize(),
      encode:true,
      success:function(data) {
        if(!data.success){
          if(data.errors){
            $('#info').html(data.errors).addClass('alert alert-danger');
            $('input[name="txtName"]').focus();
            return false;
          }
        }else{
          $('#info').removeClass('alert alert-danger');
          alert(data.message);
          window.location.reload();
        }
      }
    });
  }
  function update() {
    $.ajax({
        url: '<?php echo site_url('dashboard/category/update/') ?>',
        type: 'POST',
        dataType: 'json',
        data: $('#form').serialize(),
        encode:true,
        success:function (data) {
          if(!data.success){
            if(data.errors){
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
  $('#category_data').DataTable({
    "processing": true,
    "ajax": {
        "url": "<?php echo site_url('dashboard/category/get_category/') ?>",
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