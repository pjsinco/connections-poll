connections-poll
================
How to make a poll question

1.) Insert the question
insert into conn_poll(question)
  values('I would like more information and guidance about how to promote the JAOA to my colleagues and institution.')


2.) Insert the answers
insert into conn_answer(answer, poll_id)
  values('Agree', 11);

insert into conn_answer(answer, poll_id)
  values('Neither agree nor disagree', 11);

insert into conn_answer(answer, poll_id)
  values('Disagree', 11);

3.) Link: http://www.do-online.org/JAOA/connections/poll/vote-form.php?poll=<poll-id>

4.) View results: http://www.do-online.org/JAOA/connections/poll/vote-tally.php?poll=<poll-id>
