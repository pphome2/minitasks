# sql isntall


create database if not exists demo;

use demo;

create table if not exists mt_user (
    id bigint auto_increment primary key,
    username varchar(40) charset utf8,
    userpw varchar(40) charset utf8,
    admin int,
    key name (username(20))
) engine=InnoDB default charset latin1;

create table if not exists mt_param (
    id bigint auto_increment primary key,
    kod varchar(20) charset utf8,
    nev varchar(40) charset utf8,
    key name (kod(20))
) engine=InnoDB default charset latin1;

create table if not exists mt_tasks (
    id bigint auto_increment primary key,
    datum varchar(20) charset utf8,
    hdatum varchar(20) charset utf8,
    rdatum varchar(20) charset utf8,
    feladat varchar(200) charset utf8,
    felelos varchar(40) charset utf8,
    megbizo varchar(40) charset utf8,
    leiras text charset utf8,
    tulajdonos varchar(40) charset utf8,
    key name (datum(20))
) engine=InnoDB default charset latin1;
