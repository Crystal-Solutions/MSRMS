SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

CREATE SCHEMA IF NOT EXISTS `msrms` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ;
USE `msrms` ;

-- -----------------------------------------------------
-- Table `msrms`.`faculty`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `msrms`.`faculty` ;

CREATE  TABLE IF NOT EXISTS `msrms`.`faculty` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `name` VARCHAR(45) NULL ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `msrms`.`department`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `msrms`.`department` ;

CREATE  TABLE IF NOT EXISTS `msrms`.`department` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `name` VARCHAR(45) NULL ,
  `faculty_id` INT NOT NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_department_faculty1_idx` (`faculty_id` ASC) ,
  CONSTRAINT `fk_department_faculty1`
    FOREIGN KEY (`faculty_id` )
    REFERENCES `msrms`.`faculty` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `msrms`.`player`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `msrms`.`player` ;

CREATE  TABLE IF NOT EXISTS `msrms`.`player` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `name` VARCHAR(140) NULL ,
  `department_id` INT NOT NULL ,
  `year` INT NULL ,
  `date_of_birth` DATE NULL ,
  `address` VARCHAR(256) NULL ,
  `blood_type` VARCHAR(3) NULL ,
  `index_number` VARCHAR(7) NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_player_department1_idx` (`department_id` ASC) ,
  CONSTRAINT `fk_player_department1`
    FOREIGN KEY (`department_id` )
    REFERENCES `msrms`.`department` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `msrms`.`phone_number_player`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `msrms`.`phone_number_player` ;

CREATE  TABLE IF NOT EXISTS `msrms`.`phone_number_player` (
  `number` INT NOT NULL AUTO_INCREMENT ,
  `player_id` INT NOT NULL ,
  PRIMARY KEY (`number`) ,
  INDEX `fk_phone_number_player_player1_idx` (`player_id` ASC) ,
  CONSTRAINT `fk_phone_number_player_player1`
    FOREIGN KEY (`player_id` )
    REFERENCES `msrms`.`player` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `msrms`.`sport`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `msrms`.`sport` ;

CREATE  TABLE IF NOT EXISTS `msrms`.`sport` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `name` VARCHAR(45) NULL ,
  `description` VARCHAR(450) NULL ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `msrms`.`player_involved_in_sport`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `msrms`.`player_involved_in_sport` ;

CREATE  TABLE IF NOT EXISTS `msrms`.`player_involved_in_sport` (
  `player_id` INT NOT NULL ,
  `sport_id` INT NOT NULL ,
  `started_date` DATE NOT NULL ,
  `end_date` DATE NULL ,
  `position` VARCHAR(45) NULL ,
  `id` INT NOT NULL AUTO_INCREMENT ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_player_has_sport_sport1_idx` (`sport_id` ASC) ,
  INDEX `fk_player_has_sport_player1_idx` (`player_id` ASC) ,
  CONSTRAINT `fk_player_has_sport_player1`
    FOREIGN KEY (`player_id` )
    REFERENCES `msrms`.`player` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_player_has_sport_sport1`
    FOREIGN KEY (`sport_id` )
    REFERENCES `msrms`.`sport` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `msrms`.`achievement`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `msrms`.`achievement` ;

CREATE  TABLE IF NOT EXISTS `msrms`.`achievement` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `title` VARCHAR(140) NULL ,
  `description` VARCHAR(850) NULL ,
  `achieved_date` DATE NULL ,
  `player_involved_in_sport_id` INT NOT NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_achievement_player_involved_in_sport1_idx` (`player_involved_in_sport_id` ASC) ,
  CONSTRAINT `fk_achievement_player_involved_in_sport1`
    FOREIGN KEY (`player_involved_in_sport_id` )
    REFERENCES `msrms`.`player_involved_in_sport` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `msrms`.`resource`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `msrms`.`resource` ;

CREATE  TABLE IF NOT EXISTS `msrms`.`resource` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `name` VARCHAR(45) NULL ,
  `description` VARCHAR(450) NULL ,
  `instructor_name` VARCHAR(128) NULL ,
  `location` VARCHAR(128) NULL ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `msrms`.`equipment`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `msrms`.`equipment` ;

CREATE  TABLE IF NOT EXISTS `msrms`.`equipment` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `name` VARCHAR(100) NULL ,
  `description` VARCHAR(450) NULL ,
  `amount` INT NULL ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `msrms`.`authorizing_officer`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `msrms`.`authorizing_officer` ;

CREATE  TABLE IF NOT EXISTS `msrms`.`authorizing_officer` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `name` VARCHAR(128) NULL ,
  `contact_nu` VARCHAR(45) NULL ,
  `username` VARCHAR(45) NULL ,
  `password` VARCHAR(128) NULL ,
  `email` VARCHAR(128) NULL ,
  `is_active` TINYINT(1) NULL ,
  PRIMARY KEY (`id`) ,
  UNIQUE INDEX `username_UNIQUE` (`username` ASC) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `msrms`.`sport_has_equipment`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `msrms`.`sport_has_equipment` ;

CREATE  TABLE IF NOT EXISTS `msrms`.`sport_has_equipment` (
  `equipment_id` INT NOT NULL ,
  `sport_id` INT NOT NULL ,
  `authorizing_officer_id` INT NOT NULL ,
  `id` INT NOT NULL AUTO_INCREMENT ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_equipment_has_sport_sport1_idx` (`sport_id` ASC) ,
  INDEX `fk_equipment_has_sport_equipment1_idx` (`equipment_id` ASC) ,
  INDEX `fk_sport_has_equipment_authorizing_officer1_idx` (`authorizing_officer_id` ASC) ,
  CONSTRAINT `fk_equipment_has_sport_equipment1`
    FOREIGN KEY (`equipment_id` )
    REFERENCES `msrms`.`equipment` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_equipment_has_sport_sport1`
    FOREIGN KEY (`sport_id` )
    REFERENCES `msrms`.`sport` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_sport_has_equipment_authorizing_officer1`
    FOREIGN KEY (`authorizing_officer_id` )
    REFERENCES `msrms`.`authorizing_officer` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `msrms`.`time_slot_equipment`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `msrms`.`time_slot_equipment` ;

CREATE  TABLE IF NOT EXISTS `msrms`.`time_slot_equipment` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `start_time` TIME NULL ,
  `end_time` TIME NULL ,
  `sport_has_equipment_id` INT NOT NULL ,
  `day` VARCHAR(25) NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_time_slot_equipment_sport_has_equipment1_idx` (`sport_has_equipment_id` ASC) ,
  CONSTRAINT `fk_time_slot_equipment_sport_has_equipment1`
    FOREIGN KEY (`sport_has_equipment_id` )
    REFERENCES `msrms`.`sport_has_equipment` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `msrms`.`phone_number_auth_officer`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `msrms`.`phone_number_auth_officer` ;

CREATE  TABLE IF NOT EXISTS `msrms`.`phone_number_auth_officer` (
  `number` INT NOT NULL AUTO_INCREMENT ,
  `authorizing_officer_id` INT NOT NULL ,
  PRIMARY KEY (`number`) ,
  INDEX `fk_phone_number_auth_officer_authorizing_officer1_idx` (`authorizing_officer_id` ASC) ,
  CONSTRAINT `fk_phone_number_auth_officer_authorizing_officer1`
    FOREIGN KEY (`authorizing_officer_id` )
    REFERENCES `msrms`.`authorizing_officer` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `msrms`.`sport_has_resource`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `msrms`.`sport_has_resource` ;

CREATE  TABLE IF NOT EXISTS `msrms`.`sport_has_resource` (
  `sport_id` INT NOT NULL ,
  `resource_id` INT NOT NULL ,
  `authorizing_officer_id` INT NOT NULL ,
  `id` INT NOT NULL AUTO_INCREMENT ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_sport_has_resource_resource1_idx` (`resource_id` ASC) ,
  INDEX `fk_sport_has_resource_sport1_idx` (`sport_id` ASC) ,
  INDEX `fk_sport_has_resource_authorizing_officer1_idx` (`authorizing_officer_id` ASC) ,
  CONSTRAINT `fk_sport_has_resource_sport1`
    FOREIGN KEY (`sport_id` )
    REFERENCES `msrms`.`sport` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_sport_has_resource_resource1`
    FOREIGN KEY (`resource_id` )
    REFERENCES `msrms`.`resource` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_sport_has_resource_authorizing_officer1`
    FOREIGN KEY (`authorizing_officer_id` )
    REFERENCES `msrms`.`authorizing_officer` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `msrms`.`equipment_reserved_by_player`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `msrms`.`equipment_reserved_by_player` ;

CREATE  TABLE IF NOT EXISTS `msrms`.`equipment_reserved_by_player` (
  `equipment_id` INT NOT NULL ,
  `player_id` INT NOT NULL ,
  `start` DATETIME NULL ,
  `end` DATETIME NULL ,
  `amount` INT NULL ,
  `authorizing_officer_id` INT NOT NULL ,
  `id` INT NOT NULL AUTO_INCREMENT ,
  INDEX `fk_equipment_has_player_player1_idx` (`player_id` ASC) ,
  INDEX `fk_equipment_has_player_equipment1_idx` (`equipment_id` ASC) ,
  INDEX `fk_equipment_reserved_by_player_authorizing_officer1_idx` (`authorizing_officer_id` ASC) ,
  PRIMARY KEY (`id`) ,
  CONSTRAINT `fk_equipment_has_player_equipment1`
    FOREIGN KEY (`equipment_id` )
    REFERENCES `msrms`.`equipment` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_equipment_has_player_player1`
    FOREIGN KEY (`player_id` )
    REFERENCES `msrms`.`player` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_equipment_reserved_by_player_authorizing_officer1`
    FOREIGN KEY (`authorizing_officer_id` )
    REFERENCES `msrms`.`authorizing_officer` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `msrms`.`equipment_borrowed_by_player`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `msrms`.`equipment_borrowed_by_player` ;

CREATE  TABLE IF NOT EXISTS `msrms`.`equipment_borrowed_by_player` (
  `equipment_id` INT NOT NULL ,
  `player_id` INT NOT NULL ,
  `amount` INT NULL ,
  `borrowed_time` DATETIME NULL ,
  `due_time` DATETIME NULL ,
  `returned_time` DATETIME NULL ,
  `issue_details` VARCHAR(850) NULL ,
  `id` INT NOT NULL AUTO_INCREMENT ,
  INDEX `fk_equipment_has_player_player2_idx` (`player_id` ASC) ,
  INDEX `fk_equipment_has_player_equipment2_idx` (`equipment_id` ASC) ,
  PRIMARY KEY (`id`) ,
  CONSTRAINT `fk_equipment_has_player_equipment2`
    FOREIGN KEY (`equipment_id` )
    REFERENCES `msrms`.`equipment` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_equipment_has_player_player2`
    FOREIGN KEY (`player_id` )
    REFERENCES `msrms`.`player` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `msrms`.`time_slot_resource`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `msrms`.`time_slot_resource` ;

CREATE  TABLE IF NOT EXISTS `msrms`.`time_slot_resource` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `start_time` TIME NULL ,
  `end_time` TIME NULL ,
  `day` VARCHAR(25) NULL ,
  `sport_has_resource_id` INT NOT NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_time_slot_resource_sport_has_resource1_idx` (`sport_has_resource_id` ASC) ,
  CONSTRAINT `fk_time_slot_resource_sport_has_resource1`
    FOREIGN KEY (`sport_has_resource_id` )
    REFERENCES `msrms`.`sport_has_resource` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

USE `msrms` ;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
