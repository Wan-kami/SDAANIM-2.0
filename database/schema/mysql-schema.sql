/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
DROP TABLE IF EXISTS `adoption_followups`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `adoption_followups` (
  `Segui_id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `Soli_id` bigint unsigned NOT NULL,
  `Segui_tipo` enum('Entrevista','Visita','Pos_visita') COLLATE utf8mb4_unicode_ci NOT NULL,
  `Segui_estado` enum('Pendiente','En proceso','Aprobada','Rechazada') COLLATE utf8mb4_unicode_ci NOT NULL,
  `Segui_descripcion` text COLLATE utf8mb4_unicode_ci,
  `Segui_fecha` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`Segui_id`),
  KEY `adoption_followups_soli_id_foreign` (`Soli_id`),
  CONSTRAINT `adoption_followups_soli_id_foreign` FOREIGN KEY (`Soli_id`) REFERENCES `adoption_requests` (`Soli_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `adoption_requests`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `adoption_requests` (
  `Soli_id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `Usu_documento` bigint unsigned NOT NULL,
  `Anim_id` bigint unsigned NOT NULL,
  `Soli_fecha` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `Soli_estado` enum('Pendiente','En Revisión','Aceptada','Rechazada') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Pendiente',
  `Soli_voluntario` bigint unsigned DEFAULT NULL,
  `Soli_motivo` text COLLATE utf8mb4_unicode_ci,
  `Soli_otras_mascotas` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `Soli_tipo_vivienda` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `Soli_tiempo_disponible` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `Soli_comentarios` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `visita_fecha` date DEFAULT NULL,
  `reporte_voluntario` text COLLATE utf8mb4_unicode_ci,
  `apto` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`Soli_id`),
  KEY `adoption_requests_usu_documento_foreign` (`Usu_documento`),
  KEY `adoption_requests_anim_id_foreign` (`Anim_id`),
  CONSTRAINT `adoption_requests_anim_id_foreign` FOREIGN KEY (`Anim_id`) REFERENCES `animals` (`Anim_id`) ON DELETE CASCADE,
  CONSTRAINT `adoption_requests_usu_documento_foreign` FOREIGN KEY (`Usu_documento`) REFERENCES `users` (`Usu_documento`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `animals`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `animals` (
  `Anim_id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `Anim_nombre` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Anim_raza` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Anim_edad` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Anim_estado` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Anim_foto` varchar(225) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `Anim_historia` text COLLATE utf8mb4_unicode_ci,
  `Anim_sexo` enum('Macho','Hembra') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`Anim_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `availabilities`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `availabilities` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `Usu_documento` bigint unsigned NOT NULL,
  `Ava_date` date NOT NULL,
  `Ava_start_time` time NOT NULL,
  `Ava_end_time` time NOT NULL,
  `Ava_status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Disponible',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `availabilities_usu_documento_foreign` (`Usu_documento`),
  CONSTRAINT `availabilities_usu_documento_foreign` FOREIGN KEY (`Usu_documento`) REFERENCES `users` (`Usu_documento`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `cache`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`),
  KEY `cache_expiration_index` (`expiration`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `cache_locks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`),
  KEY `cache_locks_expiration_index` (`expiration`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `cart_items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cart_items` (
  `cart_id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `Usu_documento` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `prod_id` bigint unsigned NOT NULL,
  `cart_cantidad` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`cart_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `donations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `donations` (
  `Don_id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `Usu_documento` bigint unsigned DEFAULT NULL,
  `Don_fecha` date NOT NULL,
  `Don_monto` decimal(10,2) NOT NULL,
  `Don_metodo_pago` enum('Nequi','PayPal','Daviplata','Bancolombia') COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`Don_id`),
  KEY `donations_usu_documento_foreign` (`Usu_documento`),
  CONSTRAINT `donations_usu_documento_foreign` FOREIGN KEY (`Usu_documento`) REFERENCES `users` (`Usu_documento`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `failed_jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `failed_jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `inscriptions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `inscriptions` (
  `ins_id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `ins_documento` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ins_nombre` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ins_email` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ins_direccion` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ins_telefono` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ins_tipo_rol` enum('voluntario','veterinario') COLLATE utf8mb4_unicode_ci NOT NULL,
  `ins_especialidad` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ins_experiencia_anos` int DEFAULT NULL,
  `ins_certificado` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ins_tipo_ayuda` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ins_comentario` text COLLATE utf8mb4_unicode_ci,
  `ins_estado` enum('Pendiente','Aprobada','Rechazada') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Pendiente',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`ins_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `job_batches`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `job_batches` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint unsigned NOT NULL,
  `reserved_at` int unsigned DEFAULT NULL,
  `available_at` int unsigned NOT NULL,
  `created_at` int unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `medical_histories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `medical_histories` (
  `Hist_id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `Anim_id` bigint unsigned NOT NULL,
  `Usu_documento` bigint unsigned NOT NULL,
  `Hist_fecha` datetime DEFAULT NULL,
  `Hist_diagnostico` text COLLATE utf8mb4_unicode_ci,
  `Hist_tratamiento` text COLLATE utf8mb4_unicode_ci,
  `Hist_observaciones` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`Hist_id`),
  KEY `medical_histories_usu_documento_foreign` (`Usu_documento`),
  KEY `medical_histories_anim_id_foreign` (`Anim_id`),
  CONSTRAINT `medical_histories_anim_id_foreign` FOREIGN KEY (`Anim_id`) REFERENCES `animals` (`Anim_id`) ON DELETE CASCADE,
  CONSTRAINT `medical_histories_usu_documento_foreign` FOREIGN KEY (`Usu_documento`) REFERENCES `users` (`Usu_documento`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `notifications`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `notifications` (
  `Noto_id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `Usu_documento` bigint unsigned NOT NULL,
  `Noti_mensaje` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Noti_link` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `Noti_fecha` date DEFAULT NULL,
  `read_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`Noto_id`),
  KEY `notifications_usu_documento_foreign` (`Usu_documento`),
  CONSTRAINT `notifications_usu_documento_foreign` FOREIGN KEY (`Usu_documento`) REFERENCES `users` (`Usu_documento`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `order_items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `order_items` (
  `oit_id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `ord_id` bigint unsigned NOT NULL,
  `prod_id` bigint unsigned NOT NULL,
  `oit_cantidad` int NOT NULL,
  `oit_precio_unitario` decimal(12,2) NOT NULL,
  `oit_subtotal` decimal(12,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`oit_id`),
  KEY `order_items_ord_id_foreign` (`ord_id`),
  KEY `order_items_prod_id_foreign` (`prod_id`),
  CONSTRAINT `order_items_ord_id_foreign` FOREIGN KEY (`ord_id`) REFERENCES `orders` (`ord_id`) ON DELETE CASCADE,
  CONSTRAINT `order_items_prod_id_foreign` FOREIGN KEY (`prod_id`) REFERENCES `products` (`prod_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `orders`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `orders` (
  `ord_id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `Usu_documento` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ord_estado` enum('pendiente','confirmado','recogido','cancelado') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pendiente',
  `ord_fechaCreacion` datetime NOT NULL,
  `ord_fechaExpiracion` datetime DEFAULT NULL,
  `ord_fechaRecogida` datetime DEFAULT NULL,
  `ord_total` decimal(12,2) NOT NULL DEFAULT '0.00',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`ord_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `password_reset_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `products`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `products` (
  `prod_id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `prod_nombre` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `prod_descripcion` text COLLATE utf8mb4_unicode_ci,
  `prod_categoria` enum('Alimentos','Juguetes','Camas','Accesorios','Ropa') COLLATE utf8mb4_unicode_ci NOT NULL,
  `prod_precio` decimal(10,2) NOT NULL,
  `prod_cantidad` int NOT NULL DEFAULT '0',
  `prod_imagen` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fecha_registro` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`prod_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint unsigned DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `tasks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tasks` (
  `Tar_id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `Usu_documento` bigint unsigned NOT NULL,
  `Tar_titulo` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Tar_descripcion` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `Tar_base` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT 'Centro Principal',
  `Tar_fecha_asignacion` date DEFAULT NULL,
  `Tar_fecha_limite` date NOT NULL,
  `Tar_hora` time DEFAULT NULL,
  `Soli_id` bigint unsigned DEFAULT NULL,
  `Tar_estado` enum('Pendiente','Observación','En Proceso','Completado') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Pendiente',
  `Tar_comentario` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`Tar_id`),
  KEY `tasks_usu_documento_foreign` (`Usu_documento`),
  KEY `tasks_soli_id_foreign` (`Soli_id`),
  CONSTRAINT `tasks_soli_id_foreign` FOREIGN KEY (`Soli_id`) REFERENCES `adoption_requests` (`Soli_id`) ON DELETE SET NULL,
  CONSTRAINT `tasks_usu_documento_foreign` FOREIGN KEY (`Usu_documento`) REFERENCES `users` (`Usu_documento`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `Usu_documento` bigint unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Usu_telefono` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` enum('Adoptante','Voluntario','Veterinario') COLLATE utf8mb4_unicode_ci NOT NULL,
  `Usu_direccion` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Usu_foto` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('Activo','Desactivado') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`Usu_documento`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (1,'0001_01_01_000000_create_users_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (2,'0001_01_01_000001_create_cache_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (3,'0001_01_01_000002_create_jobs_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (4,'2026_03_25_022853_create_animals_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (5,'2026_03_25_022854_create_donations_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (6,'2026_03_25_022855_create_medical_histories_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (7,'2026_03_25_022856_create_inscriptions_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (8,'2026_03_25_022857_create_notifications_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (9,'2026_03_25_022858_create_adoption_requests_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (10,'2026_03_25_022858_create_products_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (11,'2026_03_25_022859_create_adoption_followups_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (12,'2026_03_25_022900_create_tasks_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (13,'2026_03_25_023000_create_availabilities_table',2);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (14,'2026_03_25_093000_add_fields_to_medical_histories',3);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (15,'2026_03_25_094000_add_link_to_notifications',4);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (16,'2026_03_25_095000_add_en_proceso_to_adoption_requests',5);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (17,'2026_03_25_100000_update_animal_age_length',6);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (18,'2026_03_25_154344_update_animal_fields_length',7);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (19,'2026_03_25_154552_fix_animal_table_constraints',8);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (20,'2026_03_26_152705_update_tasks_estado_enum',9);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (21,'2026_03_26_152728_update_existing_task_states',9);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (22,'2026_03_26_154913_add_time_and_adoption_request_to_tasks',9);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (23,'2026_03_26_154935_add_deleted_at_to_notifications',9);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (24,'2026_03_26_155332_add_base_to_tasks',10);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (25,'2026_04_04_000000_add_hora_base_to_tasks',11);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (26,'2026_04_04_100000_add_foto_to_users',11);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (27,'2026_04_08_000000_update_products_prod_categoria_enum',12);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (28,'2026_04_09_000000_create_cart_items_table',13);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (29,'2026_04_06_create_orders_tables',14);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (30,'2026_04_08_211509_add_visita_and_reporte_to_adoption_requests_table',14);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (31,'2026_04_08_211520_update_adoption_requests_status_enum',14);
