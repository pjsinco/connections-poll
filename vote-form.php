<?php

/* display a vote form */
require_once('vote-config.php');
$poll = $_GET['poll'];
  if (!is_numeric($poll)) {
    die('Invalid poll');
  }


/* look up the poll in the database */
$sql = "SELECT p.question, a.answer, a.answer_id
        FROM conn_poll p INNER JOIN conn_answer a
          ON p.id = a.poll_id
        WHERE p.id = $poll";


$result = mysql_query($sql, $db) or die("mysql error: " . mysql_error());

if (mysql_num_rows($result) == 0) {
  die('Invalid poll.');
}

/* if the user has already voted, show the results. */
if ($_COOKIE["poll_voted_$poll"]) {
//  header("Location: vote_tally.php?poll=$poll");

  /* ... instead, we'll tell the user he's already voted */
  header("Location: already-voted.php");
  exit;
}

/* vote form */
$question_list = "";
while($row = mysql_fetch_array($result)) {
  $question = $row['question'];
  $question_list .= '<li><input name="answer" type="radio" value="' . $row['answer_id'] . '"> ' . $row['answer'] . '</li>';
}

?>
<?php require('poll-template.php'); ?>
      <p><strong><?php echo $question; ?></strong></p>
      <form action="vote-process.php" method="post">
        <ul style="list-style-type: none; padding-left: 0px;">
          <?php echo $question_list; ?>
        </ul>
        <input name='poll' type='hidden' value='<?php echo $poll; ?>'>
        <input name='' type='submit' value='Submit vote'>
      </form>
    </div> <!-- end #content -->
  </div> <!-- end #page -->

</body>
</html>
