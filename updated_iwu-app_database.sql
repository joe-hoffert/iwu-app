SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

CREATE SCHEMA IF NOT EXISTS `mydb` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ;
USE `mydb` ;

-- -----------------------------------------------------
-- Table `mydb`.`Student_Account`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`Student_Account` (
  `id` INT NULL AUTO_INCREMENT,
  `studentID` INT NOT NULL,
  `firstName` VARCHAR(45) NOT NULL,
  `lastName` VARCHAR(45) NOT NULL,
  `password` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`Locations`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`Locations` (
  `id` INT NULL AUTO_INCREMENT,
  `location` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`Point_History`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`Point_History` (
  `id` INT NULL AUTO_INCREMENT,
  `lastUsed` TIMESTAMP NULL,
  `Locations_id` INT NOT NULL,
  `Student_Account_id` INT NOT NULL,
  `totalPoints` FLOAT NULL,
  `pointsSpent` FLOAT NULL,
  PRIMARY KEY (`id`, `Locations_id`, `Student_Account_id`),
  INDEX `fk_Point_History_Locations1_idx` (`Locations_id` ASC),
  INDEX `fk_Point_History_Student_Account1_idx` (`Student_Account_id` ASC),
  CONSTRAINT `fk_Point_History_Locations1`
    FOREIGN KEY (`Locations_id`)
    REFERENCES `mydb`.`Locations` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Point_History_Student_Account1`
    FOREIGN KEY (`Student_Account_id`)
    REFERENCES `mydb`.`Student_Account` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`Mealswipe_History`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`Mealswipe_History` (
  `id` INT NULL AUTO_INCREMENT,
  `lastUsed` TIMESTAMP NULL,
  `Locations_id` INT NOT NULL,
  `Student_Account_id` INT NOT NULL,
  `totalMealswipes` INT NULL,
  PRIMARY KEY (`id`, `Locations_id`, `Student_Account_id`),
  INDEX `fk_Mealswipe_History_Locations1_idx` (`Locations_id` ASC),
  INDEX `fk_Mealswipe_History_Student_Account1_idx` (`Student_Account_id` ASC),
  CONSTRAINT `fk_Mealswipe_History_Locations1`
    FOREIGN KEY (`Locations_id`)
    REFERENCES `mydb`.`Locations` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Mealswipe_History_Student_Account1`
    FOREIGN KEY (`Student_Account_id`)
    REFERENCES `mydb`.`Student_Account` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
