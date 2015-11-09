ALTER TABLE prets ADD COLUMN `created_at` datetime NOT NULL;
ALTER TABLE prets ADD COLUMN `updated_at` datetime NOT NULL;

INSERT INTO schema_migrations VALUES ('201511091019');
