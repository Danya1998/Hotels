CREATE DATABASE IF NOT EXISTS `Hotels` DEFAULT COLLATE utf8_general_ci;
USE `Hotels`;
CREATE TABLE IF NOT EXISTS `countries`(
  `id` INT UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `name` VARCHAR(255)
)ENGINE=InnoDB;
CREATE TABLE IF NOT EXISTS `cities`(
  `id` INT UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `name` VARCHAR(255),
  `country_id` INT UNSIGNED,
  FOREIGN KEY (`country_id`) REFERENCES `countries`(`id`) ON DELETE CASCADE
)ENGINE=InnoDB;
CREATE TABLE IF NOT EXISTS `hotels`(
  `id` INT UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `name` VARCHAR(255),
  `city_id` INT UNSIGNED,
  FOREIGN KEY (`city_id`) REFERENCES `cities`(`id`) ON DELETE CASCADE
)ENGINE=InnoDB;

INSERT INTO `countries` (`name`) VALUES ("Ukraine"),("United Kingdom"),("Poland");
INSERT INTO `cities`(`name`,`country_id`) VALUES
  ("Kiev",1),
  ("Dnepr",1),
  ("Lvov",1),
  ("Odessa",1),
  ("London",2),
  ("Manchester",2),
  ("Varshava",3),
  ("Khrakov",3);
INSERT INTO `hotels`(`name`,`city_id`) VALUES
  ("Kiev Hotel 1",1),
  ("Kiev Hotel 2",1),
  ("Kiev Hotel 3",1),
  ("Dnepr Hotel 1",2),
  ("Dnepr Hotel 2",2),
  ("Dnepr Hotel 3",2),
  ("London Hotel 1",5),
  ("London Hotel 2",5),
  ("London Hotel 3",5);
