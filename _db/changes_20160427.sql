ALTER TABLE `services` ADD `default_duration` FLOAT NULL;
ALTER TABLE `services` ADD `is_price_for_duration` tinyint(1) NOT NULL DEFAULT 0;

