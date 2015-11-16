update members set comments = concat(comments, '\n', deposit);

alter table members add column deposit_new tinyint(1) not null default 0 after membership_type_id;

alter table members add column deposit_expiration_date date null after deposit_new;

update members set deposit_new = 1 where deposit = 'Cheque' or deposit = 'Espece';

alter table members drop column deposit;

alter table members change column deposit_new deposit tinyint(1) not null default 0;

insert into schema_migrations values ('201511161800');
