/*
SQLyog Community Edition- MySQL GUI v5.20
Host - 5.5.60-0ubuntu0.14.04.1 : Database - practice
*********************************************************************
Server version : 5.5.60-0ubuntu0.14.04.1
*/

SET NAMES utf8;

SET SQL_MODE='';

create database if not exists `practice`;

USE `practice`;

SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO';

/*Table structure for table `classes_name` */

CREATE TABLE `classes_name` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `class_name` varchar(220) DEFAULT NULL,
  `createdDate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

/*Data for the table `classes_name` */

insert  into `classes_name`(`id`,`class_name`,`createdDate`) values (1,'class 1','2019-04-03 11:57:21'),(2,'class 2','2019-04-03 11:57:25'),(3,'class 3','2019-04-03 11:57:27'),(4,'class 4','2019-04-03 11:57:31');

/*Table structure for table `sections` */

CREATE TABLE `sections` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `class_id` int(11) DEFAULT NULL,
  `section_name` varchar(220) DEFAULT NULL,
  `createdDate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

/*Data for the table `sections` */

insert  into `sections`(`id`,`class_id`,`section_name`,`createdDate`) values (1,1,'Section A','2019-04-03 11:57:42'),(2,1,'Section B','2019-04-03 11:57:48'),(3,1,'Section C','2019-04-03 11:57:53'),(4,2,'Section A','2019-04-03 11:57:58'),(5,2,'Section B','2019-04-03 11:58:04'),(6,3,'Section A','2019-04-03 11:58:12'),(7,3,'Section B','2019-04-03 11:58:18'),(8,3,'Section C','2019-04-03 11:58:23');

/*Table structure for table `students` */

CREATE TABLE `students` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `first_name` varchar(255) DEFAULT NULL,
  `last_name` varchar(200) DEFAULT NULL,
  `email_address` varchar(255) DEFAULT NULL,
  `gender` varchar(100) DEFAULT NULL,
  `dob` varchar(150) DEFAULT NULL,
  `class_id` int(11) DEFAULT NULL,
  `section_id` int(11) DEFAULT NULL,
  `religion` varchar(100) DEFAULT NULL,
  `date_of_joining` varchar(100) DEFAULT NULL,
  `mobile_number` varchar(200) DEFAULT NULL,
  `admission_no` varchar(200) DEFAULT NULL,
  `student_id` varchar(200) DEFAULT NULL,
  `fathers_name` varchar(255) DEFAULT NULL,
  `fathers_occupation` varchar(200) DEFAULT NULL,
  `parents_mobile_number` varchar(255) DEFAULT NULL,
  `present_address` text,
  `mothers_name` varchar(255) DEFAULT NULL,
  `mothers_occupation` varchar(200) DEFAULT NULL,
  `nationality` varchar(200) DEFAULT NULL,
  `permanent_address` text,
  `student_profile_image` text,
  `parents_profile_image` text,
  `createdDate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

/*Data for the table `students` */

insert  into `students`(`id`,`first_name`,`last_name`,`email_address`,`gender`,`dob`,`class_id`,`section_id`,`religion`,`date_of_joining`,`mobile_number`,`admission_no`,`student_id`,`fathers_name`,`fathers_occupation`,`parents_mobile_number`,`present_address`,`mothers_name`,`mothers_occupation`,`nationality`,`permanent_address`,`student_profile_image`,`parents_profile_image`,`createdDate`) values (1,'shashank edit','garg edd','shaedd@gmail.com','male','27/04/2019',0,0,'hinduedd','22/04/2019','0123456789','123456edd','123456edd','sp gargedd','caedd','123456784','','rashmi gargedd','HWedd','Indiaedd','','155478997311992408_1009809872403008_2094994501_n.jpg','15547899731404395361_offerrate_seattle-washington-1.jpg','2019-04-09 11:36:13');

/*Table structure for table `subjects` */

CREATE TABLE `subjects` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `subject_name` varchar(230) DEFAULT NULL,
  `createdDate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

/*Data for the table `subjects` */

insert  into `subjects`(`id`,`subject_name`,`createdDate`) values (1,'Computer','2019-04-02 15:15:38'),(2,'Science','2019-04-02 15:15:45'),(3,'Maths','2019-04-02 15:15:47'),(4,'Hindi','2019-04-02 15:15:50'),(5,'English','2019-04-02 15:15:54'),(6,'Social Science','2019-04-02 15:15:56');

/*Table structure for table `teachers` */

CREATE TABLE `teachers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `gender` varchar(100) DEFAULT NULL,
  `dob` varchar(200) DEFAULT NULL,
  `class_id` varchar(100) DEFAULT NULL,
  `is_class_teacher` varchar(50) DEFAULT NULL,
  `joining_date` varchar(255) DEFAULT NULL,
  `mobile_number` varchar(255) DEFAULT NULL,
  `subject_id` varchar(100) DEFAULT NULL,
  `teacher_id` varchar(255) DEFAULT NULL,
  `section` varchar(100) DEFAULT NULL,
  `permanent_address` varchar(255) DEFAULT NULL,
  `profile_image` text,
  `createdDate` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

/*Data for the table `teachers` */

insert  into `teachers`(`id`,`user_id`,`gender`,`dob`,`class_id`,`is_class_teacher`,`joining_date`,`mobile_number`,`subject_id`,`teacher_id`,`section`,`permanent_address`,`profile_image`,`createdDate`) values (1,1,'male','16/04/2019','2','1','16/04/2019','2222222222222','6','765432','C','',NULL,NULL),(2,3,'male','25/04/2019','class 1','1','03/04/2019','987678888','Computer','12345','B','','1554283205challenger_ext-min.png',NULL),(3,4,'male','01/05/2019','\r\n													2','1','16/04/2019','0123456789','\r\n													5','12345','B','872\r\nSaraswati soni marg\r\nLaxma chowk','1554699692accounat.2.jpe',NULL);

/*Table structure for table `user_roles` */

CREATE TABLE `user_roles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `role` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

/*Data for the table `user_roles` */

insert  into `user_roles`(`id`,`role`) values (1,'super_admin');

/*Table structure for table `users` */

CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `first_name` varchar(200) DEFAULT NULL,
  `last_name` varchar(200) DEFAULT NULL,
  `user_name` varchar(200) DEFAULT NULL,
  `email_address` varchar(255) DEFAULT NULL,
  `password` text,
  `user_role` varchar(100) DEFAULT NULL,
  `createdDate` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

/*Data for the table `users` */

insert  into `users`(`id`,`first_name`,`last_name`,`user_name`,`email_address`,`password`,`user_role`,`createdDate`) values (1,'shashank edit','garg edit','evonsha','sha@gmail.com','e10adc3949ba59abbe56e057f20f883e','1',NULL),(2,'shashank','garg',NULL,'shashank@gmail.com','e10adc3949ba59abbe56e057f20f883e','2',NULL),(3,'Shanky','garg',NULL,'shanky@gmail.com','e10adc3949ba59abbe56e057f20f883e','3',NULL),(4,'asasas','asas',NULL,'asa@gmail.com','e10adc3949ba59abbe56e057f20f883e','2',NULL);

SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
