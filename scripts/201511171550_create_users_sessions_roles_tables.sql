CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(32) DEFAULT NULL,
  `password_digest` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `index_users_on_name` (`name`),
  UNIQUE KEY `index_users_on_email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `roles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(32) NOT NULL,
  `description` text DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `index_roles_on_name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `roles` (id, name, description,
	created_at, updated_at) VALUES
(1, 'admin', 'Gestion des roles', now(), now()),	
(2, 'games', 'Gestion des jeux', now(), now()),	
(3, 'members', 'Gestion des adhérents', now(), now());

CREATE TABLE `user_roles` (
  `user_id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  UNIQUE KEY `index_user_roles_uk` (`user_id`, `role_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO users (id, name, password_digest, email, active,
	created_at, updated_at) VALUES
(1, 'admin', 'luef5C4XumqIs', 'invalidmail@test.com', 1,
	now(), now());

INSERT INTO user_roles (user_id, role_id, created_at) VALUES
(1, 1, now());

INSERT INTO schema_migrations VALUES ('201511171550');	
