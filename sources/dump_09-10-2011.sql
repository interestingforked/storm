/*
SQLyog Ultimate v8.6 Beta2
MySQL - 5.1.40-community : Database - storm
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
/*Table structure for table `classifier` */

DROP TABLE IF EXISTS `classifier`;

CREATE TABLE `classifier` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `group` varchar(20) NOT NULL,
  `key` varchar(20) NOT NULL,
  `value` varchar(250) NOT NULL,
  `active` tinyint(1) DEFAULT '1',
  `created` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8;

/*Data for the table `classifier` */

insert  into `classifier`(`id`,`group`,`key`,`value`,`active`,`created`) values (1,'color','BLACK','Black',1,'2011-09-16 14:17:34'),(2,'color','BROWN','Brown',1,'2011-09-16 14:17:50'),(3,'color','GREEN','Green',1,'2011-09-16 14:17:59'),(4,'color','VIOLET','Lazer Blue',1,'2011-09-16 14:18:06'),(5,'color','SILVER','Silver',1,'2011-09-16 14:18:15'),(6,'color','WHITE','White',1,'2011-09-16 14:18:30'),(7,'color','PURPLE','Purple',1,'2011-10-07 00:19:26'),(8,'color','BLUE','Blue',1,'2011-10-07 00:25:18'),(9,'color','AQUA','Aqua',1,'2011-10-07 00:25:18'),(10,'color','RED','Red',1,'2011-10-07 00:25:18'),(11,'color','PINK','Pink',1,'2011-10-07 00:25:18'),(12,'color','ORANGE','Orange',1,'2011-10-07 00:25:18'),(13,'color','MIRROR','Mirror',1,'2011-10-07 00:25:18'),(14,'color','GREY','Grey',1,'2011-10-07 00:25:18'),(15,'color','YELLOW','Yellow',1,'2011-10-07 00:25:18'),(16,'color','HOTPINK','Hot Pink',1,'2011-10-07 00:25:18'),(17,'color','GOLD','Gold',1,'2011-10-07 00:25:18'),(18,'color','ROSEGOLD','Rose Gold',1,'2011-10-07 00:25:18'),(19,'color','GOLDBROWN','Gold/Brown',1,'2011-10-07 00:25:18'),(20,'color','GOLDSLATE','Gold/Slate',1,'2011-10-07 00:25:18'),(21,'color','SILVERBLACK','Silver/Black',1,'2011-10-07 00:25:18'),(22,'color','GOLDBLACK','Gold/Black',1,'2011-10-07 00:25:18'),(23,'color','GOLDAQUA','Gold/Aqua',1,'2011-10-07 00:25:18'),(24,'color','GOLDWHITE','Gold/White',1,'2011-10-07 00:25:18'),(25,'color','SLATE','Slate',1,'2011-10-07 00:26:40');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
