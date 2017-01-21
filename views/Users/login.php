<div class="panel login-form">
  <div class="panel-body">
    <h3>Login to your account</h3>
    <form action="<?php $_SERVER['PHP_SELF']; ?>" method="POST">
      <div class="form-group">
        <label for="username">Username:</label>
        <input type="text" name="username" id="" class="form-control" placeholder="username" required><br />
        <label for="password">Password:</label>
        <input type="password" name="passhash" id="" class="form-control" placeholder="password" required><br />
        <input type="submit" value="Login" class="btn btn-primary" name="submit">
      </div>
    </form>
    <div>Not registered? <a href="<?php echo ROOT_PATH; ?>users/register">Create an account</a>.</div>
  </div>
</div>