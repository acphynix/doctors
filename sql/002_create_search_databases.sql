drop table specialities;
create table `specialities` (
  `speciality` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `speciality_name` varchar(32) NOT NULL,
  PRIMARY KEY (`speciality`)
);

load data local infile '../rsc/list_specialities.txt' into table specialities
  fields terminated by ',' enclosed by '' escaped by '\\'
  lines terminated  by '\n' starting by '';



drop table speciality_keywords;
create table `speciality_keywords` (
  `id`         int(10) unsigned NOT NULL AUTO_INCREMENT,
  `speciality` int(10) unsigned NOT NULL,
  `keyword`    varchar(32) NOT NULL,
  PRIMARY KEY (`id`)
);

load data local infile '../rsc/map_specialities_keywords.csv' into table speciality_keywords
  fields terminated by ',' enclosed by '' escaped by '\\'
  lines terminated  by '\n' starting by ''
  (@spec_text,keyword)
  set speciality=(select speciality from specialities where speciality_name=@spec_text);
