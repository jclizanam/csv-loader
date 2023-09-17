DROP DATABASE `asknicely`;

-- Create Employee table on init process
CREATE DATABASE IF NOT EXISTS asknicely;

USE `asknicely`;

-- DROP TABLE IF EXIST
DROP TABLE IF EXISTS `employees`;

-- CREATE TABLE

CREATE TABLE `employees` (
     `id` int(11) PRIMARY KEY AUTO_INCREMENT,
     `created_at` int(11) NOT NULL,
     `updated_at` int(11) NOT NULL DEFAULT '0',
     `company_name` varchar(120) NOT NULL,
     `name` varchar(200) NOT NULL,
     `email` varchar(100) NOT NULL,
     `salary` decimal(10,2) NOT NULL DEFAULT '0.00'
) ENGINE=InnoDB;



