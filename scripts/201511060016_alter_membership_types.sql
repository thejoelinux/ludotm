ALTER TABLE membership_types ADD COLUMN price float(7,2);

INSERT INTO schema_migrations VALUES ('201511060016');
