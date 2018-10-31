<div class="row">
  <div class="col-md-6">
    <div class="card">
      <div class="card-header bg-light"><?php echo $title; ?></div>
      <div class="card-body">
        <div id="infoMessage"><?php echo $message;?></div>
        <?php echo form_open(uri_string());?>
          <div class="form-group">
            <?php echo lang('edit_user_fname_label', 'first_name');?>
            <?php echo form_input($first_name);?>
          </div>
          <div class="form-group">
            <?php echo lang('edit_user_lname_label', 'last_name');?>
            <?php echo form_input($last_name);?>
          </div>
          <div class="form-group">
            <?php echo lang('edit_user_company_label', 'company');?>
            <?php echo form_input($company);?>
          </div>
          <div class="form-group">
            <?php echo lang('edit_user_phone_label', 'phone');?>
            <?php echo form_input($phone);?>
          </div>
          <div class="form-group">
            <?php echo lang('edit_user_password_label', 'password');?>
            <?php echo form_input($password);?>
          </div>
          <div class="form-group">
            <?php echo lang('edit_user_password_confirm_label', 'password_confirm');?>
            <?php echo form_input($password_confirm);?>
          </div>
          <?php if ($this->ion_auth->is_admin()): ?>
            <h3><?php echo lang('edit_user_groups_heading');?></h3>
            <?php foreach ($groups as $group):?>
              <label class="checkbox">
                <?php
                  $gID=$group['id'];
                  $checked = null;
                  $item = null;
                  foreach($currentGroups as $grp) {
                    if ($gID == $grp->id) {
                      $checked= ' checked="checked"';
                      break;
                    }
                  }
                ?>
              <input type="checkbox" name="groups[]" value="<?php echo $group['id'];?>"<?php echo $checked;?>>
              <?php echo htmlspecialchars($group['name'],ENT_QUOTES,'UTF-8');?>
              </label>
            <?php endforeach?>
          <?php endif ?>
          <?php echo form_hidden('id', $user->id);?>
          <?php echo form_hidden($csrf); ?>
          <div class="form-group">
            <?php echo form_submit('submit', lang('edit_user_submit_btn'),array('class'=>'btn btn-primary'));?>
            <?php echo anchor('dashboard/users', 'Cancel',array('class'=>'btn btn-warning')); ?>
          </div>
        <?php echo form_close();?>
      </div>
    </div>
  </div>
  <div class="col-md-6"></div>
</div>