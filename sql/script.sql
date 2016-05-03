create database ri;
   connect ri;

   create table rss (
      name varchar(25) primary key,
      link varchar(500) not null
   );

   insert into rss values (
      'BBC News - Technology',
      'http://feeds.bbci.co.uk/news/technology/rss.xml'
   );
