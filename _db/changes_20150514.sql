ALTER TABLE `jos_users` ADD
      `instructor` tinyint(1) NOT NULL DEFAULT 0;

ALTER TABLE `jos_users` MODIFY
      `usertype` varchar(200) NOT NULL DEFAULT 'Registered';

ALTER TABLE `jos_users` ADD
      `deleted` date NULL;
