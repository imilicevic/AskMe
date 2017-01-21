<div>
  <h1>Categories 
    <?php if(IS_LOGGED_IN && ROLE_NAME == 'ADMIN') : ?>
      <a href="<?php echo ROOT_PATH;?>categories/add" class="btn btn-success btn-add"><span class="glyphicon glyphicon-plus"></span> Add</a>
    <?php endif; ?></h1>
  <table class="table table-bordered">
    <thead>
      <tr>
        <th>#</th>
        <th>Category Name</th>
        <th>Active</th>
        <th>Actions</th>
      </tr>
    </thead>
    <tbody>
    <?php foreach($viewModel as $item) :?>
      <?php $is_deactivated = $item['is_deactivated'];
      $is_deactivated = ($is_deactivated == true) ? 'not-active' : 'active';
      ?>
      <tr>
        <th scope="row"><?php echo $item['category_id']; ?></th>
        <td><?php echo $item['category_name']; ?></td>
        <td><?php echo $is_deactivated; ?></td>
        <td>
          <?php if(IS_LOGGED_IN && ROLE_NAME == 'ADMIN') : ?>
            <a class="btn btn-xs btn-default" href="<?php echo ROOT_PATH . 'categories/edit/' . $item['category_id'] ?>"><span class="glyphicon glyphicon-edit"></span> Edit</a>
            <a class="btn btn-xs btn-danger" href="<?php echo ROOT_PATH . 'categories/delete/' . $item['category_id'] ?>"><span class="glyphicon glyphicon-trash"></span> Delete</a>
          <?php endif; ?>
          <?php if(IS_LOGGED_IN && ROLE_NAME == 'ADMIN' || ROLE_NAME == 'MOD') : ?>
            <?php if ($is_deactivated == 'not-active') : ?>
              <a class="btn btn-xs btn-success" href="<?php echo ROOT_PATH . 'categories/activate/' . $item['category_id'] ?>"><span class="glyphicon glyphicon-ok"></span> Activate</a>
            <?php else : ?>
              <a class="btn btn-xs btn-warning" href="<?php echo ROOT_PATH . 'categories/deactivate/' . $item['category_id'] ?>"><span class="glyphicon glyphicon-remove"></span> Deactivate</a>
            <?php endif; ?>
          <?php endif; ?>
        </td>
      </tr>
    <?php endforeach; ?>
    </tbody>
  </table>
</div>