drop table if exists emails;
create table `emails` (
  `email_id`        int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id`         int(10),
  `subject`         varchar(255),
  `user_email`      varchar(45),
  `content`         text,
  `nature`          varchar(5),
  `status`          enum('queued','processing','sent'),
  `times_sent`      int(5),
  `created_on`      datetime default CURRENT_TIMESTAMP
  PRIMARY KEY (`email_id`)
);

drop table if exists payments;
create table `emails` (
  `payment_id`      int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user`            int(10),
  `account_number`  varchar(255),
  `routing_number`  varchar(45),
  `direction`       enum('to_user','from_user'),
  `amount`          varchar(10),
  `currency`        varchar(4),
  `label`           varchar(255),
  `type`            varchar(31),
  `status`          varchar(15),
  `depends_on`      int(10)           -- only perfrom this transaction after depends_on is also completed.
  PRIMARY KEY (`payment_id`)
);