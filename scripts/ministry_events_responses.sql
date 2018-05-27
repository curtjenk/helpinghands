-- AFter export from helpinghands to ministry db

-- Set primary key on users
-- run as postgres user via command line
select setval('events_id_seq', (select max(id) from events));
select setval('responses_id_seq', (select max(id) from responses));

