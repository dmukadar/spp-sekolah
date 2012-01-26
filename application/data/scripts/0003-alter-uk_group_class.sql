 DROP TABLE IF EXISTS ar_group_class;
 CREATE TABLE ar_group_class
  (
    id          serial,
    id_rate     bigint         unsigned not null,
    id_class  tinyint        unsigned not null,
    status      tinyint unsigned default 0,
    created      timestamp default '0000-00-00 00:00:00' not null,
    modified     timestamp default '0000-00-00 00:00:00' not null on update current_timestamp,
    modified_by  bigint unsigned,
    constraint uk_group_class unique(id_rate, id_class)
  );  
