/*
 * Manually export from helpinghands to ministry
 *   users, events & responses
 *
 * Instructions:
 * users
 *  skip role_id, organization_id
 *
 *  SQL below run post users export
 */

-- Confirm organizations were added during migrations
-- org id 1 = Ministry Engage
-- 2 = Cornerstone
-- 3 = Legacy Builders

-- Role 1 = Site Admin
--  2 = Admin
--  4 = Member

--- Run from command line using
---  su - postgres
---  psql ministry (per the .env file)
grant all privileges on all tables in schema public to curtis;
grant all privileges on all tables in schema public to helping;

-- Add all users to Legacy Builders org (except the Site admin and curtis)
insert into organization_user (organization_id, user_id, role_id)
select 3, id, 4 from users where id not in (1, 32);

--Make legacy builders user the site owner/admin
insert into organization_user (organization_id, user_id, role_id)
values (1, 1, 1);

--Make curtis admin of Cornerstone
insert into organization_user (organization_id, user_id, role_id)
values (2, 32, 2);

-- Make curtis admin of Legacy Builders
insert into organization_user (organization_id, user_id, role_id)
values (3, 32, 2);

-- Set primary key on users
-- run as postgres user via command line
SELECT setval('users_id_seq', (SELECT max(id) FROM users))

------  Ancillary scripts below ------
select * from organizations

select * from users where id in (1, 32)