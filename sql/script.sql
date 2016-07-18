create database ri;
   connect ri;

   create table rss (
      name varchar(25) primary key,
      link varchar(500) not null
   );

   create table user (
      username varchar(25) primary key,
      password varchar(255) not null,
      type int not null
   );
