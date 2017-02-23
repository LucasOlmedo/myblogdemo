-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

-- -----------------------------------------------------
-- Schema blog_php
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema blog_php
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `blog_php` DEFAULT CHARACTER SET utf8 ;
USE `blog_php` ;

-- -----------------------------------------------------
-- Table `blog_php`.`blog_usuario`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `blog_php`.`blog_usuario` (
  `usuario_id` INT NOT NULL AUTO_INCREMENT,
  `usuario_user` VARCHAR(150) NOT NULL,
  `usuario_pass` VARCHAR(255) NOT NULL,
  `usuario_name` VARCHAR(150) NOT NULL,
  PRIMARY KEY (`usuario_id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `blog_php`.`blog_categoria`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `blog_php`.`blog_categoria` (
  `categoria_id` INT NOT NULL AUTO_INCREMENT,
  `categoria_title` VARCHAR(150) NOT NULL,
  PRIMARY KEY (`categoria_id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `blog_php`.`blog_post`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `blog_php`.`blog_post` (
  `post_id` INT NOT NULL AUTO_INCREMENT,
  `post_title` VARCHAR(150) NOT NULL,
  `post_text` TEXT NULL,
  `post_blocked` INT NOT NULL DEFAULT 0 COMMENT '0 = bloqueado\n1 = desbloqueado',
  `post_date` DATETIME NOT NULL,
  `post_url` VARCHAR(150) NOT NULL,
  `post_categoria_id` INT NOT NULL,
  `post_usuario_id` INT NOT NULL,
  `post_creation` DATETIME NOT NULL,
  PRIMARY KEY (`post_id`),
  INDEX `fk_blog_post_blog_categoria1_idx` (`post_categoria_id` ASC),
  INDEX `fk_blog_post_blog_usuario1_idx` (`post_usuario_id` ASC),
  CONSTRAINT `fk_blog_post_blog_categoria1`
    FOREIGN KEY (`post_categoria_id`)
    REFERENCES `blog_php`.`blog_categoria` (`categoria_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_blog_post_blog_usuario1`
    FOREIGN KEY (`post_usuario_id`)
    REFERENCES `blog_php`.`blog_usuario` (`usuario_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `blog_php`.`blog_imagem`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `blog_php`.`blog_imagem` (
  `imagem_id` INT NOT NULL AUTO_INCREMENT,
  `imagem_subtitle` VARCHAR(45) NULL,
  `imagem_file` VARCHAR(150) NOT NULL,
  `imagem_featured` INT NOT NULL DEFAULT 0 COMMENT '0 = sem destaque\n1= com destaque',
  `imagem_post_id` INT NOT NULL,
  PRIMARY KEY (`imagem_id`),
  INDEX `fk_blog_imagem_blog_post_idx` (`imagem_post_id` ASC),
  CONSTRAINT `fk_blog_imagem_blog_post`
    FOREIGN KEY (`imagem_post_id`)
    REFERENCES `blog_php`.`blog_post` (`post_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
