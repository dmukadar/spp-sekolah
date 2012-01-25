 DROP TABLE IF EXISTS ar_group_student;  
 CREATE TABLE ar_group_student
  (
    id          serial,
    id_rate     bigint         unsigned not null,
    id_student  bigint        unsigned not null,
    status      tinyint unsigned default 0,
    created      timestamp default '0000-00-00 00:00:00' not null,
    modified     timestamp default '0000-00-00 00:00:00' not null on update current_timestamp,
    modified_by  bigint unsigned,
    constraint uk_group_class unique(id_rate, id_student)
  );
