CREATE SCHEMA webflow;
USE webflow;

CREATE  TABLE `webflow`.`users` (
  `id` SMALLINT UNSIGNED NOT NULL AUTO_INCREMENT ,
  `user_name` VARCHAR(100),
  `job_id` SMALLINT UNSIGNED,
  `project_id` MEDIUMINT UNSIGNED,
  `box_id` INT UNSIGNED,
  `user_start` DATETIME,
  `user_note` BLOB,
  `user_hidden` BOOLEAN,
  `payroll` BOOLEAN,
  PRIMARY KEY (`id`) );

CREATE  TABLE `webflow`.`logs` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT ,
  `user_id` SMALLINT UNSIGNED,
  `job_id` SMALLINT UNSIGNED,
  `project_id` MEDIUMINT UNSIGNED,
  `box_id` INT UNSIGNED,
  `log_start` DATETIME,
  `log_stop` DATETIME,
  PRIMARY KEY (`id`) );

CREATE  TABLE `webflow`.`messages` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT ,
  `user_id` SMALLINT UNSIGNED,
  `from_id` SMALLINT UNSIGNED,
  `message_sent` DATETIME,
  `message_content` BLOB,
  `message_read` BOOLEAN,
  PRIMARY KEY (`id`) );

CREATE  TABLE `webflow`.`tasks` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT ,
  `job_id` SMALLINT UNSIGNED,
  `project_id` MEDIUMINT UNSIGNED,
  `priority` TINYINT UNSIGNED,
  PRIMARY KEY (`id`) );

CREATE  TABLE `webflow`.`task-members` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT ,
  `task_id` INT UNSIGNED,
  `user_id` SMALLINT UNSIGNED,
  `group_id` SMALLINT UNSIGNED,
  PRIMARY KEY (`id`) );

CREATE  TABLE `webflow`.`jobs` (
  `id` SMALLINT UNSIGNED NOT NULL AUTO_INCREMENT ,
  `job_name` VARCHAR(100),
  `set_box_status_id` INT,
  `job_hidden` BOOLEAN,
  PRIMARY KEY (`id`) );

CREATE  TABLE `webflow`.`projects` (
  `id` MEDIUMINT UNSIGNED NOT NULL AUTO_INCREMENT ,
  `project_name` VARCHAR(100),
  `project_received` DATE,
  `hidden` BIT NULL DEFAULT 0,
PRIMARY KEY (`id`) );

CREATE  TABLE `webflow`.`box_status` (
  `id` SMALLINT UNSIGNED NOT NULL AUTO_INCREMENT ,
  `box_status_name` VARCHAR(100),
PRIMARY KEY (`id`) );

CREATE  TABLE `webflow`.`boxes` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT ,
  `project_id` MEDIUMINT UNSIGNED,  
  `box_status_id` SMALLINT UNSIGNED,  
  `box_name` VARCHAR(100),
PRIMARY KEY (`id`) );

CREATE  TABLE `webflow`.`groups` (
  `id` SMALLINT UNSIGNED NOT NULL AUTO_INCREMENT ,
  `group_name` VARCHAR(100),
PRIMARY KEY (`id`) );

CREATE  TABLE `webflow`.`group-members` (
  `id` SMALLINT UNSIGNED NOT NULL AUTO_INCREMENT ,
  `group_id` SMALLINT UNSIGNED,
  `user_id` SMALLINT UNSIGNED,
PRIMARY KEY (`id`) );

CREATE  TABLE `webflow`.`schedules` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT ,
  `user_id` SMALLINT UNSIGNED,
  `schedule_date` DATE,
  `schedule_note` VARCHAR(100),
PRIMARY KEY (`id`) );

CREATE  TABLE `webflow`.`help` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT ,
  `job_id` SMALLINT UNSIGNED,
  `project_id` MEDIUMINT UNSIGNED,
  `help_content` BLOB,
  PRIMARY KEY (`id`) );

CREATE  TABLE `webflow`.`auth` (
  `id` SMALLINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `admin_pass` VARCHAR(100),
PRIMARY KEY (`id`));INSERT INTO `webflow`.`auth` (`admin_pass`) VALUES ('');

ALTER TABLE `webflow`.`projects` 
ADD COLUMN `pplf` DECIMAL(10,2) NULL AFTER `hidden`,
ADD COLUMN `ppsf` DECIMAL(10,2) NULL AFTER `pplf`,
ADD COLUMN `ppb` DECIMAL(10,2) NULL AFTER `ppsf`;

ALTER TABLE `webflow`.`projects` 
ADD COLUMN `destroyed` VARCHAR(100) NULL AFTER `ppb`;