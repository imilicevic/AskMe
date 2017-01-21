<div class="padded">
  <h1>Add Category</h1>
  <div class="panel form">
    <div class="panel-body">
      <form action="<?php $_SERVER['PHP_SELF']; ?>" method="POST">
        <div class="form-group">
          <label for="category_name">Category name</label>
          <input type="text" name="category_name" id="" class="form-control" placeholder="e.g. Sports" required><br />
          <input type="submit" value="Add" class="btn btn-primary" name="submit">
          <a href="<?php echo ROOT_PATH; ?>categories" class="btn btn-danger">Cancel</a>
        </div>
      </form>
    </div>
  </div>
</div>