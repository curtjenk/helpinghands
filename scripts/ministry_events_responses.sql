-- AFter export from helpinghands to ministry db

-- set all events organization_id to Legacy builders
update events set organization_id = (select id from organizations
    where name like 'Legacy Builders%'
    limit 1);

-- Set primary key on users
-- run as postgres user via command line
select setval('events_id_seq', (select max(id) from events));
select setval('responses_id_seq', (select max(id) from responses));
