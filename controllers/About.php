<?php
class About extends Controller{
  protected function index(){
    $viewModel = new AboutModel();
    $this->returnView($viewModel->index(), true);
  }
}