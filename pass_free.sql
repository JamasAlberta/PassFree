-- MySQL dump 10.13  Distrib 5.5.54, for debian-linux-gnu (x86_64)
--
-- Host: 0.0.0.0    Database: pass_free
-- ------------------------------------------------------
-- Server version	5.5.54-0ubuntu0.14.04.1

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
-- Table structure for table `answer`
--

DROP TABLE IF EXISTS `answer`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `answer` (
  `answer_id` int(11) NOT NULL AUTO_INCREMENT,
  `hashed_answer` varchar(250) NOT NULL,
  `user_id` int(11) NOT NULL,
  PRIMARY KEY (`answer_id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `answer_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=49 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `answer`
--

LOCK TABLES `answer` WRITE;
/*!40000 ALTER TABLE `answer` DISABLE KEYS */;
INSERT INTO `answer` VALUES (45,'$2y$10$MPpSe/XyxdWqvBZAntmK0ejCxjp./j7F4OhKviQzqSidkfl5BKLMq',53),(46,'$2y$10$OXFG4tgT4OJuUkkXKtLfuOscZLKKpe5t7fivpYrP4HWhe9RONp1Mq',54),(47,'$2y$10$sx1CJNL0FfAhO2qVPyNEJe4hFQtBJwJ.MjX1997MTNu3HPZfR2q0G',55),(48,'$2y$10$RLIgalXE93ob98fUcaF4iOgEtpu/fUT/1fUtAMHKBLtdl/sv2LfrK',56);
/*!40000 ALTER TABLE `answer` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `question`
--

DROP TABLE IF EXISTS `question`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `question` (
  `question_id` int(11) NOT NULL AUTO_INCREMENT,
  `question` varchar(200) NOT NULL,
  `user_id` int(11) NOT NULL,
  PRIMARY KEY (`question_id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `question_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=179 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `question`
--

LOCK TABLES `question` WRITE;
/*!40000 ALTER TABLE `question` DISABLE KEYS */;
INSERT INTO `question` VALUES (163,'What was my mothers surname?',53),(164,'What was my uncles name in Italian?',53),(165,'What is my grandmothers name?',53),(166,'What is was second dog\'s name?',53),(167,'Answer One',54),(168,'Answer Two',54),(169,'Answer Three',54),(170,'Answer Four',54),(171,'aquestion',55),(172,'bquestion',55),(173,'cquestion',55),(174,'dquestion',55),(175,'What was my mothers surname?',56),(176,'What was my uncles name in Italian?',56),(177,'What is my grandmothers name?',56),(178,'What is was second dog\'s name?',56);
/*!40000 ALTER TABLE `question` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `saved_password`
--

DROP TABLE IF EXISTS `saved_password`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `saved_password` (
  `spassword_id` int(11) NOT NULL AUTO_INCREMENT,
  `encrypted_password` text,
  `encrypt_iv` varchar(100) NOT NULL,
  `user_id` int(11) NOT NULL,
  PRIMARY KEY (`spassword_id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `saved_password_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=42 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `saved_password`
--

LOCK TABLES `saved_password` WRITE;
/*!40000 ALTER TABLE `saved_password` DISABLE KEYS */;
INSERT INTO `saved_password` VALUES (38,'Tr+P07rQwYNiEVuQU8Q8tcx7jlmm2N41JPKM5oaYutpeVm+b7I4dW4q8DmHdmbkDbb5FMcRzjWrpAy/ylPpnYGZ5XQcSyEk=','LWGIfvFlsYMfeVRrKnLsnQ==',53),(39,'Dl+0RpSlDb1zDQ==','8e0N75hRNt8spQrBhp7JWg==',54),(40,'Tn4AxYTfzRC/wg==','QxkVv74/ZJKVjACM8p8IiQ==',55),(41,'lG3eJpbHl8dcZg==','vBQlFec70Jq9sfRcr2ppdA==',56);
/*!40000 ALTER TABLE `saved_password` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(150) NOT NULL,
  `email` varchar(255) NOT NULL,
  `last_login` datetime NOT NULL,
  `attempts_counter` int(11) NOT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=57 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user`
--

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` VALUES (53,'test','test@passfree.net','2017-05-15 02:27:38',0),(54,'James Adams','jamesadams@outlook.com','2017-05-13 08:02:42',0),(55,'Jared','jared@passfree.net','2017-05-15 10:11:28',0),(56,'testone','test1@passfree.net','2017-05-18 05:21:32',0);
/*!40000 ALTER TABLE `user` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2017-05-18 12:45:14
