<div class="padded">
<?php if(IS_LOGGED_IN) : ?>
<h1>Ask Question</h1>
<div class="panel form">
  <div class="panel-body">
    <form action="<?php $_SERVER['PHP_SELF']; ?>" method="POST">
      <div class="form-group">
        <label for="question_text">Question title:</label>
        <input type="text" name="question_text" class="form-control" placeholder="e.g. How to build an igloo?" required /> <br />
        <label for="question_body">Question text: </label>
        <textarea name="question_body" class="form-control" placeholder="Detailed explanation of your question." required></textarea> <br />
        <label for="category_id">Categories:</label>
        <?php
          $qm = new QuestionModel();
          $categories = $qm->getAllCategories();
        ?>
        <div class="row">
        <?php for ($i = 1; $i < 4; $i++): ?>
          <div class="col-md-4">
            <select class="form-control" name="category_id<?php echo $i; ?>" <?php if($i == 1) echo 'required=required'; ?>>
              <option value="">Pick a category</option>
              <?php foreach($categories as $category) : ?>
                <option value="<?php echo $category['category_id']; ?>"><?php echo $category['category_name']; ?></option>
              <?php endforeach; ?>
            </select>
          </div>
        <?php endfor; ?>
        </div>
        <input type="hidden" name="user_id" value="<?php echo LOGGED_USER_ID; ?>">

        <br>
        <input type="submit" value="Ask" class="btn btn-primary" name="submit"><br>
        <a href="<?php echo ROOT_PATH; ?>questions" class="btn btn-danger">Cancel</a>
      </div>
    </form>
  </div>
</div>
<?php endif; ?>
</div>
