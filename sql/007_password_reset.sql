 drop table if exists password_reset;
CREATE TABLE `password_reset` (
  `user_id` 	int(10) unsigned NOT NULL,
  `reset_code` 	varchar(24),
  PRIMARY KEY (`user_id`)
);