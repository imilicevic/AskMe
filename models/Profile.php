<?php
class ProfileModel extends Model{

  public function show(){
    $user_id = $_GET['id'];
    $this->query("SELECT * FROM users WHERE user_id = :id LIMIT 1");
    $this->bind(':id', $user_id);
    $row = $this->singleResult();
    return $row;
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
    $passhash = hash('sha256', $post['passhash']);

    if($post['submit']){
      // Insert into DB
      $this->query('
                    UPDATE users SET email = :email,
                    city = :city,
                    country = :country,
                    date_of_birth = :date_of_birth,
                    passhash = :passhash
                    WHERE user_id = :user_id');
      $this->bind(':user_id', $post['user_id']);
      $this->bind(':email', $post['email']);
      $this->bind(':city', $post['city']);
      $this->bind(':country', $post['country']);
      $this->bind(':date_of_birth', $post['date_of_birth']);
      $this->bind(':passhash', $passhash);
      $this->execute();

      header('Location: ' . ROOT_URL . 'profile/show/' . $post['user_id']);
    }
    return;
  }

}