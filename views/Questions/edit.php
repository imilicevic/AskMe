<?php
 // $msg = Messages::setMessage('Please, login to continue.' , 'error');
 // if(!IS_LOGGED_IN)  Messages::display();
  $item = $viewModel;
?>
<div class="padded">
<?php if(IS_LOGGED_IN) : ?>
<h1 class="text-center">Edit Question: <span class="author"><?php echo $item['question_text']; ?></span></h1>
<div class="panel form">
  <div class="panel-body">
    <form action="<?php echo ROOT_URL . 'questions/update' ?>" method="POST">
      <div class="form-group">
        <label for="question_text">Question title:</label>
        <input type="text" name="question_text" class="form-control" placeholder="e.g. How to build an igloo?" value="<?php echo $item['question_text'] ?>" required /> <br />
        <label for="question_body">Question text: </label>
        <textarea name="question_body" class="form-control" placeholder="Detailed explanation of your question."><?php echo $item['question_body'] ?></textarea> <br />
        <label for="category_id">Categories:</label>
        <?php
          $qm = new QuestionModel();
          $categories = $qm->getAllCategories();
          $question_categories = $qm->getQuestionCategories($item['question_id']);
        ?>
        <div class="row">
        <?php for ($i = 1; $i < 4; $i++): ?>
          <div class="col-md-4">
            <select class="form-control" name="category_id<?php echo $i; ?>" <?php if($i == 1) echo 'required=required'; ?>>
              <option value="">Pick a category</option>
              <?php foreach($categories as $category) : ?>
                <option value="<?php echo $category['category_id']; ?>"
                  <?php if(isset($question_categories[$i-1]['category_id']) && $category['category_id'] == $question_categories[$i-1]['category_id']) echo 'selected="selected"' ?>><?php echo $category['category_name']; ?></option>
              <?php endforeach; ?>
            </select>
            <?php
              if(isset($question_categories[$i-1]['category_id'])){
                $cat = $question_categories[$i-1]['category_id'];
              }else {
                $cat = '';
              }
            ?>
            <input type="hidden" name="old_category_id<?php echo $i; ?>" value="<?php echo $cat ?>" />
          </div>
        <?php endfor; ?>
        </div>
        <input type="hidden" name="user_id" value="<?php echo $question_categories[0]['user_id'] ?>">
        <input type="hidden" name="question_id" value="<?php echo $item['question_id']; ?>">


        <br>
        <input type="submit" value="Update" class="btn btn-primary" name="submit"><br>
        <a href="<?php echo ROOT_PATH; ?>questions/all" class="btn btn-danger">Cancel</a>
      </div>
    </form>
  </div>
</div>
<?php endif; ?>
</div>
