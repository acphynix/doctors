drop table if exists specialities;
create table `specialities` (
  `speciality` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `speciality_name` varchar(32) NOT NULL,
  PRIMARY KEY (`speciality`)
);

load data local infile '../rsc/list_specialities.txt' into table specialities
  fields terminated by ',' enclosed by '' escaped by '\\'
  lines terminated  by '\n' starting by ''
  (speciality_name)
;



drop table if exists speciality_keywords;
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

drop table if exists keywords;
create table `keywords` (
  `id`            int(10) unsigned NOT NULL AUTO_INCREMENT,
  `eq_class`      int(5),
  `keyword`       varchar(32) NOT NULL,
  PRIMARY KEY (`id`)
);

load data local infile '../rsc/map_groups_keywords.csv' into table keywords
  fields terminated by ',' enclosed by '' escaped by '\\'
  lines terminated  by '\n' starting by ''
  (eq_class, keyword)
;