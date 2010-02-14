DROP TABLE IF EXISTS `mi_lists`;
CREATE TABLE `mi_lists` (
  `id` char(36) NOT NULL,
  `site_id` char(36) DEFAULT NULL,
  `section` varchar(30) NOT NULL,
  `super_section` varchar(30) NOT NULL,
  `model` varchar(30) NOT NULL,
  `foreign_id` char(36) NOT NULL,
  `order` tinyint(2) unsigned NOT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `model` (`model`,`foreign_id`,`site_id`,`super_section`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
