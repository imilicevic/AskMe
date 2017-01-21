<?php
class Users extends Controller {
  protected function index(){
    if(!IS_LOGGED_IN || ROLE_NAME == 'USER'){
      header('Location: ' . ROOT_URL . '');
    }

    $viewModel = new UserModel();
    $this->returnView($viewModel->index(), true);
  }

  protected function register(){
    $viewModel = new UserModel();
    $this->returnView($viewModel->register(), true);
  }

  protected function login(){
    $viewModel = new UserModel();
    $this->returnView($viewModel->login(), true);
  }

  protected function logout(){
    unset($_SESSION['is_logged_in']);
    unset($_SESSION['user_data']);
    session_destroy();
    header('Location: ' .  ROOT_URL);
  }

  protected function deactivate(){
    if(!IS_LOGGED_IN || ROLE_NAME == 'USER'){
      header('Location: ' . ROOT_URL . '');
    }
    $viewModel = new UserModel();
    $this->returnView($viewModel->deactivate(), false);
  }

  protected function activate(){
    if(!IS_LOGGED_IN || ROLE_NAME == 'USER'){
      header('Location: ' . ROOT_URL . '');
    }
    $viewModel = new UserModel();
    $this->returnView($viewModel->activate(), false);
  }

  protected function delete(){
    if(!IS_LOGGED_IN || ROLE_NAME == 'USER' ||ROLE_NAME == 'MOD'){
      header('Location: ' . ROOT_URL . '');
    }
    $viewModel = new UserModel();
    $this->returnView($viewModel->delete(), true);
  }

  protected function edit(){
    if(!IS_LOGGED_IN || ROLE_NAME == 'USER' ||ROLE_NAME == 'MOD'){
      header('Location: ' . ROOT_URL . '');
    }
    $viewModel = new UserModel();
    $this->returnView($viewModel->edit(), true);
  }

  protected function update(){
    if(!IS_LOGGED_IN || ROLE_NAME == 'USER' ||ROLE_NAME == 'MOD'){
      header('Location: ' . ROOT_URL . '');
    }
    $viewModel = new UserModel();
    $this->returnView($viewModel->update(), false);
  }

}