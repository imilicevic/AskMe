<?php
class UserModel extends Model{
  public function index(){
    $this->query('SELECT * FROM users JOIN roles on users.role_id = roles.role_id order by user_id ASC');
    $rows = $this->resultSet();
    return $rows;
  }

  public function register()
  {
    // Sanitize POST
    $post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
    $passhash = hash('sha256', $post['passhash']);
    if ($post['submit']) {
      // Insert into DB
      $this->query('INSERT INTO users(username, passhash, email, city, country, date_of_birth) VALUES (:username, :passhash, :email, :city, :country, \''. $_POST['date_of_birth'] . '\')');
      $this->bind(':username', $post['username']);
      $this->bind(':passhash', $passhash);
      $this->bind(':email', $post['email']);
      $this->bind(':city', $post['city']);
      $this->bind(':country', $post['country']);
      $this->execute();

      header('Location: ' . ROOT_URL . 'users/login');
    }
    return;
  }

  public function login()
  {
    // Sanitize POST
    $post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
    $passhash = hash('sha256', $post['passhash']);
    if ($post['submit']) {
      // Compare login
      $this->query('SELECT * FROM users JOIN roles ON users.role_id = roles.role_id WHERE username = :username AND passhash = :passhash');
      $this->bind(':username', $post['username']);
      $this->bind(':passhash', $passhash);

      $row = $this->singleResult();
      if($row){
        if($row['is_deactivated']){
          Messages::setMessage('Your account is deactivated. Please contact administrator.', 'error');
        }else{
          $_SESSION['is_logged_in'] = true;
          $_SESSION['user_data'] = array(
            "id"         => $row['user_id'],
            "username"   => $row['username'],
            "role_name"  => $row['role_name'],
            "role_id"    => $row['role_id']
          );
          header('Location: ' . ROOT_URL . 'questions');
        }
      }else{
        Messages::setMessage('Incorrect login.', 'error');
      }
    }
    return;
  }

  public function deactivate(){
    $user_id = $_GET['id'];
    $this->query('UPDATE users SET is_deactivated = true  WHERE user_id = :user_id');
    $this->bind(':user_id', $user_id);
    if($this->execute()){
      header('Location: ' . ROOT_URL . 'users');
    }
    return;
  }

  public function activate(){
    $user_id = $_GET['id'];
    $this->query('UPDATE users SET is_deactivated = false  WHERE user_id = :user_id');
    $this->bind(':user_id', $user_id);
    if($this->execute()){
      header('Location: ' . ROOT_URL . 'users');
    }
    return;
  }

  public function delete(){
    $user_id = $_GET['id'];
    $this->query('DELETE FROM users  WHERE user_id = :user_id');
    $this->bind(':user_id', $user_id);
    if($this->execute()){
      header('Location: ' . ROOT_URL . 'users');
    }
    return;
  }

  public function edit(){
    $user_id = $_GET['id'];
    $this->query("SELECT * FROM users WHERE user_id = :id LIMIT 1");
    $this->bind(':id', $user_id);
    $row = $this->singleResult();
    return $row;
  }

  public function update(){
    // Sanitize POST
    $post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

    if($post['submit']){
      // Insert into DB
      $this->query('
                    UPDATE users SET is_deactivated = :is_deactivated, 
                    username = :username,  
                    email = :email,
                    city = :city,
                    country = :country,
                    date_of_birth = :date_of_birth,
                    role_id = :role_id
                    WHERE user_id = :user_id');
      $this->bind(':user_id', $post['user_id']);
      $this->bind(':is_deactivated', $post['is_deactivated']);
      $this->bind(':username', $post['username']);
      $this->bind(':email', $post['email']);
      $this->bind(':city', $post['city']);
      $this->bind(':country', $post['country']);
      $this->bind(':date_of_birth', $post['date_of_birth']);
      $this->bind(':role_id', $post['role_id']);
      $this->execute();

      if(ROLE_NAME == 'MOD' || ROLE_NAME == 'ADMIN' ){
        header('Location: ' . ROOT_URL . 'users');
      }else{
        header('Location: ' . ROOT_URL . 'home');
      }

    }
    return;
  }

}