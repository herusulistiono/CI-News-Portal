<div class="row">
  <div class="col-md-12">
    <div class="card">
      <div class="card-header bg-light">
        <?php echo $title; ?>
          <div class="text-right">
            <?php echo anchor('dashboard/users/create_user','Add User',array('class'=>'btn btn-primary btn-rounded'));?>
          </div>
        </div>
        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-hover" width="100%">
              <tr>
                <th width="5%">No</th>
                <th>Fullname</th>
                <th>Email</th>
                <th>Role</th>
                <th>Status</th>
                <th>Last Login</th>
                <th>#</th>
              </tr>
              <?php $no=1; foreach ($users as $user):?>
                <tr>
                  <td><?php echo $no++; ?></td>
                  <td><?php echo htmlspecialchars($user->first_name.' '.$user->last_name,ENT_QUOTES,'UTF-8');?></td>
                  <td><?php echo htmlspecialchars($user->email,ENT_QUOTES,'UTF-8');?></td>
                  <td>
                    <?php foreach ($user->groups as $group):?>
                      <?php echo anchor("dashboard/users/edit_group/".$group->id, htmlspecialchars($group->name,ENT_QUOTES,'UTF-8')) ;?>
                    <?php endforeach?>
                  </td>
                  <td><?php echo ($user->active) ? anchor("dashboard/users/deactivate/".$user->id, lang('index_active_link')) : anchor("dashboard/users/activate/". $user->id, lang('index_inactive_link'));?></td>
                  <td><?php echo date('d M Y H:i:s',$user->last_login) ?></td>
                  <td><?php echo anchor("dashboard/users/edit_user/".$user->id, '<i class="fa fa-edit"></i>') ;?></td>
                </tr>
              <?php endforeach;?>
            </table>
          </div>
        </div>
    </div>
  </div>
</div>