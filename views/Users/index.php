<div class="table-responsive">
  <h1>All Users</h1>
   <table class="table table-bordered table-striped table-hover">
    <thead>
    <tr>
      <th>#</th>
      <th>Username</th>
      <th>Email</th>
      <th>Location</th>
      <th>Date of birth</th>
      <th>Role</th>
      <th>Deactivated</th>
      <th>Actions</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach($viewModel as $item) :?>
      <?php $is_deactivated = $item['is_deactivated'];
      $is_deactivated = ($is_deactivated == '') ? 'active' : 'not-active';
      ?>

      <tr>
        <th scope="row"><?php echo $item['user_id']; ?></th>
        <td><?php echo $item['username']; ?></td>
        <td><?php echo $item['email']; ?></td>
        <td><?php echo $item['city'] . ', ' . $item['country'] ?></td>
        <td><?php echo $item['date_of_birth']; ?></td>
        <td><?php echo $item['role_name']; ?></td>
        <td><?php echo $is_deactivated; ?></td>
        <td>
        <?php if(IS_LOGGED_IN && ROLE_NAME == 'ADMIN') : ?>
          <a class="btn btn-xs btn-default" href="<?php echo ROOT_PATH . 'users/edit/' . $item['user_id'] ?>"><span class="glyphicon glyphicon-edit"></span> Edit</a>
          <a class="btn btn-xs btn-danger" href="<?php echo ROOT_PATH . 'users/delete/' . $item['user_id'] ?>"><span class="glyphicon glyphicon-trash"></span> Delete</a>
        <?php endif; ?>
        <?php if(IS_LOGGED_IN && (ROLE_NAME == 'ADMIN' || ROLE_NAME == 'MOD') && (LOGGED_USER_ROLE_ID > $item['role_id'] || ROLE_NAME == 'ADMIN') )  : ?>
          <?php if($is_deactivated == 'active') :?>
          <a class="btn btn-xs btn-warning" href="<?php echo ROOT_PATH . 'users/deactivate/' . $item['user_id'] ?>"><span class="glyphicon glyphicon-remove"></span> Deactivate</a>
          <?php else : ?>
            <a class="btn btn-xs btn-success" href="<?php echo ROOT_PATH . 'users/activate/' . $item['user_id'] ?>"><span class="glyphicon glyphicon-ok"></span> Activate</a>
          <?php endif; ?>
        <?php endif; ?>

        </td>
      </tr>
    <?php endforeach; ?>
    </tbody>
  </table>
</div>