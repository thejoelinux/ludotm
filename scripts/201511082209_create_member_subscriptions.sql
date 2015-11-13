CREATE TABLE `member_subscriptions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `membership_type_id` int(11) NOT NULL,
  `payment_method_id` int(11) NOT NULL,
  `credit` tinyint(1) NOT NULL DEFAULT 0,
  `price` float(5,2) NOT NULL DEFAULT 0,
  `comments` text,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `index_member_sub_on_membership_type_id` (`membership_type_id`),
  KEY `index_member_sub_on_payment_method_id` (`payment_method_id`),
  CONSTRAINT `fk_member_sub_membership_type_id` FOREIGN KEY (`membership_type_id`) REFERENCES `membership_types` (`id`),
  CONSTRAINT `fk_member_sub_payment_method_id` FOREIGN KEY (`payment_method_id`) REFERENCES `payment_methods` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

alter table member_subscriptions add `member_id` int(11) NOT NULL after `end_date`;
alter table member_subscriptions add KEY `index_member_sub_on_member_id` (`member_id`);
ALTER TABLE `adherent` ENGINE = INNODB;
alter table member_subscriptions add CONSTRAINT `fk_member_sub_member_id` FOREIGN KEY (`member_id`) REFERENCES `adherent` (`id_adherent`);

INSERT INTO schema_migrations VALUES ('201511082209');
