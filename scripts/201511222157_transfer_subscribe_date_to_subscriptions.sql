-- set subscribe_date to NULL when members have already a
-- subscription
UPDATE members m JOIN subscriptions s 
ON m.id = s.member_id AND m.subscribe_date = s.start_date 
SET m.subscribe_date = NULL;

-- all subscribe_date < 2012-01-01 set to NULL
UPDATE members
SET subscribe_date = NULL
WHERE subscribe_date < '2012-01-01';

-- 
INSERT INTO subscriptions
(start_date, end_date, member_id, membership_type_id,
    payment_method_id, credit, price,
    created_at, updated_at)
SELECT subscribe_date, DATE_ADD(subscribe_date, INTERVAL 1 YEAR),
    id, membership_type_id, 1, 0, 40, now(), now()
FROM members 
WHERE subscribe_date IS NOT NULL 
ORDER BY subscribe_date ASC;

ALTER TABLE `members`
  DROP `subscribe_date`,
  DROP `subscription_label`,
  DROP `membership_type_id`;

insert into schema_migrations values ('201511222157');












