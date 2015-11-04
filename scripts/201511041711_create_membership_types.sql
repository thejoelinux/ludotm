CREATE TABLE `membership_types` (
	`id` int(11) NOT NULL AUTO_INCREMENT,
	`name` varchar(255) NOT NULL,
	`description` text DEFAULT NULL,
	PRIMARY KEY (`id`)  
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO membership_types (name) 
	VALUES ('Famille'),('Individuel'),('Nounou'),('Nounou+famille'),('Structure');

ALTER TABLE adherent ADD COLUMN membership_type_id int(11) AFTER adhesion;

UPDATE adherent a, membership_types mt
SET a.membership_type_id = mt.id
WHERE a.adhesion = mt.name;

INSERT INTO schema_migrations VALUES ('201511041711');
