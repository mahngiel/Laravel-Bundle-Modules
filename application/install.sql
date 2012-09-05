CREATE TABLE IF NOT EXISTS `module_areas` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `area_name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `area_slug` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `area_name` (`area_name`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;
-- command split --
CREATE TABLE IF NOT EXISTS `modules` (
  `id` mediumint(3) NOT NULL AUTO_INCREMENT,
  `area_id` int(10) NOT NULL,
  `module_name` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  `module_slug` varchar(24) COLLATE utf8_unicode_ci NOT NULL,
  `module_settings` text COLLATE utf8_unicode_ci NOT NULL,
  `module_priority` int(3) NOT NULL,
  `updated_at` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`module_name`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;
