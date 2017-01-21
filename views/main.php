<?php require_once('header.php'); ?>
<body class="<?php echo strtolower(get_class($this)); ?>">
  <nav class="navbar">
    <div class="container">
      <div class="navbar-header">
        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
          <?php if(IS_LOGGED_IN) : ?>
            <a class="logged-user hidden-md hidden-lg" href="#"><span class="glyphicon glyphicon-user"></span> Hello, <strong><?php echo $_SESSION['user_data']['username'] ?>!</strong></a>
          <?php endif; ?>
          <span class="sr-only">Toggle navigation</span>
          <span class="glyphicon glyphicon-menu-hamburger"></span>
        </button>
        <a class="navbar-brand" href="<?php echo ROOT_URL; ?>">AskMe</a>
      </div>
      <div id="navbar" class="collapse navbar-collapse">
        <ul class="nav navbar-nav">
          <li><a href="<?php echo ROOT_URL; ?>">Home</a></li>
          <li><a href="<?php echo ROOT_PATH ?>about">About</a></li>
          <li><a href="<?php echo ROOT_URL; ?>questions">Questions</a></li>
          <li><a href="<?php echo ROOT_URL; ?>questions/ask">Ask Question</a></li>

          <?php if(IS_LOGGED_IN && (ROLE_NAME == 'ADMIN' || ROLE_NAME == 'MOD')) : ?>
              <li role="presentation" class="dropdown">
                <a class="dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
                  Administration <span class="caret"></span>
                </a>
                <ul class="dropdown-menu">
                  <li><a href="<?php echo ROOT_URL; ?>questions/all">All Questions</a></li>
                  <li><a href="<?php echo ROOT_URL; ?>categories">Categories</a></li>
                  <li><a href="<?php echo ROOT_URL; ?>users">Users</a></li>
                </ul>
              </li>
          <?php endif ?>
        </ul>

        <ul class="nav navbar-nav navbar-right">
          <?php if(isset($_SESSION['is_logged_in'])) : ?>
            <li role="presentation" class="dropdown">
              <a class="dropdown-toggle logged-user" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
                <div class="hidden-xs hidden-sm"><span class="glyphicon glyphicon-user"></span> Hello, <strong><?php echo $_SESSION['user_data']['username'] ?></strong><span class="hidden-md hidden-lg"></span> <span class="caret"></span></div> <div class="hidden-md hidden-lg">Account <span class="caret"></span></div>
              </a>
              <ul class="dropdown-menu">
                <li><a href="<?php echo ROOT_URL . 'profile/show/' . LOGGED_USER_ID; ?>">Settings</a></li>
                <li><a href="<?php echo ROOT_URL; ?>users/logout">Logout</a></li>
              </ul>
            </li>
          <?php else : ?>
          <li><a href="<?php echo ROOT_URL; ?>users/login">Login</a></li>
          <li><a href="<?php echo ROOT_URL; ?>users/register">Register</a></li>
          <?php endif; ?>
        </ul>
      </div><!--/.nav-collapse -->
    </div>
  </nav>

  <?php if (get_class($this) == 'Home') : ?>
    <?php require($view); ?>
  <?php else :?>
  <div class="container">
    <div class="row">
      <?php Messages::display(); ?>
      <?php include($view); ?>
    </div>
  </div><!-- /.container -->
  <?php endif; ?>
<?php require_once ('footer.php'); ?>
