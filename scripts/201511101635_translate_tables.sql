CREATE TABLE `members` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `lastname` tinytext,
  `firstname` tinytext,
  `subscribe_date` date DEFAULT NULL,
  `birth_date` date DEFAULT NULL,
  `address` tinytext,
  `po_town` tinytext,
  `home_phone` tinytext,
  `work_phone` tinytext,
  `mobile_phone` tinytext,
  `fax_phone` tinytext,
  `comments` text,
  `member_ref` int(11) DEFAULT NULL,
  `subscription_label` enum('Famille','Individuel','Nounou','Nounou+famille','Structure') DEFAULT NULL,
  `membership_type_id` int(11) DEFAULT NULL,
  `email` tinytext,
  `newsletter` tinyint(1) DEFAULT NULL,
  `other_members` longtext,
  `deposit` enum('Cheque','Espece','Aucune') DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `games` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` tinytext,
  `reference` tinytext,
  `maker` tinytext,
  `category` tinytext,
  `comments` blob,
  `maker_info` tinytext,
  `content_inventory` blob,
  `aquisition_date` date NOT NULL DEFAULT '0000-00-00',
  `price` int(11) DEFAULT NULL,
  `players_min` int(11) DEFAULT NULL,
  `players_max` int(11) DEFAULT NULL,
  `age_min` int(11) DEFAULT NULL,
  `age_max` int(11) DEFAULT NULL,
  `game_type` tinytext,
  `esar_category_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

alter table categorie_esar rename to esar_categories;

alter table medias change id_jeu game_id int(11) not null;

alter table family_members change id_adherent member_id int(11);

CREATE TABLE `loans` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `game_id` int(11) DEFAULT NULL,
  `member_id` int(11) DEFAULT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `is_back` tinyint(4) DEFAULT NULL,
  `reglera_deprec` tinytext,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

insert into members select * from adherent;

insert into games select * from jeu;

insert into loans select * from prets;

alter table adherent rename to zzz_adherent;

alter table jeu rename to zzz_jeu;

alter table prets rename to zzz_prets;

alter table stats_jour rename to zzz_stats_jour;

alter table family_members change birthdate birth_date date null;

INSERT INTO schema_migrations VALUES ('201511101635');
