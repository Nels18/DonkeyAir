-- MySQL Script generated by MySQL Workbench
-- Mon Nov 22 16:55:17 2021
-- Model: New Model    Version: 1.0
-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

-- -----------------------------------------------------
-- Schema donkeyair
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema donkeyair
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `donkeyair` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `donkeyair` ;

-- -----------------------------------------------------
-- Table `donkeyair`.`country`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `donkeyair`.`country` (
  `code` VARCHAR(2) NOT NULL,
  `name` VARCHAR(255) NOT NULL,
  PRIMARY KEY (`code`),
  UNIQUE INDEX `name_UNIQUE` (`name` ASC))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `donkeyair`.`customer`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `donkeyair`.`customer` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `email` VARCHAR(45) NOT NULL,
  `password` VARCHAR(45) NOT NULL,
  `first_name` VARCHAR(45) NOT NULL,
  `last_name` VARCHAR(45) NOT NULL,
  `title` ENUM('M', 'Mme') NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `donkeyair`.`option`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `donkeyair`.`option` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(45) NOT NULL,
  `additional_luggage` TINYINT(1) NOT NULL,
  `modifiable_ticket` TINYINT(1) NOT NULL,
  `refundable_ticket` TINYINT(1) NOT NULL,
  `multiplier_coefficient` FLOAT NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `donkeyair`.`booking`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `donkeyair`.`booking` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `customer_id` INT NOT NULL,
  `option_id` INT NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_booking_customer1_idx` (`customer_id` ASC),
  INDEX `fk_booking_option1_idx` (`option_id` ASC),
  CONSTRAINT `fk_booking_customer1`
    FOREIGN KEY (`customer_id`)
    REFERENCES `donkeyair`.`customer` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_booking_option1`
    FOREIGN KEY (`option_id`)
    REFERENCES `donkeyair`.`option` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `donkeyair`.`passenger`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `donkeyair`.`passenger` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `first_name` VARCHAR(45) NOT NULL,
  `last_name` VARCHAR(45) NOT NULL,
  `title` ENUM('M', 'Mme') NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `donkeyair`.`plane`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `donkeyair`.`plane` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `model` VARCHAR(45) NULL,
  `capacity_first_class` INT NOT NULL,
  `capacity_second_class` INT NOT NULL,
  `capacity_economic_class` INT NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `donkeyair`.`airport`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `donkeyair`.`airport` (
  `code` VARCHAR(3) NOT NULL,
  `name` VARCHAR(255) NOT NULL,
  `country_code` VARCHAR(2) NOT NULL,
  PRIMARY KEY (`code`),
  INDEX `fk_airport_country1_idx` (`country_code` ASC),
  CONSTRAINT `fk_airport_country1`
    FOREIGN KEY (`country_code`)
    REFERENCES `donkeyair`.`country` (`code`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `donkeyair`.`flight`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `donkeyair`.`flight` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `departure_date` DATETIME NOT NULL,
  `arrival_date` DATETIME NOT NULL,
  `price` FLOAT NOT NULL,
  `plane_id` INT NOT NULL,
  `airport_from_code` VARCHAR(3) NOT NULL,
  `airport_to_code` VARCHAR(3) NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_flight_plane1_idx` (`plane_id` ASC),
  INDEX `fk_flight_airport1_idx` (`airport_from_code` ASC),
  INDEX `fk_flight_airport2_idx` (`airport_to_code` ASC),
  CONSTRAINT `fk_flight_plane1`
    FOREIGN KEY (`plane_id`)
    REFERENCES `donkeyair`.`plane` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_flight_airport1`
    FOREIGN KEY (`airport_from_code`)
    REFERENCES `donkeyair`.`airport` (`code`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_flight_airport2`
    FOREIGN KEY (`airport_to_code`)
    REFERENCES `donkeyair`.`airport` (`code`)
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
-- Table `donkeyair`.`ticket`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `donkeyair`.`ticket` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `booking_id` INT NOT NULL,
  `passenger_id` INT NOT NULL,
  `flight_id` INT NOT NULL,
  `class_id` INT NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_ticket_booking1_idx` (`booking_id` ASC),
  INDEX `fk_ticket_passenger1_idx` (`passenger_id` ASC),
  INDEX `fk_ticket_flight1_idx` (`flight_id` ASC),
  INDEX `fk_ticket_class1_idx` (`class_id` ASC),
  CONSTRAINT `fk_ticket_booking1`
    FOREIGN KEY (`booking_id`)
    REFERENCES `donkeyair`.`booking` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_ticket_passenger1`
    FOREIGN KEY (`passenger_id`)
    REFERENCES `donkeyair`.`passenger` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_ticket_flight1`
    FOREIGN KEY (`flight_id`)
    REFERENCES `donkeyair`.`flight` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_ticket_class1`
    FOREIGN KEY (`class_id`)
    REFERENCES `donkeyair`.`class` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
