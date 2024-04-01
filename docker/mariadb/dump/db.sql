-- MariaDB dump 10.19  Distrib 10.9.8-MariaDB, for debian-linux-gnu (x86_64)
--
-- Host: localhost    Database: wb_db
-- ------------------------------------------------------
-- Server version	10.9.8-MariaDB-1:10.9.8+maria~ubu2204
/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */
;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */
;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */
;
/*!40101 SET NAMES utf8mb4 */
;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */
;
/*!40103 SET TIME_ZONE='+00:00' */
;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */
;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */
;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */
;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */
;
--
-- Table structure for table `products`
--

DROP TABLE IF EXISTS `products`;
/*!40101 SET @saved_cs_client     = @@character_set_client */
;
/*!40101 SET character_set_client = utf8 */
;
CREATE TABLE `products` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `key_word_id` INT(11) NOT NULL,
  `position` INT(11) NOT NULL DEFAULT 0,
  `name` VARCHAR(255) NOT NULL,
  `product_article` INT(11) NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `idx_products_key_word_id` (`key_word_id` ASC),
  INDEX `idx_products_product_article` (`product_article` ASC),
  CONSTRAINT `products_key_word_FK` FOREIGN KEY (`key_word_id`) REFERENCES `key_word` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE = InnoDB AUTO_INCREMENT = 8 DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */
;
ALTER TABLE `products` AUTO_INCREMENT = 1;
--
-- Table structure for table `key_word`
--
DROP TABLE IF EXISTS `key_word`;
CREATE TABLE IF NOT EXISTS `key_word` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `word` TEXT NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `word_unique` (`word` ASC)
) ENGINE = InnoDB AUTO_INCREMENT = 8 DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */
;
ALTER TABLE `key_word` AUTO_INCREMENT = 1;