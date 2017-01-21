<div class="padded">
  <?php $item = $viewModel; ?>
  <h1>Edit category: <span class="author"><?php echo $item['category_name'] ?></span></h1>
  <div class="panel form">
    <div class="panel-body">
      <form action="<?php echo ROOT_URL . 'categories/update' ?>" method="POST">
        <div class="form-group">
          <input type="hidden" name="category_id" value="<?php echo $item['category_id'] ?>">
          <label for="category_name">Category name</label>
          <input type="text" name="category_name" class="form-control" value="<?php echo $item['category_name'];?>" required><br />
          <?php if((IS_LOGGED_IN) && (ROLE_NAME == 'MOD' || ROLE_NAME == 'ADMIN')) : ?>
            <label for="is_deactivated">Deactivated</label><br />
            <input type="radio" name="is_deactivated" value="1" <?php if($item['is_deactivated'] == true) echo 'checked="checked"'?>> yes <br />
            <input type="radio" name="is_deactivated" value="0" <?php if($item['is_deactivated'] == false) echo 'checked="checked"'?>> no <br />
          <?php endif; ?>
          <input type="submit" value="Update" class="btn btn-primary" name="submit">
          <a href="<?php echo ROOT_PATH; ?>categories" class="btn btn-danger">Cancel</a>
        </div>
      </form>
    </div>
  </div>
</div>