<?php $item = $viewModel; ?>
<h1>Edit Answer</h1>
<div class="panel panel-default">
  <div class="panel-heading">
    <h3 class="panel-title">Edit Answer</h3>
  </div>
  <div class="panel-body">
    <form action="<?php echo ROOT_URL . 'questions/updateAnswer' ?>" method="POST">
      <div class="form-group">
        <input type="hidden" name="answer_id" value="<?php echo $item['answer_id'] ?>">
        <label for="answer_text">Answer text</label>
        <textarea name="answer_text" class="form-control" required><?php echo $item['answer_text'];?></textarea><br />
        <?php if((IS_LOGGED_IN) && (ROLE_NAME == 'MOD' || ROLE_NAME == 'ADMIN')) : ?>
        <label for="is_displayed">Displayed</label><br />
        <input type="radio" name="is_displayed" value="1" <?php if($item['is_displayed'] == true) echo 'checked="checked"'?>> yes <br />
        <input type="radio" name="is_displayed" value="0" <?php if($item['is_displayed'] == false) echo 'checked="checked"'?>> no <br />
        <?php endif ?>
        <input type="submit" value="Update" class="btn btn-primary" name="submit">
        <a href="<?php echo ROOT_PATH; ?>questions/" class="btn btn-danger">Cancel</a>
      </div>
    </form>
  </div>
</div>