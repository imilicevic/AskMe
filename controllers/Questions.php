<?php
class Questions extends Controller {
  protected function index(){
    $viewModel = new QuestionModel();
    $this->returnView($viewModel->index(), true);
  }

  protected function all(){
    if(!IS_LOGGED_IN || ROLE_NAME == 'USER'){
      header('Location: ' . ROOT_URL . '');
    }

    $viewModel = new QuestionModel();
    $this->returnView($viewModel->all(), true);
  }

  protected function ask(){
    $viewModel = new QuestionModel();
    $this->returnView($viewModel->ask(), true);
  }

  protected function update(){
    $viewModel = new QuestionModel();
    $this->returnView($viewModel->update(), false);
  }

  protected function hide(){
    if(!IS_LOGGED_IN || ROLE_NAME == 'USER'){
      header('Location: ' . ROOT_URL . '');
    }

    $viewModel = new QuestionModel();
    $this->returnView($viewModel->hide(), false);
  }

  protected function display(){
    if(!IS_LOGGED_IN || ROLE_NAME == 'USER'){
      header('Location: ' . ROOT_URL . '');
    }

    $viewModel = new QuestionModel();
    $this->returnView($viewModel->display(), false);
  }

  protected function edit(){
    $viewModel = new QuestionModel();
    $this->returnView($viewModel->edit(), true);
  }

  protected function delete(){
    if(!IS_LOGGED_IN || !ROLE_NAME == 'ADMIN'){
      header('Location: ' . ROOT_URL . '');
    }

    $viewModel = new QuestionModel();
    $this->returnView($viewModel->delete(), false);
  }

  protected function answers(){
    if(!IS_LOGGED_IN || ROLE_NAME == 'USER'){
      header('Location: ' . ROOT_URL . '');
    }

    $viewModel = new QuestionModel();
    $this->returnView($viewModel->answers(), true);
  }

  public function newAnswer(){
    $viewModel = new QuestionModel();
    $this->returnView($viewModel->newAnswer(), false);
  }

  public function editAnswer(){
    $viewModel = new QuestionModel();
    $this->returnView($viewModel->editAnswer(), true);
  }

  public function updateAnswer(){
    $viewModel = new QuestionModel();
    $this->returnView($viewModel->updateAnswer(), true);
  }

  public function deleteAnswer(){
    $viewModel = new QuestionModel();
    $this->returnView($viewModel->deleteAnswer(), false);
  }

  public function hideAnswer(){
    if(!IS_LOGGED_IN || ROLE_NAME == 'USER'){
      header('Location: ' . ROOT_URL . '');
    }

    $viewModel = new QuestionModel();
    $this->returnView($viewModel->hideAnswer(), false);
  }

  public function displayAnswer(){
    if(!IS_LOGGED_IN || ROLE_NAME == 'USER'){
      header('Location: ' . ROOT_URL . '');
    }

    $viewModel = new QuestionModel();
    $this->returnView($viewModel->displayAnswer(), false);
  }

  public function vote(){
    if(!IS_LOGGED_IN){
      header('Location: ' . ROOT_URL . 'questions');
    }

    $viewModel = new QuestionModel();
    $this->returnView($viewModel->vote(), false);
  }

}