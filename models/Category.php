<?php
class CategoryModel extends Model{
  public function index(){
    $this->query('SELECT * FROM categories ORDER BY category_id ASC');
    $rows = $this->resultSet();
    return $rows;
  }

  public function add(){
    if(!IS_LOGGED_IN || ROLE_NAME != 'ADMIN'){
      header('Location: ' . ROOT_URL . 'categories');
    }
    // Sanitize POST
    $post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

    if($post['submit']){
      // Insert into DB
      $this->query('INSERT INTO categories(category_name) VALUES (:category_name)');
      $this->bind(':category_name', $post['category_name']);
      $this->execute();
      // Redirect
        header('Location: ' . ROOT_URL . 'categories');
    }
    return;
  }

  public function deactivate(){
    $category_id = $_GET['id'];
    $this->query('UPDATE categories SET is_deactivated = true  WHERE category_id = :category_id');
    $this->bind(':category_id', $category_id);
    if($this->execute()){
      header('Location: ' . ROOT_URL . 'categories');
    }
    return;
  }

  public function activate(){
    $category_id = $_GET['id'];
    $this->query('UPDATE categories SET is_deactivated = false  WHERE category_id = :category_id');
    $this->bind(':category_id', $category_id);
    if($this->execute()){
      header('Location: ' . ROOT_URL . 'categories');
    }
    return;
  }

  public function delete(){
    if(!IS_LOGGED_IN || ROLE_NAME != 'ADMIN'){
      header('Location: ' . ROOT_URL . 'categories');
    }

    $category_id = $_GET['id'];
    $this->query('DELETE FROM categories  WHERE category_id = :category_id');
    $this->bind(':category_id', $category_id);
    if($this->execute()){
      header('Location: ' . ROOT_URL . 'categories');
    }
    return;
  }

  public function edit(){
    if(!IS_LOGGED_IN || ROLE_NAME != 'ADMIN'){
      header('Location: ' . ROOT_URL . 'categories');
    }

    $category_id = $_GET['id'];
    $this->query("SELECT * FROM categories WHERE category_id = :id LIMIT 1");
    $this->bind(':id', $category_id);
    $row = $this->singleResult();
    return $row;
  }

  public function update(){
    if(!IS_LOGGED_IN || ROLE_NAME != 'ADMIN'){
      header('Location: ' . ROOT_URL . 'categories');
    }
    
    // Sanitize POST
    $post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

    if($post['submit']){
      // Insert into DB
      $this->query('UPDATE categories SET is_deactivated = :is_deactivated, category_name = :category_name  WHERE category_id = :category_id');
      $this->bind(':category_id', $post['category_id']);
      $this->bind(':is_deactivated', $post['is_deactivated']);
      $this->bind(':category_name', $post['category_name']);
      $this->execute();
      header('Location: ' . ROOT_URL . 'categories');
    }
    return;
  }

}