<?php

/* display results of a poll */
require_once('vote-config.php');

$poll = $_REQUEST['poll'];

if (!is_numeric($poll)) {
  die('Invalid poll');
}

/*
When checking for a valid poll ID, we may as well look up 
the poll question at the same time, because we eventually 
want to display this information:
*/

$sql = "SELECT question
        FROM conn_poll
        WHERE id = $poll;";

$result = mysql_query($sql, $db) or die (mysql_error());

if (mysql_num_rows($result) != 1) {
  die('Invalid poll.');
}
$row = mysql_fetch_array($result);
$question = $row['question'];

/*
Let's find out the total number of votes in order to give some percentages 
on the individual choices later on:
*/
$sql = "SELECT count(*) as num_total_votes
        FROM conn_vote
        WHERE poll_id = $poll;";
$result = mysql_query($sql, $db) or die (mysql_error());
$row = mysql_fetch_array($result);
$num_total_votes = $row['num_total_votes'];

// debug
// echo '<pre>';
// print_r($num_total_votes);
// echo '</pre>';


$sql = "SELECT a.answer, a.answer_id, count(v.answer_id) 
          as num_votes
        FROM conn_answer a LEFT JOIN conn_vote v
          on a.poll_id = v.poll_id
          and a.answer_id = v.answer_id
        where a.poll_id = $poll
        group by a.answer_id
        order by num_votes desc, a.answer asc;";
$result = mysql_query($sql, $db) or die ('mysql error: ' . mysql_error());



/*
With the query results ready to roll, we prepare the HTML 
header and the first piece of the page:
*/
?>

<!DOCTYPE html>
<html>
<head>
  <title>Poll: <?php echo $question; ?></title>
</head>
<body>
  <ul style="list-style-type: none; font-size: 12px;">
    <li style="font-weight: bold; padding-bottom: 10px;">Poll results: <?php echo $question; ?></li>
    <?php
    while($row = mysql_fetch_array($result)): 
      if ($num_total_votes != 0) {
        $pct = sprintf("%.2f", 100.0 * $row['num_votes'] 
          / $num_total_votes);
      } else {
        $pct = 0;
      }
      
      $boxwidth = strval(1 + intval($pct)) . 'px';
    ?>
      <li style="clear: left;">
      <?php echo $row['answer']; ?>
      </li>
      <li style="clear: left; padding-bottom: 7px;">
        <div style="width: <?php echo $boxwidth; ?>; height: 15px; background-color: #333333; margin-right: 5px; float: left;"></div>
        </li>
      <?php endwhile; ?>
    <li style="clear: left">Total votes: <?php echo $num_total_votes; ?>
    </li>
  </ul>
</body>
</html>





