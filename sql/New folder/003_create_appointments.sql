-- drop table if exists timeslots;
create table `timeslots` (
  `timeslot_id`     int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id`         int(10),
  `appointment_id`  int(10),
  `price`           int(10),
  `currency`     varchar(3),
  `type`         varchar(4),    /* appt, open    */
  `timeslot_address`  varchar(63),    /* where to find doctor    */
  `timeslot_location` varchar(31),    /* todo: change to other table    */
  `start`          datetime,
  `end`            datetime,
  PRIMARY KEY (`timeslot_id`)
);

-- drop table if exists appointments;
create table `appointments` (
  `appointment_id`  int(10) unsigned NOT NULL AUTO_INCREMENT,
  `doctor_id`       int(10),
  `patient_id`      int(10),
  `status`      varchar(12),
  `appt_type`   varchar(12),
  `apptcode`    varchar(8),
  `notes`       varchar(512),
  PRIMARY KEY (`appointment_id`)
);
