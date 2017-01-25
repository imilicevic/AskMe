<div class="panel login-form register">
  <div class="panel-body">
    <h3>Create a free account</h3>
    <form action="<?php $_SERVER['PHP_SELF']; ?>" method="POST">
      <div class="form-group">
        <label for="username">Username</label>
        <input type="text" name="username" id="" class="form-control" placeholder="e.g. timmy" required><br />
        <label for="password">Password</label>
        <input type="password" name="passhash" id="" class="form-control" placeholder="password" required><br />
        <label for="email">Email</label>
        <input type="email" name="email" id="" class="form-control" placeholder="e.g. mark@mail.com" required><br />
        <label for="date_of_birth">Date of birth</label> <br />
        <input type="text" id="datepicker" name="date_of_birth" class="form-control" placeholder="1991-07-17" required> <br />
        <label for="city">City</label>
        <input type="text" name="city" id="" class="form-control" placeholder="e.g. Zagreb" required><br />
        <label for="country">Country</label>
        <input type="text" name="country" id="" class="form-control" placeholder="e.g. Croatia" required><br />
        <input type="submit" value="Register" class="btn btn-primary" name="submit">
      </div>
    </form>
    <div>Already registered? <a href="<?php echo ROOT_PATH; ?>users/login">Sign in</a>.</div>
  </div>
</div>