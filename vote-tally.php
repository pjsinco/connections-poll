<?php

/* display results of a poll */
require_once('vote-config.php');

$poll = $_REQUEST['poll'];

echo '<pre>';
print_r($poll);
echo '</pre>';

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







echo 'hello, vote tally goes here';

?>
