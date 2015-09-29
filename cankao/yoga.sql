-- MySQL dump 10.13  Distrib 5.5.35, for debian-linux-gnu (x86_64)
--
-- Host: 218.244.137.165    Database: yoga
-- ------------------------------------------------------
-- Server version	5.6.19-log

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `tbl_user`
--

DROP TABLE IF EXISTS `tbl_user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(128) NOT NULL,
  `password` varchar(128) NOT NULL,
  `email` varchar(128) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_user`
--

LOCK TABLES `tbl_user` WRITE;
/*!40000 ALTER TABLE `tbl_user` DISABLE KEYS */;
INSERT INTO `tbl_user` VALUES (2,'test22','pass2','test2@example.com'),(3,'test3','pass3','test3@example.com'),(4,'test4','pass4','test4@example.com'),(5,'test5','pass5','test5@example.com'),(6,'test6','pass6','test6@example.com'),(7,'test7','pass7','test7@example.com'),(8,'test8','pass8','test8@example.com'),(9,'test9','pass9','test9@example.com'),(10,'test10','pass10','test10@example.com'),(11,'test11','pass11','test11@example.com'),(12,'test12','pass12','test12@example.com'),(13,'test13','pass13','test13@example.com'),(14,'test14','pass14','test14@example.com'),(15,'test15','pass15','test15@example.com'),(16,'test16','pass16','test16@example.com'),(17,'test17','pass17','test17@example.com'),(18,'test18','pass18','test18@example.com'),(19,'test19','pass19','test19@example.com'),(20,'test20','pass20','test20@example.com'),(21,'test21','pass21','test21@example.com'),(22,'libo','111111','libo@163.com');
/*!40000 ALTER TABLE `tbl_user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `yoga_auth_group`
--

DROP TABLE IF EXISTS `yoga_auth_group`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `yoga_auth_group` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT COMMENT '用户组id,自增主键',
  `module` varchar(20) NOT NULL COMMENT '用户组所属模块',
  `type` tinyint(4) NOT NULL COMMENT '组类型',
  `title` char(20) NOT NULL DEFAULT '' COMMENT '用户组中文名称',
  `description` varchar(80) NOT NULL DEFAULT '' COMMENT '描述信息',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '用户组状态：为1正常，为0禁用,-1为删除',
  `rules` varchar(500) NOT NULL DEFAULT '' COMMENT '用户组拥有的规则id，多个规则 , 隔开',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `yoga_auth_group`
--

LOCK TABLES `yoga_auth_group` WRITE;
/*!40000 ALTER TABLE `yoga_auth_group` DISABLE KEYS */;
INSERT INTO `yoga_auth_group` VALUES (2,'Bar',2,'水吧','Bar Group',1,'2'),(3,'Brand',2,'品牌管理','Brand Group',1,'1'),(4,'Cashier',2,'收银','Cashier Group',1,'3'),(5,'Finance',2,'财务','Finance Group',1,'4'),(6,'Mc',2,'MC','Mc Group',1,'5'),(7,'Mcmanager',2,'MC经理','Mcmanager Group',1,'6'),(8,'Pt',2,'PT','Pt Group',1,'7'),(9,'Ptmanager',2,'PT经理','Ptmanager Group',1,'8'),(10,'Reception',2,'前台','Reception Group',1,'9'),(11,'Shopkeeper',2,'店长','Shopkeeper Group',1,'10'),(17,'Channelmanager',2,'渠道经理','Channelmanager gropu',1,'12'),(18,'Channel',2,'渠道','Channel gropu',1,'11');
/*!40000 ALTER TABLE `yoga_auth_group` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `yoga_auth_group_access`
--

DROP TABLE IF EXISTS `yoga_auth_group_access`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `yoga_auth_group_access` (
  `uid` int(10) unsigned NOT NULL COMMENT '用户id',
  `group_id` mediumint(8) unsigned NOT NULL COMMENT '用户组id',
  UNIQUE KEY `uid_group_id` (`uid`,`group_id`),
  KEY `uid` (`uid`),
  KEY `group_id` (`group_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `yoga_auth_group_access`
--

LOCK TABLES `yoga_auth_group_access` WRITE;
/*!40000 ALTER TABLE `yoga_auth_group_access` DISABLE KEYS */;
INSERT INTO `yoga_auth_group_access` VALUES (38,2),(44,2),(45,2),(53,2),(70,2),(91,2),(24,3),(25,3),(32,3),(38,3),(44,3),(45,3),(53,3),(70,3),(38,4),(45,4),(53,4),(70,4),(82,4),(91,4),(32,5),(38,5),(44,5),(45,5),(53,5),(70,5),(91,5),(38,6),(45,6),(46,6),(51,6),(52,6),(53,6),(58,6),(68,6),(70,6),(75,6),(77,6),(78,6),(79,6),(80,6),(81,6),(91,6),(38,7),(45,7),(52,7),(53,7),(67,7),(70,7),(84,7),(85,7),(91,7),(38,8),(45,8),(53,8),(58,8),(70,8),(91,8),(38,9),(45,9),(53,9),(70,9),(91,9),(38,10),(44,10),(45,10),(53,10),(70,10),(76,10),(83,10),(91,10),(24,11),(25,11),(32,11),(38,11),(44,11),(45,11),(53,11),(67,11),(70,11),(84,11),(85,11),(91,11),(38,17),(45,17),(51,17),(53,17),(69,17),(70,17),(87,17),(90,17),(91,17),(38,18),(45,18),(51,18),(53,18),(70,18),(72,18),(86,18),(89,18),(91,18),(92,18),(93,18),(94,18);
/*!40000 ALTER TABLE `yoga_auth_group_access` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `yoga_auth_rule`
--

DROP TABLE IF EXISTS `yoga_auth_rule`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `yoga_auth_rule` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT COMMENT '规则id,自增主键',
  `module` varchar(20) NOT NULL COMMENT '规则所属module',
  `type` tinyint(2) NOT NULL DEFAULT '1' COMMENT '1-url;2-主菜单',
  `name` char(80) NOT NULL DEFAULT '' COMMENT '规则唯一英文标识',
  `title` char(20) NOT NULL DEFAULT '' COMMENT '规则中文描述',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '是否有效(0:无效,1:有效)',
  `condition` varchar(300) NOT NULL DEFAULT '' COMMENT '规则附加条件',
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`module`,`name`,`type`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `yoga_auth_rule`
--

LOCK TABLES `yoga_auth_rule` WRITE;
/*!40000 ALTER TABLE `yoga_auth_rule` DISABLE KEYS */;
INSERT INTO `yoga_auth_rule` VALUES (1,'Brand',2,'Brand','Brand index',1,''),(2,'Bar',2,'Bar','Bar',1,''),(3,'Cashier',2,'Cashier','Cashier',1,''),(4,'Finance',2,'Finance','Finance',1,''),(5,'Mc',2,'Mc','Mc',1,''),(6,'Mcmanager',2,'Mcmanager','Mcmanager',1,''),(7,'Pt',2,'Pt','Pt',1,''),(8,'Ptmanager',2,'Ptmanager','Ptmanager',1,''),(9,'Reception',2,'Reception','Reception',1,''),(10,'Shopkeeper',2,'Shopkeeper','Shopkeeper',1,''),(11,'Channel',2,'Channel','Channel',1,''),(12,'Channelmanager',2,'Channelmanager','Channelmanager',1,'');
/*!40000 ALTER TABLE `yoga_auth_rule` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `yoga_brand`
--

DROP TABLE IF EXISTS `yoga_brand`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `yoga_brand` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `create_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `last_login_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `last_login_ip` varchar(255) NOT NULL DEFAULT '',
  `contact_name` varchar(255) NOT NULL DEFAULT '',
  `email` varchar(255) NOT NULL DEFAULT '',
  `phone` varchar(255) NOT NULL DEFAULT '',
  `status` tinyint(4) NOT NULL DEFAULT '1',
  `desc` varchar(255) NOT NULL DEFAULT '',
  `brand_name` varchar(255) NOT NULL DEFAULT '',
  `roles` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  UNIQUE KEY `uniq_username` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=46 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `yoga_brand`
--

LOCK TABLES `yoga_brand` WRITE;
/*!40000 ALTER TABLE `yoga_brand` DISABLE KEYS */;
INSERT INTO `yoga_brand` VALUES (34,'brand1','c78b6663d47cfbdb4d65ea51c104044e','2014-08-25 07:01:15','0000-00-00 00:00:00','','11111','peterleelibo@163.com','13111111111',1,'','Brand1','[\"shopkeeper\",\"finance\",\"reception\",\"bar\",\"cashier\",\"mcmanager\",\"mc\",\"ptmanager\",\"pt\",\"channelmanager\",\"channel\",\"Brand\"]'),(35,'rajayoga','c78b6663d47cfbdb4d65ea51c104044e','2014-08-31 11:16:12','0000-00-00 00:00:00','','trumandu','7465144@qq.com','18321383230',1,'','Raja Yoga','[\"shopkeeper\",\"finance\",\"reception\",\"bar\",\"cashier\",\"mcmanager\",\"mc\",\"ptmanager\",\"pt\",\"channelmanager\",\"channel\",\"Brand\"]'),(44,'jordan.shu','7719ef5b8eecb5afbfdcda8458b6ce0b','2014-09-03 06:17:33','0000-00-00 00:00:00','','jordan','jordan.shu@rajayoga.com.cn','13162220453',1,'这是个很大的会所','Yoga  Retreat','[\"shopkeeper\",\"finance\",\"reception\",\"bar\",\"cashier\",\"mcmanager\",\"mc\",\"ptmanager\",\"pt\",\"channelmanager\",\"channel\",\"Brand\"]'),(45,'jordan','7719ef5b8eecb5afbfdcda8458b6ce0b','2014-09-03 06:56:16','0000-00-00 00:00:00','','123','jordan.shu@rajayoga.com.cn','2345',1,'wer','brand2','[\"Brand\"]');
/*!40000 ALTER TABLE `yoga_brand` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `yoga_brand_config`
--

DROP TABLE IF EXISTS `yoga_brand_config`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `yoga_brand_config` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `member_trans_price` double NOT NULL DEFAULT '0',
  `member_upgrade_price` double NOT NULL DEFAULT '0',
  `member_fillcard_price` double NOT NULL DEFAULT '0',
  `member_payment_deadline` double NOT NULL DEFAULT '0',
  `brand_id` bigint(20) NOT NULL DEFAULT '0',
  `start_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `update_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  UNIQUE KEY `uniq_brand_id` (`brand_id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `yoga_brand_config`
--

LOCK TABLES `yoga_brand_config` WRITE;
/*!40000 ALTER TABLE `yoga_brand_config` DISABLE KEYS */;
INSERT INTO `yoga_brand_config` VALUES (12,13,121,132,151,34,'2014-08-22 06:24:24','2014-08-22 06:27:12');
/*!40000 ALTER TABLE `yoga_brand_config` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `yoga_card`
--

DROP TABLE IF EXISTS `yoga_card`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `yoga_card` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `member_id` bigint(20) NOT NULL,
  `create_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `update_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '0-normal  1-lost 2-new 3-resting 4-destroy',
  `card_number` varchar(32) NOT NULL DEFAULT '',
  `brand_id` bigint(20) NOT NULL DEFAULT '0',
  `is_active` tinyint(4) NOT NULL DEFAULT '1',
  `extension` varchar(3000) NOT NULL DEFAULT '',
  `recharge` double NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `uniq_card_number` (`brand_id`,`card_number`)
) ENGINE=InnoDB AUTO_INCREMENT=97 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `yoga_card`
--

LOCK TABLES `yoga_card` WRITE;
/*!40000 ALTER TABLE `yoga_card` DISABLE KEYS */;
INSERT INTO `yoga_card` VALUES (73,62,'2014-08-29 13:25:34','2014-08-29 13:25:34',0,'111111111111',34,1,'',0),(74,63,'2014-08-29 13:26:55','2014-08-29 13:26:55',3,'2c',34,1,'{\"start_time\":\"2014-09-01\",\"end_time\":\"2014-09-06\"}',100),(80,65,'2014-09-04 16:35:56','2014-09-04 16:35:56',0,'1234321',34,0,'',0),(81,66,'2014-09-08 08:29:38','2014-09-08 08:29:38',0,'123333',34,1,'',0),(82,89,'2014-09-12 03:11:58','2014-09-12 03:11:58',0,'asd',44,1,'',0),(83,89,'2014-09-12 08:33:42','2014-09-12 08:33:42',0,'201409121633426066',44,1,'',0),(84,89,'2014-09-12 08:35:48','2014-09-12 08:35:48',0,'20140912163548627',44,1,'',0),(85,65,'2014-09-13 14:21:49','2014-09-13 14:21:49',0,'201409132221493829',34,1,'',0),(86,65,'2014-09-13 14:21:54','2014-09-13 14:21:54',0,'201409132221548643',34,1,'',0),(87,65,'2014-09-13 14:22:08','2014-09-13 14:22:08',0,'201409132222088496',34,1,'',0),(88,65,'2014-09-13 14:22:09','2014-09-13 14:22:09',0,'201409132222099371',34,1,'',0),(89,65,'2014-09-13 14:22:36','2014-09-13 14:22:36',0,'201409132222363379',34,1,'',0),(90,65,'2014-09-13 14:22:56','2014-09-13 14:22:56',0,'201409132222565970',34,1,'',0),(91,65,'2014-09-13 14:25:20','2014-09-13 14:25:20',0,'201409132225204646',34,1,'',0),(92,65,'2014-09-13 14:28:24','2014-09-13 14:28:24',0,'201409132228246500',34,1,'',0),(93,65,'2014-09-13 14:28:52','2014-09-13 14:28:52',0,'20140913222852387',34,1,'',0),(94,65,'2014-09-13 14:35:02','2014-09-13 14:35:02',0,'201409132235021348',34,1,'',0),(95,65,'2014-09-13 15:43:24','2014-09-13 15:43:24',0,'201409132343246634',34,1,'',0),(96,68,'2014-09-13 17:20:01','2014-09-13 17:20:01',0,'96',34,1,'',0);
/*!40000 ALTER TABLE `yoga_card` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `yoga_card_op_history`
--

DROP TABLE IF EXISTS `yoga_card_op_history`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `yoga_card_op_history` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `card_id` bigint(20) NOT NULL,
  `record_id` bigint(20) NOT NULL,
  `card_status` tinyint(4) NOT NULL DEFAULT '0',
  `create_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `status_before` tinyint(4) NOT NULL DEFAULT '0',
  `extension` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  KEY `idx_card_id` (`card_id`)
) ENGINE=InnoDB AUTO_INCREMENT=75 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `yoga_card_op_history`
--

LOCK TABLES `yoga_card_op_history` WRITE;
/*!40000 ALTER TABLE `yoga_card_op_history` DISABLE KEYS */;
INSERT INTO `yoga_card_op_history` VALUES (50,45,45,1,'2014-08-26 07:53:50',0,''),(51,45,45,0,'2014-08-26 07:54:03',1,''),(52,45,45,2,'2014-08-26 08:02:24',0,'50'),(53,50,45,3,'2014-08-26 09:07:58',0,'{\"start_time\":\"2014-08-27\",\"end_date\":\"2014-08-28\"}'),(54,44,45,3,'2014-08-26 09:13:42',0,'{\"start_time\":\"2014-08-27\",\"end_date\":\"2014-08-30\"}'),(55,43,45,3,'2014-08-26 09:14:21',0,'{\"start_time\":\"2014-08-27\",\"end_date\":\"2014-08-30\"}'),(56,42,45,3,'2014-08-26 09:16:10',0,'{\"start_time\":\"2014-08-27\",\"end_date\":\"2014-08-30\"}'),(57,42,45,0,'2014-08-26 09:16:25',3,''),(58,43,45,0,'2014-08-26 09:17:41',3,''),(59,50,45,0,'2014-08-26 10:17:16',3,''),(60,44,45,0,'2014-08-26 10:20:52',3,''),(61,50,45,3,'2014-08-26 10:21:11',0,'{\"start_time\":\"2014-08-28\",\"end_time\":\"2014-08-29\"}'),(62,50,45,0,'2014-08-26 10:21:16',3,''),(63,53,45,1,'2014-08-27 09:53:23',0,''),(64,53,45,0,'2014-08-27 09:53:29',1,''),(65,53,45,2,'2014-08-27 09:53:33',0,'0'),(66,52,45,2,'2014-08-27 10:05:54',0,'55'),(67,55,45,2,'2014-08-27 10:07:21',0,'56'),(68,56,45,2,'2014-08-27 10:07:33',0,'0'),(69,74,45,1,'2014-08-31 01:57:13',0,''),(70,74,45,0,'2014-08-31 01:57:31',1,''),(71,74,45,3,'2014-08-31 02:20:19',0,'{\"start_time\":\"2014-09-01\",\"end_time\":\"2014-09-06\"}'),(72,74,45,3,'2014-08-31 02:22:15',0,'{\"start_time\":\"2014-09-01\",\"end_time\":\"2014-09-06\"}'),(73,74,45,3,'2014-08-31 02:23:48',0,'{\"start_time\":\"2014-09-01\",\"end_time\":\"2014-09-06\"}'),(74,74,45,0,'2014-08-31 02:27:58',3,'');
/*!40000 ALTER TABLE `yoga_card_op_history` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `yoga_card_saleclub`
--

DROP TABLE IF EXISTS `yoga_card_saleclub`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `yoga_card_saleclub` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `card_type_id` bigint(20) NOT NULL,
  `club_id` bigint(20) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_club_id` (`club_id`),
  KEY `idx_card_id` (`card_type_id`)
) ENGINE=InnoDB AUTO_INCREMENT=273 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `yoga_card_saleclub`
--

LOCK TABLES `yoga_card_saleclub` WRITE;
/*!40000 ALTER TABLE `yoga_card_saleclub` DISABLE KEYS */;
INSERT INTO `yoga_card_saleclub` VALUES (144,23,79),(145,23,80),(146,23,89),(147,23,90),(148,23,91),(149,23,93),(150,23,95),(151,23,107),(152,23,108),(153,23,109),(154,23,110),(155,23,111),(156,23,112),(157,23,113),(158,23,114),(222,22,79),(223,22,80),(224,22,89),(225,22,90),(226,22,91),(227,22,93),(228,22,95),(229,22,107),(230,22,108),(231,22,109),(232,22,110),(233,22,111),(234,22,112),(235,22,113),(236,22,114),(237,25,79),(238,25,80),(239,25,89),(240,25,90),(241,25,91),(242,25,93),(243,25,95),(244,25,107),(245,25,108),(246,25,109),(247,25,110),(248,25,111),(249,25,112),(250,25,113),(251,25,114),(252,24,79),(253,26,79),(254,26,80),(255,26,89),(256,26,90),(257,26,91),(258,26,93),(259,26,95),(260,26,107),(261,26,108),(262,26,109),(263,26,110),(264,26,111),(265,26,112),(266,26,113),(267,26,114),(268,26,115),(269,26,116),(270,26,117),(271,26,118),(272,27,122);
/*!40000 ALTER TABLE `yoga_card_saleclub` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `yoga_card_type`
--

DROP TABLE IF EXISTS `yoga_card_type`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `yoga_card_type` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `category` int(20) NOT NULL COMMENT '1个人卡，2家庭卡，3主副卡，4VIP卡，5不记名卡,6team cared',
  `type` tinyint(4) NOT NULL DEFAULT '0' COMMENT '1-time 2-number',
  `valid_time` int(11) NOT NULL DEFAULT '12',
  `brand_id` bigint(20) NOT NULL,
  `description` text NOT NULL,
  `start_time` date NOT NULL,
  `end_time` date NOT NULL,
  `price` double NOT NULL DEFAULT '0',
  `create_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `update_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `peak_time` varchar(255) NOT NULL DEFAULT '',
  `sold_num` int(11) NOT NULL DEFAULT '0',
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `price_buy` double NOT NULL DEFAULT '0',
  `max_present_num` int(11) NOT NULL DEFAULT '0',
  `free_pt_id` varchar(255) NOT NULL DEFAULT '',
  `free_pt_number` int(11) NOT NULL DEFAULT '0',
  `valid_number` int(11) NOT NULL DEFAULT '50',
  `max_present_day` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `idx_brand_id` (`brand_id`)
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `yoga_card_type`
--

LOCK TABLES `yoga_card_type` WRITE;
/*!40000 ALTER TABLE `yoga_card_type` DISABLE KEYS */;
INSERT INTO `yoga_card_type` VALUES (17,'test1222',3,2,11,34,'xxxx\n','2014-01-01','2014-12-10',1122,'0000-00-00 00:00:00','2014-08-27 07:41:22','8',0,0,0,1,'',0,50,0),(22,'次数卡--2',2,2,12,34,'xxxx','2014-01-01','2014-12-25',2000,'2014-06-24 08:54:01','2014-08-28 16:04:48','9',0,1,0,1,'',0,60,2),(23,'时间卡--1',6,1,50,34,'xxx','2014-06-01','2014-12-31',321,'2014-06-24 09:56:02','2014-08-28 06:13:50','8',0,1,0,10,'',0,51,10),(24,'次数卡--1',1,2,10,34,'第三方','2014-08-01','2014-08-31',123,'2014-08-27 07:33:57','2014-08-31 09:13:52','',0,1,0,10,'',0,50,1),(25,'便宜的次数卡',1,2,12,34,'1','2014-04-01','2015-03-25',11111,'2014-08-28 15:36:40','2014-08-28 17:08:20','',0,1,0,1,'',0,1,1),(26,'XXXXX',6,2,111,34,'','2014-08-03','2014-10-29',111,'2014-08-31 13:28:26','2014-08-31 13:28:27','9,11',0,1,0,12,'',0,31,12),(27,'月卡',1,1,1,44,'月卡好','2014-09-12','2015-07-30',1800,'2014-09-12 02:45:09','2014-09-12 02:45:09','',0,1,0,2,'',0,0,3);
/*!40000 ALTER TABLE `yoga_card_type` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `yoga_card_useclub`
--

DROP TABLE IF EXISTS `yoga_card_useclub`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `yoga_card_useclub` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `card_type_id` bigint(20) NOT NULL,
  `club_id` bigint(20) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_club_id` (`club_id`),
  KEY `idx_card_id` (`card_type_id`)
) ENGINE=InnoDB AUTO_INCREMENT=290 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `yoga_card_useclub`
--

LOCK TABLES `yoga_card_useclub` WRITE;
/*!40000 ALTER TABLE `yoga_card_useclub` DISABLE KEYS */;
INSERT INTO `yoga_card_useclub` VALUES (161,23,79),(162,23,80),(163,23,89),(164,23,90),(165,23,91),(166,23,93),(167,23,95),(168,23,107),(169,23,108),(170,23,109),(171,23,110),(172,23,111),(173,23,112),(174,23,113),(175,23,114),(239,22,79),(240,22,80),(241,22,89),(242,22,90),(243,22,91),(244,22,93),(245,22,95),(246,22,107),(247,22,108),(248,22,109),(249,22,110),(250,22,111),(251,22,112),(252,22,113),(253,22,114),(254,25,79),(255,25,80),(256,25,89),(257,25,90),(258,25,91),(259,25,93),(260,25,95),(261,25,107),(262,25,108),(263,25,109),(264,25,110),(265,25,111),(266,25,112),(267,25,113),(268,25,114),(269,24,80),(270,26,79),(271,26,80),(272,26,89),(273,26,90),(274,26,91),(275,26,93),(276,26,95),(277,26,107),(278,26,108),(279,26,109),(280,26,110),(281,26,111),(282,26,112),(283,26,113),(284,26,114),(285,26,115),(286,26,116),(287,26,117),(288,26,118),(289,27,122);
/*!40000 ALTER TABLE `yoga_card_useclub` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `yoga_cash_history`
--

DROP TABLE IF EXISTS `yoga_cash_history`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `yoga_cash_history` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `record_id` bigint(20) NOT NULL,
  `create_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `price` double NOT NULL DEFAULT '0',
  `brand_id` bigint(20) NOT NULL,
  `description` text NOT NULL,
  `contract_id` bigint(20) NOT NULL,
  `update_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `cash` double NOT NULL DEFAULT '0',
  `pos` double NOT NULL DEFAULT '0',
  `check` double NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `idx_brand_id` (`brand_id`),
  KEY `idx_contract_id` (`contract_id`)
) ENGINE=InnoDB AUTO_INCREMENT=85 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `yoga_cash_history`
--

LOCK TABLES `yoga_cash_history` WRITE;
/*!40000 ALTER TABLE `yoga_cash_history` DISABLE KEYS */;
INSERT INTO `yoga_cash_history` VALUES (41,0,'2014-08-24 16:33:37',102,0,'',41,'0000-00-00 00:00:00',0,0,0),(42,45,'2014-08-24 16:36:58',1013,34,'',42,'0000-00-00 00:00:00',0,0,0),(43,45,'2014-08-24 16:37:56',1003,34,'',43,'0000-00-00 00:00:00',0,0,0),(44,45,'2014-08-25 06:11:33',33,34,'',44,'0000-00-00 00:00:00',0,0,0),(45,45,'2014-08-25 06:13:36',99,34,'',45,'0000-00-00 00:00:00',0,0,0),(46,45,'2014-08-25 08:52:31',102,34,'',46,'0000-00-00 00:00:00',0,0,0),(47,45,'2014-08-25 08:56:15',3,34,'',47,'0000-00-00 00:00:00',0,0,0),(48,45,'2014-08-25 15:03:46',0,34,'',48,'0000-00-00 00:00:00',0,0,0),(49,45,'2014-08-25 16:11:58',0,34,'',49,'0000-00-00 00:00:00',0,0,0),(50,45,'2014-08-27 09:45:18',6,34,'',50,'0000-00-00 00:00:00',0,0,0),(51,45,'2014-08-27 09:49:09',100,34,'',51,'0000-00-00 00:00:00',0,0,0),(52,45,'2014-08-27 09:51:28',0,34,'',52,'0000-00-00 00:00:00',0,0,0),(53,45,'2014-08-27 10:13:03',0,34,'',53,'0000-00-00 00:00:00',0,0,0),(54,45,'2014-08-27 10:13:32',0,34,'',54,'0000-00-00 00:00:00',0,0,0),(55,45,'2014-08-28 09:06:29',0,34,'',55,'0000-00-00 00:00:00',0,0,0),(56,45,'2014-08-28 09:07:10',103,34,'',56,'0000-00-00 00:00:00',0,0,0),(57,45,'2014-08-28 09:14:51',100,34,'',57,'0000-00-00 00:00:00',0,0,0),(58,45,'2014-08-28 17:04:00',105,34,'',66,'0000-00-00 00:00:00',0,0,0),(59,45,'2014-08-28 17:08:45',6,34,'',67,'0000-00-00 00:00:00',0,0,0),(60,45,'2014-08-28 17:58:26',104,34,'',58,'0000-00-00 00:00:00',0,0,0),(61,45,'2014-08-29 08:03:03',0,34,'',59,'0000-00-00 00:00:00',0,0,0),(62,45,'2014-08-29 08:48:46',0,34,'',60,'0000-00-00 00:00:00',0,0,0),(63,45,'2014-08-29 08:51:10',0,34,'',61,'0000-00-00 00:00:00',0,0,0),(64,45,'2014-08-29 08:52:03',0,34,'',62,'0000-00-00 00:00:00',0,0,0),(65,45,'2014-08-29 13:25:34',1,34,'',63,'0000-00-00 00:00:00',0,0,0),(66,45,'2014-08-29 13:26:55',1,34,'',64,'0000-00-00 00:00:00',0,0,0),(67,45,'2014-08-29 14:25:08',23,34,'',65,'0000-00-00 00:00:00',0,0,0),(68,45,'2014-08-31 00:46:20',1,34,'',0,'0000-00-00 00:00:00',0,0,0),(69,45,'2014-08-31 00:47:53',0,34,'',0,'0000-00-00 00:00:00',0,0,0),(70,45,'2014-08-31 01:03:23',1,34,'',0,'0000-00-00 00:00:00',0,0,0),(71,45,'2014-08-31 01:05:56',0,34,'',72,'0000-00-00 00:00:00',0,0,0),(72,45,'2014-08-31 03:33:18',11,34,'',64,'0000-00-00 00:00:00',0,0,0),(73,45,'2014-08-31 03:33:32',21,34,'',64,'0000-00-00 00:00:00',0,0,0),(74,45,'2014-08-31 03:34:59',31,34,'',64,'0000-00-00 00:00:00',0,0,0),(75,45,'2014-08-31 03:35:16',41,34,'',64,'0000-00-00 00:00:00',0,0,0),(76,45,'2014-08-31 03:39:28',51,34,'',64,'0000-00-00 00:00:00',0,0,0),(77,45,'2014-08-31 03:39:44',61,34,'',64,'0000-00-00 00:00:00',0,0,0),(78,45,'2014-08-31 03:39:49',71,34,'',64,'0000-00-00 00:00:00',0,0,0),(79,45,'2014-08-31 03:40:02',72,34,'',64,'0000-00-00 00:00:00',0,0,0),(80,45,'2014-08-31 04:20:57',6,34,'',72,'0000-00-00 00:00:00',1,2,3),(81,45,'2014-08-31 04:21:05',15,34,'',72,'0000-00-00 00:00:00',2,3,4),(82,82,'2014-09-12 03:11:58',0,44,'',76,'0000-00-00 00:00:00',1800,0,0),(83,82,'2014-09-12 08:33:42',0,44,'',77,'0000-00-00 00:00:00',1800,0,0),(84,82,'2014-09-12 08:35:48',0,44,'',78,'0000-00-00 00:00:00',1800,0,0);
/*!40000 ALTER TABLE `yoga_cash_history` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `yoga_channel`
--

DROP TABLE IF EXISTS `yoga_channel`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `yoga_channel` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `level` bigint(20) NOT NULL DEFAULT '0',
  `create_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `update_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `brand_id` bigint(20) NOT NULL,
  `description` text NOT NULL,
  `contact_name` varchar(255) NOT NULL DEFAULT '',
  `contact_phone` varchar(20) NOT NULL DEFAULT '',
  `user_id` bigint(20) NOT NULL DEFAULT '0',
  `club_id` bigint(20) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `idx_brand_id` (`brand_id`),
  KEY `idx_user_id` (`user_id`),
  KEY `idx_club_id` (`club_id`)
) ENGINE=InnoDB AUTO_INCREMENT=55 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `yoga_channel`
--

LOCK TABLES `yoga_channel` WRITE;
/*!40000 ALTER TABLE `yoga_channel` DISABLE KEYS */;
INSERT INTO `yoga_channel` VALUES (13,'123321',2,'2014-06-23 02:29:42','2014-09-02 07:29:00',34,'xasdf','12312312','111111111',51,79),(14,'设计大奖',1,'2014-06-23 04:08:34','2014-09-02 07:28:59',34,'电脑都觉得那些脑残呢处女处女处女呢的奶茶奶茶奶茶奶茶奶茶奶茶','新疆细菌学家','zjzjzq',51,79),(15,'TEST3',3,'2014-06-23 20:01:45','2014-09-02 07:28:57',34,'123','XX','OO',51,79),(16,'Coffee',4,'2014-08-27 05:45:32','2014-09-02 07:28:55',34,'xxxxxxxxx','xx','14111',45,79),(17,'Resturant',2,'2014-08-27 05:46:03','2014-09-02 07:28:39',34,'123321','111','313131',45,79),(18,'A',1,'2014-09-02 07:27:49','2014-09-02 07:27:49',34,'','XXX','131',51,79),(24,'abcdefg',1,'2014-09-03 12:46:11','2014-09-03 12:46:12',34,'xxx','123','321',51,79),(25,'WI(店访）',1,'2014-09-03 13:00:10','2014-09-15 03:55:19',35,'','店长','64274398',73,0),(26,'TI（电询）',1,'2014-09-03 13:00:43','2014-09-15 03:55:14',35,'','店长','64274398',73,0),(27,'外场派发',1,'2014-09-03 13:01:21','2014-09-15 03:55:10',35,'','店长','64274398',74,0),(28,'BR（转介）',1,'2014-09-03 13:01:44','2014-09-15 03:55:05',35,'','店长','64274398',74,0),(30,'团购',1,'2014-09-03 13:06:53','2014-09-15 03:55:00',35,'','Soumns','12312312312',72,0),(31,'网络咨询',1,'2014-09-15 02:49:58','2014-09-15 04:25:14',35,'','soumns','12312312312',0,0),(33,'WI（店访）',1,'2014-09-15 14:52:02','2014-09-15 15:13:56',35,'','店长','02164274398',92,119),(34,'TI（电询）',1,'2014-09-15 14:52:22','2014-09-15 15:13:56',35,'','店长','02164274398',92,119),(35,'网络咨询',1,'2014-09-15 14:53:18','2014-09-15 14:54:42',35,'','市场专员','02164274398',72,119),(36,'团购',1,'2014-09-15 14:53:48','2014-09-15 15:13:57',35,'','市场专员','02164274398',72,119),(37,'外场',1,'2014-09-15 14:54:33','2014-09-15 15:13:58',35,'','店长','02164274398',92,119),(38,'陌CALL',1,'2014-09-15 14:55:26','2014-09-15 15:13:59',35,'','店长','02164274398',92,119),(39,'BR（转介）',1,'2014-09-15 14:56:06','2014-09-15 15:13:31',35,'','店长','02164274398',92,119),(40,'礼品名单',1,'2014-09-15 14:57:25','2014-09-15 15:14:00',35,'','市场专员','02164274398',72,119),(41,'万达WI（店访）',1,'2014-09-15 15:15:05','2014-09-15 15:15:05',35,'','店长','02164274398',93,120),(42,'万达TI（电询）',1,'2014-09-16 11:37:16','2014-09-16 11:37:16',35,'','店长','02164274398',93,120),(43,'万达BR（转介）',1,'2014-09-16 11:37:46','2014-09-16 11:37:45',35,'','店长','02164274398',93,120),(44,'万达外场派单',1,'2014-09-16 11:38:17','2014-09-16 11:38:17',35,'','店长','02164274398',93,120),(45,'万达网络咨询',1,'2014-09-16 11:38:36','2014-09-16 11:38:36',35,'','市场专员','02164274398',86,120),(46,'万达团购',1,'2014-09-16 11:38:55','2014-09-16 11:38:55',35,'','市场专员','02164274398',86,120),(47,'万达礼品领取',1,'2014-09-16 11:39:15','2014-09-16 11:39:15',35,'','市场专员','02164274398',86,120),(48,'万里外场派单',1,'2014-09-16 11:40:08','2014-09-16 11:40:08',35,'','店长','02164274398',94,121),(49,'万里WI（店访）',1,'2014-09-16 11:40:41','2014-09-16 11:40:41',35,'','店长','02164274398',94,121),(50,'万里TI（电询）',1,'2014-09-16 11:41:08','2014-09-16 11:41:08',35,'','店长','02164274398',94,121),(51,'万里BR（转介）',1,'2014-09-16 11:41:59','2014-09-16 11:41:59',35,'','店长','02164274398',94,121),(52,'万里网络咨询',1,'2014-09-16 11:42:26','2014-09-16 11:43:20',35,'','市场专员','02164274398',89,121),(53,'万里团购',1,'2014-09-16 11:42:42','2014-09-16 11:42:42',35,'','市场专员','02164274398',89,121),(54,'万里礼品领取',1,'2014-09-16 11:43:10','2014-09-16 11:43:10',35,'','市场专员','02164274398',89,121);
/*!40000 ALTER TABLE `yoga_channel` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `yoga_channel_all_statistics`
--

DROP TABLE IF EXISTS `yoga_channel_all_statistics`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `yoga_channel_all_statistics` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `brand_id` bigint(20) NOT NULL,
  `club_id` bigint(20) NOT NULL DEFAULT '0',
  `protential_plan` int(11) NOT NULL DEFAULT '0',
  `protential_value` int(11) NOT NULL DEFAULT '0',
  `channel_plan` int(11) NOT NULL DEFAULT '0',
  `channel_value` int(11) NOT NULL DEFAULT '0',
  `transform_plan` int(11) NOT NULL DEFAULT '0',
  `transform_value` int(11) NOT NULL DEFAULT '0',
  `time` date DEFAULT NULL,
  `create_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `update_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  UNIQUE KEY `uniq_time_club` (`club_id`,`time`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `yoga_channel_all_statistics`
--

LOCK TABLES `yoga_channel_all_statistics` WRITE;
/*!40000 ALTER TABLE `yoga_channel_all_statistics` DISABLE KEYS */;
INSERT INTO `yoga_channel_all_statistics` VALUES (5,34,79,111,0,222,1,0,1,'2014-01-01','2014-06-22 14:23:27','2014-06-22 14:28:59'),(6,34,79,1111,0,2222,1,0,1,'2014-02-01','2014-06-22 14:24:16','2014-06-22 14:29:18'),(7,34,79,11,0,22,1,33,1,'2014-08-01','2014-06-22 14:39:57','2014-06-22 14:39:57'),(8,34,79,11,0,22,1,33,1,'2014-06-01','2014-06-22 14:40:41','2014-06-22 14:40:41'),(9,34,79,11,0,1213,0,123123,0,'2014-07-01','2014-06-22 15:11:40','2014-06-22 15:11:40'),(10,34,79,101,0,11,0,21,0,'2014-09-01','2014-09-05 06:26:23','2014-09-05 06:26:22'),(11,34,79,21,0,12,0,13,0,'2014-10-01','2014-09-05 09:26:57','2014-09-05 09:27:17');
/*!40000 ALTER TABLE `yoga_channel_all_statistics` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `yoga_channel_single_statistics`
--

DROP TABLE IF EXISTS `yoga_channel_single_statistics`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `yoga_channel_single_statistics` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) NOT NULL,
  `brand_id` bigint(20) NOT NULL,
  `club_id` bigint(20) NOT NULL DEFAULT '0',
  `protential_plan` int(11) NOT NULL DEFAULT '0',
  `protential_value` int(11) NOT NULL DEFAULT '0',
  `channel_plan` int(11) NOT NULL DEFAULT '0',
  `channel_value` int(11) NOT NULL DEFAULT '0',
  `transform_plan` int(11) NOT NULL DEFAULT '0',
  `transform_value` int(11) NOT NULL DEFAULT '0',
  `time` char(10) DEFAULT NULL,
  `create_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `update_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  UNIQUE KEY `uniq_time_brand` (`user_id`,`time`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `yoga_channel_single_statistics`
--

LOCK TABLES `yoga_channel_single_statistics` WRITE;
/*!40000 ALTER TABLE `yoga_channel_single_statistics` DISABLE KEYS */;
INSERT INTO `yoga_channel_single_statistics` VALUES (15,45,34,79,101,0,10,0,1,0,'2014-09-01','2014-09-09 16:01:25','2014-09-09 16:01:35');
/*!40000 ALTER TABLE `yoga_channel_single_statistics` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `yoga_channel_visit`
--

DROP TABLE IF EXISTS `yoga_channel_visit`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `yoga_channel_visit` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) NOT NULL,
  `channel_id` bigint(20) NOT NULL,
  `create_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `update_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `description` text NOT NULL,
  `visit_name` varchar(255) NOT NULL DEFAULT '',
  `visit_phone` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  KEY `idx_user_id` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `yoga_channel_visit`
--

LOCK TABLES `yoga_channel_visit` WRITE;
/*!40000 ALTER TABLE `yoga_channel_visit` DISABLE KEYS */;
INSERT INTO `yoga_channel_visit` VALUES (12,45,14,'2014-06-23 05:14:46','2014-06-23 05:18:48','123123123','1231','123123'),(13,45,14,'2014-06-23 05:19:41','2014-06-23 05:19:41','33','11','22'),(14,45,13,'2014-06-23 05:25:06','2014-06-23 05:25:06','123','xx','00'),(15,45,14,'2014-06-23 05:27:13','2014-06-23 05:30:17','33','1','22');
/*!40000 ALTER TABLE `yoga_channel_visit` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `yoga_club`
--

DROP TABLE IF EXISTS `yoga_club`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `yoga_club` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `brand_id` bigint(20) NOT NULL,
  `code` varchar(255) NOT NULL DEFAULT '0',
  `create_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `location` varchar(255) NOT NULL DEFAULT '',
  `club_name` varchar(255) NOT NULL,
  `phone` varchar(25) NOT NULL DEFAULT '',
  `fax` varchar(25) NOT NULL DEFAULT '',
  `email` varchar(25) NOT NULL DEFAULT '',
  `zipcode` varchar(25) NOT NULL DEFAULT '',
  `desc` text,
  `update_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `idx_brand_id` (`brand_id`)
) ENGINE=InnoDB AUTO_INCREMENT=123 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `yoga_club`
--

LOCK TABLES `yoga_club` WRITE;
/*!40000 ALTER TABLE `yoga_club` DISABLE KEYS */;
INSERT INTO `yoga_club` VALUES (79,34,'111','2014-08-12 12:11:04','上海市,上海市,市、县级市、县,','club79','22','11','11@xx.com','','xxx','0000-00-00 00:00:00'),(80,34,'0021','2014-08-12 12:26:21','上海市,上海市,黄浦区,111','club80','13111111111','123','321@11.com','','12333333333333333333333333333333333333333333','0000-00-00 00:00:00'),(89,34,'123','2014-08-13 13:02:55','xxxxxxxxxxxxx','club89','','','','',NULL,'0000-00-00 00:00:00'),(90,34,'123','2014-08-13 13:02:55','xxxxxxxxxxxxx','club90','','','','',NULL,'0000-00-00 00:00:00'),(91,34,'123','2014-08-13 13:02:55','xxxxxxxxxxxxx','club91','','','','',NULL,'0000-00-00 00:00:00'),(93,34,'123','2014-08-13 13:02:56','xxxxxxxxxxxxx','club93','','','','',NULL,'0000-00-00 00:00:00'),(95,34,'123','2014-08-13 13:02:57','上海市,上海市,徐汇区,123','newclub','','','','','','2014-08-31 13:04:29'),(107,34,'111','2014-06-17 04:57:55','上海市,上海市,卢湾区,','club107','','','','','','2014-06-17 08:18:56'),(108,34,'','2014-06-17 04:58:02','上海市,地级市,市、县级市、县,','club108','','','','','','2014-06-17 04:58:02'),(109,34,'','2014-06-17 04:58:05','上海市,地级市,市、县级市、县,','club109','','','','','','2014-06-17 04:58:05'),(110,34,'','2014-06-17 04:58:10','上海市,地级市,市、县级市、县,','club110','','','','','','2014-06-17 04:58:10'),(111,34,'4157','2014-06-17 17:29:18','上海市,上海市,黄浦区,123','Club1','13111111111','131111111','peterleelibo@163.com','','dddd','2014-06-17 17:29:18'),(112,34,'0529','2014-06-17 17:29:42','天津市,天津市,河东区,123','Club2','13111111111','1311111111','peterleelibo@163.com','','xx','2014-06-17 17:29:42'),(113,34,'1111','2014-08-18 02:18:40','上海市,上海市,长宁区,111','Club3','13111111111','1111','peterleelibo@163.com','','','2014-08-18 02:18:40'),(114,34,'0','2014-08-20 04:48:14','内蒙古,包头市,固阳县,123','Club1','','','','','','2014-08-20 04:48:14'),(115,34,'0','2014-08-31 13:14:04','上海市,上海市,静安区,XX','A','','','','','','2014-08-31 13:14:05'),(116,34,'0','2014-08-31 13:14:13','上海市,上海市,静安区,XX','A','','','','','','2014-08-31 13:14:14'),(117,34,'0','2014-08-31 13:16:45','上海市,地级市,市、县级市、县,','C','','','','','','2014-08-31 13:16:45'),(118,34,'0','2014-08-31 13:20:38','上海市,上海市,杨浦区,xx','Raja','','','','','','2014-08-31 13:20:39'),(119,35,'0','2014-09-03 01:31:36','上海市,上海市,徐汇区,辛耕路88号','徐汇店','021-64274398','','','','','2014-09-03 01:31:36'),(120,35,'0','2014-09-03 01:32:13','上海市,上海市,杨浦区,五角场万达广场','万达店','','','','','','2014-09-03 01:32:13'),(121,35,'0','2014-09-03 01:32:55','上海市,上海市,普陀区,','万里店','','','','','','2014-09-03 01:32:55'),(122,44,'0','2014-09-12 02:23:58','上海市,上海市,徐汇区,徐家汇辛耕路88号','徐家汇店','02164274318','02164274318','jordan.shu@rajayoga.com.c','','haodian','2014-09-12 02:23:58');
/*!40000 ALTER TABLE `yoga_club` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `yoga_contract`
--

DROP TABLE IF EXISTS `yoga_contract`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `yoga_contract` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `total_num` int(11) NOT NULL DEFAULT '0',
  `used_num` int(11) NOT NULL DEFAULT '0',
  `contract_number` varchar(255) NOT NULL DEFAULT '' COMMENT 'ymdhisms',
  `type` varchar(255) NOT NULL COMMENT '0--normal 1--team',
  `card_type_id` bigint(20) NOT NULL,
  `card_id` varchar(255) NOT NULL DEFAULT '',
  `member_id` bigint(20) NOT NULL,
  `start_time` date NOT NULL DEFAULT '0000-00-00',
  `end_time` date NOT NULL DEFAULT '0000-00-00',
  `present_day` int(11) NOT NULL DEFAULT '0',
  `present_num` int(11) NOT NULL DEFAULT '0',
  `price` double NOT NULL DEFAULT '0',
  `payed` double NOT NULL DEFAULT '0',
  `brand_id` bigint(20) NOT NULL,
  `description` text NOT NULL,
  `record_id` bigint(20) NOT NULL,
  `create_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `update_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `status` tinyint(4) NOT NULL DEFAULT '1' COMMENT '1-new 2-continue 3-upgrade 4-transform',
  `invalid` tinyint(4) NOT NULL DEFAULT '1' COMMENT '1-valid 0--invalid',
  `sale_club_id` bigint(20) NOT NULL DEFAULT '0',
  `mc_id` bigint(20) NOT NULL DEFAULT '0' COMMENT '入会时的mc',
  `c_id` bigint(20) NOT NULL DEFAULT '0' COMMENT '入会时的渠道',
  `active_type` tinyint(4) NOT NULL DEFAULT '0',
  `contract_type` int(11) NOT NULL DEFAULT '0' COMMENT '0--card  1--goods 2--pt',
  `club_id` bigint(20) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `idx_brand_id` (`brand_id`),
  KEY `idx_member_id` (`member_id`),
  KEY `idx_mc_id` (`mc_id`),
  KEY `idx_c_id` (`c_id`),
  KEY `idx_contract` (`contract_number`),
  KEY `idx_card_id` (`card_id`)
) ENGINE=InnoDB AUTO_INCREMENT=90 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `yoga_contract`
--

LOCK TABLES `yoga_contract` WRITE;
/*!40000 ALTER TABLE `yoga_contract` DISABLE KEYS */;
INSERT INTO `yoga_contract` VALUES (63,1,0,'201408292125342149','0',25,'75',64,'2014-08-29','2019-01-11',0,0,11110,1,34,'',45,'2014-08-29 13:25:34','2014-08-29 13:30:52',3,1,79,52,0,0,0,0),(64,63,0,'201408292126558901','0',23,'74',63,'2014-08-29','2019-01-11',11,12,321,72,34,'',45,'2014-08-29 13:26:55','2014-08-31 03:40:02',1,1,79,0,0,0,0,0),(72,61,0,'201408310905568792','1',22,'74',63,'2018-11-09','2019-01-11',1,1,2000,15,34,'aaa',45,'2014-08-31 01:05:56','2014-08-31 04:21:05',2,1,79,0,0,0,0,0),(74,2,0,'201409050035562926','0',25,'80',65,'0000-00-00','0000-00-00',1,1,2222,0,34,'',45,'2014-09-04 16:35:56','2014-09-04 16:35:56',1,1,79,0,0,2,0,0),(75,72,0,'201409081629389701','0',22,'81',66,'2014-09-08','2015-09-19',11,12,2000,0,34,'',45,'2014-09-08 08:29:38','2014-09-08 08:29:38',1,1,79,0,0,0,0,0),(76,0,0,'201409121111583906','0',27,'82',89,'2014-09-13','2014-01-13',0,0,1800,1800,44,'',82,'2014-09-12 03:11:58','2014-09-12 03:11:58',1,1,122,0,0,1,0,0),(77,0,0,'201409121633427566','0',27,'83',89,'2014-09-19','2014-01-19',0,0,1800,1800,44,'',82,'2014-09-12 08:33:42','2014-09-12 08:33:42',1,1,122,0,0,1,0,0),(78,0,0,'201409121635488139','0',27,'84',89,'2014-09-13','2014-01-13',0,0,1800,1800,44,'',82,'2014-09-12 08:35:48','2014-09-12 08:35:48',1,1,122,0,0,1,0,0),(79,73,0,'201409132221492973','0',22,'85',65,'2014-09-13','2015-09-25',12,13,10,0,34,'',45,'2014-09-13 14:21:49','2014-09-13 14:21:49',1,1,79,0,0,1,0,0),(80,73,0,'20140913222154764','0',22,'86',65,'2014-09-13','2015-09-25',12,13,10,0,34,'',45,'2014-09-13 14:21:54','2014-09-13 14:21:54',1,1,79,0,0,1,0,0),(81,73,0,'20140913222208588','0',22,'87',65,'2014-09-13','2015-09-25',12,13,10,0,34,'',45,'2014-09-13 14:22:08','2014-09-13 14:22:08',1,1,79,0,0,1,0,0),(82,73,0,'201409132222094742','0',22,'88',65,'2014-09-13','2015-09-25',12,13,10,0,34,'',45,'2014-09-13 14:22:09','2014-09-13 14:22:09',1,1,79,0,0,1,0,0),(83,71,0,'201409132222362504','0',22,'89',65,'2014-09-13','2015-09-24',11,11,1,0,34,'',45,'2014-09-13 14:22:36','2014-09-13 14:22:36',1,1,79,0,0,0,0,0),(84,71,0,'201409132222573851','0',22,'90',65,'2014-09-13','2015-09-24',11,11,1,0,34,'',45,'2014-09-13 14:22:57','2014-09-13 14:22:56',1,1,79,0,0,0,0,0),(85,71,0,'201409132225216799','0',22,'91',65,'2014-09-13','2015-09-24',11,11,1,0,34,'',45,'2014-09-13 14:25:21','2014-09-13 14:25:20',1,1,79,0,0,0,0,0),(86,71,0,'201409132228249579','0',22,'92',65,'2014-09-13','2015-09-24',11,11,1,0,34,'',45,'2014-09-13 14:28:24','2014-09-13 14:28:24',1,1,79,0,0,0,0,0),(87,71,0,'201409132228526808','0',22,'93',65,'2014-09-13','2015-09-24',11,11,1,0,34,'',45,'2014-09-13 14:28:52','2014-09-13 14:28:52',1,1,79,0,0,0,0,0),(88,1,0,'201409132235021416','0',25,'94',65,'2014-09-13','2015-09-13',0,0,11111,0,34,'',45,'2014-09-13 14:35:02','2014-09-13 17:02:31',3,1,79,0,0,0,0,0),(89,60,0,'201409132343242346','0',22,'80',65,'2014-09-13','2015-09-24',11,0,2000,0,34,'',45,'2014-09-13 15:43:24','2014-09-13 15:43:24',4,1,79,0,0,0,0,0);
/*!40000 ALTER TABLE `yoga_contract` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `yoga_contract_history`
--

DROP TABLE IF EXISTS `yoga_contract_history`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `yoga_contract_history` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `contract_id` bigint(20) NOT NULL,
  `extension` varchar(5000) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  KEY `idx_contract_id` (`contract_id`)
) ENGINE=InnoDB AUTO_INCREMENT=103 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `yoga_contract_history`
--

LOCK TABLES `yoga_contract_history` WRITE;
/*!40000 ALTER TABLE `yoga_contract_history` DISABLE KEYS */;
INSERT INTO `yoga_contract_history` VALUES (41,41,'{\"member_id\":\"62\",\"type\":\"0\",\"card_type_id\":\"23\",\"valid_type\":\"0\",\"present_value\":\"21\",\"start_time\":\"2014-08-24\",\"end_time\":\"2024-09-24\",\"price\":\"1111\",\"cash\":\"100\",\"pos\":\"1\",\"check\":\"1\",\"check_num\":\"1\",\"description\":\"xx\"}'),(42,42,'{\"member_id\":\"62\",\"type\":\"0\",\"card_type_id\":\"22\",\"valid_type\":\"1\",\"present_value\":\"12\",\"start_time\":\"2014-08-24\",\"end_time\":\"2014-09-24\",\"price\":\"2000\",\"cash\":\"1001\",\"pos\":\"11\",\"check\":\"1\",\"check_num\":\"1\",\"description\":\"xx\"}'),(43,43,'{\"member_id\":\"62\",\"type\":\"0\",\"card_type_id\":\"23\",\"valid_type\":\"0\",\"present_value\":\"21\",\"start_time\":\"2014-08-24\",\"end_time\":\"2024-09-24\",\"price\":\"1111\",\"cash\":\"1001\",\"pos\":\"1\",\"check\":\"1\",\"check_num\":\"1\",\"description\":\"\"}'),(44,44,'{\"member_id\":\"62\",\"type\":\"0\",\"card_type_id\":\"22\",\"valid_type\":\"0\",\"present_value\":\"1\",\"start_time\":\"2014-08-25\",\"end_time\":\"2014-09-25\",\"price\":\"2000\",\"cash\":\"11\",\"pos\":\"11\",\"check\":\"11\",\"check_num\":\"11\",\"description\":\"11\"}'),(45,45,'{\"member_id\":\"63\",\"type\":\"0\",\"card_type_id\":\"23\",\"valid_type\":\"0\",\"present_value\":\"21\",\"start_time\":\"2014-08-25\",\"end_time\":\"2024-09-25\",\"price\":\"1111\",\"cash\":\"22\",\"pos\":\"33\",\"check\":\"44\",\"check_num\":\"xx\",\"description\":\"123\"}'),(46,46,'{\"member_id\":\"67\",\"type\":\"0\",\"card_type_id\":\"23\",\"valid_type\":\"0\",\"present_value\":\"21\",\"start_time\":\"2014-08-25\",\"end_time\":\"2024-09-25\",\"price\":\"1111\",\"cash\":\"100\",\"pos\":\"1\",\"check\":\"1\",\"check_num\":\"\",\"description\":\"123\"}'),(47,47,'{\"member_id\":\"67\",\"type\":\"0\",\"card_type_id\":\"22\",\"valid_type\":\"0\",\"present_value\":\"1\",\"start_time\":\"2014-08-25\",\"end_time\":\"2014-09-25\",\"price\":\"2000\",\"cash\":\"1\",\"pos\":\"1\",\"check\":\"1\",\"check_num\":\"1\",\"description\":\"\"}'),(48,48,'{\"member_id\":\"70\",\"type\":\"0\",\"card_type_id\":\"22\",\"valid_type\":\"0\",\"present_value\":\"1\",\"start_time\":\"2014-08-25\",\"end_time\":\"2014-09-25\",\"price\":\"2000\",\"cash\":\"0\",\"pos\":\"0\",\"check\":\"0\",\"check_num\":\"\",\"description\":\"\"}'),(49,49,'{\"member_id\":\"71\",\"type\":\"1\",\"card_type_id\":\"23\",\"valid_type\":\"2\",\"present_value\":\"21\",\"start_time\":\"2014-08-26\",\"end_time\":\"2024-09-26\",\"price\":\"1000\",\"cash\":\"0\",\"pos\":\"0\",\"check\":\"0\",\"check_num\":\"\",\"description\":\"\"}'),(50,50,'{\"member_id\":\"63\",\"type\":\"0\",\"card_type_id\":\"23\",\"valid_type\":\"0\",\"present_day\":\"11\",\"present_num\":\"0\",\"start_time\":\"2014-08-27\",\"end_time\":\"2024-10-08\",\"price\":\"1111\",\"cash\":\"1\",\"card_number\":\"19870520\",\"pos\":\"2\",\"check\":\"3\",\"check_num\":\"4\",\"description\":\"5\"}'),(51,51,'{\"member_id\":\"62\",\"type\":\"0\",\"card_type_id\":\"22\",\"valid_type\":\"0\",\"present_day\":\"11\",\"present_num\":\"12\",\"start_time\":\"2014-08-27\",\"end_time\":\"2014-10-08\",\"price\":\"2000\",\"cash\":\"100\",\"card_number\":\"12345676\",\"pos\":\"0\",\"check\":\"0\",\"check_num\":\"\",\"description\":\"\"}'),(52,52,'{\"member_id\":\"63\",\"type\":\"0\",\"card_type_id\":\"22\",\"valid_type\":\"0\",\"present_day\":\"11\",\"present_num\":\"0\",\"start_time\":\"2014-08-27\",\"end_time\":\"2014-10-08\",\"price\":\"2000\",\"cash\":\"0\",\"card_number\":\"\",\"pos\":\"0\",\"check\":\"0\",\"check_num\":\"\",\"description\":\"\"}'),(53,53,'{\"member_id\":\"62\",\"type\":\"0\",\"card_type_id\":\"22\",\"valid_type\":\"0\",\"present_day\":\"0\",\"present_num\":\"0\",\"start_time\":\"2014-08-27\",\"end_time\":\"2014-09-27\",\"price\":\"2000\",\"cash\":\"0\",\"card_number\":\"\",\"pos\":\"0\",\"check\":\"0\",\"check_num\":\"\",\"description\":\"\"}'),(54,54,'{\"member_id\":\"63\",\"type\":\"0\",\"card_type_id\":\"24\",\"valid_type\":\"2\",\"present_day\":\"0\",\"present_num\":\"0\",\"start_time\":\"2014-08-27\",\"end_time\":\"2015-07-27\",\"price\":\"123\",\"cash\":\"0\",\"card_number\":\"\",\"pos\":\"0\",\"check\":\"0\",\"check_num\":\"11\",\"description\":\"\"}'),(55,55,'{\"member_id\":\"62\",\"type\":\"0\",\"card_type_id\":\"23\",\"valid_type\":\"0\",\"present_day\":\"1\",\"present_num\":\"2\",\"start_time\":\"2014-08-28\",\"end_time\":\"2018-10-29\",\"price\":\"321\",\"cash\":\"0\",\"card_number\":\"19870520\",\"pos\":\"0\",\"check\":\"0\",\"check_num\":\"\",\"description\":\"\"}'),(56,56,'{\"member_id\":\"63\",\"type\":\"0\",\"card_type_id\":\"24\",\"valid_type\":\"0\",\"present_day\":\"1\",\"present_num\":\"12\",\"start_time\":\"2014-08-28\",\"end_time\":\"2015-06-29\",\"price\":\"123\",\"cash\":\"100\",\"card_number\":\"99999999\",\"pos\":\"1\",\"check\":\"2\",\"check_num\":\"\",\"description\":\"\"}'),(57,57,'{\"member_id\":\"63\",\"type\":\"0\",\"card_type_id\":\"24\",\"valid_type\":\"0\",\"present_day\":\"10\",\"present_num\":\"10\",\"start_time\":\"2014-08-28\",\"end_time\":\"2015-07-08\",\"price\":\"123\",\"cash\":\"100\",\"card_number\":\"999999999\",\"pos\":\"0\",\"check\":\"0\",\"check_num\":\"\",\"description\":\"\"}'),(58,66,'{\"card_id\":\"62\",\"user_id\":\"63\",\"type\":\"0\",\"card_type_id\":\"22\",\"present_day\":\"11\",\"present_num\":\"12\",\"should_pay\":\"1876\",\"cash\":\"100\",\"pos\":\"2\",\"check\":\"3\",\"check_num\":\"\",\"description\":\"\"}'),(59,67,'{\"card_id\":\"62\",\"user_id\":\"63\",\"type\":\"1\",\"card_type_id\":\"25\",\"present_day\":\"11\",\"present_num\":\"12\",\"should_pay\":\"9111\",\"cash\":\"1\",\"pos\":\"2\",\"check\":\"3\",\"check_num\":\"4\",\"description\":\"\"}'),(60,58,'{\"member_id\":\"62\",\"type\":\"0\",\"card_type_id\":\"23\",\"active_type\":\"2\",\"present_day\":\"10\",\"present_num\":\"0\",\"start_time\":\"\",\"end_time\":\"\",\"price\":\"321\",\"cash\":\"100\",\"card_number\":\"88888888888888\",\"pos\":\"1\",\"check\":\"3\",\"check_num\":\"\",\"description\":\"xxxxxxx\"}'),(61,59,'{\"member_id\":\"63\",\"type\":\"0\",\"card_type_id\":\"23\",\"active_type\":\"0\",\"present_day\":\"0\",\"present_num\":\"0\",\"start_time\":\"2014-08-29\",\"end_time\":\"2018-10-29\",\"price\":\"321\",\"cash\":\"0\",\"card_number\":\"\",\"pos\":\"0\",\"check\":\"0\",\"check_num\":\"\",\"description\":\"\"}'),(62,60,'{\"member_id\":\"62\",\"type\":\"0\",\"card_type_id\":\"22\",\"active_type\":\"0\",\"present_day\":\"1\",\"present_num\":\"2\",\"start_time\":\"2014-08-29\",\"end_time\":\"2015-08-30\",\"price\":\"2000\",\"cash\":\"0\",\"card_number\":\"111111111\",\"pos\":\"0\",\"check\":\"0\",\"check_num\":\"\",\"description\":\"\"}'),(63,61,'{\"member_id\":\"62\",\"type\":\"0\",\"card_type_id\":\"22\",\"active_type\":\"1\",\"present_day\":\"11\",\"present_num\":\"22\",\"start_time\":\"2014-08-07\",\"end_time\":\"2015-08-18\",\"price\":\"2000\",\"cash\":\"0\",\"card_number\":\"111111111111111\",\"pos\":\"0\",\"check\":\"0\",\"check_num\":\"\",\"description\":\"\"}'),(64,62,'{\"member_id\":\"62\",\"type\":\"0\",\"card_type_id\":\"22\",\"active_type\":\"1\",\"present_day\":\"11\",\"present_num\":\"11\",\"start_time\":\"2014-08-27\",\"end_time\":\"2015-09-07\",\"price\":\"2000\",\"cash\":\"0\",\"card_number\":\"1111111111111\",\"pos\":\"0\",\"check\":\"0\",\"check_num\":\"\",\"description\":\"\"}'),(65,63,'{\"member_id\":\"62\",\"type\":\"0\",\"card_type_id\":\"22\",\"active_type\":\"0\",\"present_day\":\"11\",\"present_num\":\"0\",\"start_time\":\"2014-08-29\",\"end_time\":\"2015-09-09\",\"price\":\"2000\",\"cash\":\"1\",\"card_number\":\"111111111111\",\"pos\":\"0\",\"check\":\"0\",\"check_num\":\"\",\"description\":\"\"}'),(66,64,'{\"member_id\":\"63\",\"type\":\"0\",\"card_type_id\":\"23\",\"active_type\":\"0\",\"present_day\":\"11\",\"present_num\":\"12\",\"start_time\":\"2014-08-29\",\"end_time\":\"2018-11-09\",\"price\":\"321\",\"cash\":\"1\",\"card_number\":\"2222222222222222222\",\"pos\":\"0\",\"check\":\"0\",\"check_num\":\"\",\"description\":\"\"}'),(67,63,'{\"owner_id\":\"62\",\"contract_id\":\"63\",\"new_id\":\"64\",\"new_card_number\":\"333333333333333333333333\"}'),(68,65,'{\"current_contract_id\":\"64\",\"current_member_id\":\"63\",\"type\":\"0\",\"card_type_id\":\"24\",\"present_day\":\"11\",\"present_num\":\"99\",\"start_time\":\"2018-11-09\",\"should_pay\":\"123\",\"cash\":\"3\",\"pos\":\"10\",\"check\":\"10\",\"check_num\":\"\",\"description\":\"\"}'),(69,0,'{\"current_contract_id\":\"64\",\"current_member_id\":\"63\",\"type\":\"0\",\"card_type_id\":\"23\",\"present_day\":\"11\",\"present_num\":\"0\",\"start_time\":\"2018-11-08\",\"should_pay\":\"321\",\"cash\":\"1\",\"pos\":\"0\",\"check\":\"0\",\"check_num\":\"\",\"description\":\"\"}'),(70,0,'{\"current_contract_id\":\"64\",\"current_member_id\":\"63\",\"type\":\"0\",\"card_type_id\":\"22\",\"present_day\":\"0\",\"present_num\":\"0\",\"start_time\":\"2018-11-09\",\"should_pay\":\"2000\",\"cash\":\"0\",\"pos\":\"0\",\"check\":\"0\",\"check_num\":\"\",\"description\":\"\"}'),(71,0,'{\"current_contract_id\":\"64\",\"current_member_id\":\"63\",\"type\":\"1\",\"card_type_id\":\"23\",\"present_day\":\"11\",\"present_num\":\"0\",\"start_time\":\"2018-11-09\",\"end_time_\":\"2023-01-20\",\"should_pay\":\"321\",\"cash\":\"1\",\"pos\":\"0\",\"check\":\"0\",\"check_num\":\"\",\"description\":\"\"}'),(72,72,'{\"current_contract_id\":\"64\",\"current_member_id\":\"63\",\"type\":\"1\",\"card_type_id\":\"22\",\"present_day\":\"1\",\"present_num\":\"1\",\"start_time\":\"2018-11-09\",\"end_time_\":\"2019-11-10\",\"should_pay\":\"2000\",\"cash\":\"0\",\"pos\":\"0\",\"check\":\"0\",\"check_num\":\"\",\"description\":\"\"}'),(73,64,'{\"current_contract_id\":\"64\",\"current_member_id\":\"63\",\"cash\":\"10\",\"pos\":\"0\",\"check\":\"0\",\"check_num\":\"\",\"description\":\"\"}'),(74,64,'{\"current_contract_id\":\"64\",\"current_member_id\":\"63\",\"cash\":\"0\",\"pos\":\"10\",\"check\":\"0\",\"check_num\":\"\",\"description\":\"\"}'),(75,64,'{\"current_contract_id\":\"64\",\"current_member_id\":\"63\",\"cash\":\"0\",\"pos\":\"10\",\"check\":\"0\",\"check_num\":\"\",\"description\":\"\"}'),(76,64,'{\"current_contract_id\":\"64\",\"current_member_id\":\"63\",\"cash\":\"0\",\"pos\":\"0\",\"check\":\"10\",\"check_num\":\"\",\"description\":\"\"}'),(77,64,'{\"current_contract_id\":\"64\",\"current_member_id\":\"63\",\"cash\":\"0\",\"pos\":\"0\",\"check\":\"10\",\"check_num\":\"\",\"description\":\"\"}'),(78,64,'{\"current_contract_id\":\"64\",\"current_member_id\":\"63\",\"cash\":\"0\",\"pos\":\"10\",\"check\":\"0\",\"check_num\":\"\",\"description\":\"\"}'),(79,64,'{\"current_contract_id\":\"64\",\"current_member_id\":\"63\",\"cash\":\"10\",\"pos\":\"0\",\"check\":\"0\",\"check_num\":\"\",\"description\":\"\"}'),(80,64,'{\"current_contract_id\":\"64\",\"current_member_id\":\"63\",\"cash\":\"1\",\"pos\":\"0\",\"check\":\"0\",\"check_num\":\"\",\"description\":\"\"}'),(81,72,'{\"current_contract_id\":\"72\",\"current_member_id\":\"63\",\"cash\":\"1\",\"pos\":\"2\",\"check\":\"3\",\"check_num\":\"\",\"description\":\"xx\"}'),(82,72,'{\"current_contract_id\":\"72\",\"current_member_id\":\"63\",\"cash\":\"2\",\"pos\":\"3\",\"check\":\"4\",\"check_num\":\"\",\"description\":\"aaa\"}'),(83,74,'{\"member_id\":\"65\",\"type\":\"0\",\"card_type_id\":\"25\",\"active_type\":\"2\",\"present_day\":\"1\",\"present_num\":\"1\",\"start_time\":\"\",\"end_time\":\"\",\"price\":\"2222\",\"cash\":\"0\",\"card_number\":\"1234321\",\"pos\":\"0\",\"check\":\"0\",\"check_num\":\"\",\"description\":\"\"}'),(84,75,'{\"member_id\":\"66\",\"type\":\"0\",\"card_type_id\":\"22\",\"active_type\":\"0\",\"present_day\":\"11\",\"present_num\":\"12\",\"start_time\":\"2014-09-08\",\"end_time\":\"2015-09-19\",\"price\":\"2000\",\"cash\":\"0\",\"card_number\":\"123333\",\"pos\":\"0\",\"check\":\"0\",\"check_num\":\"\",\"description\":\"\"}'),(85,76,'{\"member_id\":\"89\",\"type\":\"0\",\"card_type_id\":\"27\",\"active_type\":\"1\",\"present_day\":\"0\",\"present_num\":\"0\",\"start_time\":\"2014-09-13\",\"end_time\":\"2014-01-13\",\"price\":\"1800\",\"cash\":\"1800\",\"card_number\":\"asd\",\"pos\":\"0\",\"check\":\"0\",\"check_num\":\"\",\"description\":\"\"}'),(86,77,'{\"member_id\":\"89\",\"type\":\"0\",\"card_type_id\":\"27\",\"active_type\":\"1\",\"present_day\":\"0\",\"present_num\":\"0\",\"start_time\":\"2014-09-19\",\"end_time\":\"2014-01-19\",\"price\":\"1800\",\"cash\":\"1800\",\"card_number\":\"\",\"pos\":\"0\",\"check\":\"0\",\"check_num\":\"\",\"description\":\"\"}'),(87,78,'{\"member_id\":\"89\",\"type\":\"0\",\"card_type_id\":\"27\",\"active_type\":\"1\",\"present_day\":\"0\",\"present_num\":\"0\",\"start_time\":\"2014-09-13\",\"end_time\":\"2014-01-13\",\"price\":\"1800\",\"cash\":\"1800\",\"card_number\":\"\",\"pos\":\"0\",\"check\":\"0\",\"check_num\":\"\",\"description\":\"\"}'),(88,79,'{\"member_id\":\"65\",\"type\":\"0\",\"card_type_id\":\"22\",\"active_type\":\"1\",\"present_day\":\"12\",\"present_num\":\"13\",\"start_time\":\"2014-09-13\",\"end_time\":\"2015-09-25\",\"price\":\"10\",\"cash\":\"0\",\"card_number\":\"\",\"pos\":\"0\",\"check\":\"0\",\"check_num\":\"\",\"description\":\"\"}'),(89,80,'{\"member_id\":\"65\",\"type\":\"0\",\"card_type_id\":\"22\",\"active_type\":\"1\",\"present_day\":\"12\",\"present_num\":\"13\",\"start_time\":\"2014-09-13\",\"end_time\":\"2015-09-25\",\"price\":\"10\",\"cash\":\"0\",\"card_number\":\"\",\"pos\":\"0\",\"check\":\"0\",\"check_num\":\"\",\"description\":\"\"}'),(90,81,'{\"member_id\":\"65\",\"type\":\"0\",\"card_type_id\":\"22\",\"active_type\":\"1\",\"present_day\":\"12\",\"present_num\":\"13\",\"start_time\":\"2014-09-13\",\"end_time\":\"2015-09-25\",\"price\":\"10\",\"cash\":\"0\",\"card_number\":\"\",\"pos\":\"0\",\"check\":\"0\",\"check_num\":\"\",\"description\":\"\"}'),(91,82,'{\"member_id\":\"65\",\"type\":\"0\",\"card_type_id\":\"22\",\"active_type\":\"1\",\"present_day\":\"12\",\"present_num\":\"13\",\"start_time\":\"2014-09-13\",\"end_time\":\"2015-09-25\",\"price\":\"10\",\"cash\":\"0\",\"card_number\":\"\",\"pos\":\"0\",\"check\":\"0\",\"check_num\":\"\",\"description\":\"\"}'),(92,83,'{\"member_id\":\"65\",\"type\":\"0\",\"card_type_id\":\"22\",\"active_type\":\"0\",\"present_day\":\"11\",\"present_num\":\"11\",\"start_time\":\"2014-09-13\",\"end_time\":\"2015-09-24\",\"price\":\"1\",\"cash\":\"0\",\"card_number\":\"\",\"pos\":\"0\",\"check\":\"0\",\"check_num\":\"\",\"description\":\"\"}'),(93,84,'{\"member_id\":\"65\",\"type\":\"0\",\"card_type_id\":\"22\",\"active_type\":\"0\",\"present_day\":\"11\",\"present_num\":\"11\",\"start_time\":\"2014-09-13\",\"end_time\":\"2015-09-24\",\"price\":\"1\",\"cash\":\"0\",\"card_number\":\"\",\"pos\":\"0\",\"check\":\"0\",\"check_num\":\"\",\"description\":\"\"}'),(94,85,'{\"member_id\":\"65\",\"type\":\"0\",\"card_type_id\":\"22\",\"active_type\":\"0\",\"present_day\":\"11\",\"present_num\":\"11\",\"start_time\":\"2014-09-13\",\"end_time\":\"2015-09-24\",\"price\":\"1\",\"cash\":\"0\",\"card_number\":\"\",\"pos\":\"0\",\"check\":\"0\",\"check_num\":\"\",\"description\":\"\"}'),(95,86,'{\"member_id\":\"65\",\"type\":\"0\",\"card_type_id\":\"22\",\"active_type\":\"0\",\"present_day\":\"11\",\"present_num\":\"11\",\"start_time\":\"2014-09-13\",\"end_time\":\"2015-09-24\",\"price\":\"1\",\"cash\":\"0\",\"card_number\":\"\",\"pos\":\"0\",\"check\":\"0\",\"check_num\":\"\",\"description\":\"\"}'),(96,87,'{\"member_id\":\"65\",\"type\":\"0\",\"card_type_id\":\"22\",\"active_type\":\"0\",\"present_day\":\"11\",\"present_num\":\"11\",\"start_time\":\"2014-09-13\",\"end_time\":\"2015-09-24\",\"price\":\"1\",\"cash\":\"0\",\"card_number\":\"\",\"pos\":\"0\",\"check\":\"0\",\"check_num\":\"\",\"description\":\"\"}'),(97,88,'{\"member_id\":\"65\",\"type\":\"0\",\"card_type_id\":\"22\",\"active_type\":\"0\",\"present_day\":\"11\",\"present_num\":\"11\",\"start_time\":\"2014-09-13\",\"end_time\":\"2015-09-24\",\"price\":\"1\",\"cash\":\"0\",\"card_number\":\"\",\"pos\":\"0\",\"check\":\"0\",\"check_num\":\"\",\"description\":\"\"}'),(98,89,'{\"member_id\":\"65\",\"type\":\"0\",\"card_type_id\":\"22\",\"active_type\":\"0\",\"present_day\":\"11\",\"present_num\":\"0\",\"start_time\":\"2014-09-13\",\"end_time\":\"2015-09-24\",\"price\":\"2000\",\"cash\":\"0\",\"card_number\":\"\",\"pos\":\"0\",\"check\":\"0\",\"check_num\":\"\",\"description\":\"\"}'),(99,0,'{\"current_contract_id\":\"89\",\"current_member_id\":\"65\",\"type\":\"0\",\"card_type_id\":\"22\",\"present_day\":\"0\",\"present_num\":\"0\",\"start_time\":\"2015-09-24\",\"end_time_\":\"2016-09-24\",\"should_pay\":\"2000\",\"cash\":\"0\",\"pos\":\"0\",\"check\":\"0\",\"check_num\":\"\",\"description\":\"\"}'),(100,88,'{\"current_contract_id\":\"88\",\"current_member_id\":\"65\",\"type\":\"0\",\"card_type_id\":\"25\",\"present_day\":\"0\",\"present_num\":\"0\",\"end_time\":\"2015-09-13\",\"should_pay\":\"11111\",\"cash\":\"0\",\"pos\":\"0\",\"check\":\"0\",\"check_num\":\"\",\"description\":\"\"}'),(101,89,'{\"owner_id\":\"65\",\"contract_id\":\"89\",\"new_id\":\"68\",\"new_card_number\":\"\"}'),(102,89,'{\"owner_id\":\"68\",\"contract_id\":\"89\",\"new_id\":\"65\",\"new_card_number\":\"1234321\"}');
/*!40000 ALTER TABLE `yoga_contract_history` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `yoga_delay_history`
--

DROP TABLE IF EXISTS `yoga_delay_history`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `yoga_delay_history` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `create_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `club_id` bigint(20) NOT NULL,
  `brand_id` bigint(20) NOT NULL,
  `delay_day` int(11) NOT NULL DEFAULT '0',
  `reason` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=67 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `yoga_delay_history`
--

LOCK TABLES `yoga_delay_history` WRITE;
/*!40000 ALTER TABLE `yoga_delay_history` DISABLE KEYS */;
INSERT INTO `yoga_delay_history` VALUES (23,'2014-08-24 18:02:07',79,34,11,'xx'),(24,'2014-08-24 18:02:36',79,34,11,'xx'),(25,'2014-08-24 18:03:00',79,34,11,'xx'),(26,'2014-08-24 18:05:25',79,34,11,'xx'),(27,'2014-08-24 18:06:19',79,34,11,'xx'),(28,'2014-08-24 18:06:54',79,34,11,'xx'),(29,'2014-08-24 18:07:34',79,34,11,'xx'),(30,'2014-08-24 18:08:10',79,34,11,'xx'),(31,'2014-08-24 18:08:27',79,34,11,'xx'),(32,'2014-08-24 18:08:34',79,34,11,'xx'),(33,'2014-08-24 18:09:49',79,34,11,'xx'),(34,'2014-08-24 18:10:09',79,34,11,'xx'),(35,'2014-08-24 18:10:17',79,34,11,'xx'),(36,'2014-08-24 18:11:16',79,34,11,'xx'),(37,'2014-08-24 18:11:42',79,34,11,'xx'),(38,'2014-08-24 18:12:29',79,34,11,'xx'),(39,'2014-08-24 18:12:45',79,34,11,'xx'),(40,'2014-08-24 18:13:13',79,34,11,'xx'),(41,'2014-08-24 18:13:25',79,34,11,'xx'),(42,'2014-08-24 18:13:44',79,34,11,'xx'),(43,'2014-08-24 18:14:36',79,34,11,'xx'),(44,'2014-08-24 18:15:50',79,34,11,'xx'),(45,'2014-08-24 18:18:03',79,34,11,'xx'),(46,'2014-08-24 18:18:20',79,34,11,'xx'),(47,'2014-08-24 18:20:09',79,34,11,'xx'),(48,'2014-08-24 18:20:18',79,34,11,'xxxx'),(49,'2014-08-24 18:20:38',79,34,10,'xxxx'),(50,'2014-08-24 18:21:12',79,34,10,'xxxx'),(51,'2014-08-24 18:34:04',79,34,10,'xxxx'),(52,'2014-08-24 18:35:51',79,34,12,'xxx'),(53,'2014-08-24 18:36:34',79,34,12,'xxxxx'),(54,'2014-08-24 18:39:06',79,34,123,'321'),(55,'2014-08-24 18:39:19',79,34,123,'321'),(56,'2014-08-24 18:39:19',79,34,123,'321'),(57,'2014-08-24 18:39:20',79,34,123,'321'),(58,'2014-08-24 18:42:15',79,34,111,'312'),(59,'2014-08-24 18:42:26',79,34,11,'2'),(60,'2014-08-24 18:42:39',79,34,11,'22'),(61,'2014-08-24 18:43:47',79,34,1,'2'),(62,'2014-08-24 18:43:49',79,34,1,'23'),(63,'2014-08-24 18:44:00',79,34,11,'23'),(64,'2014-08-31 11:01:32',79,34,10,'xxxxxxxxx'),(65,'2014-08-31 11:09:00',79,34,10,'xxxxxxxxx1'),(66,'2014-09-12 02:33:26',122,44,23,'学习');
/*!40000 ALTER TABLE `yoga_delay_history` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `yoga_goods`
--

DROP TABLE IF EXISTS `yoga_goods`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `yoga_goods` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `category_id` bigint(20) NOT NULL,
  `sale_type` tinyint(4) NOT NULL DEFAULT '0',
  `code` varchar(255) NOT NULL DEFAULT '',
  `brand_id` bigint(20) NOT NULL,
  `description` text NOT NULL,
  `unit_price` varchar(255) NOT NULL DEFAULT '',
  `price` double NOT NULL DEFAULT '0',
  `create_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `update_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `total_num` bigint(16) NOT NULL DEFAULT '0',
  `sold_num` int(11) NOT NULL DEFAULT '0',
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `price_buy` double NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `idx_brand_id` (`brand_id`),
  KEY `idx_category` (`category_id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `yoga_goods`
--

LOCK TABLES `yoga_goods` WRITE;
/*!40000 ALTER TABLE `yoga_goods` DISABLE KEYS */;
INSERT INTO `yoga_goods` VALUES (14,'AAA',36,1,'232',34,'','111',1111,'2014-06-19 15:05:50','2014-06-19 15:05:50',2222,0,1,111),(15,'BB',36,1,'23',34,'','1111',111,'2014-06-19 15:52:28','2014-06-19 16:15:31',11,0,1,111),(16,'2323',35,0,'211',34,'323','1313',123,'2014-06-19 16:10:11','2014-06-19 16:19:23',1212,21,1,111),(17,'rxb',40,0,'11111111',34,'xxxxx','kg',12,'2014-08-31 12:56:21','2014-08-31 12:56:22',999,2,1,11),(18,'ccc',41,1,'2222222',34,'xx','t',12,'2014-08-31 13:22:35','2014-09-03 15:46:43',11,1,1,11),(19,'瑜伽垫',42,0,'',44,'好','元',268,'2014-09-12 09:06:55','2014-09-12 09:06:55',21,12,1,50),(20,'瑜伽铺巾',42,0,'',44,'不错','元',39,'2014-09-12 09:08:01','2014-09-12 09:08:01',12,44,1,25);
/*!40000 ALTER TABLE `yoga_goods` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `yoga_goods_category`
--

DROP TABLE IF EXISTS `yoga_goods_category`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `yoga_goods_category` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `property` tinyint(4) NOT NULL DEFAULT '0',
  `type` tinyint(4) NOT NULL DEFAULT '0',
  `create_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `brand_id` bigint(20) NOT NULL,
  `update_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `idx_brand_id` (`brand_id`)
) ENGINE=InnoDB AUTO_INCREMENT=44 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `yoga_goods_category`
--

LOCK TABLES `yoga_goods_category` WRITE;
/*!40000 ALTER TABLE `yoga_goods_category` DISABLE KEYS */;
INSERT INTO `yoga_goods_category` VALUES (35,'D',3,0,'2014-06-19 14:54:38',34,'0000-00-00 00:00:00'),(36,'E',4,0,'2014-06-19 14:54:41',34,'0000-00-00 00:00:00'),(37,'F',2,1,'2014-06-19 14:54:52',34,'0000-00-00 00:00:00'),(39,'普通实物a',0,0,'2014-08-31 12:49:08',34,'0000-00-00 00:00:00'),(40,'入场虚拟b',1,1,'2014-08-31 12:50:15',34,'0000-00-00 00:00:00'),(41,'C',2,1,'2014-08-31 13:21:57',34,'0000-00-00 00:00:00'),(42,'瑜伽用品',0,0,'2014-09-12 08:56:54',44,'0000-00-00 00:00:00'),(43,'瑜伽会籍卡',0,1,'2014-09-12 09:06:05',44,'0000-00-00 00:00:00');
/*!40000 ALTER TABLE `yoga_goods_category` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `yoga_goods_club`
--

DROP TABLE IF EXISTS `yoga_goods_club`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `yoga_goods_club` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `goods_id` bigint(20) NOT NULL,
  `club_id` bigint(20) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_goods` (`goods_id`),
  KEY `idx_club` (`club_id`)
) ENGINE=InnoDB AUTO_INCREMENT=94 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `yoga_goods_club`
--

LOCK TABLES `yoga_goods_club` WRITE;
/*!40000 ALTER TABLE `yoga_goods_club` DISABLE KEYS */;
INSERT INTO `yoga_goods_club` VALUES (66,14,79),(67,14,80),(70,15,79),(71,15,80),(72,15,89),(73,15,90),(74,15,91),(75,15,93),(76,15,95),(77,15,107),(78,15,108),(79,15,109),(80,15,110),(81,15,111),(82,15,112),(83,15,113),(84,16,113),(85,0,79),(86,0,80),(87,17,79),(88,17,80),(91,18,79),(92,19,122),(93,20,122);
/*!40000 ALTER TABLE `yoga_goods_club` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `yoga_goods_sale_list`
--

DROP TABLE IF EXISTS `yoga_goods_sale_list`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `yoga_goods_sale_list` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `order_id` bigint(20) NOT NULL,
  `goods_id` bigint(20) NOT NULL,
  `number` int(11) NOT NULL,
  `create_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `price` double NOT NULL DEFAULT '0',
  `goods_name` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  KEY `idx_order_id` (`order_id`),
  KEY `idx_goods_id` (`goods_id`)
) ENGINE=InnoDB AUTO_INCREMENT=84 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `yoga_goods_sale_list`
--

LOCK TABLES `yoga_goods_sale_list` WRITE;
/*!40000 ALTER TABLE `yoga_goods_sale_list` DISABLE KEYS */;
INSERT INTO `yoga_goods_sale_list` VALUES (76,76,16,1,'2014-09-01 02:54:38',123,''),(77,76,14,3,'2014-09-01 02:54:38',1111,''),(78,76,15,2,'2014-09-01 02:54:38',111,''),(79,77,16,2,'2014-09-04 16:24:08',123,''),(80,77,15,3,'2014-09-04 16:24:08',111,''),(81,78,16,2,'2014-09-04 16:24:59',123,''),(82,78,15,3,'2014-09-04 16:24:59',111,''),(83,79,16,2,'2014-09-11 11:14:35',123,'2323');
/*!40000 ALTER TABLE `yoga_goods_sale_list` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `yoga_goods_sale_order`
--

DROP TABLE IF EXISTS `yoga_goods_sale_order`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `yoga_goods_sale_order` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `member_id` bigint(20) NOT NULL,
  `price` double NOT NULL,
  `create_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `pay_way` tinyint(4) NOT NULL DEFAULT '0',
  `brand_id` bigint(20) NOT NULL,
  `sale_club_id` bigint(20) NOT NULL,
  `record_id` bigint(20) NOT NULL,
  `mc_id` bigint(20) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `idx_member_id` (`member_id`),
  KEY `idx_brand_id` (`brand_id`),
  KEY `idx_club_id` (`sale_club_id`)
) ENGINE=InnoDB AUTO_INCREMENT=80 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `yoga_goods_sale_order`
--

LOCK TABLES `yoga_goods_sale_order` WRITE;
/*!40000 ALTER TABLE `yoga_goods_sale_order` DISABLE KEYS */;
INSERT INTO `yoga_goods_sale_order` VALUES (76,62,3678,'2014-09-04 16:24:33',1,34,79,45,45),(77,62,579,'2014-09-04 16:24:08',0,34,79,45,45),(78,63,579,'2014-09-04 16:24:59',0,34,79,45,52),(79,62,246,'2014-09-11 11:14:35',0,34,79,45,45);
/*!40000 ALTER TABLE `yoga_goods_sale_order` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `yoga_mc_follow_up`
--

DROP TABLE IF EXISTS `yoga_mc_follow_up`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `yoga_mc_follow_up` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `member_id` bigint(20) NOT NULL,
  `create_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `mc_id` bigint(20) NOT NULL,
  `ret` tinyint(4) NOT NULL DEFAULT '0' COMMENT '0--失败 1--参观 2--体验',
  `appoint_time` date NOT NULL DEFAULT '0000-00-00',
  `failed_reason` varchar(64) DEFAULT NULL,
  `desc` varchar(5000) NOT NULL DEFAULT '',
  `club_id` bigint(20) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `idx_mc_id` (`mc_id`),
  KEY `idx_memeber_id` (`member_id`),
  KEY `idx_appoint_time` (`appoint_time`)
) ENGINE=InnoDB AUTO_INCREMENT=119 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `yoga_mc_follow_up`
--

LOCK TABLES `yoga_mc_follow_up` WRITE;
/*!40000 ALTER TABLE `yoga_mc_follow_up` DISABLE KEYS */;
INSERT INTO `yoga_mc_follow_up` VALUES (76,76,'2014-09-02 17:24:38',52,0,'2014-09-03','未接通','',79),(77,76,'2014-09-02 17:30:30',52,0,'0000-00-00','未接通','',79),(78,76,'2014-09-02 17:30:41',52,0,'0000-00-00','未接通','',79),(79,73,'2014-09-02 17:31:24',52,0,'2014-09-01','取消','1111111111',79),(80,76,'2014-09-02 17:32:37',52,1,'2014-09-03','未接通','asdffdsa',79),(81,76,'2014-09-02 17:34:41',52,1,'2014-09-23','未接通','12332111',79),(82,76,'2014-09-02 17:35:50',52,2,'2014-09-28','未接通','123',79),(83,76,'2014-09-03 01:27:12',52,1,'2014-09-17','未接通','123321',79),(84,76,'2014-09-03 01:57:28',52,0,'0000-00-00','对服务有意见','333333',79),(85,75,'2014-09-03 01:58:34',52,0,'0000-00-00','未接通','',79),(86,75,'2014-09-03 01:58:43',52,0,'0000-00-00','未接通','',79),(87,75,'2014-09-03 01:58:48',52,0,'0000-00-00','未接通','',79),(88,74,'2014-09-03 01:58:58',52,0,'0000-00-00','未接通','',79),(89,76,'2014-09-03 02:00:00',52,0,'0000-00-00','未接通','',79),(90,76,'2014-09-03 02:00:04',52,0,'0000-00-00','未接通','',79),(91,76,'2014-09-03 02:00:07',52,0,'0000-00-00','未接通','',79),(92,68,'2014-09-03 02:23:18',52,1,'2014-09-04','未接通','',79),(93,69,'2014-09-03 02:23:26',52,2,'2014-09-05','未接通','',79),(94,75,'2014-09-03 02:26:10',52,0,'0000-00-00','未接通','',79),(95,75,'2014-09-03 02:26:50',52,0,'0000-00-00','未接通','',79),(96,74,'2014-09-03 02:26:59',52,0,'0000-00-00','未接通','',79),(97,73,'2014-09-03 02:27:02',52,0,'0000-00-00','未接通','',79),(98,72,'2014-09-03 02:27:05',52,0,'0000-00-00','未接通','',79),(99,71,'2014-09-03 02:27:10',52,0,'0000-00-00','未接通','',79),(100,70,'2014-09-03 02:27:13',52,0,'0000-00-00','未接通','',79),(101,69,'2014-09-03 02:27:17',52,0,'0000-00-00','未接通','',79),(102,63,'2014-09-03 15:53:14',52,1,'0000-00-00','123','321',79),(103,77,'2014-09-04 14:26:08',52,1,'2014-09-12','未接通','sdf',79),(104,76,'2014-09-04 14:26:17',52,0,'2014-09-12','对团操课有意见','sdf',79),(105,71,'2014-09-04 14:26:26',52,2,'2014-09-30','对团操课有意见','sdf',79),(106,75,'2014-09-04 14:28:21',45,0,'0000-00-00','对服务有意见','123321',79),(107,74,'2014-09-04 14:28:27',45,1,'2014-09-24','对服务有意见','123321',79),(108,73,'2014-09-04 14:28:34',45,2,'2014-09-19','对服务有意见','123321',79),(109,72,'2014-09-04 14:28:58',45,0,'2014-09-19','价格','123321',79),(110,86,'2014-09-11 11:57:31',79,2,'2014-09-17','未接通','18：45Flow Basic Sindy，想带朋友，先自己来',119),(111,85,'2014-09-11 11:58:38',79,2,'2014-09-12','未接通','16：00Sun Salutation Sindy',119),(112,88,'2014-09-11 11:59:18',79,2,'2014-09-09','未接通','19：15Flow1 David',119),(113,90,'2014-09-12 08:52:10',79,2,'2014-09-13','未接通','17：45Yin',119),(114,92,'2014-09-13 06:05:25',79,2,'2014-09-12','未接通','20：00Flow Basic',119),(115,91,'2014-09-13 06:06:09',79,2,'2014-09-13','未接通','14：0Raja Sculpt',119),(116,93,'2014-09-13 07:30:27',79,2,'2014-09-14','未接通','17：30Yin Jacky Xu',119),(117,95,'2014-09-14 04:29:55',79,2,'2014-09-14','未接通','14：00Raja1.0Amy',119),(118,97,'2014-09-14 07:00:39',79,0,'0000-00-00','最近没有时间','在欧洲，10天回',119);
/*!40000 ALTER TABLE `yoga_mc_follow_up` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `yoga_mc_plan`
--

DROP TABLE IF EXISTS `yoga_mc_plan`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `yoga_mc_plan` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) NOT NULL,
  `brand_id` bigint(20) NOT NULL,
  `club_id` bigint(20) NOT NULL DEFAULT '0',
  `protential_plan` int(11) NOT NULL DEFAULT '0',
  `protential_value` int(11) NOT NULL DEFAULT '0',
  `cardsale_plan` int(11) NOT NULL DEFAULT '0',
  `cardsale_value` int(11) NOT NULL DEFAULT '0',
  `transform_plan` int(11) NOT NULL DEFAULT '0',
  `transform_value` int(11) NOT NULL DEFAULT '0',
  `br_plan` int(11) NOT NULL DEFAULT '0',
  `br_value` int(11) NOT NULL DEFAULT '0',
  `time` char(10) DEFAULT NULL,
  `create_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `update_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  UNIQUE KEY `uniq_time_uid` (`user_id`,`time`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `yoga_mc_plan`
--

LOCK TABLES `yoga_mc_plan` WRITE;
/*!40000 ALTER TABLE `yoga_mc_plan` DISABLE KEYS */;
INSERT INTO `yoga_mc_plan` VALUES (10,52,34,79,1000,0,10,0,100,0,1,0,'2014-09-01','2014-09-08 06:10:14','2014-09-08 06:10:14'),(11,45,34,79,10,0,0,0,0,0,0,0,'2014-09-01','2014-09-08 08:30:13','2014-09-09 15:30:01'),(12,45,34,79,6666,0,66,0,666,0,6,0,'2014-08-01','2014-09-08 08:38:54','2014-09-08 08:38:54'),(13,46,34,79,8888,0,99,0,999,0,9,0,'2014-09-01','2014-09-09 13:08:39','2014-09-09 13:08:39'),(14,51,34,79,7777,0,99,0,999,0,9,0,'2014-09-01','2014-09-09 13:08:54','2014-09-09 13:08:54'),(15,58,34,79,6667,0,99,0,999,0,9,0,'2014-09-01','2014-09-09 13:09:11','2014-09-09 13:09:11');
/*!40000 ALTER TABLE `yoga_mc_plan` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `yoga_mc_plan_total`
--

DROP TABLE IF EXISTS `yoga_mc_plan_total`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `yoga_mc_plan_total` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `brand_id` bigint(20) NOT NULL,
  `club_id` bigint(20) NOT NULL DEFAULT '0',
  `protential_plan` int(11) NOT NULL DEFAULT '0',
  `protential_value` int(11) NOT NULL DEFAULT '0',
  `cardsale_plan` int(11) NOT NULL DEFAULT '0',
  `cardsale_value` int(11) NOT NULL DEFAULT '0',
  `transform_plan` int(11) NOT NULL DEFAULT '0',
  `transform_value` int(11) NOT NULL DEFAULT '0',
  `br_plan` int(11) NOT NULL DEFAULT '0',
  `br_value` int(11) NOT NULL DEFAULT '0',
  `time` date DEFAULT NULL,
  `create_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `update_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  UNIQUE KEY `uniq_time_club` (`club_id`,`time`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `yoga_mc_plan_total`
--

LOCK TABLES `yoga_mc_plan_total` WRITE;
/*!40000 ALTER TABLE `yoga_mc_plan_total` DISABLE KEYS */;
INSERT INTO `yoga_mc_plan_total` VALUES (12,34,79,10000,0,100,0,1000,0,1,0,'2014-09-01','2014-09-08 05:44:23','2014-09-08 05:44:36'),(13,34,79,9999,0,99,0,999,0,9,0,'2014-08-01','2014-09-08 08:20:50','2014-09-08 08:20:51');
/*!40000 ALTER TABLE `yoga_mc_plan_total` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `yoga_mc_service_list`
--

DROP TABLE IF EXISTS `yoga_mc_service_list`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `yoga_mc_service_list` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `member_id` bigint(20) NOT NULL,
  `create_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `mc_id` bigint(20) NOT NULL,
  `ret` tinyint(4) NOT NULL DEFAULT '0' COMMENT '0--没意向 1--有意向 2--成功',
  `failed_reason` varchar(64) DEFAULT NULL,
  `desc` varchar(5000) NOT NULL DEFAULT '',
  `recommend_goods_id` bigint(20) NOT NULL DEFAULT '0',
  `club_id` bigint(20) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `idx_mc_id` (`mc_id`),
  KEY `idx_memeber_id` (`member_id`)
) ENGINE=InnoDB AUTO_INCREMENT=107 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `yoga_mc_service_list`
--

LOCK TABLES `yoga_mc_service_list` WRITE;
/*!40000 ALTER TABLE `yoga_mc_service_list` DISABLE KEYS */;
INSERT INTO `yoga_mc_service_list` VALUES (102,63,'2014-09-03 15:56:14',52,1,'123','321',17,79),(103,63,'2014-09-03 16:07:44',52,0,'不喜欢','就是不喜欢',18,79),(104,62,'2014-09-04 14:42:12',45,0,'xxx','',14,79),(105,62,'2014-09-04 14:42:19',45,1,'xxx','',15,79),(106,62,'2014-09-04 14:42:25',45,2,'xxx','',17,79);
/*!40000 ALTER TABLE `yoga_mc_service_list` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `yoga_member_basic`
--

DROP TABLE IF EXISTS `yoga_member_basic`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `yoga_member_basic` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `sex` varchar(10) NOT NULL DEFAULT 'male',
  `type` tinyint(4) NOT NULL DEFAULT '0',
  `phone` varchar(255) NOT NULL DEFAULT '',
  `email` varchar(255) NOT NULL DEFAULT '',
  `birthday` varchar(255) NOT NULL DEFAULT '',
  `home_phone` varchar(255) NOT NULL DEFAULT '',
  `office_phone` varchar(255) NOT NULL DEFAULT '',
  `create_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `office_name` varchar(255) NOT NULL DEFAULT '',
  `office_addr` varchar(255) NOT NULL DEFAULT '',
  `home_addr` varchar(255) NOT NULL DEFAULT '',
  `other_clubs` varchar(255) NOT NULL DEFAULT '',
  `near_club` bigint(20) NOT NULL DEFAULT '0',
  `purpose` varchar(255) NOT NULL DEFAULT '',
  `country` varchar(255) NOT NULL DEFAULT '',
  `nation` varchar(255) NOT NULL DEFAULT '',
  `job` varchar(255) NOT NULL DEFAULT '',
  `emergency_name` varchar(255) NOT NULL DEFAULT '',
  `emergency_phone` varchar(255) NOT NULL DEFAULT '',
  `certificate_type` tinyint(4) NOT NULL DEFAULT '0',
  `certificate_number` varchar(255) NOT NULL DEFAULT '',
  `marriage` tinyint(4) NOT NULL DEFAULT '0',
  `has_child` tinyint(4) NOT NULL DEFAULT '0',
  `hobby` varchar(255) NOT NULL DEFAULT '',
  `avatar` varchar(255) NOT NULL DEFAULT '',
  `how_getinfo` tinyint(4) NOT NULL DEFAULT '0',
  `desc` text NOT NULL,
  `brand_id` bigint(20) NOT NULL,
  `recommend_id` bigint(20) NOT NULL DEFAULT '0',
  `recommend_name` varchar(255) NOT NULL DEFAULT '',
  `recommend_phone` varchar(255) NOT NULL DEFAULT '',
  `channel_id` bigint(20) NOT NULL DEFAULT '0' COMMENT '0--recomment by friend2,other--from channel',
  `update_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `record_id` bigint(20) NOT NULL,
  `is_member` tinyint(4) NOT NULL DEFAULT '0',
  `member_id` bigint(20) NOT NULL DEFAULT '0',
  `mc_id` bigint(20) NOT NULL DEFAULT '0',
  `club_id` bigint(20) NOT NULL DEFAULT '0',
  `maybuy` bigint(20) NOT NULL DEFAULT '0',
  `hopeprice` double NOT NULL DEFAULT '0',
  `is_assign` tinyint(4) NOT NULL DEFAULT '0',
  `assign_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `follow_up_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `mc_service_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `join_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `add_way` tinyint(4) NOT NULL DEFAULT '0' COMMENT '0--mc 1--channel 2-reception',
  `pt_id` bigint(20) NOT NULL DEFAULT '0',
  `pt_assign_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `pt_follow_up_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  UNIQUE KEY `uniq_c_n_p` (`club_id`,`name`,`phone`),
  KEY `idx_recomment_id` (`recommend_id`),
  KEY `idx_channel` (`channel_id`),
  KEY `idx_mc_id` (`mc_id`),
  KEY `idx_r_phone` (`recommend_phone`)
) ENGINE=InnoDB AUTO_INCREMENT=100 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `yoga_member_basic`
--

LOCK TABLES `yoga_member_basic` WRITE;
/*!40000 ALTER TABLE `yoga_member_basic` DISABLE KEYS */;
INSERT INTO `yoga_member_basic` VALUES (62,'1A','female',3,'62','peterleelibo@163.com','2014-07-15','025111111','023','2014-06-23 15:21:00','zeq','男单东路','x','爱上地方',95,'5','中国','汗x','it','cc','135678太热',1,'13111111111',1,1,'rock','62.jpg',5,'士大夫阿斯顿发生地方爱上地方爱上地方爱上地方爱上地方爱上地方爱上地方爱上地方爱上地方爱上地方爱上地方爱上地方爱上地方爱上地方爱上地方爱上地方爱上地方阿斯顿发生的发生的发生的发撒的',34,0,'1111','2222',13,'2014-08-28 08:59:01',45,1,0,45,79,0,0,0,'2014-09-04 13:18:47','0000-00-00 00:00:00','2014-09-04 14:42:25','2014-08-31 16:00:00',0,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),(63,'1B','male',4,'63','','','','','2014-06-23 15:27:38','','','x','',79,'1','','','','','',1,'',0,0,'','63.jpg',1,'',34,46,'','',13,'2014-08-28 08:59:14',45,1,0,52,79,0,0,0,'2014-08-30 16:00:00','2014-09-03 15:53:16','2014-09-03 16:07:45','2014-08-31 16:00:00',0,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),(64,'1C','male',4,'64','','','','','2014-06-23 15:30:48','','','x','',79,'1','','','','','',1,'',0,0,'','',1,'',34,51,'','',13,'2014-08-28 08:59:28',45,0,0,45,79,0,0,0,'2014-09-04 09:02:19','0000-00-00 00:00:00','0000-00-00 00:00:00','2014-08-31 16:00:00',0,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),(65,'1','female',3,'65','peterleelibo@163.com','2014-06-19','025','77','2014-06-23 18:49:03','55','66','11','xxasd',109,'5','22','33','44','xx','45345',1,'00',1,1,'88','65.jpg',5,'asdf sdf',34,51,'','',13,'2014-06-24 07:45:13',45,1,0,45,79,0,0,0,'2014-09-04 02:02:45','0000-00-00 00:00:00','0000-00-00 00:00:00','2014-09-13 15:43:25',0,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),(66,'xxxx','female',4,'222222','','','','','2014-08-25 07:12:51','','','','',79,'1','','','','','',1,'',0,0,'','',1,'',34,45,'','',13,'2014-08-25 07:12:51',45,1,0,45,79,0,0,0,'2014-09-04 01:56:25','0000-00-00 00:00:00','0000-00-00 00:00:00','2014-09-08 08:29:38',0,58,'2014-09-17 08:17:59','0000-00-00 00:00:00'),(67,'1233','female',4,'2131','','','','','2014-08-25 07:14:00','','','','',79,'1','','','','','',1,'',0,0,'','',1,'',34,45,'','',13,'2014-08-25 07:14:00',45,0,0,45,79,0,0,0,'2014-09-04 01:56:25','0000-00-00 00:00:00','0000-00-00 00:00:00','2014-08-31 16:00:00',0,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),(68,'xxx','female',4,'1231','','','','','2014-08-25 07:14:53','','','','',79,'1','','','','','',1,'',0,0,'','68.jpg',1,'',34,45,'','',15,'2014-09-02 09:38:46',45,0,0,45,79,0,0,0,'2014-09-04 01:55:21','0000-00-00 00:00:00','0000-00-00 00:00:00','2014-08-31 16:00:00',0,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),(69,'xxxx','female',4,'123','','','','','2014-08-25 14:21:31','','','','',79,'1','','','','','',1,'',0,0,'','',1,'',34,0,'','',-2,'2014-08-25 14:21:31',45,0,0,45,79,0,0,0,'2014-09-04 01:55:21','2014-09-03 02:27:16','0000-00-00 00:00:00','2014-08-31 16:00:00',0,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),(70,'abcde','female',4,'13','','','','','2014-08-25 14:51:07','','','','',79,'1','','','','','',1,'',0,0,'','',1,'',34,46,'','',13,'2014-08-25 14:51:07',45,0,0,45,79,0,0,0,'2014-09-04 09:02:19','2014-09-03 02:27:13','0000-00-00 00:00:00','2014-08-31 16:00:00',0,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),(71,'李波','male',3,'18321383230','','','','','2014-08-25 16:11:05','','','','',79,'1','','','','','',1,'',0,0,'','',1,'',34,0,'','',-2,'2014-08-25 16:11:05',45,0,0,52,79,0,0,0,'2014-08-30 16:00:00','2014-09-04 14:26:26','0000-00-00 00:00:00','2014-08-31 16:00:00',0,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),(72,'213123','female',4,'xxxxxxxxx','','','','','2014-09-01 15:43:05','','','','',79,'1','','','','','',1,'',0,0,'','',1,'',34,45,'','',13,'2014-09-01 15:44:11',45,0,0,45,79,0,0,0,'2014-09-04 09:02:34','2014-09-04 14:28:58','0000-00-00 00:00:00','2014-08-31 16:00:00',0,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),(73,'Peter1','male',3,'18321383230','peterleelibo@163.com','2014-10-21','025','021','2014-09-02 07:35:52','g','nandan','hml','muyou',107,'3','cn','han','it','cw','13567',2,'000111000111',1,0,'xx','73.jpg',2,'xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx',34,0,'1A','62',14,'2014-09-02 08:05:38',45,0,0,45,79,22,100,0,'2014-09-04 09:03:26','2014-09-04 14:28:34','0000-00-00 00:00:00','2014-08-31 16:00:00',0,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),(74,'Peter2','male',3,'111','peterleelibo@163.com','2014-10-21','025','021','2014-09-02 08:08:10','g','nandan','hml','muyou',79,'1','cn','汗x','it','cw','13567',2,'000111000111',1,1,'xx','74.jpg',2,'11',34,71,'李波','18321383230',14,'2014-09-02 08:10:44',45,0,0,45,79,23,100,0,'2014-09-04 09:02:51','2014-09-04 14:28:27','0000-00-00 00:00:00','2014-08-31 16:00:00',0,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),(75,'11A','female',3,'11111','y','2014-09-22','111111','','2014-09-02 09:56:49','','','111111','',79,'1','xxbc','xhxhw','hxhxxhdj','','',1,'',0,0,'','75.jpg',1,'',34,74,'Peter2','111',13,'2014-09-02 10:22:10',52,0,0,45,79,23,111,0,'2014-09-04 09:03:10','2014-09-04 14:28:21','0000-00-00 00:00:00','2014-08-31 16:00:00',0,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),(76,'11B','female',3,'1231','','','','','2014-09-02 10:24:22','','','','',79,'1','','','','','',1,'',0,0,'','default.jpg',1,'',34,74,'Peter2','111',13,'2014-09-02 10:24:22',52,0,0,52,79,22,112,0,'2014-08-30 16:00:00','2014-09-04 14:26:17','0000-00-00 00:00:00','2014-08-31 16:00:00',0,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),(77,'94','female',4,'94','','','','','2014-09-03 17:41:07','','','','',79,'1','','','','','',1,'',0,0,'','default.jpg',1,'',34,0,'','',13,'2014-09-03 17:41:09',52,0,0,52,79,0,0,0,'2014-09-05 15:00:00','2014-09-04 14:26:08','0000-00-00 00:00:00','0000-00-00 00:00:00',0,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),(78,'郭小姐','female',3,'13524286230','','','','','2014-09-04 08:01:11','','','','',119,'5','','','','','',1,'',0,0,'','default.jpg',1,'刚搬到附近、不喜欢留联系方式，之前有接触过，还处于基础，想要yoga跟太极一起。下次安排课程',35,0,'','',25,'2014-09-04 08:01:11',75,0,0,75,119,0,0,0,'0000-00-00 00:00:00','0000-00-00 00:00:00','0000-00-00 00:00:00','0000-00-00 00:00:00',0,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),(79,'李保彦','female',4,'18019007556','','','','','2014-09-04 08:06:16','','','','',119,'1','','','','','',1,'',1,1,'','default.jpg',1,'',35,0,'','',25,'2014-09-04 08:06:16',78,0,0,78,119,0,0,0,'0000-00-00 00:00:00','0000-00-00 00:00:00','0000-00-00 00:00:00','0000-00-00 00:00:00',0,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),(80,'吴晶','female',3,'13661660557','','','','','2014-09-04 08:12:02','','','','',119,'1','','','','','',1,'',0,0,'','default.jpg',1,'',35,0,'','',26,'2014-09-04 08:12:02',78,0,0,78,119,0,0,0,'0000-00-00 00:00:00','0000-00-00 00:00:00','0000-00-00 00:00:00','0000-00-00 00:00:00',0,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),(81,'李小波','male',3,'18321383231','peterleelibo@163.com','2014-09-17','025','023','2014-09-05 13:06:01','g','nandan','hml','muyou',80,'2','cn','han','it','cc','13567',2,'000111000111',1,1,'rock','81.png',2,'笑嘻嘻详细信息详细信息详细信息',34,71,'李波','18321383230',18,'2014-09-05 13:34:27',52,0,0,52,79,22,111,0,'0000-00-00 00:00:00','0000-00-00 00:00:00','0000-00-00 00:00:00','0000-00-00 00:00:00',0,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),(82,'RBAC','female',4,'94','','','','','2014-09-05 13:34:57','','','','',79,'1','','','','','',1,'',0,0,'','default.jpg',1,'',34,73,'Peter1','18321383230',13,'2014-09-05 13:34:56',52,0,0,52,79,0,0,0,'0000-00-00 00:00:00','0000-00-00 00:00:00','0000-00-00 00:00:00','0000-00-00 00:00:00',0,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),(83,'3333','female',4,'18321383231','','','','','2014-09-05 15:46:23','','','','',79,'1','','','','','',1,'',0,0,'','default.jpg',1,'',34,73,'Peter1','18321383230',13,'2014-09-05 15:46:23',45,0,0,0,79,22,13,0,'0000-00-00 00:00:00','0000-00-00 00:00:00','0000-00-00 00:00:00','0000-00-00 00:00:00',1,58,'2014-09-13 13:31:53','2014-09-13 13:47:19'),(84,'zhangsan','female',4,'111','','','','','2014-09-09 15:29:38','','','','',79,'1','','','','','',1,'',0,0,'','default.jpg',1,'',34,74,'Peter2','111',13,'2014-09-09 15:29:38',45,0,0,45,79,0,0,0,'0000-00-00 00:00:00','0000-00-00 00:00:00','0000-00-00 00:00:00','0000-00-00 00:00:00',0,45,'2014-09-12 05:19:50','2014-09-17 08:37:19'),(85,'李艳','female',4,'13524825975','','','','','2014-09-10 05:45:05','','','','',119,'3','','','','','',1,'',0,0,'','default.jpg',1,'',35,0,'','',27,'2014-09-10 05:45:05',79,0,0,79,119,0,0,0,'0000-00-00 00:00:00','2014-09-11 11:58:38','0000-00-00 00:00:00','0000-00-00 00:00:00',0,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),(86,'Lucia He','female',4,'13636568740','','','','24075055','2014-09-11 07:14:13','','美罗大厦','','',119,'1','','','','','',1,'',0,0,'','default.jpg',1,'前台',35,0,'','',27,'2014-09-11 07:14:13',79,0,0,79,119,0,0,0,'0000-00-00 00:00:00','2014-09-11 11:57:31','0000-00-00 00:00:00','0000-00-00 00:00:00',0,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),(87,'刘云','female',4,'13524685453','','','','','2014-09-11 07:15:28','','美罗大厦','','',119,'1','','','','','',1,'',0,0,'','default.jpg',1,'',35,0,'','',27,'2014-09-11 07:15:28',79,0,0,79,119,0,0,0,'0000-00-00 00:00:00','0000-00-00 00:00:00','0000-00-00 00:00:00','0000-00-00 00:00:00',0,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),(88,'林琤琤','female',4,'13957688656','','','','','2014-09-11 07:20:26','','','','',119,'1','','','','','',1,'',1,1,'','default.jpg',1,'浙江人',35,0,'','陈曦',28,'2014-09-11 07:20:26',79,0,0,79,119,0,0,0,'0000-00-00 00:00:00','2014-09-11 11:59:18','0000-00-00 00:00:00','0000-00-00 00:00:00',0,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),(89,'123123','female',4,'12312312312','','','','','2014-09-12 02:35:45','','','','',122,'1','','','','','',1,'',0,0,'','default.jpg',1,'',44,0,'zxc','123123',0,'2014-09-12 02:35:45',83,1,0,0,122,0,4000,0,'0000-00-00 00:00:00','0000-00-00 00:00:00','0000-00-00 00:00:00','2014-09-12 08:35:48',1,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),(90,'卫青','female',4,'18930080701','','','','','2014-09-12 08:49:55','','','','',119,'1','','','','','',1,'',0,0,'','default.jpg',1,'',35,0,'单佳','',28,'2014-09-12 08:49:55',79,0,0,79,119,0,0,0,'0000-00-00 00:00:00','2014-09-12 08:52:10','0000-00-00 00:00:00','0000-00-00 00:00:00',0,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),(91,'白玉','female',4,'13999963808','','','','','2014-09-13 06:02:55','','','','',119,'1','','','','','',1,'',0,0,'','default.jpg',1,'',35,0,'杜建华','',28,'2014-09-13 06:02:55',79,0,0,79,119,0,0,0,'0000-00-00 00:00:00','2014-09-13 06:06:09','0000-00-00 00:00:00','0000-00-00 00:00:00',0,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),(92,'查丹','female',4,'18964845089','','','','','2014-09-13 06:04:47','','','','',119,'1','','','','','',1,'',0,0,'','default.jpg',1,'',35,0,'李卉','',28,'2014-09-13 06:04:47',79,0,0,79,119,0,0,0,'0000-00-00 00:00:00','2014-09-13 06:05:25','0000-00-00 00:00:00','0000-00-00 00:00:00',0,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),(93,'徐艳','female',4,'15026704207','','','','','2014-09-13 07:29:21','','','','',119,'1','','','','','',1,'',0,0,'','default.jpg',1,'',35,0,'陈文婷','',28,'2014-09-13 07:29:21',79,0,0,79,119,0,0,0,'0000-00-00 00:00:00','2014-09-13 07:30:27','0000-00-00 00:00:00','0000-00-00 00:00:00',0,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),(94,'查丹','female',4,'18964845189','','','','','2014-09-13 13:21:23','','','','',119,'1','','','','','',1,'',0,0,'','default.jpg',1,'',35,0,'李卉','',28,'2014-09-13 13:21:23',79,0,0,79,119,0,0,0,'0000-00-00 00:00:00','0000-00-00 00:00:00','0000-00-00 00:00:00','0000-00-00 00:00:00',0,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),(95,'李大莲','female',4,'13651649096','','','','','2014-09-14 04:29:10','','','','',119,'1','','','','','',1,'',0,0,'','default.jpg',1,'',35,0,'施红菊','',28,'2014-09-14 04:29:10',79,0,0,79,119,0,0,0,'0000-00-00 00:00:00','2014-09-14 04:29:55','0000-00-00 00:00:00','0000-00-00 00:00:00',0,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),(96,'梁','female',4,'18616164227','','','','','2014-09-14 06:55:48','','','','',119,'1','','','','','',1,'',0,0,'','default.jpg',1,'',35,0,'','',27,'2014-09-14 06:55:48',79,0,0,79,119,0,0,0,'0000-00-00 00:00:00','0000-00-00 00:00:00','0000-00-00 00:00:00','0000-00-00 00:00:00',0,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),(97,'郁先生','female',4,'15801758580','','','','','2014-09-14 06:59:24','','','','',119,'1','','','','','',1,'',0,0,'','default.jpg',1,'',35,0,'','',27,'2014-09-14 06:59:24',79,0,0,79,119,0,0,0,'0000-00-00 00:00:00','2014-09-14 07:00:39','0000-00-00 00:00:00','0000-00-00 00:00:00',0,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),(98,'千克1','female',4,'13111111111','','','','','2014-09-15 15:23:48','','','','',79,'1','','','','','',1,'',0,0,'','default.jpg',1,'',34,71,'李波','18321383230',13,'2014-09-15 15:23:48',52,0,0,52,79,23,12,0,'0000-00-00 00:00:00','0000-00-00 00:00:00','0000-00-00 00:00:00','0000-00-00 00:00:00',0,0,'0000-00-00 00:00:00','0000-00-00 00:00:00'),(99,'曾青青','female',4,'13402160849 ','','','','','2014-09-17 07:03:43','','','','',119,'1','','','','','',1,'',0,0,'','default.jpg',1,'',35,0,'','',35,'2014-09-17 07:03:43',72,0,0,0,119,0,0,0,'0000-00-00 00:00:00','0000-00-00 00:00:00','0000-00-00 00:00:00','0000-00-00 00:00:00',1,0,'0000-00-00 00:00:00','0000-00-00 00:00:00');
/*!40000 ALTER TABLE `yoga_member_basic` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `yoga_menu`
--

DROP TABLE IF EXISTS `yoga_menu`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `yoga_menu` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '文档ID',
  `title` varchar(50) NOT NULL DEFAULT '' COMMENT '标题',
  `pid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '上级分类ID',
  `sort` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '排序（同级有效）',
  `url` char(255) NOT NULL DEFAULT '' COMMENT '链接地址',
  `hide` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否隐藏',
  `tip` varchar(255) NOT NULL DEFAULT '' COMMENT '提示',
  `group` varchar(50) DEFAULT '' COMMENT '分组',
  `is_dev` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否仅开发者模式可见',
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '状态',
  `icon` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  KEY `pid` (`pid`),
  KEY `status` (`status`)
) ENGINE=InnoDB AUTO_INCREMENT=63 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `yoga_menu`
--

LOCK TABLES `yoga_menu` WRITE;
/*!40000 ALTER TABLE `yoga_menu` DISABLE KEYS */;
INSERT INTO `yoga_menu` VALUES (1,'品牌管理',0,1,'Brand/index',0,'','',0,1,'icon-sitemap'),(2,'店长',0,2,'Shopkeeper/index',0,'','',0,1,'icon-home'),(3,'财务',0,3,'Finance/index',0,'','',0,1,'icon-bar-chart'),(4,'前台',0,4,'Reception/index',0,'','',0,1,'icon-coffee'),(5,'水吧',0,5,'Bar/index',0,'','',0,1,'icon-beer'),(6,'收银',0,6,'Cashier/index',0,'','',0,1,'icon-money'),(7,'MC经理',0,7,'Mcmanager/index',0,'','',0,1,'icon-user-md'),(8,'MC',0,8,'Mc/index',0,'','',0,1,'icon-user'),(9,'PT经理',0,9,'Ptmanager/index',0,'','',0,1,'icon-user-md'),(10,'PT',0,10,'Pt/index',0,'','',0,1,'icon-user'),(12,'渠道经理',0,12,'Channelmanager/index',0,'','',0,1,'icon-user-md'),(13,'渠道',0,13,'Channel/index',0,'','',0,1,'icon-user'),(14,'员工管理',1,0,'Brand/Employee/index',0,'','',0,1,''),(15,'会员批量延期',1,0,'Brand/Shop/delay',0,'','',0,1,''),(16,'会籍合同查询',1,0,'Brand/Mcontract/index',0,'','',0,1,''),(17,'基础设置',1,0,'Brand/Shop/config',0,'','',0,1,''),(18,'稽核',1,0,'Brand/Review/index',0,'','',0,1,''),(19,'会所信息管理',17,0,'Brand/Shop/clubsinfo',0,'','',0,1,'icon-leaf'),(20,'高峰时段设置',17,0,'Brand/Shop/peak',0,'','',0,1,'icon-leaf'),(21,'商品管理',17,0,'Brand/Goods/index',0,'','',0,1,'icon-leaf'),(22,'PT课程设置',17,0,'Brand/Ptclass/index',0,'','',0,1,'icon-leaf'),(23,'卡种设置',17,0,'Brand/Cardtype/index',0,'','',0,1,'icon-leaf'),(24,'系统设置',17,0,'Brand/Systemconfig/index',0,'','',0,1,'icon-leaf'),(25,'合同修改审批',18,0,'Brand/Review/contract',0,'','',0,1,'icon-leaf'),(26,'合同金额异常审批',18,0,'Brand/Review/contractexception',0,'','',0,1,'icon-leaf'),(27,'退会申请',18,0,'Brand/Review/departure',0,'','',0,1,'icon-leaf'),(28,'消费明细',18,0,'Brand/Review/consume',0,'','',0,1,'icon-leaf'),(29,'员工管理',2,0,'Shopkeeper/Employee/index',0,'','',0,0,''),(30,'渠道计划',12,0,'Channelmanager/Plan/index',0,'','',0,0,''),(31,'渠道管理',12,0,'Channelmanager/Channel/index',0,'','',0,0,''),(32,'跟进记录',13,0,'Channel/Visit/index',0,'','',0,0,''),(33,'来访登记',4,0,'Reception/Visit/index',0,'','',0,0,''),(34,'增加潜在客户',13,0,'Channel/Visitn/index',0,'','',0,0,''),(35,'渠道统计',12,0,'Channelmanager/Statistics/index',0,'','',0,0,''),(36,'渠道统计',13,0,'Channel/Statistics/index',0,'','',0,0,''),(37,'会员入会',6,0,'Cashier/Member/index',0,'','',0,0,''),(38,'会籍合同管理',6,0,'Cashier/Contract/index',0,'','',0,0,''),(39,'PT合同管理',6,0,'Cashier/Ptcontract/index',0,'','',0,0,''),(40,'卡种查询',6,0,'Cashier/Cardtype/index',0,'','',0,0,''),(41,'消费明细',6,0,'Cashier/Consume/index',0,'','',0,0,''),(42,'增加潜客',8,0,'Mc/Visit/index',0,'','',0,0,''),(43,'客户管理',13,0,'Channel/Visitn/myallmemberlist',0,'','',0,0,''),(44,'会员卡管理',4,0,'Reception/Cardmanage/index',0,'','',0,0,''),(45,'充值卡管理',5,0,'Bar/Recharge/index',0,'','',0,0,''),(46,'商品销售',5,0,'Bar/Goods/index',0,'','',0,0,''),(47,'卖品流水',5,0,'Bar/Goods/list',0,'','',0,0,''),(48,'我的潜客',8,0,'Mc/Visit/mynotmemberlist',0,'','',0,0,''),(49,'销售跟进',8,0,'Mc/Manage/sale',0,'','',0,0,''),(50,'我的预约',8,0,'Mc/Manage/myappoint',0,'','',0,0,''),(51,'卡种查询',8,0,'Mc/Cardtype/index',0,'','',0,0,''),(52,'我的会员',8,0,'Mc/Visit/myismemberlist',0,'','',0,0,''),(53,'会员跟进',8,0,'Mc/Manage/service',0,'','',0,0,''),(54,'潜客管理',7,0,'Mcmanager/Member/notmember',0,'','',0,0,''),(55,'会员管理',7,0,'Mcmanager/Member/ismember',0,'','',0,0,''),(56,'MC销售跟进',7,0,'Mcmanager/Mcsale/followuplist',0,'','',0,0,''),(57,'MC会员跟进',7,0,'Mcmanager/Mcsale/servicelist',0,'','',0,0,''),(58,'MC业绩统计',7,0,'Mcmanager/Mcstatistics/index',0,'','',0,0,''),(59,'MC计划',7,0,'Mcmanager/Plan/index',0,'','',0,0,''),(60,'英雄榜',8,0,'Mc/List/index',0,'','',0,0,''),(61,'会员管理',9,0,'Ptmanager/Member/index',0,'','',0,0,''),(62,'销售跟进',10,0,'Pt/Sale/index',0,'','',0,0,'');
/*!40000 ALTER TABLE `yoga_menu` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `yoga_peak_time`
--

DROP TABLE IF EXISTS `yoga_peak_time`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `yoga_peak_time` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `club_id` varchar(3000) NOT NULL DEFAULT '',
  `create_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `update_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `peak_name` varchar(255) NOT NULL DEFAULT '',
  `peak_time` varchar(1024) NOT NULL DEFAULT '',
  `brand_id` bigint(20) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_club_id` (`club_id`(255)),
  KEY `idx_brand_id` (`brand_id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `yoga_peak_time`
--

LOCK TABLES `yoga_peak_time` WRITE;
/*!40000 ALTER TABLE `yoga_peak_time` DISABLE KEYS */;
INSERT INTO `yoga_peak_time` VALUES (6,'89','2014-06-17 09:12:59','2014-06-17 09:12:59','xxxx','[{\"week\":\"1\",\"start_time\":\"00:00\",\"end_time\":\"00:00\"}]',34),(9,'109','2014-08-20 10:31:41','2014-08-20 10:31:41','test','[{\"week\":\"1\",\"start_time\":\"02:00\",\"end_time\":\"07:00\"},{\"week\":\"6\",\"start_time\":\"04:00\",\"end_time\":\"04:00\"}]',34),(10,'108','2014-08-28 12:20:01','2014-08-28 12:20:01','xxx','[{\"week\":\"1\",\"start_time\":\"00:00\",\"end_time\":\"00:00\"},{\"week\":\"1\",\"start_time\":\"00:00\",\"end_time\":\"00:00\"},{\"week\":\"1\",\"start_time\":\"00:00\",\"end_time\":\"00:00\"},{\"week\":\"1\",\"start_time\":\"00:00\",\"end_time\":\"00:00\"}]',34),(11,'118','2014-08-31 13:21:22','2014-08-31 13:21:23','下班高峰期','[{\"week\":\"1\",\"start_time\":\"05:00\",\"end_time\":\"09:00\"},{\"week\":\"1\",\"start_time\":\"08:00\",\"end_time\":\"09:00\"},{\"week\":\"6\",\"start_time\":\"08:00\",\"end_time\":\"08:00\"}]',34),(12,'122','2014-09-12 02:42:48','2014-09-12 02:42:48','徐家汇高峰时段','[{\"week\":\"1\",\"start_time\":\"16:00\",\"end_time\":\"21:00\"},{\"week\":\"2\",\"start_time\":\"16:00\",\"end_time\":\"21:00\"},{\"week\":\"3\",\"start_time\":\"16:00\",\"end_time\":\"21:00\"},{\"week\":\"4\",\"start_time\":\"16:00\",\"end_time\":\"21:00\"},{\"week\":\"5\",\"start_time\":\"16:00\",\"end_time\":\"21:00\"},{\"week\":\"6\",\"start_time\":\"09:00\",\"end_time\":\"21:00\"},{\"week\":\"7\",\"start_time\":\"09:00\",\"end_time\":\"21:00\"}]',44);
/*!40000 ALTER TABLE `yoga_peak_time` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `yoga_pt_class`
--

DROP TABLE IF EXISTS `yoga_pt_class`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `yoga_pt_class` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `brand_id` bigint(20) NOT NULL,
  `description` text NOT NULL,
  `price` double NOT NULL DEFAULT '0',
  `create_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `update_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `time` int(11) NOT NULL DEFAULT '30',
  PRIMARY KEY (`id`),
  KEY `idx_brand_id` (`brand_id`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `yoga_pt_class`
--

LOCK TABLES `yoga_pt_class` WRITE;
/*!40000 ALTER TABLE `yoga_pt_class` DISABLE KEYS */;
INSERT INTO `yoga_pt_class` VALUES (17,'123',34,'xx',11,'2014-06-20 16:00:38','2014-06-20 16:00:38',1,30),(18,'ptxx',34,'aa',122,'2014-06-20 16:01:34','2014-06-20 16:06:50',0,301),(19,'22',34,'',33,'2014-06-20 16:10:04','2014-08-31 13:26:52',1,22),(20,'NEWPT1',34,'xx',998,'2014-08-31 13:26:01','2014-08-31 13:26:32',1,45),(21,'瑜伽私教',44,'很好的课',600,'2014-09-12 09:10:47','2014-09-12 09:10:47',1,60),(22,'健身私教',44,'好',400,'2014-09-12 09:12:16','2014-09-12 09:12:16',1,60);
/*!40000 ALTER TABLE `yoga_pt_class` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `yoga_pt_club`
--

DROP TABLE IF EXISTS `yoga_pt_club`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `yoga_pt_club` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `pt_class_id` bigint(20) NOT NULL,
  `club_id` bigint(20) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_pt_id` (`pt_class_id`),
  KEY `idx_club` (`club_id`)
) ENGINE=InnoDB AUTO_INCREMENT=102 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `yoga_pt_club`
--

LOCK TABLES `yoga_pt_club` WRITE;
/*!40000 ALTER TABLE `yoga_pt_club` DISABLE KEYS */;
INSERT INTO `yoga_pt_club` VALUES (85,17,80),(88,18,113),(89,18,114),(93,20,79),(94,20,80),(97,19,79),(98,19,80),(99,19,89),(100,21,122),(101,22,122);
/*!40000 ALTER TABLE `yoga_pt_club` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `yoga_pt_follow_up`
--

DROP TABLE IF EXISTS `yoga_pt_follow_up`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `yoga_pt_follow_up` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `member_id` bigint(20) NOT NULL,
  `create_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `pt_id` bigint(20) NOT NULL,
  `ret` tinyint(4) NOT NULL DEFAULT '0' COMMENT '0--失败 1--success',
  `appoint_time` date NOT NULL DEFAULT '0000-00-00',
  `failed_reason` varchar(64) DEFAULT NULL,
  `desc` varchar(5000) NOT NULL DEFAULT '',
  `pt_class_id` bigint(20) NOT NULL DEFAULT '0',
  `pt_class_number` int(11) NOT NULL DEFAULT '0',
  `club_id` bigint(20) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `idx_pt_id` (`pt_id`),
  KEY `idx_memeber_id` (`member_id`),
  KEY `idx_appoint_time` (`appoint_time`)
) ENGINE=InnoDB AUTO_INCREMENT=122 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `yoga_pt_follow_up`
--

LOCK TABLES `yoga_pt_follow_up` WRITE;
/*!40000 ALTER TABLE `yoga_pt_follow_up` DISABLE KEYS */;
INSERT INTO `yoga_pt_follow_up` VALUES (115,83,'2014-09-13 13:37:09',58,0,'0000-00-00','未接通','',20,0,79),(116,83,'2014-09-13 13:37:59',58,1,'2014-09-14','未接通','1231',19,0,79),(117,83,'2014-09-13 13:47:07',58,0,'0000-00-00','不感兴趣','',20,0,79),(118,83,'2014-09-13 13:47:19',58,1,'2014-09-17','不感兴趣','',20,0,79),(119,83,'2014-09-13 13:47:19',58,1,'2014-09-17','不感兴趣','',20,0,79),(120,84,'2014-09-17 08:33:44',45,1,'2014-09-02','未接通','',19,0,79),(121,84,'2014-09-17 08:37:19',45,1,'0000-00-00','未接通','',19,0,79);
/*!40000 ALTER TABLE `yoga_pt_follow_up` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `yoga_recharge_history`
--

DROP TABLE IF EXISTS `yoga_recharge_history`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `yoga_recharge_history` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `card_id` bigint(20) NOT NULL,
  `value` double NOT NULL DEFAULT '0',
  `create_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `description` text NOT NULL,
  `record_id` bigint(20) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_card_id` (`card_id`)
) ENGINE=InnoDB AUTO_INCREMENT=82 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `yoga_recharge_history`
--

LOCK TABLES `yoga_recharge_history` WRITE;
/*!40000 ALTER TABLE `yoga_recharge_history` DISABLE KEYS */;
INSERT INTO `yoga_recharge_history` VALUES (76,75,1,'2014-08-31 10:36:57','',51),(77,75,2,'2014-08-31 10:36:57','',51),(78,75,1,'2014-08-31 10:36:57','',51),(79,75,111,'2014-08-31 10:36:57','',51),(80,75,999,'2014-08-31 10:36:57','',51),(81,74,100,'2014-09-04 05:40:55','',53);
/*!40000 ALTER TABLE `yoga_recharge_history` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `yoga_review`
--

DROP TABLE IF EXISTS `yoga_review`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `yoga_review` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `club_id` bigint(20) NOT NULL,
  `brand_id` bigint(20) NOT NULL,
  `extension` text,
  `type` int(11) NOT NULL DEFAULT '0',
  `result` tinyint(4) NOT NULL DEFAULT '0',
  `note` text,
  `status` tinyint(4) NOT NULL DEFAULT '0',
  `create_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `update_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `reason` varchar(255) NOT NULL DEFAULT '',
  `record_id` bigint(20) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `idx_brand_id` (`brand_id`)
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `yoga_review`
--

LOCK TABLES `yoga_review` WRITE;
/*!40000 ALTER TABLE `yoga_review` DISABLE KEYS */;
INSERT INTO `yoga_review` VALUES (21,79,34,'{\"id\":\"88\",\"total_num\":\"71\",\"used_num\":\"0\",\"contract_number\":\"201409132235021416\",\"type\":\"0\",\"card_type_id\":\"22\",\"card_id\":\"94\",\"member_id\":\"65\",\"start_time\":\"2014-09-13\",\"end_time\":\"2015-09-24\",\"present_day\":\"11\",\"present_num\":\"11\",\"price\":\"1\",\"payed\":\"0\",\"brand_id\":\"34\",\"description\":\"\",\"record_id\":\"45\",\"create_time\":\"2014-09-13 22:35:02\",\"update_time\":\"2014-09-13 22:35:02\",\"status\":\"1\",\"invalid\":\"1\",\"sale_club_id\":\"79\",\"mc_id\":\"0\",\"c_id\":\"0\",\"active_type\":\"0\",\"contract_type\":\"0\",\"club_id\":\"0\"}',0,2,'',2,'2014-09-13 14:35:03','0000-00-00 00:00:00','新办卡赠送次数过多新办卡赠送天数过多新办卡收银过低',45),(22,79,34,'{\"id\":\"89\",\"total_num\":\"60\",\"used_num\":\"0\",\"contract_number\":\"201409132343242346\",\"type\":\"0\",\"card_type_id\":\"22\",\"card_id\":\"95\",\"member_id\":\"65\",\"start_time\":\"2014-09-13\",\"end_time\":\"2015-09-24\",\"present_day\":\"11\",\"present_num\":\"0\",\"price\":\"2000\",\"payed\":\"0\",\"brand_id\":\"34\",\"description\":\"\",\"record_id\":\"45\",\"create_time\":\"2014-09-13 23:43:24\",\"update_time\":\"2014-09-13 23:43:24\",\"status\":\"1\",\"invalid\":\"1\",\"sale_club_id\":\"79\",\"mc_id\":\"0\",\"c_id\":\"0\",\"active_type\":\"0\",\"contract_type\":\"0\",\"club_id\":\"0\"}',0,2,'',2,'2014-09-13 15:43:25','0000-00-00 00:00:00','新办卡赠送天数过多',45),(23,79,34,'{\"id\":\"63\",\"total_num\":\"1\",\"used_num\":\"0\",\"contract_number\":\"201408292125342149\",\"type\":\"0\",\"card_type_id\":\"25\",\"card_id\":\"75\",\"member_id\":\"64\",\"start_time\":\"2014-08-29\",\"end_time\":\"2019-01-11\",\"present_day\":\"0\",\"present_num\":\"0\",\"price\":\"11110\",\"payed\":\"1\",\"brand_id\":\"34\",\"description\":\"\",\"record_id\":\"45\",\"create_time\":\"2014-08-29 21:25:34\",\"update_time\":\"2014-08-29 21:30:52\",\"status\":\"3\",\"invalid\":\"1\",\"sale_club_id\":\"79\",\"mc_id\":\"52\",\"c_id\":\"0\",\"active_type\":\"0\",\"contract_type\":\"0\",\"club_id\":\"0\"}',0,2,'',2,'2014-09-13 17:01:40','0000-00-00 00:00:00','合同续会续会收银过低',45),(24,79,34,'{\"id\":\"88\",\"total_num\":\"1\",\"used_num\":\"0\",\"contract_number\":\"201409132235021416\",\"type\":\"0\",\"card_type_id\":\"25\",\"card_id\":\"94\",\"member_id\":\"65\",\"start_time\":\"2014-09-13\",\"end_time\":\"2015-09-13\",\"present_day\":\"0\",\"present_num\":\"0\",\"price\":\"11111\",\"payed\":\"0\",\"brand_id\":\"34\",\"description\":\"\",\"record_id\":\"45\",\"create_time\":\"2014-09-13 22:35:02\",\"update_time\":\"2014-09-14 01:02:31\",\"status\":\"3\",\"invalid\":\"1\",\"sale_club_id\":\"79\",\"mc_id\":\"0\",\"c_id\":\"0\",\"active_type\":\"0\",\"contract_type\":\"0\",\"club_id\":\"0\"}',0,2,'',2,'2014-09-13 17:02:31','0000-00-00 00:00:00','合同升级升级收银过低',45),(26,79,34,'{\"id\":\"89\",\"total_num\":\"60\",\"used_num\":\"0\",\"contract_number\":\"201409132343242346\",\"type\":\"0\",\"card_type_id\":\"22\",\"card_id\":\"80\",\"member_id\":\"65\",\"start_time\":\"2014-09-13\",\"end_time\":\"2015-09-24\",\"present_day\":\"11\",\"present_num\":\"0\",\"price\":\"2000\",\"payed\":\"0\",\"brand_id\":\"34\",\"description\":\"\",\"record_id\":\"45\",\"create_time\":\"2014-09-13 23:43:24\",\"update_time\":\"2014-09-13 23:43:24\",\"status\":4,\"invalid\":\"1\",\"sale_club_id\":\"79\",\"mc_id\":\"0\",\"c_id\":\"0\",\"active_type\":\"0\",\"contract_type\":\"0\",\"club_id\":\"0\"}',0,2,'',2,'2014-09-13 17:21:54','0000-00-00 00:00:00','合同转让',45);
/*!40000 ALTER TABLE `yoga_review` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `yoga_sys_config`
--

DROP TABLE IF EXISTS `yoga_sys_config`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `yoga_sys_config` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `default_role` varchar(5000) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `yoga_sys_config`
--

LOCK TABLES `yoga_sys_config` WRITE;
/*!40000 ALTER TABLE `yoga_sys_config` DISABLE KEYS */;
INSERT INTO `yoga_sys_config` VALUES (1,'[\"reception\",\"bar\",\"cashier\"]');
/*!40000 ALTER TABLE `yoga_sys_config` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `yoga_sys_user`
--

DROP TABLE IF EXISTS `yoga_sys_user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `yoga_sys_user` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `create_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `last_login_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `last_login_ip` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  UNIQUE KEY `uniq_username` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `yoga_sys_user`
--

LOCK TABLES `yoga_sys_user` WRITE;
/*!40000 ALTER TABLE `yoga_sys_user` DISABLE KEYS */;
INSERT INTO `yoga_sys_user` VALUES (18,'admin','f9f793663056c922a7438d875f2f043f','2014-08-10 14:08:51','2014-09-05 03:29:10','116.226.60.234'),(20,'admin2','f9f793663056c922a7438d875f2f043f','2014-08-10 14:17:26','2014-08-10 14:17:26','127.0.0.1'),(21,'admin3','68670d70ddcd625ef9f3b188c614c852','2014-09-03 06:34:54','2014-09-03 06:49:52','116.226.40.242');
/*!40000 ALTER TABLE `yoga_sys_user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `yoga_test`
--

DROP TABLE IF EXISTS `yoga_test`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `yoga_test` (
  `username` varchar(255) NOT NULL,
  `xx` varchar(255) NOT NULL,
  PRIMARY KEY (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `yoga_test`
--

LOCK TABLES `yoga_test` WRITE;
/*!40000 ALTER TABLE `yoga_test` DISABLE KEYS */;
/*!40000 ALTER TABLE `yoga_test` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `yoga_user`
--

DROP TABLE IF EXISTS `yoga_user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `yoga_user` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `create_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `last_login_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `last_login_ip` varchar(255) NOT NULL DEFAULT '',
  `brand_id` bigint(20) NOT NULL,
  `is_brand` tinyint(4) NOT NULL DEFAULT '0',
  `club_id` bigint(20) NOT NULL DEFAULT '0',
  `update_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  UNIQUE KEY `uniq_username` (`username`),
  KEY `idx_is_brand` (`is_brand`)
) ENGINE=InnoDB AUTO_INCREMENT=95 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `yoga_user`
--

LOCK TABLES `yoga_user` WRITE;
/*!40000 ALTER TABLE `yoga_user` DISABLE KEYS */;
INSERT INTO `yoga_user` VALUES (45,'brand1','f9f793663056c922a7438d875f2f043f','2014-08-18 02:37:46','2014-09-17 09:37:13','218.80.198.230',34,34,79,'0000-00-00 00:00:00'),(46,'xxxxx','c78b6663d47cfbdb4d65ea51c104044e','2014-08-17 16:00:00','2014-06-24 05:28:36','127.0.0.1',34,0,79,'2014-08-22 01:08:46'),(51,'adfasdf','c78b6663d47cfbdb4d65ea51c104044e','2014-08-22 01:57:59','2014-08-27 07:16:59','127.0.0.1',34,0,79,'2014-08-22 01:57:59'),(52,'mc11','f9f793663056c922a7438d875f2f043f','2014-08-25 07:53:18','2014-09-17 09:31:59','218.80.198.230',34,0,79,'2014-08-25 07:53:18'),(53,'rajayoga','f9f793663056c922a7438d875f2f043f','2014-08-31 11:16:12','2014-09-16 09:03:36','116.226.47.253',35,35,0,'0000-00-00 00:00:00'),(58,'Test1','f9f793663056c922a7438d875f2f043f','2014-08-31 14:19:40','2014-09-13 13:35:18','127.0.0.1',34,0,79,'2014-08-31 14:19:40'),(67,'zoexu','7719ef5b8eecb5afbfdcda8458b6ce0b','2014-09-03 01:35:24','2014-09-15 14:37:40','116.237.100.64',35,0,119,'2014-09-03 01:35:24'),(68,'Lawlance','7719ef5b8eecb5afbfdcda8458b6ce0b','2014-09-02 16:00:00','2014-09-05 09:26:46','116.226.60.234',35,0,119,'2014-09-03 01:37:25'),(69,'xuhuichanel','a2a49add54ef4ecccdcf385e1a1f4964','2014-09-03 01:44:34','2014-09-15 15:15:43','116.237.100.64',35,0,119,'2014-09-03 01:44:34'),(70,'jordan.shu','f9f793663056c922a7438d875f2f043f','2014-09-03 06:12:53','2014-09-12 02:23:16','116.226.66.174',44,44,0,'0000-00-00 00:00:00'),(72,'xuhuimkt','85650fd5a4f6bace4adef616a5774fba','2014-09-02 16:00:00','2014-09-17 07:02:42','116.226.56.97',35,0,119,'2014-09-03 11:56:53'),(75,'Angela','7719ef5b8eecb5afbfdcda8458b6ce0b','2014-09-03 12:16:09','2014-09-12 09:46:14','223.104.5.6',35,0,119,'2014-09-03 12:16:09'),(76,'qiantai1','7719ef5b8eecb5afbfdcda8458b6ce0b','2014-09-03 12:24:44','2014-09-15 15:16:40','116.237.100.64',35,0,119,'2014-09-03 12:24:44'),(77,'Kevin','7719ef5b8eecb5afbfdcda8458b6ce0b','2014-09-03 13:10:31','0000-00-00 00:00:00','',35,0,119,'2014-09-03 13:10:31'),(78,'Daisiy','7719ef5b8eecb5afbfdcda8458b6ce0b','2014-09-03 13:17:16','2014-09-12 08:00:26','116.226.54.129',35,0,119,'2014-09-03 13:17:16'),(79,'Dido','7719ef5b8eecb5afbfdcda8458b6ce0b','2014-09-03 13:20:48','2014-09-15 10:15:31','116.226.54.129',35,0,119,'2014-09-03 13:20:48'),(80,'Andy','7719ef5b8eecb5afbfdcda8458b6ce0b','2014-09-03 13:21:20','2014-09-09 06:42:57','116.226.64.60',35,0,119,'2014-09-03 13:21:20'),(81,'Lily','7719ef5b8eecb5afbfdcda8458b6ce0b','2014-09-03 13:22:23','2014-09-04 08:16:10','116.226.54.129',35,0,119,'2014-09-03 13:22:23'),(82,'huarry','f9f793663056c922a7438d875f2f043f','2014-09-12 02:25:50','2014-09-12 02:36:49','116.226.66.174',44,0,122,'2014-09-12 02:25:50'),(83,'harry','f9f793663056c922a7438d875f2f043f','2014-09-12 02:31:39','2014-09-12 02:34:08','116.226.66.174',44,0,122,'2014-09-12 02:31:39'),(84,'rainjin','7719ef5b8eecb5afbfdcda8458b6ce0b','2014-09-15 02:35:39','0000-00-00 00:00:00','',35,0,120,'2014-09-15 02:35:39'),(85,'ansenlin','7719ef5b8eecb5afbfdcda8458b6ce0b','2014-09-15 02:38:02','0000-00-00 00:00:00','',35,0,121,'2014-09-15 02:38:02'),(86,'wandamkt','85650fd5a4f6bace4adef616a5774fba','2014-09-15 03:30:31','0000-00-00 00:00:00','',35,0,120,'2014-09-15 03:30:31'),(87,'wandachanel','a2a49add54ef4ecccdcf385e1a1f4964','2014-09-15 03:31:29','2014-09-16 11:36:09','116.226.47.253',35,0,120,'2014-09-15 03:31:29'),(89,'wanlimkt','85650fd5a4f6bace4adef616a5774fba','2014-09-14 16:00:00','0000-00-00 00:00:00','',35,0,121,'2014-09-15 03:33:13'),(90,'wanlichanel','a2a49add54ef4ecccdcf385e1a1f4964','2014-09-15 03:54:26','2014-09-16 11:39:49','116.226.47.253',35,0,121,'2014-09-15 03:54:26'),(91,'peter','f9f793663056c922a7438d875f2f043f','2014-09-15 10:02:07','2014-09-15 10:02:25','127.0.0.1',35,0,119,'2014-09-15 10:02:06'),(92,'xuhuiclub','7719ef5b8eecb5afbfdcda8458b6ce0b','2014-09-14 16:00:00','0000-00-00 00:00:00','',35,0,119,'2014-09-15 15:06:32'),(93,'wandaclub','7719ef5b8eecb5afbfdcda8458b6ce0b','2014-09-14 16:00:00','0000-00-00 00:00:00','',35,0,120,'2014-09-15 15:07:10'),(94,'wanliclub','7719ef5b8eecb5afbfdcda8458b6ce0b','2014-09-14 16:00:00','0000-00-00 00:00:00','',35,0,121,'2014-09-15 15:07:41');
/*!40000 ALTER TABLE `yoga_user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `yoga_user_extension`
--

DROP TABLE IF EXISTS `yoga_user_extension`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `yoga_user_extension` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `name_cn` varchar(255) NOT NULL,
  `name_en` varchar(255) NOT NULL,
  `create_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `sex` varchar(10) NOT NULL DEFAULT 'male',
  `marriage` tinyint(4) NOT NULL DEFAULT '0',
  `identity_card` varchar(20) NOT NULL DEFAULT '',
  `birthday` varchar(255) NOT NULL DEFAULT '',
  `phone` varchar(255) NOT NULL DEFAULT '',
  `email` varchar(255) NOT NULL DEFAULT '',
  `work_status` varchar(255) NOT NULL DEFAULT '',
  `work_in_time` varchar(25) NOT NULL DEFAULT '',
  `work_out_time` varchar(25) NOT NULL DEFAULT '',
  `bank_card` varchar(255) NOT NULL DEFAULT '',
  `level` tinyint(4) NOT NULL DEFAULT '1',
  `coat_size` varchar(10) NOT NULL DEFAULT '',
  `trousers_size` varchar(10) NOT NULL DEFAULT '',
  `shoe_size` varchar(10) NOT NULL DEFAULT '',
  `school` varchar(255) NOT NULL DEFAULT '',
  `major` varchar(255) NOT NULL DEFAULT '',
  `graduate_time` varchar(25) NOT NULL DEFAULT '',
  `education` varchar(10) NOT NULL DEFAULT '',
  `origin` varchar(255) NOT NULL DEFAULT '',
  `hukou` varchar(255) NOT NULL DEFAULT '',
  `address` varchar(255) NOT NULL DEFAULT '',
  `desc` text NOT NULL,
  `avatar` varchar(255) NOT NULL DEFAULT '',
  `train` varchar(255) NOT NULL DEFAULT '',
  `update_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=95 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `yoga_user_extension`
--

LOCK TABLES `yoga_user_extension` WRITE;
/*!40000 ALTER TABLE `yoga_user_extension` DISABLE KEYS */;
INSERT INTO `yoga_user_extension` VALUES (45,'Brand1','Brand1','2014-09-01 03:34:27','male',0,'','','','','','','','',1,'','','','','','','','','','','','default.jpg','','0000-00-00 00:00:00'),(46,'123123','xx','2014-08-17 16:00:00','female',0,'','','11111','','0','1900-12-06','1900-12-20','',1,'','','','','','1900-12-27','0','','','','','46.jpg','','2014-06-19 17:44:11'),(51,'下sadf','1sdf','2014-08-22 01:57:59','male',0,'','','','','0','0000-00-00','0000-00-00','',1,'','','','','','0000-00-00','0','','','','','51.jpg','','2014-08-22 01:57:59'),(52,'MC','MC','2014-08-25 07:53:18','male',0,'','','','','0','0000-00-00','0000-00-00','',1,'','','','','','0000-00-00','0','','','','','default.jpg','','2014-08-25 07:53:18'),(58,'test1','xxx1','2014-08-31 14:19:40','male',0,'','','','','0','','','',1,'','','','','','','0','','','','','default.jpg','','2014-08-31 14:19:40'),(66,'tB','tB','2014-09-01 03:37:46','male',0,'','','','','','','','',1,'','','','','','','','','','','','','','0000-00-00 00:00:00'),(67,'徐晓锦','Zoe','2014-09-03 01:35:24','female',0,'','','','','0','','','',1,'','','','','','','0','','','','','default.jpg','','2014-09-03 01:35:24'),(68,'张超','Lawlance','2014-09-02 16:00:00','male',0,'','','','','0','','','',1,'','','','','','','0','','','','','default.jpg','','2014-09-03 01:37:25'),(69,'徐汇渠道','xuhuichanel','2014-09-03 01:44:34','male',0,'','','','','0','','','',1,'','','','','','','0','','','','','default.jpg','','2014-09-03 01:44:34'),(70,'Yoga  Retreat','Yoga  Retreat','2014-09-03 06:12:53','male',0,'','','','','','','','',1,'','','','','','','','','','','','','','0000-00-00 00:00:00'),(71,'brand2','brand2','2014-09-03 06:56:16','male',0,'','','','','','','','',1,'','','','','','','','','','','','','','0000-00-00 00:00:00'),(72,'徐汇市场','xuhuimkt','2014-09-02 16:00:00','female',0,'','','','','0','','','',1,'','','','','','','0','','','','','default.jpg','','2014-09-03 11:56:53'),(75,'杜慧敏','Angela','2014-09-03 12:16:09','female',0,'','','','','0','','','',1,'','','','','','','0','','','','','default.jpg','','2014-09-03 12:16:09'),(76,'前台一','qiantai1','2014-09-03 12:24:44','female',0,'','','','','0','','','',1,'','','','','','','0','','','','','default.jpg','','2014-09-03 12:24:44'),(77,'陆慧康','Kevin','2014-09-03 13:10:31','male',0,'','','','','0','','','',1,'','','','','','','0','','','','','default.jpg','','2014-09-03 13:10:31'),(78,'林筱','Daisiy','2014-09-03 13:17:16','female',0,'','','','','0','','','',1,'','','','','','','0','','','','','default.jpg','','2014-09-03 13:17:16'),(79,'邓柳','Dido','2014-09-03 13:20:48','female',0,'','','','','0','','','',1,'','','','','','','0','','','','','default.jpg','','2014-09-03 13:20:48'),(80,'付明','Andy','2014-09-03 13:21:20','male',0,'','','','','0','','','',1,'','','','','','','0','','','','','default.jpg','','2014-09-03 13:21:20'),(81,'万玉凤','Lily','2014-09-03 13:22:23','female',0,'','','','','0','','','',1,'','','','','','','0','','','','','default.jpg','','2014-09-03 13:22:23'),(82,'晚景','huarry','2014-09-12 02:25:50','male',1,'262330199823064053','','13162220453','jordan.shu@rajayoga.com.cn','0','','','',1,'','','','','','','0','','','','','default.jpg','','2014-09-12 02:25:50'),(83,'高强','jordan','2014-09-12 02:31:39','male',0,'262330199823064050','','12345','shugao2009@163.com','0','','','',1,'','','','','','','0','','','','','default.jpg','','2014-09-12 02:31:39'),(84,'金睿豪','Rain','2014-09-15 02:35:39','male',0,'','','','','0','','','',1,'','','','','','','0','','','','','default.jpg','','2014-09-15 02:35:39'),(85,'林晓峰','Ansen','2014-09-15 02:38:02','male',0,'','','','','0','','','',1,'','','','','','','0','','','','','default.jpg','','2014-09-15 02:38:02'),(86,'万达市场','wandamkt','2014-09-15 03:30:31','male',0,'','','','','0','','','',1,'','','','','','','0','','','','','default.jpg','','2014-09-15 03:30:31'),(87,'万达渠道','wandachanel','2014-09-15 03:31:29','male',0,'','','','','0','','','',1,'','','','','','','0','','','','','default.jpg','','2014-09-15 03:31:29'),(89,'万里市场','wanlimkt','2014-09-14 16:00:00','male',0,'','','','','0','','','',1,'','','','','','','0','','','','','default.jpg','','2014-09-15 03:33:13'),(90,'万里渠道','wanlichanel','2014-09-15 03:54:26','male',0,'','','','','0','','','',1,'','','','','','','0','','','','','default.jpg','','2014-09-15 03:54:26'),(91,'李波','Peter','2014-09-15 10:02:07','male',0,'','','','','0','','','',1,'','','','','','','0','','','','','default.jpg','','2014-09-15 10:02:06'),(92,'徐汇门店渠道','xuhuiclub','2014-09-14 16:00:00','male',0,'','','','','0','','','',1,'','','','','','','0','','','','','default.jpg','','2014-09-15 15:06:32'),(93,'万达门店渠道','wandaclub','2014-09-14 16:00:00','male',0,'','','','','0','','','',1,'','','','','','','0','','','','','default.jpg','','2014-09-15 15:07:10'),(94,'万里门店渠道','wanliclub','2014-09-14 16:00:00','male',0,'','','','','0','','','',1,'','','','','','','0','','','','','default.jpg','','2014-09-15 15:07:41');
/*!40000 ALTER TABLE `yoga_user_extension` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2014-09-17 17:55:57
