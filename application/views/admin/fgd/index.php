<div class="row">
  <div class="col-md-12">
    <div class="card">
      <div class="card-header bg-light">
        <?php echo $title; ?>
        <div class="text-right"><?php echo anchor('dashboard/fgd/add', 'Create New',array('class'=>'btn btn-primary btn-rounded')); ?></div></div>
        <div class="card-body">
          <div class="table-responsive">
            <table id="news_data" class="table table-hover" width="100%">
              <thead>
                <tr>
                  <th width="5%">No</th>
                  <th>Title</th>
                  <th>Categories</th>
                  <th>Author</th>
                  <th>Date Post</th>
                  <th>Read</th>
                  <th>Status</th>
                  <th width="8%" class="no-sort">#</th>
                </tr>
              </thead>
              <tbody></tbody>
            </table>
          </div>
        </div>
    </div>
  </div>
</div>
<script type="text/javascript">
  function deleted(news_id) {
    if (confirm('Are you sure want to delete?')) {
      $.ajax({
          url: '<?php echo site_url('dashboard/news/delete') ?>',
          type: 'POST',
          dataType: 'json',
          data: 'news_id='+news_id,
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
  function publish(news_id) {
    if (confirm('Are you sure ?')) {
        $.ajax({
            url: '<?php echo site_url('dashboard/news/publish') ?>',
            type: 'POST',
            dataType: 'json',
            data: 'news_id='+news_id,
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
  function unpublish(news_id) {
    if (confirm('Are you sure ?')) {
        $.ajax({
            url: '<?php echo site_url('dashboard/news/unpublish') ?>',
            type: 'POST',
            dataType: 'json',
            data: 'news_id='+news_id,
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
  $('#news_data').DataTable({
    "processing": true,
    "ajax": {
        "url": "<?php echo site_url('dashboard/fgd/get_all_news/') ?>",
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