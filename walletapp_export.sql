-- MariaDB dump 10.19  Distrib 10.4.32-MariaDB, for Win64 (AMD64)
--
-- Host: localhost    Database: walletapp
-- ------------------------------------------------------
-- Server version	10.4.32-MariaDB

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
-- Table structure for table `beneficiaries`
--

DROP TABLE IF EXISTS `beneficiaries`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `beneficiaries` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `beneficiaries`
--

LOCK TABLES `beneficiaries` WRITE;
/*!40000 ALTER TABLE `beneficiaries` DISABLE KEYS */;
/*!40000 ALTER TABLE `beneficiaries` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cache`
--

DROP TABLE IF EXISTS `cache`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` bigint(20) NOT NULL,
  PRIMARY KEY (`key`),
  KEY `cache_expiration_index` (`expiration`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cache`
--

LOCK TABLES `cache` WRITE;
/*!40000 ALTER TABLE `cache` DISABLE KEYS */;
/*!40000 ALTER TABLE `cache` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cache_locks`
--

DROP TABLE IF EXISTS `cache_locks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` bigint(20) NOT NULL,
  PRIMARY KEY (`key`),
  KEY `cache_locks_expiration_index` (`expiration`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cache_locks`
--

LOCK TABLES `cache_locks` WRITE;
/*!40000 ALTER TABLE `cache_locks` DISABLE KEYS */;
/*!40000 ALTER TABLE `cache_locks` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `chat_messages`
--

DROP TABLE IF EXISTS `chat_messages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `chat_messages` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL,
  `sender_id` bigint(20) unsigned NOT NULL,
  `message` text NOT NULL,
  `is_from_admin` tinyint(1) NOT NULL DEFAULT 0,
  `is_read` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `chat_messages_user_id_created_at_index` (`user_id`,`created_at`),
  KEY `chat_messages_user_id_is_read_index` (`user_id`,`is_read`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `chat_messages`
--

LOCK TABLES `chat_messages` WRITE;
/*!40000 ALTER TABLE `chat_messages` DISABLE KEYS */;
INSERT INTO `chat_messages` VALUES (1,3,3,'salam',0,1,'2026-06-04 21:21:38','2026-06-04 21:22:43'),(2,3,2,'salam buyurun',1,1,'2026-06-04 21:22:59','2026-06-04 21:26:05');
/*!40000 ALTER TABLE `chat_messages` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `failed_jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) NOT NULL,
  `connection` varchar(255) NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`),
  KEY `failed_jobs_connection_queue_failed_at_index` (`connection`,`queue`,`failed_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `failed_jobs`
--

LOCK TABLES `failed_jobs` WRITE;
/*!40000 ALTER TABLE `failed_jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `failed_jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `fees`
--

DROP TABLE IF EXISTS `fees`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `fees` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `fees`
--

LOCK TABLES `fees` WRITE;
/*!40000 ALTER TABLE `fees` DISABLE KEYS */;
/*!40000 ALTER TABLE `fees` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `job_batches`
--

DROP TABLE IF EXISTS `job_batches`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `job_batches`
--

LOCK TABLES `job_batches` WRITE;
/*!40000 ALTER TABLE `job_batches` DISABLE KEYS */;
/*!40000 ALTER TABLE `job_batches` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jobs`
--

DROP TABLE IF EXISTS `jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` smallint(5) unsigned NOT NULL,
  `reserved_at` int(10) unsigned DEFAULT NULL,
  `available_at` int(10) unsigned NOT NULL,
  `created_at` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jobs`
--

LOCK TABLES `jobs` WRITE;
/*!40000 ALTER TABLE `jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `jobs` ENABLE KEYS */;
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
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'0001_01_01_000000_create_users_table',1),(2,'0001_01_01_000001_create_cache_table',1),(3,'0001_01_01_000002_create_jobs_table',1),(4,'2026_05_17_185417_create_wallets_table',2),(5,'2026_06_01_000000_add_user_id_and_balance_to_wallets_table',3),(6,'2026_06_01_100000_create_transactions_table',3),(7,'2026_06_03_130838_add_pin_to_wallets_table',4),(8,'2026_06_03_130848_create_transaction_limits_table',4),(9,'2026_06_03_130858_create_fees_table',4),(10,'2026_06_03_130907_create_scheduled_transfers_table',4),(11,'2026_06_03_130923_create_beneficiaries_table',4),(12,'2026_06_03_130932_add_metadata_to_transactions_table',4),(13,'2026_06_03_213821_create_wallets_table',5),(14,'2026_06_03_220121_add_admin_fields_to_users_table',6),(15,'2026_06_03_220135_create_verification_requests_table',6),(16,'2026_06_04_001240_add_missing_columns_to_wallets_table',7),(17,'2026_06_04_074249_add_wallet_columns_to_transactions_table',8),(18,'2026_06_04_075910_add_id_card_fields_to_users_table',9),(19,'2026_06_04_082504_add_verification_type_to_verification_requests_table',10),(20,'2026_06_04_130000_make_passport_path_nullable_in_verification_requests',11),(21,'2026_06_04_150000_create_notification_logs_table',11);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `notification_logs`
--

DROP TABLE IF EXISTS `notification_logs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `notification_logs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL,
  `type` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `amount` decimal(15,2) DEFAULT NULL,
  `metadata` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`metadata`)),
  `is_read` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `notification_logs_user_id_created_at_index` (`user_id`,`created_at`),
  CONSTRAINT `notification_logs_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `notification_logs`
--

LOCK TABLES `notification_logs` WRITE;
/*!40000 ALTER TABLE `notification_logs` DISABLE KEYS */;
INSERT INTO `notification_logs` VALUES (1,3,'money_sent','Money Sent','You sent $5.00 to Maksim.',5.00,'{\"reference\":\"TXN_1780587204_3\"}',1,'2026-06-04 13:33:24','2026-06-04 13:47:30'),(2,5,'money_received','Money Received','You received $5.00 from Amir Aslan.',5.00,'{\"reference\":\"TXN_1780587204_3\"}',1,'2026-06-04 13:33:24','2026-06-04 13:51:22'),(3,5,'wallet_top_up','Wallet Top Up','You added $25.00 to your wallet.',25.00,'{\"reference\":\"TOPUP_1780608993_5\"}',1,'2026-06-04 19:36:33','2026-06-04 19:36:33'),(4,5,'wallet_top_up','Wallet Top Up','You added $50.00 to your wallet.',50.00,'{\"reference\":\"TOPUP_1780611151_5\"}',1,'2026-06-04 20:12:31','2026-06-04 20:12:31'),(5,5,'money_sent','Money Sent','You sent $5.00 to Amir Aslan.',5.00,'{\"reference\":\"TXN_1780611598_5\"}',1,'2026-06-04 20:19:58','2026-06-04 20:19:58'),(6,3,'money_received','Money Received','You received $5.00 from Maksim Aliyev.',5.00,'{\"reference\":\"TXN_1780611598_5\"}',1,'2026-06-04 20:19:58','2026-06-04 20:20:57'),(7,5,'money_sent','Money Sent','You sent $5.00 to Amir Aslan.',5.00,'{\"reference\":\"TXN_1780617506_5\"}',1,'2026-06-04 21:58:26','2026-06-04 21:58:26'),(8,3,'money_received','Money Received','You received $5.00 from Maksim Aliyev.',5.00,'{\"reference\":\"TXN_1780617506_5\"}',1,'2026-06-04 21:58:26','2026-06-04 21:59:04');
/*!40000 ALTER TABLE `notification_logs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_reset_tokens`
--

DROP TABLE IF EXISTS `password_reset_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `password_reset_tokens`
--

LOCK TABLES `password_reset_tokens` WRITE;
/*!40000 ALTER TABLE `password_reset_tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_reset_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `scheduled_transfers`
--

DROP TABLE IF EXISTS `scheduled_transfers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `scheduled_transfers` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `scheduled_transfers`
--

LOCK TABLES `scheduled_transfers` WRITE;
/*!40000 ALTER TABLE `scheduled_transfers` DISABLE KEYS */;
/*!40000 ALTER TABLE `scheduled_transfers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sessions`
--

DROP TABLE IF EXISTS `sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) unsigned DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sessions`
--

LOCK TABLES `sessions` WRITE;
/*!40000 ALTER TABLE `sessions` DISABLE KEYS */;
INSERT INTO `sessions` VALUES ('bVe54NGN2Inc8Rh6PwOs1QHVzOe2uJCzk9c8Ir6U',2,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36','eyJfdG9rZW4iOiJGS21OejlqZlNRVEpMeDQ1bkZGMEdaa1J0bUNoelV0bEtOeGlOQUhvIiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cLzEyNy4wLjAuMTo4MDAwXC9hZG1pblwvdXNlcnMiLCJyb3V0ZSI6ImFkbWluLnVzZXJzIn0sIl9mbGFzaCI6eyJvbGQiOltdLCJuZXciOltdfSwidXJsIjpbXSwibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiOjJ9',1780939106),('vgFgdbYuO8fVUERYuzSLcfuuxD7AZT5glEvwB50V',5,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36','eyJfdG9rZW4iOiJZZHY5RzlubnFjak03S2RmVk05ZU5FSGR5Z1QxcUFIb0xjSWFIWXlDIiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cLzEyNy4wLjAuMTo4MDAwXC90cmFuc2ZlciIsInJvdXRlIjoid2FsbGV0LnRyYW5zZmVyLmZvcm0ifSwiX2ZsYXNoIjp7Im9sZCI6W10sIm5ldyI6W119LCJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI6NX0=',1780696195),('XfvYR1HGd0D8oAyMetEMpzkNoSlxNM6jVeiGeLgY',2,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36 Edg/148.0.0.0','eyJfdG9rZW4iOiJreEhiT1locnVYRUY3VlAwbDg1cmhlY2hDUmR5ODhTQnpXME9tTTdYIiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cLzEyNy4wLjAuMTo4MDAwXC9hZG1pblwvZGFzaGJvYXJkIiwicm91dGUiOiJhZG1pbi5kYXNoYm9hcmQifSwiX2ZsYXNoIjp7Im9sZCI6W10sIm5ldyI6W119LCJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI6Mn0=',1780617963),('Y8JGdA9rp54Nam2xV663X7dED0r8DyLsGMFTl3go',2,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36','eyJfdG9rZW4iOiI4dklGQlo2UVI5eGFYY3ZTc1NLQmxoeno4cm5IOGJBR3VZTVViWUdwIiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cLzEyNy4wLjAuMTo4MDAwIiwicm91dGUiOiJob21lIn0sIl9mbGFzaCI6eyJvbGQiOltdLCJuZXciOltdfSwibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiOjJ9',1780617764),('Z0NfZALUuZuljror0PeakQGqBOjmmzq63T1bDnzu',NULL,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Verdent/2.2.22 Chrome/142.0.7444.265 Electron/39.8.7 Safari/537.36','eyJfdG9rZW4iOiJzRGpnNGpwSjJ4akhvdjJRQlEybUdsbUU3UmtSbzdPdG5DVGkxSXg4IiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cLzEyNy4wLjAuMTo4MDAwXC9fZml4XC9jcmVhdGUtY2hhdC10YWJsZSIsInJvdXRlIjpudWxsfSwiX2ZsYXNoIjp7Im9sZCI6W10sIm5ldyI6W119fQ==',1780615270);
/*!40000 ALTER TABLE `sessions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `transaction_limits`
--

DROP TABLE IF EXISTS `transaction_limits`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `transaction_limits` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `transaction_limits`
--

LOCK TABLES `transaction_limits` WRITE;
/*!40000 ALTER TABLE `transaction_limits` DISABLE KEYS */;
/*!40000 ALTER TABLE `transaction_limits` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `transactions`
--

DROP TABLE IF EXISTS `transactions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `transactions` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `sender_wallet_id` bigint(20) unsigned DEFAULT NULL,
  `receiver_wallet_id` bigint(20) unsigned DEFAULT NULL,
  `user_id` bigint(20) unsigned NOT NULL,
  `type` enum('deposit','withdrawal','transfer') NOT NULL DEFAULT 'deposit',
  `amount` decimal(15,2) NOT NULL,
  `reference` varchar(255) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `status` enum('completed','pending','failed') NOT NULL DEFAULT 'completed',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `transactions_reference_unique` (`reference`),
  KEY `transactions_user_id_index` (`user_id`),
  CONSTRAINT `transactions_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `transactions`
--

LOCK TABLES `transactions` WRITE;
/*!40000 ALTER TABLE `transactions` DISABLE KEYS */;
INSERT INTO `transactions` VALUES (1,NULL,NULL,3,'deposit',10.00,'TOPUP_1780580440_3','Top up via Bank transfer','completed','2026-06-04 11:40:40','2026-06-04 11:40:40'),(2,NULL,NULL,3,'deposit',10.00,'TOPUP_1780580455_3','Top up via Mobile money','completed','2026-06-04 11:40:55','2026-06-04 11:40:55'),(3,NULL,NULL,3,'deposit',10.00,'TOPUP_1780580462_3','Top up via Card','completed','2026-06-04 11:41:02','2026-06-04 11:41:02'),(4,NULL,NULL,3,'deposit',25.00,'TOPUP_1780581365_3','Wallet top up','completed','2026-06-04 11:56:05','2026-06-04 11:56:05'),(5,NULL,NULL,3,'deposit',25.00,'TOPUP_1780581398_3','Wallet top up','completed','2026-06-04 11:56:38','2026-06-04 11:56:38'),(6,NULL,NULL,3,'transfer',10.00,'TXN_1780585419_3','Good luck','completed','2026-06-04 13:03:39','2026-06-04 13:03:39'),(7,NULL,NULL,5,'deposit',10.00,'TXN_1780585419_3_R','Received from Amir Aslan','completed','2026-06-04 13:03:39','2026-06-04 13:03:39'),(8,NULL,NULL,3,'transfer',5.00,'TXN_1780587204_3','Good job','completed','2026-06-04 13:33:24','2026-06-04 13:33:24'),(9,NULL,NULL,5,'deposit',5.00,'TXN_1780587204_3_R','Received from Amir Aslan','completed','2026-06-04 13:33:24','2026-06-04 13:33:24'),(10,NULL,NULL,5,'deposit',25.00,'TOPUP_1780608993_5','Wallet top up','completed','2026-06-04 19:36:33','2026-06-04 19:36:33'),(11,NULL,NULL,5,'deposit',50.00,'TOPUP_1780611151_5','Wallet top up','completed','2026-06-04 20:12:31','2026-06-04 20:12:31'),(12,NULL,NULL,5,'transfer',5.00,'TXN_1780611598_5','Transfer to Amir Aslan','completed','2026-06-04 20:19:58','2026-06-04 20:19:58'),(13,NULL,NULL,3,'deposit',5.00,'TXN_1780611598_5_R','Received from Maksim Aliyev','completed','2026-06-04 20:19:58','2026-06-04 20:19:58'),(14,NULL,NULL,5,'transfer',5.00,'TXN_1780617506_5','Good luck','completed','2026-06-04 21:58:26','2026-06-04 21:58:26'),(15,NULL,NULL,3,'deposit',5.00,'TXN_1780617506_5_R','Received from Maksim Aliyev','completed','2026-06-04 21:58:26','2026-06-04 21:58:26');
/*!40000 ALTER TABLE `transactions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `is_admin` tinyint(1) NOT NULL DEFAULT 0,
  `is_verified` tinyint(1) NOT NULL DEFAULT 0,
  `id_card_verified` tinyint(1) NOT NULL DEFAULT 0,
  `verified_at` timestamp NULL DEFAULT NULL,
  `passport_path` varchar(255) DEFAULT NULL,
  `id_card_path` varchar(255) DEFAULT NULL,
  `id_card_type` enum('passport','driving_license','national_id','other') DEFAULT NULL,
  `rejection_reason` text DEFAULT NULL,
  `id_card_rejection_reason` text DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `profile_image` varchar(255) DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'Test User','testuser@example.test',0,0,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'$2y$12$Z.YevDqA1eVeNAdZxzQwGOGLNmiieVGOYTFivvjSBPHcXnAkFNQyG',NULL,NULL,'2026-06-01 05:52:24','2026-06-01 05:52:24'),(2,'Admin','tyupityup@gmail.com',1,0,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'$2y$12$fZjoOBIucIElIoT09sR55OYMZzpmT7f/hi5FQkX/vTOxLl2Zoeh02','uploads/profile_images/rasul-eminli-2-1780433404.jpg',NULL,'2026-06-01 06:12:56','2026-06-04 18:20:14'),(3,'Amir Aslan','resul.re56@gmail.com',0,1,1,'2026-06-04 11:19:21','verifications/passports/user3_passport.jpg',NULL,NULL,NULL,NULL,NULL,'$2y$12$Mi4myCCHFmr3l8eVm/v0EejtNIHzsxGWbJiy0sd4dDmxv2vjIP9QW','uploads/profile_images/amir-aslan-3-1780559801.jpg',NULL,'2026-06-03 19:55:33','2026-06-04 11:19:21'),(4,'Admin User','admin@example.com',0,0,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'$2y$12$lK21ATHvj/Vgcv9FfsMdweONb7kohJyH6kbz2H1molD89HSHJkhGC',NULL,NULL,'2026-06-03 20:15:58','2026-06-03 20:15:58'),(5,'Maksim Aliyev','americo@gmail.com',0,1,1,'2026-06-04 13:02:36','verifications/passports/pRtOC0UR1rWofyRtPjwSidB6hf2kpDPBDgVfPEh1.jpg','verifications/id_cards/NvorHbF6LoAnPxzpp8vr7Qb87hgGNosioPWy7afu.jpg','national_id',NULL,NULL,NULL,'$2y$12$ibylZiSMK9y39dEhqXHxPOjUEz1bI0wePHAph5N/GghC8nMGhYqkW','uploads/profile_images/maksim-aliyev-5-1780611129.jpg',NULL,'2026-06-04 12:58:54','2026-06-04 20:12:09');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `verification_requests`
--

DROP TABLE IF EXISTS `verification_requests`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `verification_requests` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL,
  `passport_path` varchar(255) DEFAULT NULL,
  `id_card_path` varchar(255) DEFAULT NULL,
  `id_card_type` varchar(255) DEFAULT NULL,
  `status` enum('pending','approved','rejected') NOT NULL DEFAULT 'pending',
  `verification_type` enum('passport','id_card','both') NOT NULL DEFAULT 'passport',
  `admin_notes` text DEFAULT NULL,
  `reviewed_by` bigint(20) unsigned DEFAULT NULL,
  `reviewed_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `verification_requests_user_id_foreign` (`user_id`),
  KEY `verification_requests_reviewed_by_foreign` (`reviewed_by`),
  CONSTRAINT `verification_requests_reviewed_by_foreign` FOREIGN KEY (`reviewed_by`) REFERENCES `users` (`id`),
  CONSTRAINT `verification_requests_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `verification_requests`
--

LOCK TABLES `verification_requests` WRITE;
/*!40000 ALTER TABLE `verification_requests` DISABLE KEYS */;
INSERT INTO `verification_requests` VALUES (1,3,'verifications/passports/sample_passport.jpg',NULL,NULL,'approved','passport',NULL,2,'2026-06-04 11:02:12','2026-06-04 05:57:32','2026-06-04 11:02:12'),(2,3,'verifications/passports/user3_passport.jpg','verifications/id_cards/GKqLLCdQJMWitpZr0rX5rORufO6gVhftIBEgM72t.jpg','national_id','approved','id_card',NULL,2,'2026-06-04 11:19:21','2026-06-04 10:50:56','2026-06-04 11:19:21'),(3,5,'verifications/passports/pRtOC0UR1rWofyRtPjwSidB6hf2kpDPBDgVfPEh1.jpg',NULL,NULL,'approved','passport',NULL,2,'2026-06-04 13:02:25','2026-06-04 13:01:16','2026-06-04 13:02:25'),(4,5,'verifications/passports/pRtOC0UR1rWofyRtPjwSidB6hf2kpDPBDgVfPEh1.jpg','verifications/id_cards/NvorHbF6LoAnPxzpp8vr7Qb87hgGNosioPWy7afu.jpg','national_id','approved','id_card',NULL,2,'2026-06-04 13:02:36','2026-06-04 13:01:27','2026-06-04 13:02:36');
/*!40000 ALTER TABLE `verification_requests` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wallets`
--

DROP TABLE IF EXISTS `wallets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wallets` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `wallet_address` varchar(255) NOT NULL,
  `user_id` bigint(20) unsigned DEFAULT NULL,
  `balance` decimal(15,2) NOT NULL DEFAULT 0.00,
  `currency` varchar(3) NOT NULL DEFAULT 'USD',
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `wallets_wallet_address_unique` (`wallet_address`),
  KEY `wallets_user_id_foreign` (`user_id`),
  CONSTRAINT `wallets_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wallets`
--

LOCK TABLES `wallets` WRITE;
/*!40000 ALTER TABLE `wallets` DISABLE KEYS */;
INSERT INTO `wallets` VALUES (1,'WLT_WPOGSSJLSYN1',3,75.00,'USD',1,'2026-06-03 22:18:21','2026-06-04 21:58:26'),(2,'WLT_INJKZBJVNSIQ',1,0.00,'USD',1,'2026-06-03 22:21:24','2026-06-03 22:21:24'),(3,'WLT_89GVL5EMFKHY',2,0.00,'USD',1,'2026-06-03 22:21:24','2026-06-03 22:21:24'),(4,'WLT_APKV5KYXXESG',4,0.00,'USD',1,'2026-06-03 22:21:24','2026-06-03 22:21:24'),(5,'WLT_QRJ70V9LAGNR',5,80.00,'USD',1,'2026-06-04 12:58:54','2026-06-04 21:58:26');
/*!40000 ALTER TABLE `wallets` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping routines for database 'walletapp'
--
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2026-06-08 19:22:39
