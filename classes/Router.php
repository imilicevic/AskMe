<?php
class Router{
  private $controller;
  private $action;
  private $request;

  /**
   * Bootstrap constructor.
   * URL looks like this: http://askme/users/register
   * @param $request - gets controller (users) and action (register) from url
   * if controller is not available in url - then use default controller 'home'
   * if action is not available in url - then use action 'index'
   * in other cases use specified controller and action
   */
  public function __construct($request)
  {
    $this->request = $request;

    // Controllers
    if($this->request['controller'] == ''){
      // case when url is like http://askme/
      $this->controller = 'home';
    }else{
      // case when url is like http://askme/users - request is now 'users'
      $this->controller = $this->request['controller'];
    }

    // Actions
    if($this->request['action'] == ''){
      $this->action = 'index';
    }else{
      $this->action = $this->request['action'];
    }

    // echo 'controller: '.  $this->controller . ' <br>action: ' . $this->action;
  }

  /**
   * Method instantiates the controller from the URL if it exists and its action
   */
  public function createController(){
    // Check Class
    if(class_exists($this->controller)){
      $parents = class_parents($this->controller);

      // Check Extend - check if class is extended
      if(in_array("Controller", $parents)){
        if(method_exists($this->controller, $this->action)){
          return new $this->controller($this->action, $this->request);
        }else{
          // MEthod Does not exist
          echo '<h1>Method does not exist</h1>';
          return;
        }
      }else{
        // Base Controller is not found
        echo '<h1>Base Controller does not exist</h1>';
        return;
      }
    }else{
      // Controller Class does not exist
      echo '<h1>Controller Class does not exist</h1>';
      return;
    }
  }
}