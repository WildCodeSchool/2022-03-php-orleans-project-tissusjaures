SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

-- -----------------------------------------------------
-- Table `tissus_jaures`.`cloth_categories`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `tissus_jaures`.`cloth_categories` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(100) NOT NULL,
  `image` VARCHAR(100) NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;

-- -----------------------------------------------------
-- Content `tissus_jaures`.`cloth_categories`
-- -----------------------------------------------------
INSERT INTO `cloth_categories` (`id`, `name`, `image`) VALUES
(1, "Tissus d'ameublement", '/assets/images/tss1'),
(2, "Loisirs créatifs", '/assets/images/tss1'),
(3, "Mercerie", '/assets/images/tss1'),
(4, "Tissus couture", '/assets/images/tss1'),
(5, "Voilage", '/assets/images/tss1'),
(6, "Décoration", '/assets/images/tss1');

-- -----------------------------------------------------
-- Table `tissus_jaures`.`machine_categories`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `tissus_jaures`.`machine_categories` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(100) NOT NULL,
  `image` VARCHAR(100) NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;

-- -----------------------------------------------------
-- Content `tissus_jaures`.`machine_categories`
-- -----------------------------------------------------
INSERT INTO `machine_categories` (`id`, `name`, `image`) VALUES
(1, "Machines à coudre", '/assets/images/mchn1');

-- -----------------------------------------------------
-- Table `tissus_jaures`.`cloth`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `tissus_jaures`.`cloth` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(100) NOT NULL,
  `description` TEXT NULL,
  `price` FLOAT NOT NULL,
  `image` VARCHAR(100) NOT NULL,
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
(1, "Tissu bleu", "Un joli tissu bleu", 5, '/assets/images/tss1', 0, 0, 1),
(2, "Tissu vert", "Un joli tissu vert", 4, '/assets/images/tss1', 0, 0, 3),
(3, "Tissu jaune", "Un joli tissu jaune", 2.5, '/assets/images/tss1', 1, 0, 4),
(4, "Tissu rouge", "Un joli tissu rouge", 150, '/assets/images/tss1', 0, 1, 2),
(5, "Tissu violet", "Un joli tissu violet", 1, '/assets/images/tss1', 1, 1, 1),
(6, "Tissu orange", "Un joli tissu orange", 4.5, '/assets/images/tss1', 1, 0, 4);

-- -----------------------------------------------------
-- Table `tissus_jaures`.`machines`
-- -----------------------------------------------------

CREATE TABLE IF NOT EXISTS `tissus_jaures`.`machines` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(100) NOT NULL,
  `description` TEXT NULL,
  `price` FLOAT NOT NULL,
  `image` VARCHAR(100) NOT NULL,
  `is_on_sale` TINYINT NULL,
  `is_new` TINYINT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;

-- -- -----------------------------------------------------
-- -- Content `tissus_jaures`.`machines`
-- -- -----------------------------------------------------
INSERT INTO `machines` (`id`, `name`, `description`, `price`, `image`,`is_on_sale`, `is_new`) VALUES
(1, "Machine Singer", "Une machine Singer", 400, '/assets/images/mchn1', 0, 0),
(2, "Machine Singer", "Une belle machine Singer", 300, '/assets/images/mchn1', 1, 1),
(3, "Machine Singer", "Une superbe machine Singer", 150.5, '/assets/images/mchn1', 1, 0),
(4, "Machine Singer", "Une magnifique machine Singer", 10000, '/assets/images/mchn1', 0, 1);

-- -----------------------------------------------------
-- Table `tissus_jaures`.`tips_and_tricks_categories`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `tissus_jaures`.`tips_and_tricks_categories` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(100) NOT NULL,
  `link` VARCHAR(100) NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;

-- -----------------------------------------------------
-- Content `tissus_jaures`.`tips_and_tricks_categories`
-- -----------------------------------------------------
INSERT INTO `tips_and_tricks_categories` (`id`, `name`, `link`) VALUES
(1, "Astuces", "/astuces"),
(2, "Tutoriels", "/tutoriels"),
(3, "Lexique", "/lexique");

-- -----------------------------------------------------
-- Table `tissus_jaures`.`tutorials`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `tissus_jaures`.`tutorials` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(100) NOT NULL,
  `image` VARCHAR(100) NOT NULL,
  `content` TEXT NOT NULL,
  `tips_and_tricks_categories_id` INT NOT NULL,
  PRIMARY KEY (`id`, `tips_and_tricks_categories_id`),
  INDEX `fk_tutorials_tips_and_tricks_categories_idx` (`tips_and_tricks_categories_id` ASC) VISIBLE,
  CONSTRAINT `fk_tutorials_tips_and_tricks_categories`
    FOREIGN KEY (`tips_and_tricks_categories_id`)
    REFERENCES `tissus_jaures`.`tips_and_tricks_categories` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

-- -- -----------------------------------------------------
-- -- Content `tissus_jaures`.`tutorials`
-- -- -----------------------------------------------------

INSERT INTO `tutorials` (`id`, `name`, `image`, `content`, `tips_and_tricks_categories_id`) VALUES
(1, "Confectionner des rideaux", "/assets/images/tss1.jpg", "La hauteur du rideau = Haut de la barre au sol + 3cm.
La hauteur du tissu = Hauteur du rideaux + 20cm pour les ourlets.", 2),
(2, "Fixer ses tringles", "/assets/images/tss1.jpg", "La barre est généralement placée 15cm environ au dessus du haut de la fenêtre.
Pour plus d’esthétique, la barre dépasse d’environ 20cm de chaque coté de la fenêtre. Le respect de ces distances permet également une ouverture facile des fenêtres.
Bien mesurer avant de percer ! Les supports se placent à environ 10cm du bout de la tringle.", 2),
(3, "Conseil déco", "/assets/images/tss1.jpg", "Votre pièce doit être harmonieuse...
Pourquoi ne pas poser un voilage léger porté par une tringlerie fine, des doubles rideaux sur des tringles de grand diamètre et des embouts de barre pour s'accorder au style de votre intérieur...", 2);


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
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

-- -- -----------------------------------------------------
-- -- Content `tissus_jaures`.`lexicon`
-- -- -----------------------------------------------------
INSERT INTO `lexicon` (`id`, `name`, `definition`, `tips_and_tricks_categories_id`) VALUES
(1, "Appliqué : ", " Technique. Coudre à point invisibles (rentré de 5mm) un motif sur un tissu de fond.", 3),
(2, "Biais :", " Bande de tissus étroite et en diagonale (45°du droit fil) utilisé pour border.", 3),
(3, "Boutis :", " Technique « provençale ». Matelassage de plusieurs tissus à la main. Les deux cotés pouvant être exposés.", 3),
(4, "Charm quilt :", " Ouvrage réalisé avec un gabarit unique et une multitude de tissus tous différents.", 3),
(5, "Cording :", " Technique. Introduction d’un cordon entre deux lignes de matelassage pour donner du relief à un ouvrage.", 3),
(6, "Crazy quilt :", " Ouvrage réalisé avec des pièces de formes irrégulières assemblées et dont les coutures sont brodées à la main.", 3),
(7, "Log cabin :", " Ouvrage réalisé par assemblage d’un carré central avec des bandes de tissus de longueurs croissantes et alternant deux bandes claires et deux foncées.", 3),
(8, "Molleton :", " Rembourrage en coton, laine ou matière synthétiques. Il existe différentes épaisseurs et qualités.", 3),
(9, "Muslin :", " Tissu de coton léger écru ou blanc.", 3),
(10, "Quilt :", " Traduction américaine de patchwork.", 3),
(11, "Toile à beurre :", " Toile de coton très fine à maille lâche", 3),
(12, "Stippling :", " Quilting serré.", 3),
(13, "Viseline :", "non-tissé thermocollant utilisé en appliqué.", 3);


-- -----------------------------------------------------
-- Table `tissus_jaures`.`tips`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `tissus_jaures`.`tips` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(100) NOT NULL,
  `image` VARCHAR(100) NOT NULL,
  `content` TEXT NOT NULL,
  `is_monthly_tip` TINYINT NOT NULL,
  `tips_and_tricks_categories_id` INT NOT NULL,
  PRIMARY KEY (`id`, `tips_and_tricks_categories_id`),
  INDEX `fk_tips_tips_and_tricks_categories_idx` (`tips_and_tricks_categories_id` ASC) VISIBLE,
  CONSTRAINT `fk_tips_tips_and_tricks_categories`
    FOREIGN KEY (`tips_and_tricks_categories_id`)
    REFERENCES `tissus_jaures`.`tips_and_tricks_categories` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

-- -----------------------------------------------------
-- Content `tissus_jaures`.`tips`
-- -----------------------------------------------------
INSERT INTO `tips` (`id`, `name`, `image`, `content`, `is_monthly_tip`, `tips_and_tricks_categories_id`) VALUES
(1, "L'ourlet parfait", "/assets/images/ourlet.jpg", "Plutôt que d’utiliser plusieurs fois votre mètre pour vérifier que votre ourlet est égal en tout point, utilisez plutôt cette astuce :
Faites un cran dans un rectangle de carton a la hauteur désirée et reportez votre ourlet grâce à un crayon en utilisant la marque du carton !", 1, 1),
(2, "Détacher un linge", "/assets/images/tache.jpg", "Epongez la tâche avec un papier absorbant et un fer chaud. Frottez ensuite avec du savon de Marseille sec que vous laisserez agir quelques minutes. Rincez à l'eau chaude.", 0, 1),
(3, "Taches de bougie", "/assets/images/tachebougie.jpg", "Une tâche de bougie sur votre vêtement ou votre sol? Prenez un buvard et déposé le sur la tâche. Passez ensuite un fer à repasser bien chaud sur le buvard. La cire va se décoller se venir se déposer sur le buvard. ", 0, 1),
(4, "Taches de peintures", "/assets/images/tachepeinture.jpg", "Trempez les vêtements tachés de peinture immédiatement dans du lait puis lavez normalement. Cette astuce est notamment utilisée dans les écoles maternelles.", 0 , 1),
(5, "Coudre de la toile cirée", "/assets/images/toileciree.jpg", "Pour coudre de la toile enduite, nous recommandons un pied presseur RN téflon.

Les toiles enduites ou cirées collent au pied. Voilà pourquoi lorsque vous les piquez avec un pied de biche normal, vous obtenez des plis non désirés et autres bonnes surprises!

Ce pied étant assez cher pour des travaux occasionnels, nous avons une astuces à vous confier...

Celle-ci consiste à coller sous un pied presseur normal, du ruban adhésif de peintre (ruban de masquage). Vous devrez ensuite couper le surplus de ruban adhésif afin qu’il ne dépasse pas du pied…

….vous avez un pied pour coudre de la toile enduite.", 0, 1);



SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;




SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;