CREATE TABLE IF NOT EXISTS `services` (
  `id` int(5) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(256) NOT NULL,
  `discount_disabled` bit(1) NOT NULL DEFAULT 0,
  `amount` int(5) NOT NULL, /*ct*/
  `description` varchar(256) NOT NULL,

  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


ALTER TABLE `jos_users` ADD `discount` double NOT NULL DEFAULT 0;


ALTER TABLE `zadmin_vanza2`.`flights`
  CHANGE COLUMN `pilot` `instructor` INT NULL,
  CHANGE COLUMN `passenger` `payer` INT NOT NULL,
  CHANGE COLUMN `task` `task` VARCHAR(20) CHARACTER SET 'utf8' COLLATE 'utf8_lithuanian_ci' NULL,
  CHANGE COLUMN `amount` `amount` DECIMAL(10,0) NULL,
  CHANGE COLUMN `duration` `duration` DECIMAL(2,2) NULL,
  ADD COLUMN `service_id` INT NULL;

ALTER TABLE `zadmin_vanza2`.`vak_balance_journal`
  DROP PRIMARY KEY;

ALTER TABLE `zadmin_vanza2`.`vak_balance_journal`
  ADD INDEX `IX_BALANCE_JOURNAL_ID_UPDATED` (`contact_id` ASC, `fee_updated` ASC) ;
