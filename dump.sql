-- MySQL dump 10.13  Distrib 5.1.73, for redhat-linux-gnu (x86_64)
--
-- Host: localhost    Database: jajo232
-- ------------------------------------------------------
-- Server version	5.1.73

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
-- Table structure for table `Charities`
--

DROP TABLE IF EXISTS `Charities`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Charities` (
  `charity_id` int(11) NOT NULL AUTO_INCREMENT,
  `charity_type` int(11) NOT NULL,
  `charity_name` varchar(50) NOT NULL,
  `street_address` varchar(100) NOT NULL,
  `city_name` varchar(20) NOT NULL,
  `state_abrev` varchar(2) NOT NULL,
  `zip_code` int(5) NOT NULL,
  `phone_country` varchar(5) DEFAULT NULL,
  `phone_area` varchar(3) NOT NULL,
  `phone_main` varchar(7) NOT NULL,
  `charity_description` varchar(500) NOT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `charity_owner` int(50) NOT NULL,
  PRIMARY KEY (`charity_id`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Charities`
--

/*LOCK TABLES `Charities` WRITE; */
/*!40000 ALTER TABLE `Charities` DISABLE KEYS */;
INSERT INTO `Charities` VALUES (1,1,'Test Charity','320 East Maxwell','Lexington','KY',40508,'1','502','4941039','This is a test charity.',NULL,NULL,4),(2,1,'Test Charity','320 East Maxwell','Lexington','KY',40508,'1','502','4941039','This is a test charity.',NULL,NULL,4),(3,3,'Kevin Laughs Loudly','Right here','Lexington','KY',40508,'1','666','5554902','Kevin is going to laugh REALLY LOUDLY AND ANNOY EVERYONE',NULL,NULL,4),(4,2,'After School Program Example','Nowhere','Lexington','KY',40508,'1','859','5551234','This is a example program for testing',NULL,NULL,4),(5,2,'After School Program Example 2','Nowhere','Lexington','KY',40508,'1','859','5551234','This is a example program for testing 2',NULL,NULL,4),(6,3,'Test Event','Somewhere','Lexington','KY',40508,'1','859','5552345','This is a test',NULL,NULL,4),(7,3,'Test Event 2','Somewhere','Lexington','KY',40508,'1','859','5552345','This is a test 2',NULL,NULL,4),(8,3,'Test Event 3','Anywhere','Lexington','KY',40508,'1','859','5553456','This is another test',NULL,NULL,4);
/*!40000 ALTER TABLE `Charities` ENABLE KEYS */;
/*UNLOCK TABLES;*/

--
-- Table structure for table `Logins`
--

DROP TABLE IF EXISTS `Logins`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Logins` (
  `userid` int(50) NOT NULL AUTO_INCREMENT,
  `username` varchar(20) DEFAULT NULL,
  `password` varchar(20) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`userid`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Logins`
--

/*LOCK TABLES `Logins` WRITE;*/
/*!40000 ALTER TABLE `Logins` DISABLE KEYS */;
INSERT INTO `Logins` VALUES (1,'admin','admin',NULL),(2,'Kevin','niveK','kevlogan7@gmail.com'),(3,'Mandy','ydnaM','mandydcox@gmail.com'),(4,'Jordan','nadroj','jordanxallen@gmail.com'),(5,'Bob','Ross','bobross@gmail.com'),(8,'Kevbob7','fratbob','kevbob@gmail.com');
/*!40000 ALTER TABLE `Logins` ENABLE KEYS */;
/*UNLOCK TABLES;*/

--
-- Table structure for table `Tag`
--

DROP TABLE IF EXISTS `Tag`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Tag` (
  `tag_id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `tag_string` varchar(50) NOT NULL,
  `tag_name` varchar(50) NOT NULL,
  PRIMARY KEY (`tag_id`)
) ENGINE=MyISAM AUTO_INCREMENT=26 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Tag`
--

/*LOCK TABLES `Tag` WRITE;*/
/*!40000 ALTER TABLE `Tag` DISABLE KEYS */;
INSERT INTO `Tag` VALUES (1,'Homeless','homeless'),(2,'Unemployed','unemployed'),(3,'Hungry','hungry'),(4,'Single Parent','single_parent'),(5,'Depressed/Emotional','depressed'),(6,'Struggling with addiction','addiction'),(7,'Struggling financially','financial'),(8,'Veteran','veteran'),(9,'Disabled','disabled'),(10,'Injured/Sick','injured'),(11,'Suicidal','suicidal'),(12,'Need education','education'),(13,'Pregnant','pregnant'),(14,'Elderly','elderly'),(15,'New mom','new_mom'),(16,'Need clothes','clothes'),(17,'Need help for the holidays','holiday_help'),(18,'Baby supplies','baby_supplies'),(19,'Daycare','daycare'),(20,'Child education help','child_education'),(21,'Child\'s school supplies','school_supplies'),(22,'Disabled child','child_disabled'),(23,'Injured/Sick child','child_injured'),(24,'Child needs clothes','child_clothes'),(25,'Child needs counseling','child_counceling');
/*!40000 ALTER TABLE `Tag` ENABLE KEYS */;
/*UNLOCK TABLES;*/

--
-- Table structure for table `Tag2Charity`
--

DROP TABLE IF EXISTS `Tag2Charity`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Tag2Charity` (
  `tag_id` smallint(5) unsigned NOT NULL,
  `charity_id` int(11) NOT NULL,
  PRIMARY KEY (`tag_id`,`charity_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Tag2Charity`
--

/*LOCK TABLES `Tag2Charity` WRITE;*/
/*!40000 ALTER TABLE `Tag2Charity` DISABLE KEYS */;
INSERT INTO `Tag2Charity` VALUES (1,6),(2,8),(4,8),(12,8),(13,6),(18,8),(20,8);
/*!40000 ALTER TABLE `Tag2Charity` ENABLE KEYS */;
/*UNLOCK TABLES;*/
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2016-03-12 14:20:28
