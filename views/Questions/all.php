<div class="table-responsive">
  <h1>All Questions</h1>
  <table class="table table-bordered table-hover">
    <thead>
    <tr>
      <th>#</th>
      <th>Question</th>
      <th>Username</th>
      <th>Published date</th>
      <th>Displayed</th>
      <th>No. of Answers</th>
      <th>Actions</th>
    </tr>
    </thead>
    <tbody>
    <?php $qm = new QuestionModel(); ?>
    <?php foreach($viewModel as $item) :?>
      <?php $is_displayed = $item['is_displayed'];
        $is_displayed = ($is_displayed == '') ? 'hidden' : 'visible';
      ?>

      <tr>
        <th scope="row"><?php echo $item['question_id']; ?></th>
        <td><?php echo $item['question_text']; ?></td>
        <td><?php echo $item['username']; ?></td>
        <td><?php echo Model::parse_timestamp($item['published_at'], 'd.m.Y. H:m'); ?></td>
        <td><?php echo $is_displayed; ?></td>
        <td class="text-center"><?php
            $qm = new QuestionModel();
            $count =  $qm->getNumberOfAnswers($item['question_id']);
            echo $count['count']; ?></td>
        <td>
          <?php if(IS_LOGGED_IN && (ROLE_NAME == 'ADMIN' || ROLE_NAME == 'MOD') )  : ?>
            <a class="btn btn-xs btn-default" href="<?php echo ROOT_PATH . 'questions/edit/' . $item['question_id'] ?>"><span class="glyphicon glyphicon-edit"></span> Edit</a>
            <a class="btn btn-xs btn-default" href="<?php echo ROOT_PATH . 'questions/answers/' . $item['question_id'] ?>"><span class="glyphicon glyphicon-comment"></span> Answers</a>
            <?php if ($is_displayed == 'visible') : ?>
              <a class="btn btn-xs btn-warning" href="<?php echo ROOT_PATH . 'questions/hide/' . $item['question_id'] ?>"><span class="glyphicon glyphicon-remove"></span> Hide</a></a>
            <?php else : ?>
              <a class="btn btn-xs btn-success" href="<?php echo ROOT_PATH . 'questions/display/' . $item['question_id'] ?>"><span class="glyphicon glyphicon-ok"></span> Show</a>
            <?php endif; ?>
          <?php endif; ?>
          <?php if(IS_LOGGED_IN && ROLE_NAME == 'ADMIN' && $count['count'] == 0) : ?>
            <a class="btn btn-xs btn-danger" href="<?php echo ROOT_PATH . 'questions/delete/' . $item['question_id'] ?>"><span class="glyphicon glyphicon-trash"></span> Delete</a>
          <?php endif; ?>
        </td>
      </tr>
    <?php endforeach; ?>
    </tbody>
  </table>
</div>
<?php $_SESSION['current_page'] = 'questions/all'; ?>