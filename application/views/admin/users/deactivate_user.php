<div class="row">
  <div class="col-md-6">
    <div class="card">
      <div class="card-header bg-light"><?php echo lang('deactivate_heading');?></div>
      <div class="card-body">
      	<p><?php echo sprintf(lang('deactivate_subheading'), $user->username);?></p>
		<?php echo form_open("dashboard/users/deactivate/".$user->id);?>
		  <div class="form-group">
		  	<?php echo lang('deactivate_confirm_y_label', 'confirm');?>
		    <input type="radio" name="confirm" value="yes" checked="checked" />
		    <?php echo lang('deactivate_confirm_n_label', 'confirm');?>
		    <input type="radio" name="confirm" value="no" />
		  </div>
		  <?php echo form_hidden($csrf); ?>
		  <?php echo form_hidden(array('id'=>$user->id)); ?>
		  <div class="form-group">
		  	<?php echo form_submit('submit', lang('deactivate_submit_btn'),array('class'=>'btn btn-primary'));?>
		  	<?php echo anchor('dashboard/users', 'Cancel',array('class'=>'btn btn-warning')); ?>
		  </div>
		<?php echo form_close();?>
      </div>
    </div>
  </div>
  <div class="col-md-6"></div>
</div>