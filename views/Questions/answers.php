<div class="table-responsive">
  <?php if(sizeof($viewModel) == 0) : ?>
    <h1>No answers found for this question.</h1>
  <?php else : ?>
    <h1>All answers for: <span class="author">
        <?php echo $viewModel[0]['question_text']; ?></span></h1>
    <table class="table table-bordered table-hover">
      <thead>
      <tr>
        <th>#</th>
        <th>Answer</th>
        <th>Username</th>
        <th>Published date</th>
        <th>Displayed</th>
        <th>Actions</th>
      </tr>
      </thead>
      <tbody>
    <?php foreach($viewModel as $item) :?>
        <?php $is_displayed = $item['answer_displayed'];
          $is_displayed = ($is_displayed == '' || $is_displayed == false) ? 'hidden' : 'visible';
        ?>

        <tr>
          <th scope="row"><?php echo $item['answer_id']; ?></th>
          <td><?php echo $item['answer_text']; ?></td>
          <td><?php echo $item['username']; ?></td>
          <td><?php echo Model::parse_timestamp($item['published_at'], 'd.m.Y. H:m'); ?></td>
          <td><?php echo $is_displayed; ?></td>
          <td>

            <?php if(IS_LOGGED_IN && (ROLE_NAME == 'ADMIN' || ROLE_NAME == 'MOD') )  : ?>
              <a class="btn btn-xs btn-default" href="<?php echo ROOT_PATH . 'questions/editAnswer/' . $item['answer_id'] ?>"><span class="glyphicon glyphicon-edit"></span> Edit</a>
              <?php if ($is_displayed == 'visible') : ?>
                <a class="btn btn-xs btn-warning" href="<?php echo ROOT_PATH . 'questions/hideAnswer/' . $item['answer_id'] ?>"><span class="glyphicon glyphicon-remove"></span> Hide</a>
              <?php else : ?>
                <a class="btn btn-xs btn-success" href="<?php echo ROOT_PATH . 'questions/displayAnswer/' . $item['answer_id'] ?>"><span class="glyphicon glyphicon-ok"></span> Show</a>
              <?php endif; ?>
            <?php endif; ?>
            <?php if(IS_LOGGED_IN && ROLE_NAME == 'ADMIN') : ?>
              <a class="btn btn-xs btn-danger" href="<?php echo ROOT_PATH . 'questions/deleteAnswer/' . $item['answer_id'] ?>"><span class="glyphicon glyphicon-trash"></span> Delete</a>
            <?php endif; ?>

          </td>
        </tr>
        <?php
          $_SESSION['last_question_id'] = $item['question_id'];
          $_SESSION['current_page'] = 'questions/answers';
        ?>
    <?php endforeach; ?>
      </tbody>
    </table>
  <?php endif; ?>
</div>