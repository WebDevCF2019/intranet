-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

-- -----------------------------------------------------
-- Schema intranetv3
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema intranetv3
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `intranetv3` DEFAULT CHARACTER SET utf8 ;
USE `intranetv3` ;

-- -----------------------------------------------------
-- Table `intranetv3`.`lasession`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `intranetv3`.`lasession` (
  `idlasession` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `lenom` VARCHAR(45) NOT NULL,
  `lacronyme` VARCHAR(10) NOT NULL,
  `lannee` YEAR(4) NOT NULL,
  `lenumero` TINYINT(1) NULL,
  `letype` TINYINT(1) NOT NULL,
  `debut` DATE NOT NULL,
  `fin` DATE NOT NULL,
  `lafiliere_idfiliere` TINYINT(3) UNSIGNED NOT NULL,
  PRIMARY KEY (`idlasession`),
  INDEX `fk_session_filiere1_idx` (`lafiliere_idfiliere` ASC),
  CONSTRAINT `fk_session_filiere1`
    FOREIGN KEY (`lafiliere_idfiliere`)
    REFERENCES `intranetv3`.`lafiliere` (`idlafiliere`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `intranetv3`.`linscription`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `intranetv3`.`linscription` (
  `idlinscription` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `debut` DATE NULL,
  `fin` DATE NULL,
  `utilisateur_idutilisateur` MEDIUMINT UNSIGNED NOT NULL,
  `lasession_idsession` INT UNSIGNED NOT NULL,
  PRIMARY KEY (`idlinscription`),
  INDEX `fk_inscription_utilisateur1_idx` (`utilisateur_idutilisateur` ASC),
  INDEX `fk_inscription_session1_idx` (`lasession_idsession` ASC),
  CONSTRAINT `fk_inscription_utilisateur1`
    FOREIGN KEY (`utilisateur_idutilisateur`)
    REFERENCES `intranetv3`.`lutilisateur` (`idlutilisateur`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_inscription_session1`
    FOREIGN KEY (`lasession_idsession`)
    REFERENCES `intranetv3`.`lasession` (`idlasession`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
