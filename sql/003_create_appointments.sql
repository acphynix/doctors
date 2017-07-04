drop table if exists timeslots;
create table `timeslots` (
  `timeslot_id`     int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id`         int(10),
  `appointment_id`  int(10),
  `price`           int(10),
  `currency`     varchar(3),
  `type`         varchar(4),    /* appt, open    */
  `start`          datetime,
  `end`            datetime,
  PRIMARY KEY (`timeslot_id`)
);

drop table if exists appointments;
create table `appointments` (
  `appointment_id`  int(10) unsigned NOT NULL AUTO_INCREMENT,
  `price`           int(10),
  `currency`     varchar(3),
  `doctor_id`       int(10),
  `patient_id`      int(10),
  `status`      varchar(12),
  `type`        varchar(12),
  `notes`      varchar(512),
  PRIMARY KEY (`appointment_id`)
);
