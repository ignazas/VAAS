UPDATE `services` SET `amount`=`amount`/3.4528;

ALTER TABLE `services`
      ADD `is_flight` tinyint(1) NOT NULL DEFAULT 1,
      ADD `unit` varchar(10) NULL,
      ADD `amount_unit` int(3) NULL;
