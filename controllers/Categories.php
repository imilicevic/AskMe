<?php
class Categories extends Controller{
  protected function index(){
    if(!IS_LOGGED_IN || ROLE_NAME == 'USER'){
      header('Location: ' . ROOT_URL . '');
    }
    $viewModel = new CategoryModel();
    $this->returnView($viewModel->index(), true);
  }

  protected function add(){
    if(!IS_LOGGED_IN || ROLE_NAME == 'USER'){
      header('Location: ' . ROOT_URL . '');
    }

    $viewModel = new CategoryModel();
    $this->returnView($viewModel->add(), true);
  }

  protected function edit(){
    if(!IS_LOGGED_IN || ROLE_NAME == 'USER' || ROLE_NAME == 'MOD'){
      header('Location: ' . ROOT_URL . '');
    }

    $viewModel = new CategoryModel();
    $this->returnView($viewModel->edit(), true);
  }

  protected function update(){
    if(!IS_LOGGED_IN || ROLE_NAME == 'USER' || ROLE_NAME == 'MOD'){
      header('Location: ' . ROOT_URL . '');
    }

    $viewModel = new CategoryModel();
    $this->returnView($viewModel->update(), false);
  }

  protected function delete(){
    if(!IS_LOGGED_IN || ROLE_NAME == 'USER' || ROLE_NAME == 'MOD'){
      header('Location: ' . ROOT_URL . '');
    }

    $viewModel = new CategoryModel();
    $this->returnView($viewModel->delete(), false);
  }

  protected function deactivate(){
    if(!IS_LOGGED_IN){
      header('Location: ' . ROOT_URL . '');
    }

    $viewModel = new CategoryModel();
    $this->returnView($viewModel->deactivate(), false);
  }

  protected function activate(){
    if(!IS_LOGGED_IN){
      header('Location: ' . ROOT_URL . '');
    }

    $viewModel = new CategoryModel();
    $this->returnView($viewModel->activate(), false);
  }


}