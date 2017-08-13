drop table if exists actions;
create table `actions` (
  `action_id`       int(10) unsigned NOT NULL AUTO_INCREMENT,
  `action_exec`     varchar(511) not null,
  `silent`          int(2) default 0,
  `action_status`   enum('queued','processing','complete') default 'queued',
  `created_on`      datetime default CURRENT_TIMESTAMP,
  `performed_on`    datetime,
  PRIMARY KEY (`action_id`)
);
