<div class="padded">
<?php $user = $viewModel; ?>
  <h1>Edit Your Profile</h1>
  <div class="panel form">
    <div class="panel-body">
      <form action="<?php echo ROOT_URL . 'profile/update' ?>" method="POST">
        <div class="form-group">
          <input type="hidden" name="user_id" value="<?php echo $user['user_id'] ?>">
          <label for="username">Username</label>
          <input type="text" name="username" id="" class="form-control" value="<?php echo $user['username']?>" placeholder="e.g. timmy" required <?php if(ROLE_NAME != 'ADMIN') echo 'disabled'; ?>><br />
          <label for="password">Password</label>
          <input type="password" name="passhash" id="" class="form-control" placeholder="password" required><br />
          <label for="email">Email</label>
          <input type="email" name="email" id="" class="form-control" value="<?php echo $user['email']; ?>" placeholder="e.g. mark@mail.com" required><br />
          <label for="date_of_birth">Date of birth</label> <br />
          <input type="text" name="date_of_birth" class="form-control" value="<?php echo $user['date_of_birth']; ?>" placeholder="e.g. 2017-01-05"> <br />
          <label for="city">City</label>
          <input type="text" name="city" id="" class="form-control" placeholder="e.g. Zagreb" value="<?php echo $user['city']; ?>" required><br />
          <label for="country">Country</label>
          <input type="text" name="country" id="" class="form-control" placeholder="e.g. Croatia" value="<?php echo $user['country']; ?>" required><br />
          <input type="submit" value="Update" class="btn btn-primary" name="submit">
          <a href="<?php echo ROOT_PATH ?>profile/show/<?php echo $user['user_id'] ?>" class="btn btn-danger">Cancel</a>
        </div>
      </form>
    </div>
  </div>
</div>