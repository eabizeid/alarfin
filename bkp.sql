-- MySQL dump 10.13  Distrib 5.5.37, for debian-linux-gnu (x86_64)
--
-- Host: localhost    Database: alarfin
-- ------------------------------------------------------
-- Server version	5.5.37-0ubuntu0.13.10.1

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
-- Table structure for table `carImages`
--

DROP TABLE IF EXISTS `carImages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `carImages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `car_id` int(11) DEFAULT NULL,
  `imageName` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_B220D217C3C6F69F` (`car_id`),
  CONSTRAINT `FK_B220D217C3C6F69F` FOREIGN KEY (`car_id`) REFERENCES `cars` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `carImages`
--

LOCK TABLES `carImages` WRITE;
/*!40000 ALTER TABLE `carImages` DISABLE KEYS */;
/*!40000 ALTER TABLE `carImages` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cars`
--

DROP TABLE IF EXISTS `cars`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cars` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `trademark_id` int(11) DEFAULT NULL,
  `model_id` int(11) DEFAULT NULL,
  `version_id` int(11) DEFAULT NULL,
  `fuel_id` int(11) DEFAULT NULL,
  `year_id` int(11) DEFAULT NULL,
  `direction_id` int(11) DEFAULT NULL,
  `title` varchar(150) COLLATE utf8_unicode_ci NOT NULL,
  `price` bigint(20) NOT NULL,
  `km` int(11) NOT NULL,
  `mandatoryImage` varchar(150) COLLATE utf8_unicode_ci NOT NULL,
  `color` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `status` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_95C71D14828AA8BA` (`trademark_id`),
  UNIQUE KEY `UNIQ_95C71D147975B7E7` (`model_id`),
  UNIQUE KEY `UNIQ_95C71D144BBC2705` (`version_id`),
  UNIQUE KEY `UNIQ_95C71D1497C79677` (`fuel_id`),
  UNIQUE KEY `UNIQ_95C71D1440C1FEA7` (`year_id`),
  UNIQUE KEY `UNIQ_95C71D14AF73D997` (`direction_id`),
  CONSTRAINT `FK_95C71D1440C1FEA7` FOREIGN KEY (`year_id`) REFERENCES `years` (`id`),
  CONSTRAINT `FK_95C71D144BBC2705` FOREIGN KEY (`version_id`) REFERENCES `versions` (`id`),
  CONSTRAINT `FK_95C71D147975B7E7` FOREIGN KEY (`model_id`) REFERENCES `models` (`id`),
  CONSTRAINT `FK_95C71D14828AA8BA` FOREIGN KEY (`trademark_id`) REFERENCES `trademarks` (`id`),
  CONSTRAINT `FK_95C71D1497C79677` FOREIGN KEY (`fuel_id`) REFERENCES `fuels` (`id`),
  CONSTRAINT `FK_95C71D14AF73D997` FOREIGN KEY (`direction_id`) REFERENCES `directions` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cars`
--

LOCK TABLES `cars` WRITE;
/*!40000 ALTER TABLE `cars` DISABLE KEYS */;
INSERT INTO `cars` VALUES (1,1,1,NULL,1,1,NULL,'Vendo Sandero Stepway',110000,35000,'foto-auto.jpg','','');
/*!40000 ALTER TABLE `cars` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `directions`
--

DROP TABLE IF EXISTS `directions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `directions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `description` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `directions`
--

LOCK TABLES `directions` WRITE;
/*!40000 ALTER TABLE `directions` DISABLE KEYS */;
/*!40000 ALTER TABLE `directions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `feature_types`
--

DROP TABLE IF EXISTS `feature_types`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `feature_types` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `description` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `feature_types`
--

LOCK TABLES `feature_types` WRITE;
/*!40000 ALTER TABLE `feature_types` DISABLE KEYS */;
/*!40000 ALTER TABLE `feature_types` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `features`
--

DROP TABLE IF EXISTS `features`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `features` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `description` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `featureType_id` int(11) DEFAULT NULL,
  `car_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_BFC0DC138AD7B422` (`featureType_id`),
  KEY `IDX_BFC0DC13C3C6F69F` (`car_id`),
  CONSTRAINT `FK_BFC0DC138AD7B422` FOREIGN KEY (`featureType_id`) REFERENCES `feature_types` (`id`),
  CONSTRAINT `FK_BFC0DC13C3C6F69F` FOREIGN KEY (`car_id`) REFERENCES `cars` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `features`
--

LOCK TABLES `features` WRITE;
/*!40000 ALTER TABLE `features` DISABLE KEYS */;
/*!40000 ALTER TABLE `features` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `fuels`
--

DROP TABLE IF EXISTS `fuels`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `fuels` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `description` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `fuels`
--

LOCK TABLES `fuels` WRITE;
/*!40000 ALTER TABLE `fuels` DISABLE KEYS */;
INSERT INTO `fuels` VALUES (1,'NAFTA');
/*!40000 ALTER TABLE `fuels` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `licensees`
--

DROP TABLE IF EXISTS `licensees`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `licensees` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `status` tinyint(1) NOT NULL,
  `socialReason` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `fantasyName` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `cuit` varchar(11) COLLATE utf8_unicode_ci NOT NULL,
  `plainPassword` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `mail` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `telephone` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_B18F65EEB9BA4881` (`cuit`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `licensees`
--

LOCK TABLES `licensees` WRITE;
/*!40000 ALTER TABLE `licensees` DISABLE KEYS */;
INSERT INTO `licensees` VALUES (1,1,'Eduardo','cacona','20283147453','123456','eduardo.abizeid@gmail.com','',''),(2,1,'eduardo','Abi Zeid Eduardo','20283147457','especial','shiatsuenmerlo@gmail.com','','+542656470489'),(3,1,'aaaaa','dkasdka;s','22222222','123456','magaliposca@gmail.com','','+542656470489');
/*!40000 ALTER TABLE `licensees` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `models`
--

DROP TABLE IF EXISTS `models`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `models` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `trademark_id` int(11) DEFAULT NULL,
  `description` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_E4D63009828AA8BA` (`trademark_id`),
  CONSTRAINT `FK_E4D63009828AA8BA` FOREIGN KEY (`trademark_id`) REFERENCES `trademarks` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `models`
--

LOCK TABLES `models` WRITE;
/*!40000 ALTER TABLE `models` DISABLE KEYS */;
INSERT INTO `models` VALUES (1,1,'Stepway');
/*!40000 ALTER TABLE `models` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `roles`
--

DROP TABLE IF EXISTS `roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `roles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `roles`
--

LOCK TABLES `roles` WRITE;
/*!40000 ALTER TABLE `roles` DISABLE KEYS */;
INSERT INTO `roles` VALUES (1,'ROLE_USER'),(2,'ROLE_LICENSEE'),(3,'ROLE_ALARFIN');
/*!40000 ALTER TABLE `roles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `trademarks`
--

DROP TABLE IF EXISTS `trademarks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `trademarks` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `description` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `trademarks`
--

LOCK TABLES `trademarks` WRITE;
/*!40000 ALTER TABLE `trademarks` DISABLE KEYS */;
INSERT INTO `trademarks` VALUES (1,'RENAULT');
/*!40000 ALTER TABLE `trademarks` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_car`
--

DROP TABLE IF EXISTS `user_car`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user_car` (
  `user_id` int(11) NOT NULL,
  `car_id` int(11) NOT NULL,
  PRIMARY KEY (`user_id`,`car_id`),
  KEY `IDX_9C2B8716A76ED395` (`user_id`),
  KEY `IDX_9C2B8716C3C6F69F` (`car_id`),
  CONSTRAINT `FK_9C2B8716C3C6F69F` FOREIGN KEY (`car_id`) REFERENCES `cars` (`id`),
  CONSTRAINT `FK_9C2B8716A76ED395` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_car`
--

LOCK TABLES `user_car` WRITE;
/*!40000 ALTER TABLE `user_car` DISABLE KEYS */;
/*!40000 ALTER TABLE `user_car` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_types`
--

DROP TABLE IF EXISTS `user_types`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user_types` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `description` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_types`
--

LOCK TABLES `user_types` WRITE;
/*!40000 ALTER TABLE `user_types` DISABLE KEYS */;
/*!40000 ALTER TABLE `user_types` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `firstName` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `lastName` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `mail` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `telephone` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `status` tinyint(1) NOT NULL,
  `salt` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'Eduardo','Abi Zeid','eduardo.abizeid@gmail.com','470489','28Pmc398','',1,'');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `usuario_rol`
--

DROP TABLE IF EXISTS `usuario_rol`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `usuario_rol` (
  `usuario_id` int(11) NOT NULL,
  `rol_id` int(11) NOT NULL,
  PRIMARY KEY (`usuario_id`,`rol_id`),
  KEY `IDX_72EDD1A4DB38439E` (`usuario_id`),
  KEY `IDX_72EDD1A44BAB96C` (`rol_id`),
  CONSTRAINT `FK_72EDD1A44BAB96C` FOREIGN KEY (`rol_id`) REFERENCES `roles` (`id`),
  CONSTRAINT `FK_72EDD1A4DB38439E` FOREIGN KEY (`usuario_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usuario_rol`
--

LOCK TABLES `usuario_rol` WRITE;
/*!40000 ALTER TABLE `usuario_rol` DISABLE KEYS */;
INSERT INTO `usuario_rol` VALUES (1,1);
/*!40000 ALTER TABLE `usuario_rol` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `versions`
--

DROP TABLE IF EXISTS `versions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `versions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `model_id` int(11) DEFAULT NULL,
  `description` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_19DC40D27975B7E7` (`model_id`),
  CONSTRAINT `FK_19DC40D27975B7E7` FOREIGN KEY (`model_id`) REFERENCES `models` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `versions`
--

LOCK TABLES `versions` WRITE;
/*!40000 ALTER TABLE `versions` DISABLE KEYS */;
/*!40000 ALTER TABLE `versions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `years`
--

DROP TABLE IF EXISTS `years`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `years` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `description` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `years`
--

LOCK TABLES `years` WRITE;
/*!40000 ALTER TABLE `years` DISABLE KEYS */;
INSERT INTO `years` VALUES (1,'2011');
/*!40000 ALTER TABLE `years` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2014-11-04  8:59:51
