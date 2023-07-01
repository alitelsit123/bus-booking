-- MariaDB dump 10.19  Distrib 10.11.3-MariaDB, for Linux (x86_64)
--
-- Host: localhost    Database: bus_booking
-- ------------------------------------------------------
-- Server version	10.11.3-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `bookings`
--

DROP TABLE IF EXISTS `bookings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `bookings` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `code` varchar(255) DEFAULT NULL,
  `token` varchar(255) DEFAULT NULL,
  `date` varchar(255) DEFAULT NULL,
  `gross_amount` bigint(20) unsigned NOT NULL,
  `start_book` varchar(255) DEFAULT NULL,
  `end_book` varchar(255) DEFAULT NULL,
  `data` text DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  `user_id` bigint(20) unsigned DEFAULT NULL,
  `bus_id` bigint(20) unsigned DEFAULT NULL,
  `payment_date` varchar(255) DEFAULT NULL,
  `status_booking` varchar(255) DEFAULT NULL,
  `city_from` varchar(255) DEFAULT NULL,
  `location_from` text DEFAULT NULL,
  `city_to` varchar(255) DEFAULT NULL,
  `location_to` text DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bookings`
--

LOCK TABLES `bookings` WRITE;
/*!40000 ALTER TABLE `bookings` DISABLE KEYS */;
INSERT INTO `bookings` VALUES
(4,'INV-64961259547EC','8c2c0070-663f-4866-9e93-95cf2f8eda9f','2023-06-24',75000000,'2023-06-24','2023-07-24',NULL,'settlement',3,2,'2023-06-24 08:06:09','',NULL,NULL,NULL,NULL),
(5,'INV-649612DC7398D','cef30f12-3ce5-46f0-81ff-1f71ace4afb2','2023-06-24',8000000,'2023-06-22','2023-06-30',NULL,'settlement',3,1,'2023-06-24 04:49:59','Belum di ambil',NULL,NULL,NULL,NULL),
(6,'INV-649640C2DD50A','0fb231b5-b891-46a3-be5a-0f1100277ad1','2023-06-24',7800000,'2023-06-24','2023-06-30',NULL,'pending',3,3,NULL,NULL,NULL,NULL,NULL,NULL);
/*!40000 ALTER TABLE `bookings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `busses`
--

DROP TABLE IF EXISTS `busses`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `busses` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `code` varchar(255) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `plat` varchar(255) DEFAULT NULL,
  `mesin` varchar(255) DEFAULT NULL,
  `type_id` bigint(20) unsigned DEFAULT NULL,
  `year` int(11) DEFAULT NULL,
  `seat` int(11) DEFAULT NULL,
  `price_daily` bigint(20) NOT NULL DEFAULT 0,
  `status` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `busses`
--

LOCK TABLES `busses` WRITE;
/*!40000 ALTER TABLE `busses` DISABLE KEYS */;
INSERT INTO `busses` VALUES
(1,'Bus Kencana','Dengan Garansi Uang Kembali, sekarang penumpang dapat membatalkan tiket bus Pahala Kencana mereka dan mendapatkan uang kembali. Pelanggan hanya harus memastikan bahwa add-on Garansi Uang Kembali telah dipilih saat mereka memesan tiket bus Pahala Kencana melalui platform redBus. Penumpang akan harus membayar biaya layanan saat mereka memilih add-on Garansi Uang Kembali. Dengan ini, pelanggan dapat menerima uang kembali dalam jumlah wajar sampai 75% dari harga tiket bus mereka jika mereka membatalkan tiket sebelum perjalanan bus dimulai. Garansi Uang Kembali menawarkan fleksibilitas dan menghilangkan ketidaknyamanan yang timbul jika pelanggan harus membatalkan tiket bus Pahala Kencana mereka akibat keadaan yang tidak terduga.','BUS-6493C1BA0B351','6494faed28cda.png','KJ0389R','Scania',6,2009,50,1000000,'Active'),
(2,'Sumber','Berikut ini adalah beberapa alasan mengapa banyak orang memilih PO Pahala Kencana sebagai pilihan utama ketika bepergian menggunakan bus:\r\n\r\nHarga tiket bus yang terjangkau.\r\nTiket bus online Pahala Kencana relatif terjangkau, dimulai dari Rp200.000, sehingga cocok bagi para pelancong dengan bujet terbatas.\r\n\r\nPengalaman yang mumpuni.\r\nPahala Kencana telah beroperasi selama puluhan tahun dan memiliki pengalaman yang cukup dalam menghadapi berbagai situasi dan kondisi jalan.\r\n\r\nPilihan waktu Keberangkatan yang banyak.\r\nPahala Kencana bus menyediakan banyak pilihan jam keberangkatan, sehingga memudahkan para penumpang dalam memilih jadwal yang sesuai dengan kebutuhan mereka.','BUS-6494F896B7A3D','6494f89698c6e.png','KB0002H','Turbo',7,2020,40,2500000,'Tidak Aktif'),
(3,'Sugeng Selamat','PO Pahala Kencana selalu melayani penumpang di kota-kota besar yang tersebar di Pulau Jawa, Bali hingga Sumatera.','BUS-6494FB2C9BC90','6494fb2c99b7f.png','PO02223','Turbo',7,2019,30,1300000,'Active');
/*!40000 ALTER TABLE `busses` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `companies`
--

DROP TABLE IF EXISTS `companies`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `companies` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` text NOT NULL,
  `alias` text DEFAULT NULL,
  `address` text DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `companies`
--

LOCK TABLES `companies` WRITE;
/*!40000 ALTER TABLE `companies` DISABLE KEYS */;
INSERT INTO `companies` VALUES
(1,'PT Trans Salim Barakatullah','Potranssaba','Magetan','0892384823','test@gmail.com');
/*!40000 ALTER TABLE `companies` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES
(1,'2014_10_12_000000_create_users_table',1),
(2,'2019_12_14_000001_create_personal_access_tokens_table',1),
(3,'2023_06_17_212304_create_types_table',2),
(12,'2023_06_17_220231_create_busses_table',3),
(13,'2023_06_22_021155_create_companies_table',3),
(14,'2023_06_23_021230_refactor_to_companies_table',4),
(16,'2023_06_23_164057_create_bookings_table',5),
(17,'2023_06_23_212421_add_payment_date_to_bookings_table',6),
(18,'2023_06_23_220824_add_status_booking_to_bookings_table',7),
(19,'2023_07_01_084856_add_book_attrs_to_bookings_table',8);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `personal_access_tokens`
--

DROP TABLE IF EXISTS `personal_access_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
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
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `personal_access_tokens`
--

LOCK TABLES `personal_access_tokens` WRITE;
/*!40000 ALTER TABLE `personal_access_tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `personal_access_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `types`
--

DROP TABLE IF EXISTS `types`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `types` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `types`
--

LOCK TABLES `types` WRITE;
/*!40000 ALTER TABLE `types` DISABLE KEYS */;
INSERT INTO `types` VALUES
(6,'Luxury'),
(8,'test');
/*!40000 ALTER TABLE `types` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `email` varchar(255) NOT NULL,
  `password` text NOT NULL,
  `name` varchar(255) NOT NULL,
  `nik` text DEFAULT NULL,
  `phone` text DEFAULT NULL,
  `address` text DEFAULT NULL,
  `role` varchar(255) DEFAULT 'costumer',
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES
(1,'admin@gmail.com','$2y$10$5IYwNGKKEwZdxIFKmy9zaOwjPNJwcy0eX7q5oXkR5IWXTG74Ql2tK','admin','12345678','0987654321','jokja','admin'),
(2,'hikmal@gmail.com','$2y$10$feGoGqjaw.WmSKhKvoTvjemmLFtuuqLNBykd5TyHASPVL7GUotoFK','hikmal@gmail.com','0239409','099328948','laksfdj','customer'),
(3,'hikmalkoko3@gmail.com','$2y$10$9Ayt7IJ7JmARtTJ8KjD7BOhI.26VpTc9MJMOOzBZgmaeTn.8Rcm7C','eja','08928487234','0895355094422','jogjakarta','customer');
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

-- Dump completed on 2023-07-01 16:30:31
