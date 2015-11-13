-- initialize schema_migrations
CREATE TABLE `schema_migrations` (
  `version` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  UNIQUE KEY `unique_schema_migrations` (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `media_types` (
	`id` int(11) NOT NULL AUTO_INCREMENT, 
	`description` varchar(255) DEFAULT NULL,
	`mime_type` varchar(255) NOT NULL, 
	PRIMARY KEY (`id`)  
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO media_types (description, mime_type) VALUES ('Image PNG', 'image/png');
INSERT INTO media_types (description, mime_type) VALUES ('Image GIF', 'image/gif');
INSERT INTO media_types (description, mime_type) VALUES ('Image JPG', 'image/jpg');
INSERT INTO media_types (description, mime_type) VALUES ('Fichier PDF', 'application/pdf');

INSERT INTO schema_migrations VALUES ('201511032238');
