<div class="row">
  <div class="col-md-6">
    <div class="card">
      <div class="card-header bg-light"><?php echo $title; ?></div>
      <div class="card-body">
      	<div id="infoMessage"><?php echo $message;?></div>
		<?php echo form_open(current_url());?>
	      <div class="form-group">
	        <?php echo lang('edit_group_name_label','group_name');?>
	        <?php echo form_input($group_name);?>
	      </div>
	      <div class="form-group">
	        <?php echo lang('edit_group_desc_label','description');?>
	        <?php echo form_input($group_description);?>
	      </div>
	      <div class="form-group">
	      	<?php echo form_submit('submit',lang('edit_group_submit_btn'),array('class'=>'btn btn-primary'));?>
	      	<?php echo anchor('dashboard/users', 'Cancel',array('class'=>'btn btn-warning')); ?>
	      </div>
		<?php echo form_close();?>
      </div>
    </div>
  </div>
  <div class="col-md-6"></div>
</div>