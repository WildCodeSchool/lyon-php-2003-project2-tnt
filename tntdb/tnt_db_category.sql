-- MySQL dump 10.13  Distrib 5.7.30, for Linux (x86_64)
--
-- Host: localhost    Database: tnt_db
-- ------------------------------------------------------
-- Server version	5.7.30-0ubuntu0.18.04.1

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
-- Table structure for table `category`
--

DROP TABLE IF EXISTS `category`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `category` (
  `id` int(11) NOT NULL,
  `name` varchar(45) NOT NULL,
  `parent_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_category_1_idx` (`parent_id`),
  CONSTRAINT `fk_category_1` FOREIGN KEY (`parent_id`) REFERENCES `category` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `category`
--

LOCK TABLES `category` WRITE;
/*!40000 ALTER TABLE `category` DISABLE KEYS */;
INSERT INTO `category` VALUES (1,'VEHICULE',1),(2,'IMMOBILIER',2),(3,'VACANCES',3),(4,'LOISIRS',4),(5,'MODE',5),(6,'MULTIMEDIA',6),(7,'SERVICE',7),(8,'MAISON',8),(9,'MATERIEL PRO',9),(11,'Voitures',1),(12,'Motos',1),(13,'Caravaning',1),(14,'Utilitaires',1),(15,'Camions',1),(16,'Nautisme',1),(21,'Maison',2),(22,'Appartement',2),(23,'Bureau',2),(31,'Location',3),(32,'Gites',3),(33,'Camping',3),(34,'Hotels',3),(41,'DVD/CD',4),(42,'Vins et Gastronomie',4),(43,'Livres',4),(44,'Animaux',4),(45,'Vélos',4),(46,'Sports & hobby',4),(47,'Instruments de Musique',4),(48,'Collections',4),(49,'Jeux et jouets',4),(51,'Vêtements',5),(52,'Chaussure',5),(53,'Accessoire & Bagagerie',5),(54,'Montre & Bijoux',5),(55,'Equipent Bébé',5),(56,'Vêtements Bébé',5),(57,'Luxe et Tendance',5),(61,'Informatique',6),(62,'Console & jeux Vidéo',6),(63,'Image & Son',6),(64,'Téléphonie',6),(71,'Billeterie',7),(72,'Evènements',7),(73,'Cours Particuliers',7),(74,'Covoiturage',7),(81,'Ameublement',8),(82,'Electroménager',8),(83,'Art de la table',8),(84,'Décoration',8),(85,'Linge de Maison',8),(86,'Bricolage',8),(87,'Jardinage',8),(91,'Matériel Agricole',9),(92,'Transport - Manutention',9),(93,'BTP',9),(94,'Outillage',9),(95,'Restauration',9),(96,'Fournitures de bureau',9),(97,'Commerces & Marchés',9),(98,'Matériel Médical',9);
/*!40000 ALTER TABLE `category` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2020-05-11 11:34:18
