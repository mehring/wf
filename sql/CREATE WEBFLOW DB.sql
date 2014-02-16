SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

DROP SCHEMA IF EXISTS `webflow` ;
CREATE SCHEMA IF NOT EXISTS `webflow` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ;
USE `webflow` ;

-- -----------------------------------------------------
-- Table `webflow`.`jobs`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `webflow`.`jobs` ;

CREATE TABLE IF NOT EXISTS `webflow`.`jobs` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `job_name` VARCHAR(100) NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `webflow`.`projects`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `webflow`.`projects` ;

CREATE TABLE IF NOT EXISTS `webflow`.`projects` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `project_name` VARCHAR(100) NULL,
  `project_received` DATE NULL,
  `hidden` BIT NULL DEFAULT 0,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `webflow`.`box_status`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `webflow`.`box_status` ;

CREATE TABLE IF NOT EXISTS `webflow`.`box_status` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `box_status_name` VARCHAR(100) NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `webflow`.`boxes`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `webflow`.`boxes` ;

CREATE TABLE IF NOT EXISTS `webflow`.`boxes` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `project_id` INT UNSIGNED NOT NULL,
  `box_name` VARCHAR(100) NULL,
  `box_status_id` INT UNSIGNED NOT NULL,
  PRIMARY KEY (`id`, `project_id`),
  INDEX `fk_boxes_projects1_idx` (`project_id` ASC),
  INDEX `fk_boxes_box_status1_idx` (`box_status_id` ASC),
  CONSTRAINT `fk_boxes_projects1`
    FOREIGN KEY (`project_id`)
    REFERENCES `webflow`.`projects` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_boxes_box_status1`
    FOREIGN KEY (`box_status_id`)
    REFERENCES `webflow`.`box_status` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `webflow`.`users`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `webflow`.`users` ;

CREATE TABLE IF NOT EXISTS `webflow`.`users` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `user_name` VARCHAR(100) NULL,
  `job_id` INT UNSIGNED NOT NULL,
  `project_id` INT UNSIGNED NOT NULL,
  `box_id` INT UNSIGNED NOT NULL,
  `user_start` DATETIME NULL,
  `user_note` BLOB NULL,
  `user_hidden` TINYINT(1) NULL,
  PRIMARY KEY (`id`, `job_id`, `project_id`, `box_id`),
  INDEX `fk_users_jobs1_idx` (`job_id` ASC),
  INDEX `fk_users_projects1_idx` (`project_id` ASC),
  INDEX `fk_users_boxes1_idx` (`box_id` ASC),
  CONSTRAINT `fk_users_jobs1`
    FOREIGN KEY (`job_id`)
    REFERENCES `webflow`.`jobs` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_users_projects1`
    FOREIGN KEY (`project_id`)
    REFERENCES `webflow`.`projects` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_users_boxes1`
    FOREIGN KEY (`box_id`)
    REFERENCES `webflow`.`boxes` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `webflow`.`logs`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `webflow`.`logs` ;

CREATE TABLE IF NOT EXISTS `webflow`.`logs` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` INT NOT NULL,
  `job_id` INT UNSIGNED NOT NULL,
  `project_id` INT UNSIGNED NOT NULL,
  `box_id` INT UNSIGNED NOT NULL,
  `log_start` DATETIME NULL,
  `log_stop` DATETIME NULL,
  PRIMARY KEY (`id`, `user_id`, `job_id`, `project_id`, `box_id`),
  INDEX `fk_logs_users1_idx` (`user_id` ASC),
  INDEX `fk_logs_jobs1_idx` (`job_id` ASC),
  INDEX `fk_logs_projects1_idx` (`project_id` ASC),
  INDEX `fk_logs_boxes1_idx` (`box_id` ASC),
  CONSTRAINT `fk_logs_users1`
    FOREIGN KEY (`user_id`)
    REFERENCES `webflow`.`users` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_logs_jobs1`
    FOREIGN KEY (`job_id`)
    REFERENCES `webflow`.`jobs` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_logs_projects1`
    FOREIGN KEY (`project_id`)
    REFERENCES `webflow`.`projects` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_logs_boxes1`
    FOREIGN KEY (`box_id`)
    REFERENCES `webflow`.`boxes` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `webflow`.`messages`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `webflow`.`messages` ;

CREATE TABLE IF NOT EXISTS `webflow`.`messages` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` INT NOT NULL,
  `from_id` INT NOT NULL,
  `message_sent` DATETIME NULL,
  `message_content` BLOB NULL,
  `message_read` TINYINT(1) NULL,
  PRIMARY KEY (`id`, `user_id`, `from_id`),
  INDEX `fk_messages_users1_idx` (`user_id` ASC),
  INDEX `fk_messages_users2_idx` (`from_id` ASC),
  CONSTRAINT `fk_messages_users1`
    FOREIGN KEY (`user_id`)
    REFERENCES `webflow`.`users` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_messages_users2`
    FOREIGN KEY (`from_id`)
    REFERENCES `webflow`.`users` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `webflow`.`tasks`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `webflow`.`tasks` ;

CREATE TABLE IF NOT EXISTS `webflow`.`tasks` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `job_id` INT UNSIGNED NOT NULL,
  `project_id` INT UNSIGNED NOT NULL,
  `priority` TINYINT UNSIGNED NULL,
  PRIMARY KEY (`id`, `job_id`, `project_id`),
  INDEX `fk_tasks_jobs1_idx` (`job_id` ASC),
  INDEX `fk_tasks_projects1_idx` (`project_id` ASC),
  CONSTRAINT `fk_tasks_jobs1`
    FOREIGN KEY (`job_id`)
    REFERENCES `webflow`.`jobs` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_tasks_projects1`
    FOREIGN KEY (`project_id`)
    REFERENCES `webflow`.`projects` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `webflow`.`groups`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `webflow`.`groups` ;

CREATE TABLE IF NOT EXISTS `webflow`.`groups` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `group_name` VARCHAR(100) NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `webflow`.`task-members`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `webflow`.`task-members` ;

CREATE TABLE IF NOT EXISTS `webflow`.`task-members` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `task_id` INT UNSIGNED NOT NULL,
  `user_id` INT NULL,
  `group_id` INT UNSIGNED NULL,
  PRIMARY KEY (`id`, `task_id`, `user_id`, `group_id`),
  INDEX `fk_task-members_tasks1_idx` (`task_id` ASC),
  INDEX `fk_task-members_users1_idx` (`user_id` ASC),
  INDEX `fk_task-members_groups1_idx` (`group_id` ASC),
  CONSTRAINT `fk_task-members_tasks1`
    FOREIGN KEY (`task_id`)
    REFERENCES `webflow`.`tasks` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_task-members_users1`
    FOREIGN KEY (`user_id`)
    REFERENCES `webflow`.`users` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_task-members_groups1`
    FOREIGN KEY (`group_id`)
    REFERENCES `webflow`.`groups` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `webflow`.`group-members`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `webflow`.`group-members` ;

CREATE TABLE IF NOT EXISTS `webflow`.`group-members` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `group_id` INT UNSIGNED NOT NULL,
  `user_id` INT NOT NULL,
  PRIMARY KEY (`id`, `group_id`, `user_id`),
  INDEX `fk_group-members_groups1_idx` (`group_id` ASC),
  INDEX `fk_group-members_users1_idx` (`user_id` ASC),
  CONSTRAINT `fk_group-members_groups1`
    FOREIGN KEY (`group_id`)
    REFERENCES `webflow`.`groups` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_group-members_users1`
    FOREIGN KEY (`user_id`)
    REFERENCES `webflow`.`users` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `webflow`.`help`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `webflow`.`help` ;

CREATE TABLE IF NOT EXISTS `webflow`.`help` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `job_id` INT UNSIGNED NOT NULL,
  `project_id` INT UNSIGNED NOT NULL,
  `help_content` BLOB NULL,
  PRIMARY KEY (`id`, `job_id`, `project_id`),
  INDEX `fk_help_jobs_idx` (`job_id` ASC),
  INDEX `fk_help_projects1_idx` (`project_id` ASC),
  CONSTRAINT `fk_help_jobs`
    FOREIGN KEY (`job_id`)
    REFERENCES `webflow`.`jobs` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_help_projects1`
    FOREIGN KEY (`project_id`)
    REFERENCES `webflow`.`projects` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `webflow`.`auth`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `webflow`.`auth` ;

CREATE TABLE IF NOT EXISTS `webflow`.`auth` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `admin_pass` VARCHAR(100) NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
