<?php
class Profile extends Controller {

  protected function edit(){
    if(!IS_LOGGED_IN){
      header('Location: ' . ROOT_URL . '');
    }
    $viewModel = new ProfileModel();
    $this->returnView($viewModel->edit(), true);
  }

  protected function update(){
    if(!IS_LOGGED_IN){
      header('Location: ' . ROOT_URL . '');
    }
    $viewModel = new ProfileModel();
    $this->returnView($viewModel->update(), false);
  }

  protected function show(){
    if(!IS_LOGGED_IN){
      header('Location: ' . ROOT_URL . '');
    }
    $viewModel = new ProfileModel();
    $this->returnView($viewModel->show(), true);
  }

}