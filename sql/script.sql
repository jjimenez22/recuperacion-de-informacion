create database ri;
   connect ri;

   create table rss (
      name varchar(25) primary key,
      link varchar(500) not null
   );
