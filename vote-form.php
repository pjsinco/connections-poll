<?php

/* display a vote form */
require_once('vote-config.php');
$poll = $_GET('poll');
if (!is_numeric($poll)) {
  die('Invalid poll');
}

/* look up the poll in the database */
$sql = "SELECT p.question, a.answer, a.answer_id
        FROM conn_poll p inner join conn_answer a
        ON p.id = a.poll_id
        p.id = $poll;";

$result = mysqli_query($sql, $db) or die("mysql error: " . mysql_error());

if (mysql_num_rows($result) == 0) {
  die('Invalid poll.');
}

/* if the user has already voted, show the results. */
if ($_COOKIE["poll_voted $poll"]) {
  header("Location: vote_tally.php?poll=$poll");
  exit;
}

/* vote form */
$question_list = "";
while($row = mysql_fetch_array($result)) {

}


?>
