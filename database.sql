-- MySQL dump 10.13  Distrib 5.7.33, for Win64 (x86_64)
--
-- Host: 127.0.0.1    Database: solution_factory
-- ------------------------------------------------------
-- Server version	5.7.33

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
-- Table structure for table `courses`
--

DROP TABLE IF EXISTS `courses`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `courses` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) NOT NULL,
  `code` varchar(255) DEFAULT NULL,
  `duree` int(11) DEFAULT NULL,
  `niveau` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `courses`
--

LOCK TABLES `courses` WRITE;
/*!40000 ALTER TABLE `courses` DISABLE KEYS */;
INSERT INTO `courses` VALUES (1,'RGPD','rgpd',NULL,2),(2,'Angular','angular',48,3),(3,'HTML','html',4,1),(7,'programmation object oriente','poo',32,4);
/*!40000 ALTER TABLE `courses` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `formation_course`
--

DROP TABLE IF EXISTS `formation_course`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `formation_course` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `formation_id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `formation_course_courses_id_fk` (`course_id`),
  KEY `formation_course_formations_id_fk` (`formation_id`),
  CONSTRAINT `formation_course_courses_id_fk` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE CASCADE,
  CONSTRAINT `formation_course_formations_id_fk` FOREIGN KEY (`formation_id`) REFERENCES `formations` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `formation_course`
--

LOCK TABLES `formation_course` WRITE;
/*!40000 ALTER TABLE `formation_course` DISABLE KEYS */;
/*!40000 ALTER TABLE `formation_course` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `formations`
--

DROP TABLE IF EXISTS `formations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `formations` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) NOT NULL,
  `code` varchar(255) DEFAULT NULL,
  `niveau` int(11) DEFAULT NULL,
  `duree` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `formations`
--

LOCK TABLES `formations` WRITE;
/*!40000 ALTER TABLE `formations` DISABLE KEYS */;
/*!40000 ALTER TABLE `formations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `roles`
--

DROP TABLE IF EXISTS `roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `roles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `code` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `roles`
--

LOCK TABLES `roles` WRITE;
/*!40000 ALTER TABLE `roles` DISABLE KEYS */;
INSERT INTO `roles` VALUES (1,'Administrateur','admin'),(2,'Student','student'),(3,'Teacher','teacher');
/*!40000 ALTER TABLE `roles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `session_etudiants`
--

DROP TABLE IF EXISTS `session_etudiants`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `session_etudiants` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date` datetime DEFAULT NULL,
  `session_formation_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `statut` varchar(255) DEFAULT 'actif',
  PRIMARY KEY (`id`),
  KEY `session_etudiants_session_formations_id_fk` (`session_formation_id`),
  KEY `session_etudiants_users_id_fk` (`user_id`),
  CONSTRAINT `session_etudiants_session_formations_id_fk` FOREIGN KEY (`session_formation_id`) REFERENCES `session_formations` (`id`),
  CONSTRAINT `session_etudiants_users_id_fk` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `session_etudiants`
--

LOCK TABLES `session_etudiants` WRITE;
/*!40000 ALTER TABLE `session_etudiants` DISABLE KEYS */;
/*!40000 ALTER TABLE `session_etudiants` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `session_formations`
--

DROP TABLE IF EXISTS `session_formations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `session_formations` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `formation_id` int(11) DEFAULT NULL,
  `duree` int(11) DEFAULT NULL,
  `debut` datetime DEFAULT NULL,
  `annee` datetime DEFAULT NULL,
  `max_students` int(11) DEFAULT NULL,
  `statut` varchar(255) DEFAULT 'actif',
  PRIMARY KEY (`id`),
  KEY `session_formations_formations_id_fk` (`formation_id`),
  CONSTRAINT `session_formations_formations_id_fk` FOREIGN KEY (`formation_id`) REFERENCES `formations` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `session_formations`
--

LOCK TABLES `session_formations` WRITE;
/*!40000 ALTER TABLE `session_formations` DISABLE KEYS */;
/*!40000 ALTER TABLE `session_formations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_role`
--

DROP TABLE IF EXISTS `user_role`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user_role` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `role_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_role_roles_id_fk` (`role_id`),
  KEY `user_role_users_id_fk` (`user_id`),
  CONSTRAINT `user_role_roles_id_fk` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE,
  CONSTRAINT `user_role_users_id_fk` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_role`
--

LOCK TABLES `user_role` WRITE;
/*!40000 ALTER TABLE `user_role` DISABLE KEYS */;
INSERT INTO `user_role` VALUES (1,1,1),(2,1,3),(3,7,2),(4,8,2);
/*!40000 ALTER TABLE `user_role` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) NOT NULL,
  `prenom` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `mdp` varchar(255) NOT NULL,
  `statut` varchar(20) DEFAULT 'student',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'administrator','admin','admin@admin.com','$2y$10$0hztUTNlIsG5NDB1Eq5pvevjkXv/pz8/P1J/5j9iK/bnc0v9QaI.G',NULL),(7,'obby','sidane','sidane.obby@efrei.fr','$2y$10$0hztUTNlIsG5NDB1Eq5pvevjkXv/pz8/P1J/5j9iK/bnc0v9QaI.G',NULL),(8,'sidane','obby','obby.sidane@efrei.fr','$2y$10$DbZf6SItBStLJWBzlRUsBOlBUiGK2S4Y9zaQ4V6DVVFNhG7JpgO.K',NULL),(9,'sidane','obby','obby.sidane1@efrei.fr','$2y$10$S00DWbpy9j/g6n6xWHGQl.PSQqBpGOTL59lD0.LwITgIFR.qeeey.',NULL);
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2023-06-20  0:24:40
