
INSERT INTO alumni (`alumni_id`,`username`,`email`,`password`,`company`,`designation`,`address`,`branch`,`phno`,`yearofgraduation`) VALUES ('17BD1A0585','Arutla Harish Kumar','harishharry2503@gmail.com','warispoppa','Virtusa','Intern','plot no.10 arun jyothi colony bansilalpet gandhi nagar','CSE','9908187838','2021-08-21');
INSERT INTO alumni (`alumni_id`,`username`,`email`,`password`,`company`,`designation`,`address`,`branch`,`phno`,`yearofgraduation`) VALUES ('17BD1A0596','Abdul Waris','mawaris99@gmail.com','baigan','Experian','Intern','Saidabad Sbi colony behind swimming pool','CSE','1234567891','2021-08-21');

INSERT INTO gallery (`alumni_id`,`image_url`,`date_uploaded`) VALUES ('17BD1A0585','img/608a98ba35226.jpeg','2021-04-29 17:00:02');
INSERT INTO gallery (`alumni_id`,`image_url`,`date_uploaded`) VALUES ('17BD1A0585','img/608a98ba457f4.jpeg','2021-04-29 17:00:02');
INSERT INTO gallery (`alumni_id`,`image_url`,`date_uploaded`) VALUES ('17BD1A0585','img/608a98ba73990.jpeg','2021-04-29 17:00:02');
INSERT INTO gallery (`alumni_id`,`image_url`,`date_uploaded`) VALUES ('17BD1A0585','img/608a98baaaec8.jpeg','2021-04-29 17:00:02');
INSERT INTO gallery (`alumni_id`,`image_url`,`date_uploaded`) VALUES ('17BD1A0585','img/608a98bacd841.gif','2021-04-29 17:00:02');

INSERT INTO admin (`admin_id`,`username`,`email`,`password`) VALUES ('d51f11b3','admin','admin','admin');

INSERT INTO career_highlighting (`alumni_id`,`description`,`alumni_photo_url`) VALUES ('17BD1A0596','Winner of SIH 2020','../Alumni/img/608a9b644cbf0.jpeg');
INSERT INTO career_highlighting (`alumni_id`,`description`,`alumni_photo_url`) VALUES ('17BD1A0585','Winner of Google Codejam 2020','../Alumni/img/608a9b9b6bb99.jpeg');

INSERT INTO event (`event_id`,`title`,`description`,`date_posted`,`start_date`,`end_date`,`image_url`) VALUES (1,'Dandiya Nights','On the eve of dandiya navaratri','2021-04-29 17:09:09','2021-12-11 00:00:00','2021-12-15 13:00:00','../Admin/img/608a9add0eafb.jpeg');

INSERT INTO id_log (`id`) VALUES ('17BD1A0585');
INSERT INTO id_log (`id`) VALUES ('17BD1A0596');
INSERT INTO id_log (`id`) VALUES ('d51f11b3');

INSERT INTO job_posting (`job_id`,`id`,`company`,`type`,`salary`,`description`,`date_posted`) VALUES (1,'17BD1A0585','Virtusa','Full Time',40000,'Position for Software Engineer. Must have good analytical skills, Coding Skills','2021-04-29 16:58:36');
INSERT INTO job_posting (`job_id`,`id`,`company`,`type`,`salary`,`description`,`date_posted`) VALUES (2,'17BD1A0585','Experian','Full Time',40000,'Position for Software Engineer. Must have good analytical skills, Coding Skills','2021-04-29 16:58:48');
INSERT INTO job_posting (`job_id`,`id`,`company`,`type`,`salary`,`description`,`date_posted`) VALUES (3,'17BD1A0585','DarwinBox','Full Time',60000,'Position for Software Engineer. Must have good analytical skills, Coding Skills','2021-04-29 16:59:04');
INSERT INTO job_posting (`job_id`,`id`,`company`,`type`,`salary`,`description`,`date_posted`) VALUES (4,'d51f11b3','Netcracker','Internship',25000,'You will be working on AS400','2021-04-29 17:12:58');
