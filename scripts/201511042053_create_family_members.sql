CREATE TABLE `family_members` (
	`id` int(11) NOT NULL AUTO_INCREMENT,
	`firstname` varchar(255) NOT NULL,
	`lastname` varchar(255) NOT NULL,
	`id_adherent` int(11) NOT NULL,
	`birthdate` date NULL,
	`link_id` int(11) NULL,
	`description` text DEFAULT NULL,
	PRIMARY KEY (`id`)  
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO schema_migrations VALUES ('201511042053');
