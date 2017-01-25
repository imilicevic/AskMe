<div class="padded">
<?php $item = $viewModel; ?>
  <h3>Edit User: <span class="author"><?php echo $item['username']; ?></span></h3>
  <div class="panel form">
    <div class="panel-body">
      <form action="<?php echo ROOT_URL . 'users/update' ?>" method="POST">
        <div class="form-group">
          <input type="hidden" name="user_id" value="<?php echo $item['user_id'] ?>">
          <label for="username">Username</label>
          <input type="text" name="username" id="" class="form-control" value="<?php echo $item['username']?>" placeholder="e.g. timmy" required><br />
          <label for="email">Email</label>
          <input type="email" name="email" id="" class="form-control" value="<?php echo $item['email']; ?>" placeholder="e.g. mark@mail.com" required><br />
          <label for="date_of_birth">Date of birth</label> <br />
          <input type="text" id="datepicker" name="date_of_birth" class="form-control" value="<?php echo $item['date_of_birth']; ?>" placeholder="e.g. 2017-01-05"> <br />
          <label for="city">City</label>
          <input type="text" name="city" id="" class="form-control" placeholder="e.g. Zagreb" value="<?php echo $item['city']; ?>" required><br />
          <label for="country">Country</label>
          <input type="text" name="country" id="" class="form-control" placeholder="e.g. Croatia" value="<?php echo $item['country']; ?>" required><br />

          <?php if(IS_LOGGED_IN && ROLE_NAME == 'ADMIN') : ?>
            <label for="is_deactivated">Deactivate user</label><br />
            <input type="radio" name="is_deactivated" value="1" <?php if($item['is_deactivated'] == true) echo 'checked="checked"'?>> yes <br />
            <input type="radio" name="is_deactivated" value="0" <?php if($item['is_deactivated'] == false) echo 'checked="checked"'?>> no <br /> <br />

            <label for="role_id">User Role</label>
            <select name="role_id" required class="form-control">
              <option value="1" <?php if($item['role_id'] == 1) echo "selected=selected"; ?>>USER</option>
              <option value="2" <?php if($item['role_id'] == 2) echo "selected=selected"; ?>>MOD</option>
              <option value="3" <?php if($item['role_id'] == 3) echo "selected=selected"; ?>>ADMIN</option>
            </select>
            <br />
          <?php else : ?>
            <?php $is_deactivated = $item['is_deactivated'];
            $is_deactivated = ($is_deactivated == '') ? true : false;
            ?>
            <input type="hidden" name="is_deactivated" value="<?php echo $is_deactivated; ?>" />
            <input type="hidden" name="role_id" value="<?php echo $item['role_id']; ?>" />
          <?php endif; ?>
          <input type="submit" value="Update" class="btn btn-primary" name="submit">
          <a href="<?php echo ROOT_PATH; ?>users" class="btn btn-danger">Cancel</a>
        </div>
      </form>
    </div>
  </div>
</div>