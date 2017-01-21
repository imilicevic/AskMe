<?php
// Start Session
session_start();
// Include config file and routing
require('config.php');
require('classes/Router.php');
require('classes/Controller.php');
require('classes/Model.php');
require('classes/Messages.php');

require('controllers/Home.php');
require('controllers/About.php');
require('controllers/Questions.php');
require('controllers/Users.php');
require('controllers/Categories.php');
require('controllers/Profile.php');

require('models/Home.php');
require('models/About.php');
require('models/Question.php');
require('models/User.php');
require('models/Category.php');
require('models/Profile.php');

$router = new Router($_GET);
$controller = $router->createController();

if($controller){
  $controller->executeAction();
}





