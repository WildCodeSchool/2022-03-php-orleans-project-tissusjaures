-- MySQL Script generated by MySQL Workbench
-- Sun Apr 17 11:12:27 2022
-- Model: New Model    Version: 1.0
-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

-- -----------------------------------------------------
-- Table `tissus_jaures`.`cloth_categories`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `tissus_jaures`.`cloth_categories` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(100) NOT NULL,
  `image` VARCHAR(100) NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;

-- -----------------------------------------------------
-- Content `tissus_jaures`.`cloth_categories`
-- -----------------------------------------------------
INSERT INTO `cloth_categories` (`id`, `name`, `image`) VALUES
(1, "Tissus d'ameublement", 'public/assets/images/tss1'),
(2, "Loisirs créatifs", 'public/assets/images/tss1'),
(3, "Mercerie", 'public/assets/images/tss1'),
(4, "Tissus couture", 'public/assets/images/tss1'),
(5, "Voilage", 'public/assets/images/tss1'),
(6, "Décoration", 'public/assets/images/tss1');

-- -----------------------------------------------------
-- Table `tissus_jaures`.`machine_categories`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `tissus_jaures`.`machine_categories` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(100) NOT NULL,
  `image` VARCHAR(100) NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;

-- -----------------------------------------------------
-- Content `tissus_jaures`.`machine_categories`
-- -----------------------------------------------------
INSERT INTO `machine_categories` (`id`, `name`, `image`) VALUES
(1, "Machines à coudre", 'public/assets/images/mchn1');

-- -----------------------------------------------------
-- Table `tissus_jaures`.`cloth`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `tissus_jaures`.`cloth` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(100) NOT NULL,
  `description` TEXT NULL,
  `price` FLOAT NOT NULL,
  `image` VARCHAR(100) NULL,
  `is_on_sale` TINYINT NULL,
  `is_new` TINYINT NULL,
  `cloth_categories_id` INT NOT NULL,
  PRIMARY KEY (`id`, `cloth_categories_id`),
  INDEX `fk_cloth_cloth_categories_idx` (`cloth_categories_id` ASC) VISIBLE,
  CONSTRAINT `fk_cloth_cloth_categories`
    FOREIGN KEY (`cloth_categories_id`)
    REFERENCES `tissus_jaures`.`cloth_categories` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

-- -----------------------------------------------------
-- Content `tissus_jaures`.`cloth`
-- -----------------------------------------------------
INSERT INTO `cloth` (`id`, `name`, `description`, `price`, `image`,`is_on_sale`, `is_new`, `cloth_categories_id`) VALUES
(1, "Tissu bleu", "Un joli tissu bleu", 5, 'public/assets/images/tss1', 0, 0, 1),
(2, "Tissu vert", "Un joli tissu vert", 4, 'public/assets/images/tss1', 0, 0, 3),
(3, "Tissu jaune", "Un joli tissu jaune", 2.5, 'public/assets/images/tss1', 1, 0, 4),
(4, "Tissu rouge", "Un joli tissu rouge", 150, 'public/assets/images/tss1', 0, 1, 2),
(5, "Tissu violet", "Un joli tissu violet", 1, 'public/assets/images/tss1', 1, 1, 1),
(6, "Tissu orange", "Un joli tissu orange", 4.5, 'public/assets/images/tss1', 1, 0, 4);

-- -----------------------------------------------------
-- Table `tissus_jaures`.`machines`
-- -----------------------------------------------------

CREATE TABLE IF NOT EXISTS `tissus_jaures`.`machines` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(100) NOT NULL,
  `description` TEXT NULL,
  `price` FLOAT NOT NULL,
  `image` VARCHAR(100) NULL,
  `is_on_sale` TINYINT NULL,
  `is_new` TINYINT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;

-- -- -----------------------------------------------------
-- -- Content `tissus_jaures`.`machines`
-- -- -----------------------------------------------------
INSERT INTO `machines` (`id`, `name`, `description`, `price`, `image`,`is_on_sale`, `is_new`) VALUES
(1, "Machine Singer", "Une machine Singer", 400, 'public/assets/images/mchn1', 0, 0),
(2, "Machine Singer", "Une belle machine Singer", 300, 'public/assets/images/mchn1', 1, 1),
(3, "Machine Singer", "Une superbe machine Singer", 150.5, 'public/assets/images/mchn1', 1, 0),
(4, "Machine Singer", "Une magnifique machine Singer", 10000, 'public/assets/images/mchn1', 0, 1);


-- -----------------------------------------------------
-- Table `tissus_jaures`.`tips_and_tricks_categories`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `tissus_jaures`.`tips_and_tricks_categories` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(100) NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;

-- -----------------------------------------------------
-- Content `tissus_jaures`.`tips_and_tricks_categories`
-- -----------------------------------------------------
INSERT INTO `tips_and_tricks_categories` (`id`, `name`, `image`) VALUES
(1, "Astuces")
(2, "Tutoriels")
(2, "Lexique");

-- -----------------------------------------------------
-- Table `tissus_jaures`.`tutorials`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `tissus_jaures`.`tutorials` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(100) NOT NULL,
  `image` VARCHAR(100) NULL,
  `content` TEXT NOT NULL,
  `tips_and_tricks_categories_id` INT NOT NULL,
  PRIMARY KEY (`id`, `tips_and_tricks_categories_id`),
  INDEX `fk_tutorials_tips_and_tricks_categories_idx` (`tips_and_tricks_categories_id` ASC) VISIBLE,
  CONSTRAINT `fk_tutorials_tips_and_tricks_categories`
    FOREIGN KEY (`tips_and_tricks_categories_id`)
    REFERENCES `tissus_jaures`.`tips_and_tricks_categories` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION))
ENGINE = InnoDB;
  
-- -----------------------------------------------------
-- Table `tissus_jaures`.`lexicon`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `tissus_jaures`.`lexicon` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(100) NOT NULL,
  `definition` TEXT NOT NULL,
  `tips_and_tricks_categories_id` INT NOT NULL,
  PRIMARY KEY (`id`, `tips_and_tricks_categories_id`),
  INDEX `fk_lexicon_tips_and_tricks_categories_idx` (`tips_and_tricks_categories_id` ASC) VISIBLE,
  CONSTRAINT `fk_lexicon_tips_and_tricks_categories`
    FOREIGN KEY (`tips_and_tricks_categories_id`)
    REFERENCES `tissus_jaures`.`tips_and_tricks_categories` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION))
ENGINE = InnoDB;

-- -----------------------------------------------------
-- Table `tissus_jaures`.`tips`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `tissus_jaures`.`tips` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(100) NOT NULL,
  `content` TEXT NOT NULL,
    `tips_and_tricks_categories_id` INT NOT NULL,
  PRIMARY KEY (`id`, `tips_and_tricks_categories_id`),
  INDEX `fk_tips_tips_and_tricks_categories_idx` (`tips_and_tricks_categories_id` ASC) VISIBLE,
  CONSTRAINT `fk_tips_tips_and_tricks_categories`
    FOREIGN KEY (`tips_and_tricks_categories_id`)
    REFERENCES `tissus_jaures`.`tips_and_tricks_categories` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION))
ENGINE = InnoDB;

SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;




