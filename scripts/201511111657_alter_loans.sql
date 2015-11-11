alter table loans change is_back is_back tinyint(4) NOT NULL DEFAULT 0;

INSERT INTO schema_migrations VALUES ('201511111657');
