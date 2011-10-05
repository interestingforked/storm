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
/*Table structure for table `attachments` */

DROP TABLE IF EXISTS `attachments`;

CREATE TABLE `attachments` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `module` varchar(20) NOT NULL,
  `module_id` int(11) NOT NULL,
  `mimetype` varchar(30) DEFAULT NULL,
  `image` varchar(200) DEFAULT NULL,
  `alt` varchar(200) DEFAULT NULL,
  `size` char(1) DEFAULT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;

/*Data for the table `attachments` */

insert  into `attachments`(`id`,`module`,`module_id`,`mimetype`,`image`,`alt`,`size`,`created`) values (1,'product',1,'image/png','sotec_green.png',NULL,'S','2011-09-08 15:45:47'),(2,'product',2,'image/png','simplex_purple.png',NULL,'S','2011-09-08 15:45:48'),(3,'product',3,'image/png','bion_black.png',NULL,'S','2011-09-08 15:45:49'),(4,'product',4,'image/png','dualmec_silver.png',NULL,'S','2011-09-08 15:45:49'),(5,'product',5,'image/png','noxer_silver.png',NULL,'S','2011-09-08 15:45:50'),(6,'product',6,'image/png','circuit_mk_2_slate.png',NULL,'S','2011-09-08 15:45:50'),(7,'product',7,'image/png','exar_blue.png',NULL,'S','2011-09-08 15:45:51'),(8,'product',8,'image/png','darth_black.png',NULL,'S','2011-09-08 15:45:52'),(10,'product',1,'image/jpeg','sotec_angle.jpg',NULL,'B','2011-09-08 15:47:03'),(11,'productNode',1,'image/png','sotec_black.png',NULL,'S','2011-09-08 16:05:52'),(12,'productNode',2,'image/png','sotec_green.png',NULL,'S','2011-09-08 17:34:34');

/*Table structure for table `categories` */

DROP TABLE IF EXISTS `categories`;

CREATE TABLE `categories` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `parent_id` int(11) unsigned DEFAULT '0',
  `active` tinyint(1) DEFAULT '1',
  `sort` int(3) DEFAULT NULL,
  `slug` varchar(250) NOT NULL,
  `image` varchar(250) DEFAULT NULL,
  `created` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

/*Data for the table `categories` */

insert  into `categories`(`id`,`parent_id`,`active`,`sort`,`slug`,`image`,`created`) values (1,0,1,1,'categories',NULL,NULL),(2,1,1,1,'watches',NULL,NULL),(3,1,1,2,'accesories',NULL,NULL),(4,1,1,3,'collections',NULL,NULL),(5,2,1,1,'watches/men','watch_cat1.jpg',NULL),(6,2,1,2,'watches/woman','watch_cat_w.jpg',NULL),(7,2,1,3,'watches/unisex','watch_cat_usex.jpg',NULL);

/*Table structure for table `contents` */

DROP TABLE IF EXISTS `contents`;

CREATE TABLE `contents` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `module` varchar(20) NOT NULL,
  `module_id` int(11) NOT NULL,
  `language` varchar(2) NOT NULL,
  `title` varchar(250) DEFAULT NULL,
  `body` text,
  `meta_title` varchar(250) DEFAULT NULL,
  `meta_description` text,
  `meta_keywords` text,
  `background` varchar(250) DEFAULT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8;

/*Data for the table `contents` */

insert  into `contents`(`id`,`module`,`module_id`,`language`,`title`,`body`,`meta_title`,`meta_description`,`meta_keywords`,`background`,`created`) values (1,'page',2,'ru','Новости',NULL,NULL,NULL,NULL,NULL,'2011-08-31 17:09:55'),(2,'page',3,'ru','Реклама',NULL,NULL,NULL,NULL,NULL,'2011-08-31 17:12:06'),(3,'page',4,'ru','Storm Vintage',NULL,NULL,NULL,NULL,NULL,'2011-08-31 17:12:06'),(4,'page',5,'ru','Информация и сервис',NULL,NULL,NULL,NULL,NULL,'2011-08-31 17:12:06'),(5,'page',6,'ru','Зарегистрироваться',NULL,NULL,NULL,NULL,NULL,'2011-08-31 17:12:06'),(6,'page',7,'ru','Магазины',NULL,NULL,NULL,NULL,NULL,'2011-08-31 17:12:06'),(7,'page',8,'ru','О Storm',NULL,NULL,NULL,NULL,NULL,'2011-08-31 17:12:06'),(8,'page',9,'ru','Контакты',NULL,NULL,NULL,NULL,NULL,'2011-08-31 17:12:06'),(9,'page',10,'ru','Журналы',NULL,NULL,NULL,NULL,NULL,'2011-08-31 17:12:06'),(10,'page',11,'ru','Знаменитости',NULL,NULL,NULL,NULL,NULL,'2011-08-31 17:12:06'),(11,'page',12,'ru','Реклама',NULL,NULL,NULL,NULL,NULL,'2011-08-31 17:12:06'),(12,'category',2,'ru','Часы','<p>Часы STORM изготовлены из высококачественной нержавеющей стали различной обработки и полировки. Все модели часов оснащены японскими или швейцарскими механизмами, царапиноустойчивым минеральным стеклом и анти-аллергенны.</p>','Часы','асы STORM изготовлены из высококачественной нержавеющей стали различной обработки и полировки.',NULL,'remi_v2.jpg','2011-09-08 19:04:31'),(13,'category',3,'ru','Бижутерия',NULL,NULL,NULL,NULL,'jewellery_mens.jpg','2011-09-08 19:05:46'),(14,'category',4,'ru','Коллекции',NULL,NULL,NULL,NULL,NULL,'2011-09-01 15:24:13'),(15,'category',5,'ru','Мужские','Линия часов STORM для мужчин включают в себя модели выполненные в разных стилях с ярко выраженной индивидуальностью. Различные приспособления и другие уникальные атрибуты делают их ультра-модными аксессуарами для стильных и современных мужчин',NULL,NULL,NULL,'remi_v2.jpg','2011-09-08 19:06:09'),(16,'category',6,'ru','Женские','Женская коллекция часов STORM создана под влиянием последних модных тенденций. При изготовлении этих часов, помимо стали, используется позолота и драгоценные камни. Также существует серия классических женских часов STORM , известных своим минимализмом и плавностью линий.и плавностью линий.',NULL,NULL,NULL,'remi_v2.jpg','2011-09-08 19:06:10'),(17,'category',7,'ru','Унисекс','УНИСЕКС Одними из характерных черт дизайна компании STORM являются минимализм и простота. Именно такими являются часы, которые подходят как мужчинам, так и женщинам.',NULL,NULL,NULL,'remi_v2.jpg','2011-09-08 19:06:11'),(18,'product',1,'ru','Sotec','Sotec - часы простые, но элегантные благодаря плетенному, стальному браслету и стеклу, элегантно окантовывающего корпус, что несомненно добавит акцент престижа к любому наряду. Эти часы также отображают дату и доступны зеленого, синего и белого цвета. Водостойкость до 50м.',NULL,NULL,NULL,NULL,'2011-09-06 17:49:53'),(19,'product',2,'ru','Simplex','Simplex это отличный выбор для людей ведущих активный образ жизни. Часы STORM с комфортным, силиконовым, браслетом, с функцией даты, стальным безелем и нанесенным на циферблат принтом. Часы брызгозащищенны и доступны в черном, голубом, белом и фиолетовом цвете.',NULL,NULL,NULL,NULL,'2011-09-06 17:50:26'),(20,'product',3,'ru','Bion','Bion это стильные мужские часы кожанным ремешком, с принтом под кожу крокодила и вторым часовым механизмом. Эти часы для стильных и уверенных в себе людей доступны в серебрянном / коричневом и черном / черном цветовом исполнении. Часы отображают дату и влагозащищенны до 50 м.',NULL,NULL,NULL,NULL,'2011-09-06 17:51:09'),(21,'product',4,'ru','Dualmec','Часы STORM Dualmec выпущенны лимитированной серией в количестве 3000 штук. Часы с двумя механизмами, для индикации времени другого часового пояса, с индикацией даты и необычным оформлением циферблата. Эти невероятные часы, выглядящие как произвение современного искусства, влагозащищены и доступны в серебрянном, черном и коричневом исполнении.',NULL,NULL,NULL,NULL,'2011-09-06 17:51:23'),(22,'product',5,'ru','Noxer','Мудрое решение для человека, следящего за модой и ведущего активный образ жизни. Часы Noxer это хронограф с функцией даты и влагозащищенностью до 50 м. Доступны в черном и стальном исполнении, а так же и с позолоченным и вороненым покрытием корпуса.',NULL,NULL,NULL,NULL,'2011-09-07 15:14:09'),(23,'product',6,'ru','MK 2 Circuit','MK 2 Circuit - Самые уникальные и необычные часы STORM с LED дисплеем (диодные часы). Индикация времени и даты. Часы доступны в различном цветовом исполнении. Инструкция на русском языке прилагается.',NULL,NULL,NULL,NULL,'2011-09-07 15:15:14'),(24,'product',7,'ru','Exar','Стильные мужские часы STORM EXAR выполнены в классическом, спортивном стиле, но при этом имеют яркие, стильные цвета. Доступны с белым, черным, голубым и оранжевым циферблатом. Влагозащищенность до 50 м.',NULL,NULL,NULL,NULL,'2011-09-07 15:15:32'),(25,'product',8,'ru','Darth','Специальный выпуск часов STORM. Часы Darth не оставят равнодушным никого, благодаря их необычному дизайну и дисковому механизму. Часы влагозащищены и доступны с черным, зеркальным, белым и фирменным, STORM, синим цветом дисплея',NULL,NULL,NULL,NULL,'2011-09-07 15:15:51');

/*Table structure for table `pages` */

DROP TABLE IF EXISTS `pages`;

CREATE TABLE `pages` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `parent_id` int(11) unsigned DEFAULT '0',
  `active` tinyint(1) DEFAULT '1',
  `sort` int(3) DEFAULT NULL,
  `slug` varchar(250) NOT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;

/*Data for the table `pages` */

insert  into `pages`(`id`,`parent_id`,`active`,`sort`,`slug`,`created`) values (1,0,1,1,'pages','2011-08-31 16:36:11'),(2,1,1,1,'news','2011-08-31 16:36:26'),(3,1,1,2,'as-seen-in','2011-08-31 16:36:45'),(4,1,1,3,'vintage','2011-08-31 16:36:58'),(5,1,1,4,'info-and-services','2011-08-31 16:37:16'),(6,1,1,5,'mailing-list','2011-08-31 16:37:48'),(7,1,1,6,'stocklist','2011-08-31 16:38:09'),(8,1,1,7,'about-storm','2011-08-31 16:38:19'),(9,1,1,8,'contact','2011-08-31 16:38:28'),(10,3,1,1,'as-seen-in/magazines','2011-09-01 14:48:30'),(11,3,1,2,'as-seen-in/celebs','2011-09-01 14:48:33'),(12,3,1,3,'as-seen-in/advertising','2011-09-01 14:48:36');

/*Table structure for table `product_nodes` */

DROP TABLE IF EXISTS `product_nodes`;

CREATE TABLE `product_nodes` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `product_id` int(11) unsigned NOT NULL,
  `active` tinyint(1) DEFAULT '1',
  `main` tinyint(1) DEFAULT '0',
  `new` tinyint(1) DEFAULT '0',
  `sale` tinyint(1) DEFAULT '0',
  `price` decimal(15,2) NOT NULL DEFAULT '0.00',
  `old_price` decimal(15,2) DEFAULT '0.00',
  `quantity` int(10) DEFAULT '0',
  `sort` int(3) DEFAULT NULL,
  `color` varchar(30) DEFAULT NULL,
  `size` varchar(30) DEFAULT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `product_nodes_product_id_fkey` (`product_id`),
  CONSTRAINT `product_nodes_product_id_fkey` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;

/*Data for the table `product_nodes` */

insert  into `product_nodes`(`id`,`product_id`,`active`,`main`,`new`,`sale`,`price`,`old_price`,`quantity`,`sort`,`color`,`size`,`created`) values (1,1,1,1,1,0,'120.00','0.00',3,1,'BLACK',NULL,'2011-09-06 17:18:18'),(2,1,1,0,0,1,'99.99','120.00',2,2,'GREEN',NULL,'2011-09-06 17:18:51'),(3,2,1,1,1,0,'34.00','0.00',4,1,'VIOLET',NULL,'2011-09-06 18:22:38'),(4,3,1,1,0,1,'130.00','0.00',0,1,'SILVER',NULL,'2011-09-06 18:22:47'),(5,4,1,1,1,1,'129.99','150.00',3,1,'BLACK',NULL,'2011-09-06 17:40:38'),(6,5,1,1,0,0,'45.00','0.00',3,1,'SILVER',NULL,'2011-09-07 15:19:24'),(7,6,1,1,1,0,'120.00','0.00',2,1,'BLACK',NULL,'2011-09-07 15:20:09'),(8,7,1,1,0,1,'78.99','86.00',5,1,'WHITE',NULL,'2011-09-07 15:19:29'),(9,7,1,0,0,0,'84.00','0.00',0,2,'BROWN',NULL,'2011-09-07 15:19:33'),(10,8,1,1,0,0,'95.00','0.00',1,1,'BLACK',NULL,'2011-09-07 15:19:22');

/*Table structure for table `products` */

DROP TABLE IF EXISTS `products`;

CREATE TABLE `products` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `category_id` int(11) unsigned NOT NULL,
  `active` tinyint(1) DEFAULT '1',
  `sort` int(3) DEFAULT NULL,
  `slug` varchar(250) DEFAULT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `products_category_id_fkey` (`category_id`),
  CONSTRAINT `products_category_id_fkey` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

/*Data for the table `products` */

insert  into `products`(`id`,`category_id`,`active`,`sort`,`slug`,`created`) values (1,5,1,1,'sotec','2011-09-06 17:17:13'),(2,5,1,2,'simplex','2011-09-06 17:17:31'),(3,5,1,3,'bion','2011-09-06 17:17:48'),(4,5,1,4,'dualmec','2011-09-06 17:40:09'),(5,5,1,5,'noxer','2011-09-07 15:12:17'),(6,5,1,6,'mk-2-circuit','2011-09-07 15:12:35'),(7,5,1,7,'exar','2011-09-07 15:12:46'),(8,5,1,8,'darth','2011-09-07 15:13:15');

/*Table structure for table `profiles` */

DROP TABLE IF EXISTS `profiles`;

CREATE TABLE `profiles` (
  `user_id` int(11) NOT NULL,
  `lastname` varchar(50) NOT NULL DEFAULT '',
  `firstname` varchar(50) NOT NULL DEFAULT '',
  `newsletters` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `profiles` */

insert  into `profiles`(`user_id`,`lastname`,`firstname`,`newsletters`) values (1,'Admin','Administrator',0),(2,'Demo','Demo',0),(3,'Romot','Oskar',0),(4,'sdfsdf','Adsdf',0),(5,'Testt','Test',0);

/*Table structure for table `profiles_fields` */

DROP TABLE IF EXISTS `profiles_fields`;

CREATE TABLE `profiles_fields` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `varname` varchar(50) NOT NULL,
  `title` varchar(255) NOT NULL,
  `field_type` varchar(50) NOT NULL,
  `field_size` int(3) NOT NULL DEFAULT '0',
  `field_size_min` int(3) NOT NULL DEFAULT '0',
  `required` int(1) NOT NULL DEFAULT '0',
  `match` varchar(255) NOT NULL DEFAULT '',
  `range` varchar(255) NOT NULL DEFAULT '',
  `error_message` varchar(255) NOT NULL DEFAULT '',
  `other_validator` varchar(5000) NOT NULL DEFAULT '',
  `default` varchar(255) NOT NULL DEFAULT '',
  `widget` varchar(255) NOT NULL DEFAULT '',
  `widgetparams` varchar(5000) NOT NULL DEFAULT '',
  `position` int(3) NOT NULL DEFAULT '0',
  `visible` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `varname` (`varname`,`widget`,`visible`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

/*Data for the table `profiles_fields` */

insert  into `profiles_fields`(`id`,`varname`,`title`,`field_type`,`field_size`,`field_size_min`,`required`,`match`,`range`,`error_message`,`other_validator`,`default`,`widget`,`widgetparams`,`position`,`visible`) values (1,'lastname','Last Name','VARCHAR',50,3,1,'','','Incorrect Last Name (length between 3 and 50 characters).','','','','',1,3),(2,'firstname','First Name','VARCHAR',50,3,1,'','','Incorrect First Name (length between 3 and 50 characters).','','','','',0,3),(3,'newsletters','Newsletters','BOOL',0,0,0,'','1==Да;0==Нет','','','','','',0,3);

/*Table structure for table `users` */

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(20) NOT NULL,
  `password` varchar(128) NOT NULL,
  `email` varchar(128) NOT NULL,
  `activkey` varchar(128) NOT NULL DEFAULT '',
  `createtime` int(10) NOT NULL DEFAULT '0',
  `lastvisit` int(10) NOT NULL DEFAULT '0',
  `superuser` int(1) NOT NULL DEFAULT '0',
  `status` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`),
  KEY `status` (`status`),
  KEY `superuser` (`superuser`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

/*Data for the table `users` */

insert  into `users`(`id`,`username`,`password`,`email`,`activkey`,`createtime`,`lastvisit`,`superuser`,`status`) values (1,'admin','21232f297a57a5a743894a0e4a801fc3','webmaster@example.com','9a24eff8c15a6a141ece27eb6947da0f',1261146094,1314794576,1,1),(2,'demo','fe01ce2a7fbac8fafaed7c982a04e229','demo@example.com','099f825543f7850cc038b90aaff39fac',1261146096,0,0,1),(3,'oskar','d8578edf8458ce06fbc5bb76a58c5ca4','oskar@roboti.lv','fa2b6ef0d0e405f65fd696277984fb3c',1315498304,0,0,1),(4,'test','098f6bcd4621d373cade4e832627b4f6','test@test.com','a5f45d0a66bf735565970c3093bf110a',1315507420,0,0,0),(5,'testing','098f6bcd4621d373cade4e832627b4f6','testtttt@ufufu.com','f5ca15ac6b7009d4d496fa57c782c757',1315507473,1315507491,0,1);

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
