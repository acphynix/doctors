 drop table if exists users_feedback;
CREATE TABLE `users_feedback` (
  `user_feedback_id` 	int(10) unsigned NOT NULL,
  `user_first_name` 	varchar(45) NOT NULL,
  `user_email` 			varchar(45) NOT NULL,
  `content` 			text NOT NULL,
  PRIMARY KEY (`user_feedback_id`)
);