ALTER TABLE members ADD COLUMN `created_at` datetime NOT NULL;
ALTER TABLE members ADD COLUMN `updated_at` datetime NOT NULL;

ALTER TABLE payment_methods ADD COLUMN `created_at` datetime NOT NULL;
ALTER TABLE payment_methods ADD COLUMN `updated_at` datetime NOT NULL;

ALTER TABLE esar_categories ADD COLUMN `created_at` datetime NOT NULL;
ALTER TABLE esar_categories ADD COLUMN `updated_at` datetime NOT NULL;

ALTER TABLE membership_types ADD COLUMN `created_at` datetime NOT NULL;
ALTER TABLE membership_types ADD COLUMN `updated_at` datetime NOT NULL;

INSERT INTO schema_migrations VALUES ('201511132227');
