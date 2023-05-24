CREATE DATABASE homework;
USE homework;

create table USER(
	username varchar(16) primary key,
    password varchar(255),
    dataNascita date, 
    mail varchar(255),
    avatar varchar(255) default "default.jpeg",
    BIO text default ""
);

create table SAVEDANIME(
	username varchar(16),
    animeID int,
    image text,
    title varchar(255),
    primary key(username, animeID),
    foreign key(username) references USER(username)
);

create table COMMENTS(
	user varchar(16),
    animeID int,
    comment text NOT NULL,
    date datetime default now(),
    title varchar(255),
    primary key(user, animeID, date),
   foreign key(user) references USER(username)
);

create table EVENT(
	id_evento int auto_increment primary key,
    user varchar(16),
    animeID int,
    title varchar(255),
    date datetime,
    type int CHECK(type>=0&&type<3)
);

delimiter $$
drop trigger if exists EliminaPreferito $$
create trigger EliminaPreferito 
after delete on SAVEDANIME
for each row
begin
	insert into event(user, animeID, title, date, type) values(old.username, old.animeID, old.title, now(), 1);
end $$

delimiter ;

delimiter $$
drop trigger if exists AggiungiPreferito $$
create trigger AggiungiPreferito 
after insert on SAVEDANIME
for each row
begin
	insert into event(user, animeID, title, date, type) values(new.username, new.animeID, new.title, now(), 0);
end $$

delimiter ;



delimiter $$
drop trigger if exists AggiungiCommento $$
create trigger AggiungiCommento 
after insert on COMMENTS
for each row
begin
	insert into event(user, animeID, title, date, type) values(new.user, new.animeID, new.title, now(), 2);
end $$

delimiter ;