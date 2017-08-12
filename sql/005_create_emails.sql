drop table if exists emails;
create table `emails` (
  `email_id`        int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id`         int(10),
  `subject`         varchar(255),
  `user_email`      varchar(45),
  `filepath`        varchar(128),
  `nature`          varchar(5),
  `status`          enum('queued','processing','sent'),
  `times_sent`      int(5),
  PRIMARY KEY (`email_id`)
);