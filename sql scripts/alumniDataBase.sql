drop user if exists 'user'@'localhost';
create user 'user'@'localhost' identified by 'user123';
grant all privileges on alumnibase.* to 'user'@'localhost';

drop database if exists alumnibase;
-- creating database 
create database alumnibase; 

use alumnibase;

drop table if exists alumni;

create table alumni(
	alumni_id varchar(10) not null,
   username varchar(20) not null,
   email varchar(50) not null,
   password varchar(50) not null,
   company varchar(15) ,
   designation varchar(50),
   address text(30) not null,
   branch varchar(15) not null,
   phno varchar(10) not null,
   yearofgraduation date not null,
   constraint pk_alumni_id primary key(alumni_id),
   constraint un_email unique(email)
) ;

drop table if exists job_posting;

create table job_posting(
          job_id int auto_increment not null,
          id varchar(10) not null,
          company varchar(50) not null,
          type text(20)  not null, -- changed
          salary int not null, -- changed
          description varchar(200) not null,
          date_posted datetime not null default now(), -- changed to date_posted and datatype to datetime
          constraint fk_job_post_id_log foreign key(id) references id_log(id) on delete cascade,
          constraint pk_job_id primary key(job_id)
);

-- gallery table

drop table if exists gallery;

create table gallery(
alumni_id varchar(10) not null,
image_url varchar(250) not null,
date_uploaded datetime not null default now(),
constraint fk_gallery_alumi_id foreign key(alumni_id) references alumni(alumni_id)
);

-- Events table
drop table if exists event;

create table event(
event_id int auto_increment not null,
title varchar(20) not null, 
description text(200) not null,
date_posted datetime not null default now(),
start_date datetime not null,
end_date datetime not null,
image_url varchar(250) not null,
constraint pk_event_id primary key(event_id),
constraint chk_events check(start_date < end_date)
);

--  Carrer Highlighting table

drop table if exists career_highlighting;

create table career_highlighting(
alumni_id varchar(10) not null,
description varchar(500) not null,
alumni_photo_url varchar(250) not null,
constraint fk_career_alumni_id foreign key(alumni_id) references alumni(alumni_id)
);

drop table if exists admin;

create table admin(
admin_id varchar(10) not null,
username varchar(20) not null,
email varchar(50) not null,
password varchar(20) not null,
 constraint pk_admin_id primary key(admin_id)
);

-- logs table where all alumni and admin IDs are dumped and managed using triggers

create table id_log(
id varchar(10) not null,
constraint pk_id primary key(id)
);
