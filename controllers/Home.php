<?php
class Home extends Controller {

  /**
   * $viewModel is property of abstract coass Controller, we instantiate HomeModel in that variable
   * kethod returnView sends this viewModel's index method and second parameter - true says that we need fullview here
   *
   */
  protected function index(){
    $viewModel = new HomeModel();
    $this->returnView($viewModel->index(), true);
  }
}