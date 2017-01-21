<?php $user = $viewModel; ?>
<div class="padded">
  <h1>Hi, <span class="author"><?php echo $user['username']; ?></span>!</h1>
  <div class="panel form">
    <div class="panel-body">
      <a class="btn btn-default pull-right" href="<?php echo ROOT_PATH . 'profile/edit/' . $user['user_id'] ?>"><span class="glyphicon glyphicon-edit"></span> Edit</a>
      <p class="lead">Here you can see and change your profile data!</p>
      <p><strong>E-mail:</strong> <?php echo $user['email']; ?></p>
      <p><strong>Location:</strong> <?php echo $user['city'] . ', ' . $user['country'] ?></p>
      <p><strong>Date of birth:</strong> <?php echo Model::parse_timestamp($user['date_of_birth'], 'd.m.Y.'); ?></p>
    </div>
  </div>
</div>