-- MySQL Script generated by MySQL Workbench
-- Fri Nov 19 15:20:29 2021
-- Model: donkeyair Full    Version: 2.0
-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

-- -----------------------------------------------------
-- Schema donkeyair
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema donkeyair
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `donkeyair` ;
USE `donkeyair` ;

-- -----------------------------------------------------
-- Table `donkeyair`.`customer`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `donkeyair`.`customer` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `email` VARCHAR(45) NOT NULL,
  `password` BINARY(64) NOT NULL,
  `first_name` VARCHAR(45) NOT NULL,
  `last_name` VARCHAR(45) NOT NULL,
  `title` ENUM('M', 'Mme') NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `donkeyair`.`booking`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `donkeyair`.`booking` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `customer_id` INT NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_booking_customer1_idx` (`customer_id` ASC),
  CONSTRAINT `fk_booking_customer1`
    FOREIGN KEY (`customer_id`)
    REFERENCES `donkeyair`.`customer` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `donkeyair`.`class`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `donkeyair`.`class` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(45) NOT NULL,
  `multiplier_coefficient` FLOAT NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `donkeyair`.`option`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `donkeyair`.`option` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(45) NOT NULL,
  `multiplier_coefficient` FLOAT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `donkeyair`.`passenger`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `donkeyair`.`passenger` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `first_name` VARCHAR(45) NOT NULL,
  `last_name` VARCHAR(45) NOT NULL,
  `title` ENUM('M', 'Mme') NULL,
  `booking_id` INT NOT NULL,
  `class_id` INT NOT NULL,
  `option_id` INT NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_passenger_booking1_idx` (`booking_id` ASC),
  INDEX `fk_passenger_class1_idx` (`class_id` ASC),
  INDEX `fk_passenger_option1_idx` (`option_id` ASC),
  CONSTRAINT `fk_passenger_booking1`
    FOREIGN KEY (`booking_id`)
    REFERENCES `donkeyair`.`booking` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_passenger_class1`
    FOREIGN KEY (`class_id`)
    REFERENCES `donkeyair`.`class` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_passenger_option1`
    FOREIGN KEY (`option_id`)
    REFERENCES `donkeyair`.`option` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `donkeyair`.`airport`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `donkeyair`.`airport` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(56) NOT NULL,
  `code` VARCHAR(3) NULL,
  `state_code` VARCHAR(2) NULL,
  `country_code` VARCHAR(2) NULL,
  `country_name` VARCHAR(32) NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `donkeyair`.`plane`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `donkeyair`.`plane` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `producer` VARCHAR(45) NULL,
  `model` VARCHAR(45) NULL,
  `capacity_first_class` INT NOT NULL,
  `capacity_seconde_class` INT NOT NULL,
  `capacity_economic_class` INT NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `donkeyair`.`flight`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `donkeyair`.`flight` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `departure_date` DATETIME NOT NULL,
  `arrival_date` DATETIME NOT NULL,
  `price` FLOAT NOT NULL,
  `airport_start_id` INT NOT NULL,
  `airport_to_id1` INT NOT NULL,
  `plane_id` INT NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_flight_city1_idx` (`airport_start_id` ASC),
  INDEX `fk_flight_city2_idx` (`airport_to_id1` ASC),
  INDEX `fk_flight_plane1_idx` (`plane_id` ASC),
  CONSTRAINT `fk_flight_city1`
    FOREIGN KEY (`airport_start_id`)
    REFERENCES `donkeyair`.`airport` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_flight_city2`
    FOREIGN KEY (`airport_to_id1`)
    REFERENCES `donkeyair`.`airport` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_flight_plane1`
    FOREIGN KEY (`plane_id`)
    REFERENCES `donkeyair`.`plane` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `donkeyair`.`booking_flight`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `donkeyair`.`booking_flight` (
  `booking_id` INT NOT NULL,
  `flight_id` INT NOT NULL,
  PRIMARY KEY (`booking_id`, `flight_id`),
  INDEX `fk_booking_has_flight_flight1_idx` (`flight_id` ASC),
  INDEX `fk_booking_has_flight_booking1_idx` (`booking_id` ASC),
  CONSTRAINT `fk_booking_has_flight_booking1`
    FOREIGN KEY (`booking_id`)
    REFERENCES `donkeyair`.`booking` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_booking_has_flight_flight1`
    FOREIGN KEY (`flight_id`)
    REFERENCES `donkeyair`.`flight` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
