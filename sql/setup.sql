-- create database HealthTechSchema;

use HealthTechSchema;

drop table users;
CREATE TABLE `users` (
  `user_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_password` varchar(64) NOT NULL,
  `user_first_name` varchar(45) NOT NULL,
  `user_middle_name` varchar(45) DEFAULT NULL,
  `user_last_name` varchar(45) NOT NULL,
  `user_dob` varchar(45) NOT NULL,
  `user_address` varchar(255) NOT NULL,
  `user_sex` enum('M','F','O') DEFAULT NULL COMMENT 'NULL = unknown',
  `user_status` enum('pending','verified','suspended') NOT NULL,
  `user_is_doctor` tinyint(4) NOT NULL COMMENT 'Boolean - specifies whether or not the user is also a doctor',
  `user_preexisting_conditions` varchar(2047) DEFAULT NULL,
  `user_email` varchar(45) DEFAULT NULL COMMENT 'One profile per email',
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `user_id_UNIQUE` (`user_id`),
  UNIQUE KEY `user_email_UNIQUE` (`user_email`)
);

drop table doctors;
CREATE TABLE `doctors` (
  `user_id` int(10) unsigned NOT NULL,
  `doctor_prof_picture` varchar(127) NOT NULL,
  `doctor_cert_status` varchar(12),
  `doctor_registration_number` varchar(11) DEFAULT NULL,
  `doctor_suspension_status` varchar(45) DEFAULT NULL COMMENT 'Is a string',
  `doctor_speciality` varchar(45) NOT NULL,
  `doctor_location` varchar(45) NOT NULL,
  `doctor_hospitals` varchar(255),
  `doctor_qualifications` varchar(255),
  `doctor_affiliations` varchar(255),
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `user_id_UNIQUE` (`user_id`)
);

drop table email_verify;
CREATE TABLE `email_verify` (
  `user_id` int(10) unsigned NOT NULL,
  `verify_code` varchar(24) NOT NULL,
  PRIMARY KEY (`user_id`)
);