drop table if exists emails;
create table `emails` (
  `email_id`        int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id`         int(10) unsigned NOT NULL,
  `email_type`      varchar(128) NOT NULL,
  `user_email`      varchar(45),
  `subject`         varchar(255),
  `content`         text,
  `email_status`    enum('new','queued','processing','sent') default 'new',
  `times_sent`      int(5) default '0',
  `created_on`      datetime default CURRENT_TIMESTAMP,
  `sent_on`         datetime,
  PRIMARY KEY (`email_id`)
);

drop table if exists payments;
create table `payments` (
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
  `depends_on`      int(10),           -- only perfrom this transaction after depends_on is also completed.
  PRIMARY KEY (`payment_id`)
);