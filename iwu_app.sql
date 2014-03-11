SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

CREATE SCHEMA IF NOT EXISTS `iwu-app` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ;
USE `iwu-app` ;

-- -----------------------------------------------------
-- Table `iwu-app`.`Account`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `iwu-app`.`Account` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `studentIDNum` INT NULL,
  `mealswipes` INT NULL,
  `points` DECIMAL(8,2) NULL DEFAULT 0.00,
  `lastUsed` TIMESTAMP NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `iwu-app`.`Student`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `iwu-app`.`Student` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `studentIDNum` INT NULL,
  `firstName` VARCHAR(45) NULL,
  `lastName` VARCHAR(45) NULL,
  `Account_id` INT NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `studentIDNum_idx` (`studentIDNum` ASC),
  CONSTRAINT `studentIDNum`
    FOREIGN KEY (`studentIDNum`)
    REFERENCES `iwu-app`.`Account` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
