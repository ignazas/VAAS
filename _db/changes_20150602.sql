UPDATE `services` SET `amount`=`amount`/3.4528;

ALTER TABLE `services`
      ADD `is_flight` tinyint(1) NOT NULL DEFAULT 1,
      ADD `unit` varchar(10) NULL,
      ADD `amount_unit` int(3) NULL;

ALTER TABLE `jos_users`
      ADD `licenseNo` varchar(20) NULL,
      ADD `licenseValidTill` date NULL,
      ADD `healthNo` varchar(20) NULL,
      ADD `healthValidTill` date NULL;

ALTER TABLE `jos_users`
      ADD `instructor_id` int(3) NULL;

ALTER TABLE `services`
      MODIFY `discount_disabled` tinyint(1) NOT NULL DEFAULT 0;

ALTER TABLE `services`
      CHANGE COLUMN `discount_disabled` `is_discount` tinyint(1) NOT NULL DEFAULT 1;

ALTER TABLE `vak_aircrafts`
      ADD `deleted` date NULL;

ALTER TABLE `flights`
      MODIFY `duration` float NULL,
      MODIFY `amount` float NULL,
      MODIFY `price` float NULL;
