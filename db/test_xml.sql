/*
SQLyog Enterprise v9.50 
MySQL - 5.5.25a-log : Database - test_xml
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
/*Table structure for table `Offers` */

DROP TABLE IF EXISTS `Offers`;

CREATE TABLE `Offers` (
  `Id` bigint(20) NOT NULL AUTO_INCREMENT COMMENT 'Идентификатор',
  `internal_id` bigint(20) NOT NULL COMMENT 'Внутренний Id',
  `type` varchar(50) NOT NULL,
  `property_type` varchar(50) NOT NULL,
  `category` varchar(50) NOT NULL,
  `url` varchar(250) NOT NULL,
  `creation_date` datetime NOT NULL,
  `last_update_date` datetime DEFAULT NULL,
  `expire_date` datetime DEFAULT NULL,
  `payed_adv` tinyint(1) NOT NULL DEFAULT '0',
  `manually_added` tinyint(1) NOT NULL DEFAULT '0',
  `country` varchar(50) NOT NULL,
  `region` varchar(50) DEFAULT NULL,
  `district` varchar(50) DEFAULT NULL,
  `locality_name` varchar(50) DEFAULT NULL,
  `sub_locality_name` varchar(50) DEFAULT NULL,
  `address` varchar(150) DEFAULT NULL,
  `direction` varchar(50) DEFAULT NULL,
  `distance` smallint(6) DEFAULT NULL,
  `latitude` smallint(6) DEFAULT NULL,
  `longitude` smallint(6) DEFAULT NULL,
  `metroName` varchar(50) DEFAULT NULL,
  `time_on_transport` smallint(6) DEFAULT NULL,
  `time_on_foot` smallint(6) DEFAULT NULL,
  `railway_station` varchar(50) DEFAULT NULL,
  `price` decimal(9,2) NOT NULL,
  `currency` varchar(10) NOT NULL,
  `period` varchar(50) DEFAULT NULL,
  `unit` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COMMENT='Предложения';

/*Table structure for table `OffersImages` */

DROP TABLE IF EXISTS `OffersImages`;

CREATE TABLE `OffersImages` (
  `Id` bigint(20) NOT NULL AUTO_INCREMENT,
  `Offers_Id` bigint(20) DEFAULT NULL,
  `image` varchar(250) DEFAULT NULL,
  PRIMARY KEY (`Id`),
  KEY `Offers_Id` (`Offers_Id`),
  CONSTRAINT `OffersImages_ibfk_1` FOREIGN KEY (`Offers_Id`) REFERENCES `Offers` (`Id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COMMENT='Фото';

/*Table structure for table `OffersSalesAgent` */

DROP TABLE IF EXISTS `OffersSalesAgent`;

CREATE TABLE `OffersSalesAgent` (
  `Id` bigint(20) NOT NULL AUTO_INCREMENT,
  `Offers_Id` bigint(20) DEFAULT NULL,
  `name` varchar(50) DEFAULT NULL,
  `phone` varchar(50) NOT NULL,
  `category` varchar(50) DEFAULT NULL,
  `organization` varchar(50) DEFAULT NULL,
  `agency_id` bigint(20) DEFAULT NULL,
  `url` varchar(250) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `partner` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`Id`),
  KEY `Offers_Id` (`Offers_Id`),
  CONSTRAINT `OffersSalesAgent_ibfk_1` FOREIGN KEY (`Offers_Id`) REFERENCES `Offers` (`Id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COMMENT='Продавец или Арендодатель';

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
