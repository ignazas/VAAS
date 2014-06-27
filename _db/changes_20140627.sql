CREATE TABLE IF NOT EXISTS `services` (
  `id` int(5) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(256) NOT NULL,
  `discount_disabled` bit(1) NOT NULL DEFAULT 0,
  `amount` int(5) NOT NULL, /*ct*/
  `description` varchar(256) NOT NULL,
  
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
