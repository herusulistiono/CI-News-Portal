<div class="container">
  <div class="row">
    <div class="col-md-12">
      <div class="my-2">&nbsp;</div> 
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="#"><i class="fa fa-home"></i></a></li>
          <li class="breadcrumb-item active" aria-current="page"><?php echo $title; ?></li>
        </ol>
      </nav>
    </div>
    <div class="col-md-8">
      <table id="category_data" class="table table-hover">
        <thead>
          <tr>
            <th>Author</th>
            <th>Email</th>
            <th>Date</th>
            <th width="3%" class="no-sort">#</th>
          </tr>
        </thead>
        <tbody></tbody>
      </table>
    </div>
    <div class="col-md-4"></div>
  </div>
</div>
<script type="text/javascript">
  $('#comment_data').DataTable({
    "processing": true,
    "ajax": {
      "url": "<?php echo site_url('comment/get_comment/') ?>",
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