CREATE TABLE IF NOT EXISTS `flights` (
  `record_id` int(11) NOT NULL AUTO_INCREMENT,
  `date` date NOT NULL,
  `airplane_registration` varchar(6) NOT NULL,
  `pilot` varchar(25) NOT NULL,
  `passenger` varchar(25) NOT NULL,
  `task` varchar(20) NOT NULL,
  `amount` int(3) NOT NULL,
  `duration` decimal(2,2) NOT NULL,
  PRIMARY KEY (`record_id`),
  UNIQUE KEY `record_id` (`record_id`)
);

CREATE TABLE IF NOT EXISTS `aircrafts` (
  `registration` varchar(6) NOT NULL,
  `model` varchar(15) NOT NULL,
  UNIQUE KEY `registration` (`registration`)
);

ALTER TABLE `aircrafts` CHANGE `registration` `callsign` VARCHAR(6) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL;