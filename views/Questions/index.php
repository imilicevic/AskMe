<div class="padded">
  <h1>Top Questions
    <?php if(IS_LOGGED_IN) :?>
    <a href="<?php echo ROOT_PATH;?>questions/ask" class="btn btn-success btn-add"><span class="glyphicon glyphicon-plus"></span> Add</a>
    <?php endif; ?>
  </h1>
<?php foreach($viewModel as $question) :?>
  <?php if($question['is_displayed']) :?>
    <?php
    // get Categories
    $qm = new QuestionModel();
    $res_categories = $qm->getCategories($question['question_id']);

    $res_answers = $qm->getAnswers($question['question_id']);
    $numAnswers = sizeof($res_answers);
    ?>
    <section class="question">
      <article class="question-item">
        <div class="pull-right">
          <?php if(IS_LOGGED_IN && (ROLE_NAME == 'MOD' || ROLE_NAME == 'ADMIN')) : ?>
            <a href="<?php echo ROOT_PATH; ?>questions/hide/<?php echo $question['question_id']; ?>" class="btn btn-xs btn-warning"><span class="glyphicon glyphicon-remove"></span> Hide </a>
            <?php if(IS_LOGGED_IN && ROLE_NAME == 'ADMIN' && $numAnswers == 0) : ?>
            <a href="<?php echo ROOT_PATH; ?>questions/delete/<?php echo $question['question_id']; ?>" class="btn btn-xs btn-danger"><span class="glyphicon glyphicon-remove"></span> Delete</a>
            <?php endif; ?>
          <?php endif; ?>
        </div>
        <div class="question-author">
          <span class="author"><?php echo $question['username'] ?></span> asked:
        </div>
        <h3><?php echo $question['question_text']; ?></h3>
        <?php if($question['question_body'] != '') : ?>
          <div class="question-body">
            <?php echo $question['question_body']; ?>
          </div>
        <?php endif; ?>
        <div class="question-categories">
          <small class="pull-right"><span class="glyphicon glyphicon-calendar"></span> <?php echo Model::parse_timestamp($question['published_at']);?></small>
          <?php foreach ($res_categories as $category) : ?>
            <span class="btn btn-default btn-xs"><?php echo $category['category_name']; ?></span>
          <?php endforeach; ?>
        </div>
        <?php if(IS_LOGGED_IN) :?>
        <div class="answers-count">
          <?php
            if($numAnswers != 0)
              echo $numAnswers . ' answers';
            else
              echo $numAnswers . ' answers. Be the first to answer.';
          ?>
        </div>
        <?php endif; ?>
        <div class="question-comments">
          <?php foreach($res_answers as $answer) : ?>
            <?php if($answer['is_displayed']) : ?>
            <div class="comment well">
              <?php if(IS_LOGGED_IN && (ROLE_NAME == 'MOD' || ROLE_NAME == 'ADMIN')) : ?>
                <div class="mod-options pull-right">
                  <a href="<?php echo ROOT_PATH; ?>questions/editAnswer/<?php echo $answer['answer_id'] ?>" class="btn btn-xs btn-default"><span class="glyphicon glyphicon-edit"></span> Edit</a>
                  <a href="<?php echo ROOT_PATH; ?>questions/hideAnswer/<?php echo $answer['answer_id'] ?>" class="btn btn-xs btn-warning"><span class="glyphicon glyphicon-remove"></span> Hide</a>
                <?php if(IS_LOGGED_IN && ROLE_NAME == 'ADMIN') : ?>
                    <a href="<?php echo ROOT_PATH; ?>questions/deleteAnswer/<?php echo $answer['answer_id'] ?>" class="btn btn-xs btn-danger "><span class="glyphicon glyphicon-trash"> </span> Delete</a>
                <?php endif; ?>
                </div>
              <?php endif; ?>
              <small class="pull-right answer-date"><span class="glyphicon glyphicon-calendar"></span> <?php echo Model::parse_timestamp($answer['published_at']); ?></small>
              <div class="answer-author">
                <span class="author"><?php echo $answer['username'] ?></span> said:
              </div>
              <div class="comment-body"><?php echo $answer['answer_text']; ?></div>

              <?php if(IS_LOGGED_IN) : ?>
                <?php
                  $res_vote = $qm->getVotes($answer['answer_id']);
                  $res_vote = ($res_vote['score'] == '') ? 0 : $res_vote['score'];
                ?>
                <div class="answer-vote">
                  <form action="<?php echo ROOT_PATH; ?>questions/vote" method="POST">
                    <input type="hidden" name="answer_id" value="<?php echo $answer['answer_id']; ?>">
                    <input type="hidden" name="user_id" value="<?php echo $answer['user_id']; ?>">
                    <input type="hidden" name="answer_score" value="<?php echo $res_vote; ?>">
                    <button class="btn btn-default btn-xs" type="submit" name="submit" value="upvote"><span class="glyphicon glyphicon-thumbs-up" ></span></button>
                    <span class="score-result"><?php echo $res_vote; ?></span>
                    <button class="btn btn-default btn-xs" type="submit" name="submit" value="downvote"><span class="glyphicon glyphicon-thumbs-down"></span></button>
                  </form>
                </div>
              <?php endif; ?>
            </div>
            <?php endif; ?>
          <?php endforeach; ?>
        </div>
        <?php if(IS_LOGGED_IN) : ?>
          <h4 class="text-center no-margin">Have something to add?</h4>
          <div class="panel form answer">
            <div class="panel-body">
              <form action="<?php echo ROOT_PATH; ?>questions/newAnswer" method="POST">
                <input type="hidden" name="user_id" value="<?php echo LOGGED_USER_ID; ?>"/>
                <input type="hidden" name="question_id" value="<?php echo $question['question_id']; ?>"/>
                <label for="name">Answer:</label>
                <textarea name="answer_text" class="form-control" placeholder="Share your knowledge." required></textarea>
                <br>
                <input type="submit" class="btn btn-primary" value="Post"  name="submit">
              </form>
            </div>
          </div>
        <?php endif; ?>
      </article>
    </section>
  <?php endif; ?>
<?php endforeach; ?>
</div>
<?php $_SESSION['current_page'] = 'questions'; ?>






