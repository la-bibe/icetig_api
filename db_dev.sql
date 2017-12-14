-- MySQL dump 10.13  Distrib 5.7.20, for Linux (x86_64)
--
-- Host: localhost    Database: icetig_api
-- ------------------------------------------------------
-- Server version	5.7.20-0ubuntu0.17.10.1

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
-- Table structure for table `access`
--

DROP TABLE IF EXISTS `access`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `access` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `access_user_id` int(11) DEFAULT NULL,
  `access_token` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `signature_token` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `generation_date` datetime NOT NULL,
  `expiration_date` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_6692B546F4B0980` (`access_user_id`),
  CONSTRAINT `FK_6692B546F4B0980` FOREIGN KEY (`access_user_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `access`
--

LOCK TABLES `access` WRITE;
/*!40000 ALTER TABLE `access` DISABLE KEYS */;
INSERT INTO `access` VALUES (1,1,'5fa11c5136135451937180c906eba7b5','976701e81536fd8ad09ad3903367eb98','2017-12-14 20:29:36','2017-12-14 20:49:36'),(2,1,'d72cbfe0dbe7dc0ae1c39491ccb15ca9','7f1eb60a2033aba44a062263f37a8ea2','2017-12-14 20:29:36','2017-12-14 20:49:36'),(3,1,'24d52dbb2a66556243de0b0a2db3922f','90b76592d8ec7fb1f7d04507f0a38dbf','2017-12-14 23:46:30','2017-12-15 00:06:30'),(4,1,'13107771f16cf224a6c23a7488ed9d10','a0fc0fb4d6d96b4cfb75bd4a4dffde74','2017-12-14 23:47:18','2017-12-15 00:07:18'),(5,1,'a4c3bf6768b6ca93d32a012306183994','549a4fc588e39352ea87992a46aa101d','2017-12-14 23:48:18','2017-12-15 00:08:18'),(6,1,'b7f7f1aeb5944e5e52c6d6564f50751b','4d8ee5c54587b533eb7a9131de29f6bf','2017-12-14 23:50:45','2017-12-15 00:10:45'),(7,1,'20ccaba3d50a21c4a7f36e07c4e6b05b','64a48c51f5badac33f058a65fd4edce0','2017-12-14 23:53:51','2017-12-15 00:13:51'),(8,1,'155cd3324a8b03e1437e45a963971e50','3b1df09db09de89e5c0225fd4ba263df','2017-12-14 23:58:54','2017-12-15 00:18:54'),(9,1,'b5f4d2521879e09ff8f6b07e39e261f9','acdc5d057728de3a5284a16e3124c8f0','2017-12-15 00:04:11','2017-12-15 00:24:11'),(10,1,'bb2b170dc9f0cdb9509f750dd5dcfca1','5f724bc58b6c1e2501eb6bf1b8a7ef5b','2017-12-15 00:05:38','2017-12-15 00:25:38'),(11,1,'fd29e859b05f645b81f7403828995998','bc8cb32c0e93d6d2f44d6a027b4fdf00','2017-12-15 00:06:07','2017-12-15 00:26:07'),(12,1,'3a53657f84d12c65cdc2e7f22dbc877b','a3bea1c14546559d6635b154ed3ba608','2017-12-15 00:06:30','2017-12-15 00:26:30'),(13,2,'f2f3430b253da87b45665679251726a7','3e13ea94a9185b3f3bb5da3f90fa14d7','2017-12-15 00:09:04','2017-12-15 00:29:04'),(14,2,'b0721f5d8fee6463f6cd2538bb6132dc','68e59619b275c75f2cfc5c255804a96f','2017-12-15 00:09:48','2017-12-15 00:29:48'),(15,2,'e43eb7404c937c3d541cb6360fd353c8','145ecd9c1e79223c1e482b05717caa58','2017-12-15 00:10:58','2017-12-15 00:30:58'),(16,1,'31663a884eef169f854052eaea4f40b8','9b6d14db58496d3b268fcd05d67fdcb9','2017-12-15 00:11:22','2017-12-15 00:31:22'),(17,1,'4f9fc2467ee9742658ebcda4e9d0d4c7','acd91c88a6b727a9d36d630184a4da18','2017-12-15 00:11:43','2017-12-15 00:31:43'),(18,2,'439e9874311c462de6d13f118d59f1e5','8786dad5a9952394364471f2e8ea2404','2017-12-15 00:13:44','2017-12-15 00:33:44');
/*!40000 ALTER TABLE `access` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `group`
--

DROP TABLE IF EXISTS `group`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `group` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `parent_id` int(11) DEFAULT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_6DC044C55E237E06` (`name`),
  KEY `IDX_6DC044C5727ACA70` (`parent_id`),
  CONSTRAINT `FK_6DC044C5727ACA70` FOREIGN KEY (`parent_id`) REFERENCES `group` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `group`
--

LOCK TABLES `group` WRITE;
/*!40000 ALTER TABLE `group` DISABLE KEYS */;
INSERT INTO `group` VALUES (1,NULL,'Pedago'),(2,NULL,'Student'),(3,1,'AER'),(4,1,'APE'),(5,2,'Tek1'),(6,2,'Tek2'),(7,2,'Tek3'),(8,2,'Tek4'),(9,2,'Tek5');
/*!40000 ALTER TABLE `group` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `group_permission`
--

DROP TABLE IF EXISTS `group_permission`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `group_permission` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `group_id` int(11) DEFAULT NULL,
  `permission` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `acl` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_3784F318FE54D947` (`group_id`),
  CONSTRAINT `FK_3784F318FE54D947` FOREIGN KEY (`group_id`) REFERENCES `group` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `group_permission`
--

LOCK TABLES `group_permission` WRITE;
/*!40000 ALTER TABLE `group_permission` DISABLE KEYS */;
INSERT INTO `group_permission` VALUES (1,1,'user',15),(2,2,'sanction',2),(3,1,'sanction',15);
/*!40000 ALTER TABLE `group_permission` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migration_versions`
--

DROP TABLE IF EXISTS `migration_versions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `migration_versions` (
  `version` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migration_versions`
--

LOCK TABLES `migration_versions` WRITE;
/*!40000 ALTER TABLE `migration_versions` DISABLE KEYS */;
INSERT INTO `migration_versions` VALUES ('20171127234233'),('20171214192646');
/*!40000 ALTER TABLE `migration_versions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `salt` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `first_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `last_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `date_of_birth` datetime DEFAULT NULL,
  `phone` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_8D93D649E7927C74` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user`
--

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` VALUES (1,'fantin.bibas@epitech.eu','5f589484239dd274965fbca829fef2fb1451aa8a5d1211fe60ca3ca0577e692b632796fb3b1837ecd450991491a7ec93a932a0056348031e9fc3fddca3354f81','309ecc489c12d6eb4cc40f50c902f2b4d0ed77ee511a7c7a9bcd3ca86d4cd86f989dd35bc5ff499670da34255b45b0cfd830e81f605dcf7dc5542e93ae9cd76f','Fantin','Bibas',NULL,'06.98.43.68.60'),(2,'quentin.sanchez@epitech.eu','52e5a425a773fe6ab0f32232df5a38e52441be7ae87355de053f9769fecca88cd23fd76affe1442279554d152120bf6f06ca466902a95833d69bf42a5f97a6b5','e4a754cd62769720b6bda8ac2413cd4c418ce643e8e623fe035e6535061e6df287e5ac28161d2d3e1adf527ef9337d9d1f878adbaec39e3bf8b9aef551d2e229','Quentin','Sanchez',NULL,NULL);
/*!40000 ALTER TABLE `user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_group`
--

DROP TABLE IF EXISTS `user_group`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user_group` (
  `group_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  PRIMARY KEY (`group_id`,`user_id`),
  KEY `IDX_8F02BF9DFE54D947` (`group_id`),
  KEY `IDX_8F02BF9DA76ED395` (`user_id`),
  CONSTRAINT `FK_8F02BF9DA76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`),
  CONSTRAINT `FK_8F02BF9DFE54D947` FOREIGN KEY (`group_id`) REFERENCES `group` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_group`
--

LOCK TABLES `user_group` WRITE;
/*!40000 ALTER TABLE `user_group` DISABLE KEYS */;
INSERT INTO `user_group` VALUES (3,1),(6,1),(6,2);
/*!40000 ALTER TABLE `user_group` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2017-12-15  0:14:26
