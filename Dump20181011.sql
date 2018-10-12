-- MySQL dump 10.13  Distrib 5.7.23, for Linux (i686)
--
-- Host: localhost    Database: vcms
-- ------------------------------------------------------
-- Server version	5.6.37

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
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `category`
--

LOCK TABLES `category` WRITE;
/*!40000 ALTER TABLE `category` DISABLE KEYS */;
INSERT INTO `category` VALUES (1,'PHP',NULL,'2018-10-06 09:09:06','2018-10-06 09:09:06'),(2,'HTML',NULL,'2018-10-06 23:40:24','2018-10-06 23:40:24');
/*!40000 ALTER TABLE `category` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `configs`
--

DROP TABLE IF EXISTS `configs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `configs` (
  `key` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `configs`
--

LOCK TABLES `configs` WRITE;
/*!40000 ALTER TABLE `configs` DISABLE KEYS */;
INSERT INTO `configs` VALUES ('post_url','{\"model\":1}','2018-10-07 00:38:51','2018-10-07 00:38:51'),('theme','2','2018-10-07 09:13:43','2018-10-08 07:26:07');
/*!40000 ALTER TABLE `configs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'2014_10_12_000000_create_users_table',1),(2,'2014_10_12_100000_create_password_resets_table',1),(3,'2018_10_02_132105_create_post_table',1),(4,'2018_10_04_074635_create_category_table',1),(5,'2018_10_07_072108_create_config_table',2),(8,'2018_10_07_081234_create_theme_table',3);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_resets`
--

DROP TABLE IF EXISTS `password_resets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `password_resets` (
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `password_resets`
--

LOCK TABLES `password_resets` WRITE;
/*!40000 ALTER TABLE `password_resets` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_resets` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `posts`
--

DROP TABLE IF EXISTS `posts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `posts` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `category` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `article` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `author` int(11) NOT NULL,
  `cover` text COLLATE utf8mb4_unicode_ci,
  `draft` tinyint(1) NOT NULL,
  `url` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `posts`
--

LOCK TABLES `posts` WRITE;
/*!40000 ALTER TABLE `posts` DISABLE KEYS */;
INSERT INTO `posts` VALUES (4,'Belajar PHP 7.2 - Chapter 1 : Mengenal Server Side Scripting, Web Server dan PHP','[\"1\"]','<p>Buat Artikel Baru</p>','123',1,'',0,'belajar-php-72---chapter-1--mengenal-server-side-scripting--web-server-dan-php','2018-10-06 22:56:46','2018-10-08 07:45:27'),(5,'Belajar PHP 7.2 - Chapter 3 : Hello World!','[\"1\",\"2\"]','<p>Buat Artikel Baru213</p>','coba3',1,'',0,'belajar-php-72---chapter-3--hello-world','2018-10-06 23:29:43','2018-10-08 07:45:24'),(6,'Chapter 4','[]','<p>Buat Artikel Baru</p>','4',1,'',0,'chapter-4','2018-10-06 23:57:57','2018-10-08 07:45:20'),(7,'Belajar PHP 7.2 - Chapter 5 : Variabel dan Array','[\"1\"]','<p>artikel saya...</p>','123',1,'',0,'belajar-php-72---chapter-5--variabel-dan-array','2018-10-07 10:49:00','2018-10-08 07:45:17'),(8,'Ini postingan asal asalan gan, jangan dilihat ntar bingung','[]','<p>asal asalan</p>','ini deskripsis yang asal aslaan',1,'',0,'ini-postingan-asal-asalan-gan--jangan-dilihat-ntar-bingung','2018-10-07 10:58:52','2018-10-08 07:27:05'),(9,'chapter 6','[]','<p>Buat Artikel Baru</p>','6',1,'',0,'chapter-6','2018-10-08 10:35:38','2018-10-08 10:35:38'),(10,'chapter 7','[]','<p>Buat Artikel Baru7</p>','7',1,'',0,'chapter-7','2018-10-08 10:35:48','2018-10-08 10:35:48'),(11,'chapter 8','[]','<p>8Buat Artikel Baru</p>','8',1,'',0,'chapter-8','2018-10-08 10:35:58','2018-10-08 10:35:58'),(12,'Chapter 9','[]','<p>Buat Artikel Baru9</p>','9',1,'',0,'chapter-9','2018-10-10 05:50:53','2018-10-10 05:50:53'),(13,'Chapter 10','[]','<p>Buat Artikel Baru10</p>','10',1,'',0,'chapter-10','2018-10-10 05:51:06','2018-10-10 05:51:06'),(14,'Chapter 11','[]','<p>Buat Artikel Baru11</p>','11',1,'',0,'chapter-11','2018-10-10 05:51:15','2018-10-10 05:51:15');
/*!40000 ALTER TABLE `posts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `themes`
--

DROP TABLE IF EXISTS `themes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `themes` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `author` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `version` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `theme_home` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `theme_post` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `theme_search` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `theme_404` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `themes`
--

LOCK TABLES `themes` WRITE;
/*!40000 ALTER TABLE `themes` DISABLE KEYS */;
INSERT INTO `themes` VALUES (1,'Blogstrap','Alfian Dwi Nugraha','1.0.0','<h1>[:app.title:]</h1>\r\n<span>[:app.description:] | [:app.email:]</span><hr>\r\n	\r\n	[:set.config.title-max|20:]\r\n	[:set.config.max-symbol|..:]\r\n	[:set.config.category-null|Tidak ada kategori.:]\r\n	[:set.config.post-null|<center>Tidak ada Postingan sama sekali...</center>:]\r\n\r\n<div>\r\n  [:data.post.div.start:]\r\n  <div style=\"border: 1px dotted red;padding: 10px;\">\r\n    <h3>[:post.title:]</h3>\r\n    <p>[:post.description:]</p>\r\n    [:post.category|<span>[:post.category.text:]</span>|, :]\r\n    <a href=\"\">Lihat Selengkapnya...</a>\r\n  </div>\r\n  [:data.post.div.end:]\r\n</div>','post5','seacrh','404','0000-00-00 00:00:00','2018-10-07 11:08:08'),(2,'Traditional No CSS','Alfian Dwi Nugraha','1.0.0','<center>\r\n  <h1>\r\n    [:app.title:]\r\n  </h1>\r\n  <span>\r\n    [:app.description:]\r\n  </span>\r\n  <hr>\r\n</center>\r\n\r\n	[:set.config.post-glue|<hr>:]\r\n	[:set.config.category-null|Tidak ada kategori.:]\r\n	[:set.config.post-null|<center>Tidak ada Postingan.</center>:]\r\n	[:set.config.pagination-limit|1:]\r\n<div class=\"border: 1px dotted red;margin-top: 10px;\">\r\n    \r\n    <!-- Paginasi untuk tombol previous jika aktif -->\r\n    [:data.post.pagination-previous.active.start:]\r\n    <a href=\"[:url:]\">1 Sebelumnya</a>\r\n    [:data.post.pagination-previous.active.end:]\r\n    <!-- Paginasi untuk tombol previous jika tidak aktif -->\r\n    [:data.post.pagination-previous.disable.start:] \r\n 	<span>1 Sebelumnya</span>\r\n	[:data.post.pagination-previous.disable.end:]\r\n      \r\n    <!-- Paginasi untuk tombol halaman -->\r\n	[:data.post.pagination-btn-page.start:]\r\n    <span>\r\n      [<a href=\"[:url:]\">1 [:page:]</a>]\r\n    </span>\r\n	[:data.post.pagination-btn-page.end:]\r\n    \r\n    <!-- Paginasi untuk tombol next jika aktif -->\r\n    [:data.post.pagination-next.active.start:]\r\n    <a href=\"[:url:]\">1 Sesudah</a>\r\n    [:data.post.pagination-next.active.end:]\r\n    <!-- Paginasi untuk tombol nex jika tidak aktif -->\r\n    [:data.post.pagination-next.disable.start:]\r\n    1 Sesudah\r\n    [:data.post.pagination-next.disable.end:]\r\n  </div>\r\n<div style=\"border: 1px solid black;padding:15px;\">\r\n  <center><h2>Semua Post</h2></center>\r\n  [:data.post.div.start:]\r\n  <div style=\"padding-left: 10px;\">\r\n    <h3>[:post.title:]</h3>\r\n    <p>[:post.description:]</p>\r\n    <a href=\"\">Lihat Selengkapnya...</a>\r\n    <p>\r\n      [:post.category|<span>[:post.category.text:]</span>|, :]\r\n    </p>\r\n  </div>\r\n  [:data.post.div.end:]\r\n  <div class=\"border: 1px dotted red;margin-top: 10px;\">\r\n    \r\n    <!-- Paginasi untuk tombol previous jika aktif -->\r\n    [:data.post.pagination-previous.active.start:]\r\n    <a href=\"[:url:]\"> Sebelumnya</a>\r\n    [:data.post.pagination-previous.active.end:]\r\n    <!-- Paginasi untuk tombol previous jika tidak aktif -->\r\n    [:data.post.pagination-previous.disable.start:] \r\n 	<span>Sebelumnya</span>\r\n	[:data.post.pagination-previous.disable.end:]\r\n      \r\n    \r\n    <!-- Paginasi untuk tombol halaman -->\r\n	[:data.post.pagination-btn-page.start:]\r\n    <span>\r\n      [<a href=\"[:url:]\">[:page:]</a>]\r\n    </span>\r\n	[:data.post.pagination-btn-page.end:]\r\n    <!-- Paginasi untuk tombol halaman jika aktif -->\r\n	[:data.post.pagination-btn-page.active.start:]\r\n    <span>\r\n      [ [:page:] ]\r\n    </span>\r\n	[:data.post.pagination-btn-page.active.end:]\r\n    \r\n    \r\n    <!-- Paginasi untuk tombol next jika aktif -->\r\n    [:data.post.pagination-next.active.start:]\r\n    <a href=\"[:url:]\"> Sesudah</a>\r\n    [:data.post.pagination-next.active.end:]\r\n    <!-- Paginasi untuk tombol nex jika tidak aktif -->\r\n    [:data.post.pagination-next.disable.start:]\r\n    Sesudah\r\n    [:data.post.pagination-next.disable.end:]\r\n  </div>\r\n</div>','p','s','4',NULL,'2018-10-08 10:54:34');
/*!40000 ALTER TABLE `themes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'Alfian Dwi Nugraha','admin1@mail.com',NULL,'$2y$10$I7tYZitBVvvKcz8P0ZsxDeFF4xBVQTEXunCtdxOP5qxc.GQUVdVvS',NULL,'2018-10-06 09:06:37','2018-10-06 09:06:37');
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

-- Dump completed on 2018-10-11  2:37:27
