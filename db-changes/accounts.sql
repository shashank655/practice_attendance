-- Adminer 4.7.6 MySQL dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

DROP TABLE IF EXISTS `admission_fee_items`;
CREATE TABLE `admission_fee_items` (
  `id` int NOT NULL AUTO_INCREMENT,
  `admission_fee_id` int NOT NULL,
  `title` varchar(255) NOT NULL,
  `amount` float(8,2) NOT NULL,
  `discount_type` varchar(255) DEFAULT NULL,
  `discount_value` float(8,2) NOT NULL DEFAULT '0.00',
  `discount` float(8,2) NOT NULL DEFAULT '0.00',
  `total` float(8,2) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


DROP TABLE IF EXISTS `admission_fee_payments`;
CREATE TABLE `admission_fee_payments` (
  `id` int NOT NULL AUTO_INCREMENT,
  `admission_fee_id` int NOT NULL,
  `amount` float(8,2) NOT NULL,
  `date` date NOT NULL,
  `method` varchar(255) NOT NULL,
  `comment` longtext NOT NULL,
  `description` longtext NOT NULL,
  `billing_address` longtext NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


DROP TABLE IF EXISTS `admission_fees`;
CREATE TABLE `admission_fees` (
  `id` int NOT NULL AUTO_INCREMENT,
  `admission_no` varchar(255) NOT NULL,
  `date` date NOT NULL,
  `due_date` date DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


DROP TABLE IF EXISTS `fee_head_items`;
CREATE TABLE `fee_head_items` (
  `id` int NOT NULL AUTO_INCREMENT,
  `fee_head_id` int NOT NULL,
  `title` varchar(255) NOT NULL,
  `amount` float(8,2) NOT NULL,
  `discount_type` varchar(255) DEFAULT NULL,
  `discount_value` float(8,2) NOT NULL DEFAULT '0.00',
  `discount` float(8,2) NOT NULL DEFAULT '0.00',
  `total` float(8,2) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


DROP TABLE IF EXISTS `fee_heads`;
CREATE TABLE `fee_heads` (
  `id` int NOT NULL AUTO_INCREMENT,
  `type` varchar(255) NOT NULL,
  `class_id` int NOT NULL,
  `title` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


DROP TABLE IF EXISTS `monthly_fee_items`;
CREATE TABLE `monthly_fee_items` (
  `id` int NOT NULL AUTO_INCREMENT,
  `monthly_fee_id` int NOT NULL,
  `title` varchar(255) NOT NULL,
  `amount` float(8,2) NOT NULL,
  `discount_type` varchar(255) DEFAULT NULL,
  `discount_value` float(8,2) NOT NULL DEFAULT '0.00',
  `discount` float(8,2) NOT NULL DEFAULT '0.00',
  `total` float(8,2) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


DROP TABLE IF EXISTS `monthly_fee_payments`;
CREATE TABLE `monthly_fee_payments` (
  `id` int NOT NULL AUTO_INCREMENT,
  `monthly_fee_id` int NOT NULL,
  `amount` float(8,2) NOT NULL,
  `date` date NOT NULL,
  `method` varchar(255) NOT NULL,
  `comment` longtext NOT NULL,
  `description` longtext NOT NULL,
  `billing_address` longtext NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


DROP TABLE IF EXISTS `monthly_fees`;
CREATE TABLE `monthly_fees` (
  `id` int NOT NULL AUTO_INCREMENT,
  `admission_no` varchar(255) NOT NULL,
  `date` date NOT NULL,
  `date_from` date NOT NULL,
  `date_to` date NOT NULL,
  `due_date` date DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


-- 2020-04-02 11:27:48