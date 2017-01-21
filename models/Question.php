<?php
class QuestionModel extends Model{
  public function index(){
    $this->query('SELECT * FROM questions JOIN users ON questions.user_id = users.user_id WHERE is_displayed = true ORDER BY published_at DESC');
    $rows = $this->resultSet();
    return $rows;
  }

  public function getCategories($question_id ){
    $this->query('SELECT category_name, categories.category_id, questions.question_id FROM categories
JOIN question_categories ON question_categories.category_id = categories.category_id
JOIN questions ON questions.question_id = question_categories.question_id
WHERE question_categories.question_id = :question_id;');
      $this->bind(':question_id', $question_id);
    $rows = $this->resultSet();
    return $rows;
  }

  public function getAllCategories(){
    $this->query('SELECT * FROM categories WHERE is_deactivated != true');
    $rows = $this->resultSet();
    return $rows;
  }

  public function getQuestionCategories($question_id){
    $this->query('SELECT categories.category_id, category_name, question_categories.question_id, users.user_id, users.username FROM question_categories JOIN questions ON questions.question_id = question_categories.question_id
JOIN categories ON question_categories.category_id = categories.category_id
JOIN users ON users.user_id = questions.user_id WHERE questions.question_id = :question_id');
    $this->bind(':question_id', $question_id);
    $rows = $this->resultSet();
    return $rows;
  }


  public function getVotes($answer_id){
    $this->query('SELECT * FROM votes JOIN users ON votes.user_id = users.user_id JOIN answers ON answers.answer_id = votes.answer_id WHERE answers.answer_id = :answer_id ORDER BY voted_at DESC LIMIT 1');
    $this->bind(':answer_id', $answer_id);
    $row = $this->singleResult();
    return $row;
  }

  public function vote(){
    $post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
    $answer_score = $post['answer_score'];
    if($post['submit'] == 'upvote') {
      $answer_score = intval($answer_score) + 1;
      $this->query('INSERT INTO votes(score, user_id, answer_id) VALUES(:score, :user_id, :answer_id);');
    }
    if($post['submit'] == 'downvote') {
      $answer_score = intval($answer_score) - 1;
      $this->query('INSERT INTO votes(score, user_id, answer_id) VALUES(:score, :user_id, :answer_id);');
    }
    $this->bind(':score', $answer_score);
    $this->bind(':user_id', $post['user_id']);
    $this->bind('answer_id', $post['answer_id']);
    $this->execute();
    header('Location: ' . ROOT_URL . 'questions');
  }

  public function hide(){
    if(!IS_LOGGED_IN || ROLE_NAME == 'USER'){
      header('Location: ' . ROOT_URL . 'questions');
    }
    $question_id = $_GET['id'];
    $current_page = $_SESSION['current_page'];
    $this->query('UPDATE questions SET is_displayed = false WHERE question_id = :question_id');
    $this->bind(':question_id', $question_id);
    if($this->execute()){
      if($current_page == 'questions'){
        header('Location: ' . ROOT_PATH . 'questions');
      }else{
        header('Location: ' . ROOT_PATH . 'questions/all');
      }
    }
    return;
  }

  public function display(){
    if(!IS_LOGGED_IN || ROLE_NAME == 'USER'){
      header('Location: ' . ROOT_URL . 'questions');
    }
    $question_id = $_GET['id'];
    $this->query('UPDATE questions SET is_displayed = true WHERE question_id = :question_id');
    $this->bind(':question_id', $question_id);
    if($this->execute()){
      header('Location: ' . ROOT_PATH . 'questions/all');
    }
    return;
  }

    public function all(){
    if(!IS_LOGGED_IN || ROLE_NAME == 'USER'){
      header('Location: ' . ROOT_URL . 'questions');
    }
    $this->query('SELECT * FROM questions JOIN users ON questions.user_id = users.user_id ORDER BY published_at DESC');
    $rows = $this->resultSet();
    return $rows;
  }

  public function getAnswers($question_id){
    $this->query('SELECT * FROM answers JOIN users ON answers.user_id = users.user_id WHERE question_id = :question_id AND is_displayed = true ORDER BY answers.published_at DESC');
    $this->bind(':question_id', $question_id);
    $rows = $this->resultSet();
    return $rows;
  }

  public function getNumberOfAnswers($question_id){
    $this->query('SELECT COUNT(*) as count FROM answers WHERE question_id = :question_id');
    $this->bind(':question_id', $question_id);
    $row = $this->singleResult();
    return $row;
  }

  public function delete(){
    if(!IS_LOGGED_IN || ROLE_NAME == 'USER'){
      header('Location: ' . ROOT_URL . 'questions');
    }
    $question_id = $_GET['id'];
    $current_page = $_SESSION['current_page'];
    $this->query('DELETE FROM questions WHERE question_id = :question_id');
    $this->bind(':question_id', $question_id);
    if($this->execute()){
      if($current_page == 'questions'){
        header('Location: ' . ROOT_PATH . 'questions');
      }else{
        header('Location: ' . ROOT_PATH . 'questions/all');
      }
    }
    return;
  }

  public function edit(){
    if(!IS_LOGGED_IN || ROLE_NAME == 'USER'){
      header('Location: ' . ROOT_URL . 'questions');
    }
    $question_id = $_GET['id'];
    $this->query("SELECT question_text, question_body, questions.question_id, categories.category_id, categories.category_name, users.user_id, users.username FROM questions JOIN users ON questions.user_id = users.user_id
JOIN question_categories ON questions.question_id = question_categories.question_id
JOIN categories ON categories.category_id = question_categories.category_id WHERE questions.question_id = :question_id;");
    $this->bind(':question_id', $question_id);
    $row = $this->singleResult();
    return $row;
  }

  public function answers(){
    if(!IS_LOGGED_IN || ROLE_NAME == 'USER'){
      header('Location: ' . ROOT_URL . 'questions');
    }

    $question_id = $_GET['id'];
    $this->query('SELECT answers.is_displayed AS answer_displayed, * FROM answers JOIN questions ON answers.question_id = questions.question_id JOIN users ON answers.user_id = users.user_id WHERE answers.question_id = :question_id ORDER BY answers.published_at DESC');
    $this->bind(':question_id', $question_id);
    $rows = $this->resultSet();
    return $rows;
  }

  public function newAnswer(){
    // Sanitize POST
    $post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

    if($post['submit']){
      // Insert into DB
      $this->query('INSERT INTO answers(answer_text, user_id, question_id) VALUES (:answer_text, :user_id, :question_id)');
      $this->bind(':answer_text', $post['answer_text']);
      $this->bind(':user_id', $post['user_id']);
      $this->bind(':question_id', $post['question_id']);
      $this->execute();

      header('Location: ' . ROOT_URL . 'questions');
      Messages::setMessage('Answer added.', 'success');
      Messages::display();
      exit();
    }
    return;
  }

  public function editAnswer(){
    $answer_id = $_GET['id'];
    $this->query("SELECT * FROM answers WHERE answer_id = :answer_id LIMIT 1");
    $this->bind(':answer_id', $answer_id);
    $row = $this->singleResult();
    return $row;
  }

  public function updateAnswer(){
    // Sanitize POST
    $post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

    if($post['submit']){
      // Insert into DB
      $this->query('UPDATE answers SET is_displayed = :is_displayed, answer_text = :answer_text  WHERE answer_id = :answer_id');
      $this->bind(':answer_id', $post['answer_id']);
      $this->bind(':is_displayed', $post['is_displayed']);
      $this->bind(':answer_text', $post['answer_text']);
      $this->execute();
      header('Location: ' . ROOT_URL . 'questions');
    }
    return;
  }


  public function deleteAnswer(){
    if(!IS_LOGGED_IN || ROLE_NAME == 'USER'){
      header('Location: ' . ROOT_URL);
    }
    $answer_id = $_GET['id'];
    $current_page = $_SESSION['current_page'];
    $question_id = $_SESSION['last_question_id'];
    $this->query('DELETE FROM answers WHERE answer_id = :answer_id');
    $this->bind(':answer_id', $answer_id);
    if($this->execute()){
      if($current_page == 'questions'){
        header('Location: ' . ROOT_PATH . 'questions');
      }else{
        header('Location: ' . ROOT_PATH . 'questions/answers/' . $question_id);
      }
    }
    return;
  }

  public function hideAnswer(){
    if(!IS_LOGGED_IN || ROLE_NAME == 'USER'){
      header('Location: ' . ROOT_URL);
    }
    $answer_id = $_GET['id'];
    $current_page = $_SESSION['current_page'];
    $question_id = $_SESSION['last_question_id'];
    $this->query('UPDATE answers SET is_displayed = false WHERE answer_id = :answer_id');
    $this->bind(':answer_id', $answer_id);
    if($this->execute()){
      if($current_page == 'questions'){
        header('Location: ' . ROOT_PATH . 'questions');
      }else{
        header('Location: ' . ROOT_PATH . 'questions/answers/' . $question_id);
      }
    }
    return;
  }

  public function displayAnswer(){
    if(!IS_LOGGED_IN || ROLE_NAME == 'USER'){
      header('Location: ' . ROOT_URL);
    }
    $answer_id = $_GET['id'];
    $current_page = $_SESSION['current_page'];
    $question_id = $_SESSION['last_question_id'];
    $this->query('UPDATE answers SET is_displayed = true WHERE answer_id = :answer_id');
    $this->bind(':answer_id', $answer_id);
    if($this->execute()){
      if($current_page == 'questions'){
        header('Location: ' . ROOT_PATH . 'questions');
      }else{
        header('Location: ' . ROOT_PATH . 'questions/answers/' . $question_id );
      }
    }
  }

  public function ask(){
    if(!IS_LOGGED_IN){
      $msg = 'Please, ' . '<a href="' . ROOT_URL . 'users/login">login</a> to continue. ';
      Messages::setMessage($msg, 'error');
    }
    $post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

    if($post['submit']){
      $this->dbh->beginTransaction();
      $this->dbh->exec('INSERT INTO questions(question_text, user_id, question_body) VALUES(\'' . $post['question_text'] . '\', ' . $post['user_id'] . ', \'' . $post['question_body'] .'\')');
      $this->dbh->exec('INSERT INTO question_categories(category_id, question_id) 
(SELECT ' . $post['category_id1'] . ', question_id FROM questions ORDER BY question_id DESC LIMIT 1);');
      if($_POST['category_id2'] != '') {
        $this->dbh->exec('INSERT INTO question_categories(category_id, question_id) 
(SELECT ' . $post['category_id2'] . ', question_id FROM questions ORDER BY question_id DESC LIMIT 1);');
      }
      if($_POST['category_id3'] != ''){
        $this->dbh->exec('INSERT INTO question_categories(category_id, question_id) 
(SELECT ' . $post['category_id3'] . ', question_id FROM questions ORDER BY question_id DESC LIMIT 1);');
      }

      if($this->dbh->commit()){
        header('Location: ' . ROOT_PATH . 'questions');
      }
    }
    return;
  }

  public function update(){
    $post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
    //$query = 'UPDATE questions SET question_text = \'' . $post['question_text'] .'\', question_body = \'' . $post['question_body'] . '\' WHERE question_id = ' . $post['question_id'];
    //echo $query;

    $query1 = 'UPDATE question_categories SET category_id = ' . $post['category_id1'].' WHERE category_id = '. $post['old_category_id1'] . ' AND question_id = ' . $post['question_id'];
    $query2 = 'UPDATE question_categories SET category_id = ' . $post['category_id2'].' WHERE category_id = '. $post['old_category_id2'] . ' AND question_id = ' . $post['question_id'];
    $query3 = 'UPDATE question_categories SET category_id = ' . $post['category_id3'].' WHERE category_id = '. $post['old_category_id3'] . ' AND question_id = ' . $post['question_id'];


    if($post['submit']){
      $this->dbh->beginTransaction();
      $this->dbh->exec('UPDATE questions SET question_text = \'' . $post['question_text'] .'\', question_body = \'' . $post['question_body'] . '\' WHERE question_id = ' . $post['question_id']);

      // Category1 - can't be blank
      // old and new category defined
      if($post['category_id1'] != '' && $post['old_category_id1'] != ''){
        // old and new category are different -> update
        if($post['category_id1'] != $post['old_category_id1']){
          $this->dbh->exec($query1);
        }
      }

      // new category defined and old was not defined
      if($post['category_id1'] != '' && $post['old_category_id1'] == ''){
        // new category -> insert
        $this->dbh->exec('INSERT INTO question_categories(category_id, question_id) VALUES (' . $post['category_id1'] . ', ' . $post['question_id'] . ')');
      }

      // Category 2
      // old and new category defined
      if($post['category_id2'] != '' && $post['old_category_id2'] != ''){
        // old and new category are different -> update
        if(($post['category_id2'] != $post['old_category_id2'])){
          $this->dbh->exec($query2);
        }
      }
      // new category defined and old was not defined
      if($post['category_id2'] != '' && $post['old_category_id2'] == ''){
        // new category -> insert
        $this->dbh->exec('INSERT INTO question_categories(category_id, question_id) VALUES (' . $post['category_id2'] . ', ' . $post['question_id'] . ')');
      }
      // new category is blank and old was selected
      if($post['category_id2'] == '' && $post['old_category_id2'] != ''){
        // new category -> delete
        $this->dbh->exec('DELETE FROM question_categories WHERE category_id = '. $post['old_category_id2'] . ' AND question_id = ' . $post['question_id']);
      }

      // Category 3
      // old and new category defined
      if($post['category_id3'] != '' && $post['old_category_id3'] != ''){
        // old and new category are different -> update
        if(($post['category_id3'] != $post['old_category_id3'])){
          $this->dbh->exec($query3);
        }
      }
      // new category defined and old was not defined
      if($post['category_id3'] != '' && $post['old_category_id3'] == ''){
        // new category -> insert
        $this->dbh->exec('INSERT INTO question_categories(category_id, question_id) VALUES (' . $post['category_id3'] . ', ' . $post['question_id'] . ')');
      }
      // new category is blank and old was selected
      if($post['category_id3'] == '' && $post['old_category_id3'] != ''){
        // new category -> delete
        $this->dbh->exec('DELETE FROM question_categories WHERE category_id = '. $post['old_category_id3'] . ' AND question_id = ' . $post['question_id']);
      }

      if($this->dbh->commit()){
        header('Location: ' . ROOT_PATH . 'questions/all');
      }
    }
    return;

  }



}