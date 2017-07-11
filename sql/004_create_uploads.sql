drop table if exists uploads;
create table `uploads` (
  `upload_id`       int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id`         int(10),
  `filesize`        int(10),
  `filepath`        varchar(128),
  `mimetype`        varchar(32),
  `nature`          varchar(5),
  `is_clean`        enum('yes','no','pending','unknown'),
  `is_relevant`     enum('yes','no','pending','unknown'),
  PRIMARY KEY (`upload_id`)
);