<?php
// Define DB Params
define("DB_HOST", "localhost");
define("DB_USER", "ivan");
define("DB_PASS", "pass");
define("DB_NAME", "askme");

// Define URL
define("ROOT_PATH", "/");
define("ROOT_URL", "http://localhost:8080/");

// Define User Variables
define("IS_LOGGED_IN", isset($_SESSION['is_logged_in']));

if(isset($_SESSION['user_data']['role_name'])){
  define("ROLE_NAME", $_SESSION['user_data']['role_name']);
}

if(isset($_SESSION['user_data']['id'])){
  define("LOGGED_USER_ID", $_SESSION['user_data']['id']);
}

if(isset($_SESSION['user_data']['role_id'])){
  define("LOGGED_USER_ROLE_ID", $_SESSION['user_data']['role_id']);
}