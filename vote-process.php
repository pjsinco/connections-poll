<?php

// recipe from Wicked Cool PHP

/*
The role of vote-process.php is to add a vote to the database 
if the vote is valid. Start by loading the database configuration 
and making sure that the poll and answer parameters are numbers.
*/
require_once('vote-config.php');

$poll = $_POST['poll'];
$answer = $_POST['answer'];
if (!is_numeric($poll) || !is_numeric($answer)) {
  die('Invalid poll or answer');
}

/*
We can verify that the poll ID and answer are actually valid 
by looking for rows that match them in the database. 
If they check out, a join on the poll and answer tables 
with these keys will result in exactly one row. 
However, it's good enough just to see if there are 
no results to this query:
*/

/* look up the poll and the answer */
$sql = "SELECT a.answer_id
        FROM conn_poll p INNER JOIN conn_answer a
          ON p.id = a.poll_id
        WHERE p.id = $poll
          AND a.answer_id = $answer";

$result = mysql_query($sql, $db) or die (mysql_error());

if (mysql_num_rows($result) == 0) {
  die ('Invalid poll or answer.');
}

/*
If we've gotten this far, we can verify that the user 
has not already voted and insert a vote row into the 
vote table if everything checks out:
*/

/* check for prior votes */
if (!$_COOKIE["poll_voted_$poll"]) {
  /* insert the vote */
  $sql = "INSERT INTO conn_vote(answer_id, poll_id)
          VALUES($answer, $poll);";
  $result = mysql_query($sql, $db) or 
    die ("Couldn't insert: " . mysql_error());

  /*
  If we were successful at inserting the vote, we can set the 
  cookie that indicates that the user has already voted. 
  This cookie will expire in 30 days.
  */

  /* mark the poll as voted */
  setcookie("poll_voted_$poll", "1", time() + (60 * 60 * 24 * 30)); 
}

/*
Finally, regardless of whether or not the user has previously 
voted, we send the user to the poll results:
*/
// header("Location: vote-tally.php?poll=$poll");

/* ... instead, we'll just thank the user */
header("Location: thank-you.php");

?>
