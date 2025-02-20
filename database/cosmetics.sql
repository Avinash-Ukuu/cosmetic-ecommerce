/*
SQLyog Ultimate v13.1.1 (64 bit)
MySQL - 10.4.32-MariaDB : Database - cosmetics
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`cosmetics` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci */;

USE `cosmetics`;

/*Table structure for table `activity_logs` */

DROP TABLE IF EXISTS `activity_logs`;

CREATE TABLE `activity_logs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `action` text DEFAULT NULL,
  `module` text DEFAULT NULL,
  `module_id` int(11) DEFAULT NULL,
  `message` text DEFAULT NULL,
  `action_by` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=199 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `activity_logs` */

insert  into `activity_logs`(`id`,`action`,`module`,`module_id`,`message`,`action_by`,`created_at`,`updated_at`) values 
(5,'created','user',5,'Raman has created \'Raveena\' account',3,'2024-08-24 06:01:55','2024-08-24 06:01:55'),
(6,'created','product',1,'Karan has created Rog Zephyrus G16, Ai Powered Gaming Laptop, Amd Ryzen Ai 9 Hx 370, Rtx 4060 Gpu',15,'2024-09-02 04:46:04','2024-09-02 04:46:04'),
(7,'created','product',2,'Karan has created Asus Tuf Gaming A14 (2024)',15,'2024-09-02 05:25:34','2024-09-02 05:25:34'),
(8,'created','product',3,'Rishi has created Sparc Lights 12w Round Indoor/outdoor Led Waterproof Ip65 (6 Way) Exterior Wall Step Light Fixture 6x2 Watts Black Finish (warm White) Ip65(metal)',9,'2024-09-02 05:46:38','2024-09-02 05:46:38'),
(9,'created','product',1,'Karan has created Sparc Lights 12w Round Indoor/outdoor Led Waterproof Ip65 (6 Way) Exterior Wall Step Light Fixture 6x2 Watts Black Finish (warm White) Ip65(metal)',15,'2024-09-02 06:09:43','2024-09-02 06:09:43'),
(10,'created','product',2,'Karan has created Rog Zephyrus G16 (2024) Ga605 Ga605wv-qp078ws',15,'2024-09-02 06:13:29','2024-09-02 06:13:29'),
(11,'created','product',3,'Rishi has created Sparc Lights 12w Round Indoor/outdoor Led Waterproof Ip65 (6 Way) Exterior Wall Step Light Fixture 6x2 Watts Black Finish (warm White) Ip65(metal)',9,'2024-09-02 06:15:03','2024-09-02 06:15:03'),
(12,'updated','user',9,'Rishi has updated the profile',9,'2024-09-02 08:41:25','2024-09-02 08:41:25'),
(13,'updated','user',9,'Rishi has updated the profile',9,'2024-09-02 08:55:49','2024-09-02 08:55:49'),
(14,'updated','user',9,'Rishi has updated the profile',9,'2024-09-02 08:56:28','2024-09-02 08:56:28'),
(15,'updated','user',6,'Pankaj has updated the profile',6,'2024-09-02 09:01:16','2024-09-02 09:01:16'),
(16,'updated','user',15,'Karan has updated the profile',15,'2024-09-02 09:02:39','2024-09-02 09:02:39'),
(17,'updated','user',15,'Karan has updated the profile',15,'2024-09-02 09:03:54','2024-09-02 09:03:54'),
(18,'updated','user',11,'Honey has updated the profile',11,'2024-09-02 09:05:08','2024-09-02 09:05:08'),
(19,'updated','user',11,'Honey has updated the profile',11,'2024-09-02 09:05:16','2024-09-02 09:05:16'),
(20,'created','product',4,'Nanit has created Titan Raga Analog Mother Of Pearl Dial Women Watch Nm2539km01/nn2539km01/np2539km01',10,'2024-09-02 09:10:45','2024-09-02 09:10:45'),
(21,'created','product',5,'Nanit has created Axor Apex Venomous Isi Ece Dot Certified Full Face Dual Visor Helmet For Men And Women With Pinlock Fitted Outer Clear Visor And Inner Smoke Sun Visor Black Grey(m)',10,'2024-09-02 09:28:00','2024-09-02 09:28:00'),
(22,'created','product',6,'Rishi has created Amazon Echo Pop',9,'2024-09-03 22:26:47','2024-09-03 22:26:47'),
(23,'created','product',7,'Rishi has created Bajaj 9w Wifi Smart Led Bulb',9,'2024-09-03 22:37:18','2024-09-03 22:37:18'),
(24,'updated','product',7,'Rishi has created Bajaj 10w Wifi Smart Led Bulb',9,'2024-09-03 22:47:52','2024-09-03 22:47:52'),
(25,'deleted','product',7,'Rishi has deleted Bajaj 10w Wifi Smart Led Bulb',9,'2024-09-03 23:01:27','2024-09-03 23:01:27'),
(26,'deleted','product',6,'Rishi has deleted Amazon Echo Pop',9,'2024-09-03 23:14:06','2024-09-03 23:14:06'),
(27,'deleted','product',2,'Karan has deleted Rog Zephyrus G16 (2024) Ga605 Ga605wv-qp078ws',15,'2024-09-03 23:15:55','2024-09-03 23:15:55'),
(28,'deleted','product',1,'Karan has deleted Sparc Lights 12w Round Indoor/outdoor Led Waterproof Ip65 (6 Way) Exterior Wall Step Light Fixture 6x2 Watts Black Finish (warm White) Ip65(metal)',15,'2024-09-03 23:16:22','2024-09-03 23:16:22'),
(29,'deleted','product',3,'Rishi has deleted Sparc Lights 12w Round Indoor/outdoor Led Waterproof Ip65 (6 Way) Exterior Wall Step Light Fixture 6x2 Watts Black Finish (warm White) Ip65(metal)',9,'2024-09-03 23:16:52','2024-09-03 23:16:52'),
(30,'created','product',8,'Rishi has created Trst',9,'2024-09-03 23:19:15','2024-09-03 23:19:15'),
(31,'created','product',9,'Rishi has created Bajaj Led Light',9,'2024-09-03 23:39:29','2024-09-03 23:39:29'),
(32,'updated','product',9,'Rishi has created Bajaj Led Light',9,'2024-09-03 23:52:48','2024-09-03 23:52:48'),
(33,'created','product',10,'Rishi has created Alexa Speaker',9,'2024-09-04 00:01:25','2024-09-04 00:01:25'),
(34,'updated','product',10,'Rishi has created Alexa Speaker',9,'2024-09-04 00:01:36','2024-09-04 00:01:36'),
(35,'updated','product',10,'Rishi has created Alexa Speaker',9,'2024-09-04 00:02:20','2024-09-04 00:02:20'),
(36,'updated','product',10,'Rishi has created Alexa Speaker',9,'2024-09-04 00:10:32','2024-09-04 00:10:32'),
(37,'updated','product',10,'Rishi has created Alexa Speaker',9,'2024-09-04 00:13:05','2024-09-04 00:13:05'),
(38,'updated','product',10,'Rishi has created Alexa Speaker',9,'2024-09-04 00:13:44','2024-09-04 00:13:44'),
(39,'updated','product',10,'Rishi has created Alexa Speaker',9,'2024-09-04 00:15:22','2024-09-04 00:15:22'),
(40,'updated','product',10,'Rishi has created Alexa Speaker',9,'2024-09-04 00:15:31','2024-09-04 00:15:31'),
(41,'updated','product',10,'Rishi has created Alexa Speaker',9,'2024-09-04 00:15:46','2024-09-04 00:15:46'),
(42,'created','product',11,'Karan has created Asus Gaming Laptop',15,'2024-09-04 00:17:53','2024-09-04 00:17:53'),
(43,'updated','product',11,'Karan has created Asus Gaming Laptop',15,'2024-09-04 00:18:20','2024-09-04 00:18:20'),
(44,'created','product',12,'Karan has created Asus Vivo Book',15,'2024-09-04 00:19:19','2024-09-04 00:19:19'),
(45,'updated','category',1,'Raman has updated category \'Laptops\' to \'Laptops\' ',3,'2024-09-04 00:44:24','2024-09-04 00:44:24'),
(46,'updated','category',1,'Raman has updated category \'Laptop\' to \'Laptop\' ',3,'2024-09-04 00:44:32','2024-09-04 00:44:32'),
(47,'updated','role',10,'Raman has updated role \'vendor\' to \'product\'',3,'2024-09-04 00:56:06','2024-09-04 00:56:06'),
(48,'updated','product',9,'Raman has created Bajaj Led Light',3,'2024-09-05 04:05:41','2024-09-05 04:05:41'),
(49,'created','category',1,'Raman has created Electronics',3,'2024-09-05 05:32:29','2024-09-05 05:32:29'),
(50,'created','category',2,'Raman has created Home & Furniture',3,'2024-09-05 05:33:56','2024-09-05 05:33:56'),
(51,'created','category',3,'Raman has created Books & Media',3,'2024-09-05 05:34:13','2024-09-05 05:34:13'),
(52,'created','category',4,'Raman has created Health & Beauty',3,'2024-09-05 05:34:23','2024-09-05 05:34:23'),
(53,'created','category',5,'Raman has created Sports & Outdoors',3,'2024-09-05 05:34:33','2024-09-05 05:34:33'),
(54,'created','category',6,'Raman has created Automotive',3,'2024-09-05 05:34:49','2024-09-05 05:34:49'),
(55,'created','category',7,'Raman has created Jewelry',3,'2024-09-05 05:35:01','2024-09-05 05:35:01'),
(56,'created','category',8,'Raman has created Test',3,'2024-09-05 05:35:07','2024-09-05 05:35:07'),
(57,'in active','Category',8,'Raman has make the test Category in active',3,'2024-09-05 05:35:15','2024-09-05 05:35:15'),
(58,'created','sub category',1,'Raman has created Mobile Phones',3,'2024-09-05 05:36:11','2024-09-05 05:36:11'),
(59,'updated','sub category',1,'Raman has updated Mobile Phone',3,'2024-09-05 05:48:46','2024-09-05 05:48:46'),
(60,'updated','sub category',1,'Raman has updated Mobile Phones',3,'2024-09-05 05:49:27','2024-09-05 05:49:27'),
(61,'active','Category',8,'Raman has make the test Category active',3,'2024-09-05 05:49:46','2024-09-05 05:49:46'),
(62,'created','sub category',2,'Raman has created Test One',3,'2024-09-05 05:50:01','2024-09-05 05:50:01'),
(63,'created','sub category',3,'Raman has created Test Two',3,'2024-09-05 05:50:14','2024-09-05 05:50:14'),
(64,'in active','SubCategory',3,'Raman has make the test two SubCategory in active',3,'2024-09-05 05:50:19','2024-09-05 05:50:19'),
(65,'active','SubCategory',3,'Raman has make the test two SubCategory active',3,'2024-09-05 05:50:23','2024-09-05 05:50:23'),
(66,'updated','sub category',3,'Raman has updated Test Two Tgree',3,'2024-09-05 05:50:53','2024-09-05 05:50:53'),
(67,'created','sub category',4,'Raman has created Laptops',3,'2024-09-05 05:52:23','2024-09-05 05:52:23'),
(68,'created','sub category',5,'Raman has created Tablets',3,'2024-09-05 05:52:32','2024-09-05 05:52:32'),
(69,'created','sub category',6,'Raman has created Cameras',3,'2024-09-05 05:52:42','2024-09-05 05:52:42'),
(70,'created','sub category',7,'Raman has created Beds',3,'2024-09-05 05:52:57','2024-09-05 05:52:57'),
(71,'created','sub category',8,'Raman has created Sofas',3,'2024-09-05 05:53:06','2024-09-05 05:53:06'),
(72,'created','sub category',9,'Raman has created Tables',3,'2024-09-05 05:53:16','2024-09-05 05:53:16'),
(73,'created','sub category',10,'Raman has created Chairs',3,'2024-09-05 05:53:27','2024-09-05 05:53:27'),
(74,'created','sub category',11,'Raman has created Fiction',3,'2024-09-05 05:53:47','2024-09-05 05:53:47'),
(75,'created','sub category',12,'Raman has created Non Fiction',3,'2024-09-05 05:54:10','2024-09-05 05:54:10'),
(76,'created','sub category',13,'Raman has created Academic',3,'2024-09-05 05:54:21','2024-09-05 05:54:21'),
(77,'created','sub category',14,'Raman has created Childrens Books',3,'2024-09-05 05:54:38','2024-09-05 05:54:38'),
(78,'created','sub category',15,'Raman has created Movies & Tv Shows',3,'2024-09-05 05:55:38','2024-09-05 05:55:38'),
(79,'created','sub category',16,'Raman has created Music Cds & Vinyl',3,'2024-09-05 05:55:53','2024-09-05 05:55:53'),
(80,'created','sub category',17,'Raman has created Skincare',3,'2024-09-05 05:56:11','2024-09-05 05:56:11'),
(81,'created','sub category',18,'Raman has created Haircare',3,'2024-09-05 05:56:26','2024-09-05 05:56:26'),
(82,'created','sub category',19,'Raman has created Makeup',3,'2024-09-05 05:56:37','2024-09-05 05:56:37'),
(83,'created','sub category',20,'Raman has created Grooming Products',3,'2024-09-05 05:56:50','2024-09-05 05:56:50'),
(84,'created','sub category',21,'Raman has created Cricket',3,'2024-09-05 05:57:07','2024-09-05 05:57:07'),
(85,'created','sub category',22,'Raman has created Football',3,'2024-09-05 05:57:16','2024-09-05 05:57:16'),
(86,'created','sub category',23,'Raman has created Badminton',3,'2024-09-05 05:57:26','2024-09-05 05:57:26'),
(87,'created','sub category',24,'Raman has created Car Covers',3,'2024-09-05 05:58:03','2024-09-05 05:58:03'),
(88,'created','sub category',25,'Raman has created Seat Covers',3,'2024-09-05 05:58:17','2024-09-05 05:58:17'),
(89,'created','sub category',26,'Raman has created Helmets',3,'2024-09-05 05:58:33','2024-09-05 05:58:33'),
(90,'created','sub category',27,'Raman has created Gloves',3,'2024-09-05 05:58:46','2024-09-05 05:58:46'),
(91,'created','sub category',28,'Raman has created Rings',3,'2024-09-05 05:58:56','2024-09-05 05:58:56'),
(92,'created','sub category',29,'Raman has created Earrings',3,'2024-09-05 05:59:06','2024-09-05 05:59:06'),
(93,'created','sub category',30,'Raman has created Necklaces',3,'2024-09-05 05:59:15','2024-09-05 05:59:15'),
(94,'created','sub category',31,'Raman has created Bracelets',3,'2024-09-05 05:59:25','2024-09-05 05:59:25'),
(95,'in active','Category',6,'Raman has make the automotive Category in active',3,'2024-09-05 06:02:59','2024-09-05 06:02:59'),
(96,'active','Category',6,'Raman has make the automotive Category active',3,'2024-09-05 06:03:11','2024-09-05 06:03:11'),
(97,'in active','Category',3,'Raman has make the books & media Category in active',3,'2024-09-05 06:03:31','2024-09-05 06:03:31'),
(98,'in active','SubCategory',5,'Raman has make the tablets SubCategory in active',3,'2024-09-05 06:05:18','2024-09-05 06:05:18'),
(99,'active','SubCategory',5,'Raman has make the tablets SubCategory active',3,'2024-09-05 06:05:22','2024-09-05 06:05:22'),
(100,'created','brand',1,'Raman has created Adidas',3,'2024-09-05 07:26:05','2024-09-05 07:26:05'),
(101,'created','brand',2,'Raman has created asus',3,'2024-09-05 07:26:14','2024-09-05 07:26:14'),
(102,'created','brand',3,'Raman has created hp',3,'2024-09-05 07:26:21','2024-09-05 07:26:21'),
(103,'created','brand',4,'Raman has created Zara',3,'2024-09-05 07:29:26','2024-09-05 07:29:26'),
(104,'created','brand',5,'Raman has created Redmi',3,'2024-09-05 07:29:37','2024-09-05 07:29:37'),
(105,'created','brand',6,'Raman has created Samsung',3,'2024-09-05 07:29:45','2024-09-05 07:29:45'),
(106,'created','brand',7,'Raman has created Iphone',3,'2024-09-05 07:29:56','2024-09-05 07:29:56'),
(107,'created','product',1,'Karan has created Redmi 13c 5g (startrail Silver, 4gb Ram, 128gb Storage)',15,'2024-09-05 08:37:11','2024-09-05 08:37:11'),
(108,'updated','product',1,'Raman has updated Redmi 13c 5g (startrail Silver, 4gb Ram, 128gb Storage)',3,'2024-09-05 08:51:38','2024-09-05 08:51:38'),
(109,'in active','Brand',1,'Raman has make the adidas Brand in active',3,'2024-09-06 00:11:27','2024-09-06 00:11:27'),
(110,'active','Brand',1,'Raman has make the adidas Brand active',3,'2024-09-06 00:11:28','2024-09-06 00:11:28'),
(111,'created','category',9,'Raman has created Books',3,'2024-09-06 00:13:15','2024-09-06 00:13:15'),
(112,'created','product',1,'Rishi has created Skinkraft - India’s 1 Customized Skincare Regimen',9,'2024-09-09 10:23:08','2024-09-09 10:23:08'),
(113,'created','product',2,'Karan has created Asus Vivobook 14 Thin And Light Laptop',15,'2024-09-10 05:51:06','2024-09-10 05:51:06'),
(114,'created','product',3,'Rishi has created Redmi 13c 5g',9,'2024-09-11 05:05:12','2024-09-11 05:05:12'),
(115,'created','product',5,'Rishi has created Samsung Guru',9,'2024-09-11 08:33:30','2024-09-11 08:33:30'),
(116,'created','product',6,'Rishi has created Samsung Guru',9,'2024-09-13 04:47:15','2024-09-13 04:47:15'),
(117,'updated','product',6,'Rishi has updated Samsung Guru',9,'2024-09-13 04:47:40','2024-09-13 04:47:40'),
(118,'updated','product',6,'Rishi has updated Samsung Guru',9,'2024-09-13 04:50:17','2024-09-13 04:50:17'),
(119,'updated','product',6,'Rishi has updated Samsung Guru',9,'2024-09-13 05:09:45','2024-09-13 05:09:45'),
(120,'updated','product',6,'Rishi has updated Samsung Guru',9,'2024-09-13 05:15:41','2024-09-13 05:15:41'),
(121,'updated','product',6,'Rishi has updated Samsung Guru',9,'2024-09-13 05:40:09','2024-09-13 05:40:09'),
(122,'created','product',7,'Rishi has created Lymio Men T-shirt',9,'2024-09-13 05:54:14','2024-09-13 05:54:14'),
(123,'created','course',2,'Sanam has created \'\' course',23,'2024-11-04 15:38:14','2024-11-04 15:38:14'),
(124,'created','course',2,'Sanam has created \'\' course',23,'2024-11-04 15:42:08','2024-11-04 15:42:08'),
(125,'created','course',2,'Sanam has created \'\' course',23,'2024-11-04 15:42:14','2024-11-04 15:42:14'),
(126,'created','course',2,'Sanam has created \'\' course',23,'2024-11-04 15:47:22','2024-11-04 15:47:22'),
(127,'unpublish','course',2,'Sanam has updated publish type of course ',23,'2024-11-06 10:10:49','2024-11-06 10:10:49'),
(128,'unpublish','course',2,'Sanam has updated publish type of course ',23,'2024-11-06 10:10:53','2024-11-06 10:10:53'),
(129,'unpublish','course',2,'Sanam has updated publish type of course ',23,'2024-11-06 10:11:05','2024-11-06 10:11:05'),
(130,'publish','course',2,'Sanam has updated publish type of course ',23,'2024-11-06 10:11:49','2024-11-06 10:11:49'),
(131,'unpublish','course',2,'Sanam has updated publish type of course ',23,'2024-11-06 10:11:56','2024-11-06 10:11:56'),
(132,'publish','course',2,'Sanam has updated publish type of course ',23,'2024-11-06 10:12:00','2024-11-06 10:12:00'),
(133,'created','course',3,'Sanam has created \'\' course',23,'2024-11-06 10:16:28','2024-11-06 10:16:28'),
(134,'unpublish','course',3,'Sanam has updated publish type of course ',23,'2024-11-06 10:16:34','2024-11-06 10:16:34'),
(135,'publish','course',3,'Sanam has updated publish type of course ',23,'2024-11-06 10:16:36','2024-11-06 10:16:36'),
(136,'created','course',3,'Sanam has created \'\' course',23,'2024-11-06 10:16:44','2024-11-06 10:16:44'),
(137,'unpublish','course',3,'Sanam has updated publish type of course ',23,'2024-11-06 10:16:47','2024-11-06 10:16:47'),
(138,'publish','course',3,'Sanam has updated publish type of course ',23,'2024-11-06 10:17:35','2024-11-06 10:17:35'),
(139,'created','course',3,'Sanam has created \'\' course',23,'2024-11-06 10:23:22','2024-11-06 10:23:22'),
(140,'created','course',3,'Sanam has created \'\' course',23,'2024-11-06 10:39:52','2024-11-06 10:39:52'),
(141,'created','product',8,'Mohit has created Palm Oil',20,'2024-11-06 11:43:32','2024-11-06 11:43:32'),
(142,'unpublish','product',8,'Mohit has updated publish type of product ',20,'2024-11-06 11:43:48','2024-11-06 11:43:48'),
(143,'publish','product',8,'Mohit has updated publish type of product ',20,'2024-11-06 11:43:53','2024-11-06 11:43:53'),
(144,'created','courseCategory',9,'Shobit has created Test course category',2,'2024-11-06 14:22:23','2024-11-06 14:22:23'),
(145,'updated','courseCategory',9,'Shobit has updated Test course category',2,'2024-11-06 14:22:42','2024-11-06 14:22:42'),
(146,'created','course',4,'Sanam has created \'\' course',23,'2024-11-06 14:37:27','2024-11-06 14:37:27'),
(147,'updated','course',4,'Sanam has updated \'\' course',23,'2024-11-06 14:38:13','2024-11-06 14:38:13'),
(148,'created','product',9,'Shyam has created Cranberry Pepper Bliss Fragrance Oil',14,'2024-11-11 11:16:15','2024-11-11 11:16:15'),
(149,'unpublish','product',9,'Shyam has updated publish type of product ',14,'2024-11-11 11:31:49','2024-11-11 11:31:49'),
(150,'created','product',10,'Shyam has created Elderberry And Evergreen Fragrance Oil',14,'2024-11-11 11:35:26','2024-11-11 11:35:26'),
(151,'created','product',11,'Shyam has created Moon Child Fragrance Oil',14,'2024-11-11 11:37:07','2024-11-11 11:37:07'),
(152,'created','product',12,'Shyam has created Frosted Fir Fragrance Oil',14,'2024-11-11 11:37:59','2024-11-11 11:37:59'),
(153,'created','product',13,'Shyam has created Lavender 40/42 Essential Oil',14,'2024-11-11 11:40:05','2024-11-11 11:40:05'),
(154,'created','product',14,'Shyam has created Oatmeal Milk And Honey Fragrance Oil',14,'2024-11-11 11:41:34','2024-11-11 11:41:34'),
(155,'created','product',15,'Shyam has created Wild Cranberry And Aspen Fragrance Oil',14,'2024-11-11 11:43:05','2024-11-11 11:43:05'),
(156,'created','product',16,'Shyam has created Candy Cane Fragrance Oil',14,'2024-11-11 11:44:48','2024-11-11 11:44:48'),
(157,'created','product',17,'Shyam has created Apple Sage Fragrance Oil',14,'2024-11-11 11:46:16','2024-11-11 11:46:16'),
(158,'publish','product',8,'Mohit has updated publish type of product ',20,'2024-11-12 12:43:36','2024-11-12 12:43:36'),
(159,'updated','product',8,'Mohit has updated Palm Oil',20,'2024-11-12 12:43:53','2024-11-12 12:43:53'),
(160,'updated','product',8,'Mohit has updated Palm Oil',20,'2024-11-12 12:48:01','2024-11-12 12:48:01'),
(161,'updated','product',8,'Mohit has updated Palm Oil',20,'2024-11-12 12:53:23','2024-11-12 12:53:23'),
(162,'updated','product',8,'Mohit has updated Palm Oil',20,'2024-11-12 13:03:41','2024-11-12 13:03:41'),
(163,'created','course',5,'Sanam has created \'\' course',23,'2024-11-21 09:40:03','2024-11-21 09:40:03'),
(164,'updated','course',5,'Sanam has updated \'\' course',23,'2024-11-21 09:40:24','2024-11-21 09:40:24'),
(165,'updated','user',14,'Shyam has updated the profile',14,'2024-11-22 10:05:41','2024-11-22 10:05:41'),
(166,'updated','product',17,'Shyam has updated Apple Sage Fragrance Oil',14,'2024-11-26 10:47:40','2024-11-26 10:47:40'),
(167,'created','product',18,'Shyam has created Pink Strawberry Fragrance Oil',14,'2024-11-26 11:23:05','2024-11-26 11:23:05'),
(168,'updated','product',18,'Shyam has updated Pink Strawberry Fragrance Oil',14,'2024-11-26 11:25:39','2024-11-26 11:25:39'),
(169,'updated','product',17,'Shyam has updated Apple Sage Fragrance Oil',14,'2024-11-26 11:26:12','2024-11-26 11:26:12'),
(170,'updated','product',16,'Shyam has updated Candy Cane Fragrance Oil',14,'2024-11-26 11:26:26','2024-11-26 11:26:26'),
(171,'updated','product',15,'Shyam has updated Wild Cranberry And Aspen Fragrance Oil',14,'2024-11-26 11:26:38','2024-11-26 11:26:38'),
(172,'updated','product',14,'Shyam has updated Oatmeal Milk And Honey Fragrance Oil',14,'2024-11-26 11:27:27','2024-11-26 11:27:27'),
(173,'updated','product',15,'Shyam has updated Wild Cranberry And Aspen Fragrance Oil',14,'2024-11-26 11:28:12','2024-11-26 11:28:12'),
(174,'updated','product',14,'Shyam has updated Oatmeal Milk And Honey Fragrance Oil',14,'2024-11-26 11:28:54','2024-11-26 11:28:54'),
(175,'updated','product',13,'Shyam has updated Lavender 40/42 Essential Oil',14,'2024-11-26 11:29:14','2024-11-26 11:29:14'),
(176,'updated','product',12,'Shyam has updated Frosted Fir Fragrance Oil',14,'2024-11-26 11:29:30','2024-11-26 11:29:30'),
(177,'updated','product',11,'Shyam has updated Moon Child Fragrance Oil',14,'2024-11-26 11:29:57','2024-11-26 11:29:57'),
(178,'updated','product',10,'Shyam has updated Elderberry And Evergreen Fragrance Oil',14,'2024-11-26 11:30:09','2024-11-26 11:30:09'),
(179,'updated','product',9,'Shyam has updated Cranberry Pepper Bliss Fragrance Oil',14,'2024-11-26 11:30:22','2024-11-26 11:30:22'),
(180,'updated','product',8,'Mohit has updated Palm Oil',20,'2024-11-26 11:31:31','2024-11-26 11:31:31'),
(181,'updated','product',2,'Karan has updated Asus Vivobook 14 Thin And Light Laptop',15,'2024-11-26 11:32:35','2024-11-26 11:32:35'),
(182,'updated','product',7,'Rishi has updated Lymio Men T-shirt',9,'2024-11-26 11:33:26','2024-11-26 11:33:26'),
(183,'updated','product',6,'Rishi has updated Samsung Guru',9,'2024-11-26 11:33:37','2024-11-26 11:33:37'),
(184,'updated','product',3,'Rishi has updated Redmi 13c 5g',9,'2024-11-26 11:33:58','2024-11-26 11:33:58'),
(185,'updated','product',1,'Rishi has updated Skinkraft - India’s 1 Customized Skincare Regimen',9,'2024-11-26 11:34:11','2024-11-26 11:34:11'),
(186,'updated','orderItems',7,'Shyam has updated the delivery status to delivered',14,'2024-12-05 11:21:11','2024-12-05 11:21:11'),
(187,'create','course',2,'Sanam has send mail to customer regarding String Art',23,'2024-12-06 12:16:50','2024-12-06 12:16:50'),
(188,'sendEmail','ManualEmail',3,'Sanam has send mail to customer regarding String Art',23,'2024-12-06 12:22:07','2024-12-06 12:22:07'),
(189,'unpublish','course',2,'Sanam has updated publish type of course ',23,'2024-12-06 12:23:00','2024-12-06 12:23:00'),
(190,'publish','course',2,'Sanam has updated publish type of course ',23,'2024-12-06 13:09:19','2024-12-06 13:09:19'),
(191,'sendEmail','ManualEmail',4,'Sanam has send mail to customer regarding String Art',23,'2024-12-06 13:09:39','2024-12-06 13:09:39'),
(192,'sendEmail','ManualEmail',5,'Sanam has send mail to customer regarding String Art',23,'2024-12-06 14:13:10','2024-12-06 14:13:10'),
(193,'sendEmail','ManualEmail',6,'Sanam has send mail to customer regarding String Art',23,'2024-12-06 14:13:30','2024-12-06 14:13:30'),
(194,'sendEmail','ManualEmail',7,'Sanam has send mail to customer regarding String Art',23,'2024-12-06 14:14:24','2024-12-06 14:14:24'),
(195,'sendEmail','ManualEmail',8,'Sanam has send mail to customer regarding String Art',23,'2024-12-06 14:23:24','2024-12-06 14:23:24'),
(196,'sendEmail','ManualEmail',9,'Sanam has send mail to customer regarding String Art',23,'2024-12-06 14:23:41','2024-12-06 14:23:41'),
(197,'unpublish','course',2,'Sanam has updated publish type of course ',23,'2024-12-06 14:24:05','2024-12-06 14:24:05'),
(198,'publish','course',2,'Sanam has updated publish type of course ',23,'2024-12-06 14:24:23','2024-12-06 14:24:23');

/*Table structure for table `addresses` */

DROP TABLE IF EXISTS `addresses`;

CREATE TABLE `addresses` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `customer_id` int(11) DEFAULT NULL,
  `address_line1` text DEFAULT NULL,
  `address_line2` text DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `state` varchar(255) DEFAULT NULL,
  `zip_code` varchar(255) DEFAULT NULL,
  `country` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `addresses` */

insert  into `addresses`(`id`,`customer_id`,`address_line1`,`address_line2`,`city`,`state`,`zip_code`,`country`,`created_at`,`updated_at`) values 
(1,1,'house number; 12, Street no. 4,','house number; 12, Street no. 4,','Jalandhar city','Punjab','144001','India','2024-09-04 09:00:05','2024-09-04 09:00:05'),
(3,1,'test 12, street 6,','test 12, street 6,','Jalandhar city','Punjab','144001','India','2024-10-22 09:28:29','2024-09-20 11:20:19');

/*Table structure for table `brands` */

DROP TABLE IF EXISTS `brands`;

CREATE TABLE `brands` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `slug` varchar(255) DEFAULT NULL,
  `position` int(11) DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `brands` */

insert  into `brands`(`id`,`name`,`slug`,`position`,`is_active`,`created_at`,`updated_at`) values 
(1,'adidas','adidas',1,1,'2024-09-06 05:41:28','2024-09-05 07:26:05'),
(2,'asus','asus',2,1,'2024-09-05 07:26:14','2024-09-05 07:26:14'),
(3,'hp','hp',3,1,'2024-09-05 07:26:21','2024-09-05 07:26:21'),
(4,'zara','zara',4,1,'2024-09-05 07:29:25','2024-09-05 07:29:25'),
(5,'redmi','redmi',5,1,'2024-09-05 07:29:37','2024-09-05 07:29:37'),
(6,'samsung','samsung',6,1,'2024-09-05 07:29:45','2024-09-05 07:29:45'),
(7,'iphone','iphone',7,1,'2024-09-05 07:29:56','2024-09-05 07:29:56');

/*Table structure for table `categories` */

DROP TABLE IF EXISTS `categories`;

CREATE TABLE `categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `slug` varchar(255) DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=126 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `categories` */

insert  into `categories`(`id`,`name`,`slug`,`is_active`,`image`,`created_at`,`updated_at`) values 
(1,'skincare','skincare',1,'category_1730871365.jpg','2024-11-06 11:06:05','2024-11-06 11:06:05'),
(2,'serums','serums',1,NULL,'2024-10-22 15:47:53','2024-10-22 15:47:53'),
(3,'solvent & hydrosols','solvent-hydrosols',1,NULL,'2024-10-22 15:47:53','2024-10-22 15:47:53'),
(4,'actives','actives',1,NULL,'2024-10-22 15:47:53','2024-10-22 15:47:53'),
(5,'extracts','extracts',1,NULL,'2024-10-22 15:47:53','2024-10-22 15:47:53'),
(6,'oil soluble','oil-soluble',1,NULL,'2024-10-23 10:58:20','2024-10-23 10:58:20'),
(7,'water soluble','water-soluble',1,NULL,'2024-10-22 15:47:53','2024-10-22 15:47:53'),
(8,'fragrance oil','fragrance-oil',1,NULL,'2024-10-22 15:47:53','2024-10-22 15:47:53'),
(9,'balms & butters','balms-butters',1,NULL,'2024-10-22 15:47:53','2024-10-22 15:47:53'),
(10,'waxes','waxes',1,NULL,'2024-10-22 15:47:53','2024-10-22 15:47:53'),
(11,'oils','oils',1,NULL,'2024-10-22 15:47:53','2024-10-22 15:47:53'),
(12,'extracts','extracts',1,NULL,'2024-10-22 15:47:53','2024-10-22 15:47:53'),
(13,'oil soluble','oil-soluble',1,NULL,'2024-10-22 15:47:53','2024-10-22 15:47:53'),
(14,'water soluble','water-soluble',1,NULL,'2024-10-22 15:47:53','2024-10-22 15:47:53'),
(15,'fragrance oil','fragrance-oil',1,NULL,'2024-10-22 15:47:53','2024-10-22 15:47:53'),
(16,'masks','masks',1,NULL,'2024-10-22 15:47:53','2024-10-22 15:47:53'),
(17,'clay','clay',1,NULL,'2024-10-22 15:47:53','2024-10-22 15:47:53'),
(18,'solvent & hydrosol','solvent-hydrosol',1,NULL,'2024-10-22 15:47:53','2024-10-22 15:47:53'),
(19,'oils','oils',1,NULL,'2024-10-22 15:47:53','2024-10-22 15:47:53'),
(20,'actives','actives',1,NULL,'2024-10-22 15:47:53','2024-10-22 15:47:53'),
(21,'extracts','extracts',1,NULL,'2024-10-22 15:47:53','2024-10-22 15:47:53'),
(22,'oil soluble','oil-soluble',1,NULL,'2024-10-22 15:47:53','2024-10-22 15:47:53'),
(23,'water soluble','water-soluble',1,NULL,'2024-10-22 15:47:53','2024-10-22 15:47:53'),
(24,'fragrance oil','fragrance-oil',1,NULL,'2024-10-22 15:47:53','2024-10-22 15:47:53'),
(25,'art','art',1,NULL,'2024-10-24 09:13:52','2024-10-24 09:13:52'),
(26,'indian art','indian-art',1,NULL,'2024-09-07 05:18:51','2024-09-07 05:18:51'),
(27,'mandala','mandala',1,NULL,'2024-09-07 05:19:10','2024-09-07 05:19:10'),
(28,'diy kits','diy-kits',1,NULL,'2024-09-07 05:19:39','2024-09-07 05:19:39'),
(29,'mdf boards','mdf-boards',1,NULL,'2024-09-07 05:19:56','2024-09-07 05:19:56'),
(30,'colourants','colourants',1,NULL,'2024-09-07 05:20:10','2024-09-07 05:20:10'),
(31,'mirrors','mirrors',1,NULL,'2024-09-07 05:24:50','2024-09-07 05:24:50'),
(32,'stationary & others','stationary-others',1,NULL,'2024-09-07 05:25:07','2024-09-07 05:25:07'),
(33,'lippan & pichwai','lippan-pichwai',1,NULL,'2024-09-07 05:25:26','2024-09-07 05:25:26'),
(34,'diy kits','diy-kits',1,NULL,'2024-09-07 05:25:37','2024-09-07 05:25:37'),
(35,'mdf boards','mdf-boards',1,NULL,'2024-09-07 05:25:50','2024-09-07 05:25:50'),
(36,'colourants','colourants',1,NULL,'2024-09-07 05:26:05','2024-09-07 05:26:05'),
(37,'mirrors','mirrors',1,NULL,'2024-09-07 05:26:16','2024-09-07 05:26:16'),
(38,'stationary & others','stationary-others',1,NULL,'2024-09-07 05:26:36','2024-09-07 05:26:36'),
(39,'modern art','modern-art',1,NULL,'2024-09-07 05:26:53','2024-09-07 05:26:53'),
(40,'fluid art','fluid-art',1,NULL,'2024-09-07 05:27:07','2024-09-07 05:27:07'),
(41,'diy kits','diy-kits',1,NULL,'2024-09-07 05:27:29','2024-09-07 05:27:29'),
(42,'mdf boards','mdf-boards',1,NULL,'2024-09-07 05:27:45','2024-09-07 05:27:45'),
(43,'canvas boards','canvas-boards',1,NULL,'2024-09-07 05:28:01','2024-09-07 05:28:01'),
(44,'colourants','colourants',1,NULL,'2024-09-07 05:28:18','2024-09-07 05:28:18'),
(45,'sculpture art','sculpture-art',1,NULL,'2024-09-07 05:28:37','2024-09-07 05:28:37'),
(46,'diy kits','diy-kits',1,NULL,'2024-09-07 05:29:37','2024-09-07 05:29:37'),
(47,'mdf boards','mdf-boards',1,NULL,'2024-09-07 05:29:51','2024-09-07 05:29:51'),
(48,'canvas boards','canvas-boards',1,NULL,'2024-09-07 05:30:06','2024-09-07 05:30:06'),
(49,'colourants','colourants',1,NULL,'2024-09-07 05:30:19','2024-09-07 05:30:19'),
(50,'calligraphy','calligraphy',1,NULL,'2024-09-07 05:30:39','2024-09-07 05:30:39'),
(51,'diy kits','diy-kits',1,NULL,'2024-09-07 05:30:54','2024-09-07 05:30:54'),
(52,'calligraphy papers','calligraphy-papers',1,NULL,'2024-09-07 05:31:05','2024-09-07 05:31:05'),
(53,'calligraphy colours & pens','calligraphy-colours-pens',1,NULL,'2024-09-07 05:31:25','2024-09-07 05:31:25'),
(54,'painting','painting',1,NULL,'2024-09-07 05:31:44','2024-09-07 05:31:44'),
(55,'diy kits','diy-kits',1,NULL,'2024-09-07 05:32:12','2024-09-07 05:32:12'),
(56,'brushes','brushes',1,NULL,'2024-09-07 05:32:24','2024-09-07 05:32:24'),
(57,'colours','colours',1,NULL,'2024-09-07 05:32:35','2024-09-07 05:32:35'),
(58,'sheets & canvas','sheets-canvas',1,NULL,'2024-09-07 05:32:54','2024-09-07 05:32:54'),
(59,'accessories','accessories',1,NULL,'2024-09-07 05:33:10','2024-09-07 05:33:10'),
(60,'bath supplies','bath-supplies',1,NULL,'2024-09-07 05:33:38','2024-09-07 05:33:38'),
(61,'cold process soap','cold-process-soap',1,NULL,'2024-09-07 05:34:05','2024-09-07 05:34:05'),
(62,'lye','lye',1,NULL,'2024-09-07 05:34:17','2024-09-07 05:34:17'),
(63,'oils','oils',1,NULL,'2024-09-07 05:34:38','2024-09-07 05:34:38'),
(64,'butters','butters',1,NULL,'2024-09-07 05:34:52','2024-09-07 05:34:52'),
(65,'fragrance oils','fragrance-oils',1,NULL,'2024-09-07 05:35:05','2024-09-07 05:35:05'),
(66,'essential oils','essential-oils',1,NULL,'2024-09-07 05:35:18','2024-09-07 05:35:18'),
(67,'herbs & powders','herbs-powders',1,NULL,'2024-09-07 05:35:37','2024-09-07 05:35:37'),
(68,'colourants','colourants',1,NULL,'2024-09-07 05:35:51','2024-09-07 05:35:51'),
(69,'additives','additives',1,NULL,'2024-09-07 05:36:06','2024-09-07 05:36:06'),
(70,'clay','clay',1,NULL,'2024-09-07 05:36:20','2024-09-07 05:36:20'),
(71,'melt and pour soap','melt-and-pour-soap',1,NULL,'2024-09-07 05:36:47','2024-09-07 05:36:47'),
(72,'soap bases','soap-bases',1,NULL,'2024-09-07 05:37:02','2024-09-07 05:37:02'),
(73,'oils','oils',1,NULL,'2024-09-07 05:37:14','2024-09-07 05:37:14'),
(74,'butters','butters',1,NULL,'2024-09-07 05:37:26','2024-09-07 05:37:26'),
(75,'fragrance oils','fragrance-oils',1,NULL,'2024-09-07 05:37:38','2024-09-07 05:37:38'),
(76,'essential oils','essential-oils',1,NULL,'2024-09-07 05:37:57','2024-09-07 05:37:57'),
(77,'clay','clay',1,NULL,'2024-09-07 05:38:10','2024-09-07 05:38:10'),
(78,'packaging','packaging',1,NULL,'2024-09-07 05:38:22','2024-09-07 05:38:22'),
(79,'whipped cream soap','whipped-cream-soap',1,NULL,'2024-09-07 05:38:41','2024-09-07 05:38:41'),
(80,'surfactants','surfactants',1,NULL,'2024-09-07 05:38:54','2024-09-07 05:38:54'),
(81,'solvent & hydrosols','solvent-hydrosols',1,NULL,'2024-09-07 05:39:18','2024-09-07 05:39:18'),
(82,'additives','additives',1,NULL,'2024-09-07 05:39:30','2024-09-07 05:39:30'),
(83,'oils','oils',1,NULL,'2024-09-07 05:39:57','2024-09-07 05:39:57'),
(84,'fragrance and oils','fragrance-and-oils',1,NULL,'2025-02-19 10:05:25','2025-02-19 10:01:37'),
(85,'perfume','perfume',1,NULL,'2024-09-07 05:40:52','2024-09-07 05:40:52'),
(86,'solvent & hydrosols','solvent-hydrosols',1,NULL,'2024-09-07 05:41:08','2024-09-07 05:41:08'),
(87,'additives','additives',1,NULL,'2024-09-07 05:41:25','2024-09-07 05:41:25'),
(88,'oils','oils',1,NULL,'2024-09-07 05:41:41','2024-09-07 05:41:41'),
(89,'wax','wax',1,NULL,'2024-09-07 05:41:55','2024-09-07 05:41:55'),
(90,'extracts','extracts',1,NULL,'2024-09-07 05:42:17','2024-09-07 05:42:17'),
(91,'butters','butters',1,NULL,'2024-09-07 05:42:30','2024-09-07 05:42:30'),
(92,'fragrance oils','fragrance-oils',1,NULL,'2024-09-07 05:42:46','2024-09-07 05:42:46'),
(93,'essential oils','essential-oils',1,NULL,'2024-09-07 05:43:07','2024-09-07 05:43:07'),
(94,'lip oils','lip-oils',1,NULL,'2024-09-07 05:43:28','2024-09-07 05:43:28'),
(95,'carrier oils','carrier-oils',1,NULL,'2024-09-07 05:43:44','2024-09-07 05:43:44'),
(96,'fragrance oil','fragrance-oil',1,NULL,'2024-09-07 05:43:59','2024-09-07 05:43:59'),
(97,'essential oils','essential-oils',1,NULL,'2024-09-07 05:44:14','2024-09-07 05:44:14'),
(98,'herbs & powders','herbs-powders',1,NULL,'2024-09-07 05:48:03','2024-09-07 05:48:03'),
(102,'electronics','electronics',1,NULL,'2024-09-10 05:48:22','2024-09-10 05:48:22'),
(103,'mobile','mobile',1,NULL,'2024-09-10 05:48:35','2024-09-10 05:48:35'),
(104,'laptop','laptop',1,NULL,'2024-09-10 05:48:48','2024-09-10 05:48:48'),
(105,'cloths','cloths',1,NULL,'2024-09-13 05:50:31','2024-09-13 05:50:31'),
(106,'mens','mens',1,NULL,'2024-09-13 05:51:08','2024-09-13 05:51:08'),
(107,'women','women',1,NULL,'2024-09-13 05:51:18','2024-09-13 05:51:18'),
(108,'shirt','shirt',1,NULL,'2024-09-13 05:51:31','2024-09-13 05:51:31'),
(109,'t shirt','t-shirt',1,NULL,'2024-09-13 05:52:05','2024-09-13 05:52:05'),
(110,'resin supplies','resin-supplies',1,NULL,'2024-10-22 16:39:35','2024-10-22 16:39:35'),
(111,'resin moulds','resin-moulds',1,NULL,'2024-10-22 16:51:58','2024-10-22 16:39:35'),
(112,'colours & pigments','colours-pigments',1,NULL,'2024-10-22 16:51:59','2024-10-22 16:39:35'),
(113,'stickers','stickers',1,NULL,'2024-10-22 16:52:00','2024-10-22 16:39:35'),
(114,'clock material','clock-material',1,NULL,'2024-10-22 16:52:01','2024-10-22 16:39:35'),
(115,'resin & hardener','resin-hardener',1,NULL,'2024-10-22 16:52:02','2024-10-22 16:39:35'),
(125,'test','test',1,'category_1739940296.jpeg','2025-02-19 10:14:56','2025-02-19 10:14:56');

/*Table structure for table `customers` */

DROP TABLE IF EXISTS `customers`;

CREATE TABLE `customers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `phone_number` varchar(60) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `customers` */

insert  into `customers`(`id`,`user_id`,`phone_number`,`created_at`,`updated_at`) values 
(1,3,'8989898989','2025-02-19 09:50:55','2025-02-19 09:50:58');

/*Table structure for table `failed_jobs` */

DROP TABLE IF EXISTS `failed_jobs`;

CREATE TABLE `failed_jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `failed_jobs` */

/*Table structure for table `migrations` */

DROP TABLE IF EXISTS `migrations`;

CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `migrations` */

insert  into `migrations`(`id`,`migration`,`batch`) values 
(1,'2014_10_12_000000_create_users_table',1),
(2,'2014_10_12_100000_create_password_reset_tokens_table',1),
(3,'2019_08_19_000000_create_failed_jobs_table',1),
(4,'2019_12_14_000001_create_personal_access_tokens_table',1);

/*Table structure for table `modules` */

DROP TABLE IF EXISTS `modules`;

CREATE TABLE `modules` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `modules` */

insert  into `modules`(`id`,`name`,`created_at`,`updated_at`) values 
(2,'user','2024-08-24 10:49:12','2024-08-24 05:19:12'),
(4,'product','2024-09-04 00:58:27','2024-09-04 00:58:27'),
(5,'category','2024-09-07 04:37:05','2024-09-07 04:37:05');

/*Table structure for table `password_reset_tokens` */

DROP TABLE IF EXISTS `password_reset_tokens`;

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `password_reset_tokens` */

/*Table structure for table `permission_role` */

DROP TABLE IF EXISTS `permission_role`;

CREATE TABLE `permission_role` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `role_id` int(11) DEFAULT NULL,
  `permission_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `permission_role` */

insert  into `permission_role`(`id`,`role_id`,`permission_id`) values 
(23,10,14),
(24,10,15),
(25,10,16),
(26,12,20),
(27,12,21),
(28,12,22);

/*Table structure for table `permissions` */

DROP TABLE IF EXISTS `permissions`;

CREATE TABLE `permissions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `module_id` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `permissions` */

insert  into `permissions`(`id`,`name`,`description`,`module_id`,`created_at`,`updated_at`) values 
(7,'management','user management',2,'2024-08-24 05:19:39','2024-08-24 05:19:39'),
(14,'create',NULL,4,'2024-09-04 00:58:49','2024-09-04 00:58:49'),
(15,'update',NULL,4,'2024-09-04 00:58:57','2024-09-04 00:58:57'),
(16,'view',NULL,4,'2024-09-04 01:00:22','2024-09-04 01:00:22'),
(17,'view',NULL,5,'2024-09-07 04:37:18','2024-09-07 04:37:18'),
(18,'create',NULL,5,'2024-09-07 04:37:31','2024-09-07 04:37:31'),
(19,'update',NULL,5,'2024-09-07 04:37:41','2024-09-07 04:37:41');

/*Table structure for table `personal_access_tokens` */

DROP TABLE IF EXISTS `personal_access_tokens`;

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) unsigned NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `personal_access_tokens` */

/*Table structure for table `product_images` */

DROP TABLE IF EXISTS `product_images`;

CREATE TABLE `product_images` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` int(11) DEFAULT NULL,
  `url` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `product_images` */

/*Table structure for table `products` */

DROP TABLE IF EXISTS `products`;

CREATE TABLE `products` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `category_id` int(11) DEFAULT NULL,
  `brand_id` int(11) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `slug` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `price_without_tax` varchar(60) DEFAULT NULL,
  `tax` varchar(60) DEFAULT NULL,
  `sale_price` varchar(60) DEFAULT NULL,
  `mrp_price` varchar(60) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `unit` varchar(255) DEFAULT NULL,
  `weight` varchar(255) DEFAULT NULL,
  `publish_type` varchar(255) DEFAULT NULL,
  `product_created_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `products` */

/*Table structure for table `role_user` */

DROP TABLE IF EXISTS `role_user`;

CREATE TABLE `role_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `role_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=75 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `role_user` */

insert  into `role_user`(`id`,`user_id`,`role_id`) values 
(60,2,1),
(74,3,10);

/*Table structure for table `roles` */

DROP TABLE IF EXISTS `roles`;

CREATE TABLE `roles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `roles` */

insert  into `roles`(`id`,`name`,`description`,`created_at`,`updated_at`) values 
(1,'admin',NULL,'2024-08-22 17:04:59','2024-08-22 17:04:51'),
(10,'customer',NULL,'2025-02-19 09:42:43','2025-02-19 09:42:43');

/*Table structure for table `users` */

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT NULL,
  `super_admin` tinyint(1) DEFAULT NULL,
  `profile_pic` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `users` */

insert  into `users`(`id`,`name`,`email`,`email_verified_at`,`password`,`remember_token`,`is_active`,`super_admin`,`profile_pic`,`created_at`,`updated_at`) values 
(1,'Technical Admin','technicaladmin@gmail.com',NULL,'$2y$12$4blrrWw4zrRODPH7MVdESuDtnROIcEZ.nyQ0y0gc2lxh3trJv3B7u',NULL,1,1,NULL,'2025-02-02 05:58:35','2025-02-02 05:58:35'),
(2,'admin','admin@gmail.com',NULL,'$2y$12$wsy83ruH3W3R7VWNejE98.4SZGN91UibqcH69qXxdvoSLWlYl.ZHi',NULL,1,NULL,'user_1739898611.jpeg','2025-02-18 17:10:11','2025-02-18 17:10:11'),
(3,'test customer','customer@gmail.com',NULL,'$2y$12$wsy83ruH3W3R7VWNejE98.4SZGN91UibqcH69qXxdvoSLWlYl.ZHi',NULL,1,NULL,NULL,'2025-02-19 09:50:17','2025-02-19 09:50:22');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
