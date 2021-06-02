-- MySQL dump 10.13  Distrib 5.7.34, for Linux (x86_64)
--
-- Host: mysql.info.unicaen.fr    Database: 21900371_3
-- ------------------------------------------------------
-- Server version	5.5.5-10.1.44-MariaDB-0+deb9u1

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
-- Table structure for table `club`
--

DROP TABLE IF EXISTS `club`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `club` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `sport` varchar(255) NOT NULL,
  `club` varchar(255) NOT NULL,
  `twitter` varchar(255) NOT NULL,
  `site` varchar(255) NOT NULL,
  `image` varchar(50) DEFAULT NULL,
  `valide` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`,`club`)
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `club`
--

LOCK TABLES `club` WRITE;
/*!40000 ALTER TABLE `club` DISABLE KEYS */;
INSERT INTO `club` VALUES (2,'Football','Stade Malherbe Caen','SMCaen','https://www.smcaen.fr/','upload/logocaen',1),(6,'test','test','test','test','',NULL),(18,'Football','FCNantes','FCNantes','https://www.fcnantes.com/','upload/logonantes',1),(20,'Basketball','Golden State Warriors','warriors','GSW','upload/logogsw',1),(25,'Football','LOSC','losclive','losc.fr','upload/2021_05_22_13_20_51.jpg',1),(26,'test','test','test','test','upload/2021_05_23_12_38_25.jpg',0);
/*!40000 ALTER TABLE `club` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `compte`
--

DROP TABLE IF EXISTS `compte`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `compte` (
  `nom` varchar(255) DEFAULT NULL,
  `login` varchar(255) NOT NULL,
  `pass` varchar(255) NOT NULL,
  `statut` varchar(255) NOT NULL,
  PRIMARY KEY (`login`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `compte`
--

LOCK TABLES `compte` WRITE;
/*!40000 ALTER TABLE `compte` DISABLE KEYS */;
INSERT INTO `compte` VALUES ('azer','azer','$2y$10$h/dREnnRUn.BkjDhO7nuwudj5Q.k2/OtdVwHgdqhoNeew9nOsXcPe','admin'),('chakib','chakib','$2y$10$NqK2g2ynJsHgl/gjamXcm.qHSSRrn9fEmO1l0qlEp9s767XJbZLK.','user'),('Diallo','Diallo','$2y$10$58NSotk5yOLI5GQJ0jGgau0ArDPsN/4rfMd8X9q19.evRz2Zkmiq6','admin'),('DIALLO','djoulde','$2y$10$YJVL.UMd3VjQ.mrK5Qp00eBQMsATcBBrU5ndUjwAGhIqn/OhNAoIS','user'),('test','test','$2y$10$qoYoiPeQ3q.du68F9TSfBOKxZZlb84hQdLldWfmrAjoPIcmBsfgxm','user'),('thomas','thomas','$2y$10$i1fvof6V7to28jYZ4y9yGOUO88FpL8m0iS/1r2h0Y7x6.0HiqnaVa','user'),('Thomastest','Thomastest','$2y$10$Sbr4wTAWEXHYO9.ZIo86P.jLnIdSbVDaWfuvZxCep/5fD1SB0nby.','user');
/*!40000 ALTER TABLE `compte` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `follow`
--

DROP TABLE IF EXISTS `follow`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `follow` (
  `user` varchar(255) NOT NULL,
  `club` int(11) NOT NULL,
  PRIMARY KEY (`user`,`club`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `follow`
--

LOCK TABLES `follow` WRITE;
/*!40000 ALTER TABLE `follow` DISABLE KEYS */;
INSERT INTO `follow` VALUES ('azer',1),('azer',2),('azer',3),('test',2),('test',5),('test',20),('thomas',5),('Thomastest',2);
/*!40000 ALTER TABLE `follow` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2021-06-02 14:01:07
