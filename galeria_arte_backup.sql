-- MySQL dump 10.13  Distrib 8.0.46, for Linux (x86_64)
--
-- Host: localhost    Database: galeria_arte
-- ------------------------------------------------------
-- Server version	8.0.46-0ubuntu0.24.04.4

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `cache`
--

DROP TABLE IF EXISTS `cache`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`)
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
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`)
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
-- Table structure for table `categorias`
--

DROP TABLE IF EXISTS `categorias`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `categorias` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `categorias_nombre_unique` (`nombre`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `categorias`
--

LOCK TABLES `categorias` WRITE;
/*!40000 ALTER TABLE `categorias` DISABLE KEYS */;
INSERT INTO `categorias` VALUES (4,'Arte conceptual'),(5,'Diseño de mundos'),(2,'Ilustraciones'),(1,'Modelado 3D'),(3,'Pixel Art'),(6,'Texturas');
/*!40000 ALTER TABLE `categorias` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `comentarios`
--

DROP TABLE IF EXISTS `comentarios`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `comentarios` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `usuario_id` bigint unsigned NOT NULL,
  `obra_id` bigint unsigned NOT NULL,
  `comentario` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `tipo` enum('critica','pregunta','positiva') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'positiva',
  `creado_en` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `comentarios_usuario_id_index` (`usuario_id`),
  KEY `comentarios_obra_id_index` (`obra_id`),
  CONSTRAINT `fk_comentarios_obra` FOREIGN KEY (`obra_id`) REFERENCES `obras` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_comentarios_usuario` FOREIGN KEY (`usuario_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `comentarios`
--

LOCK TABLES `comentarios` WRITE;
/*!40000 ALTER TABLE `comentarios` DISABLE KEYS */;
INSERT INTO `comentarios` VALUES (1,3,1,'Dibujo muy bien hecho','positiva','2026-10-10 13:11:21'),(2,3,1,'Mejorar calidad de dibujo','critica','2026-10-10 13:11:49'),(3,11,16,'¡Gracias por compartir esta pieza tan inspiradora!','positiva','2026-10-13 08:47:05');
/*!40000 ALTER TABLE `comentarios` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `failed_jobs`
--

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
  `failed_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
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
-- Table structure for table `job_batches`
--

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

--
-- Dumping data for table `jobs`
--

LOCK TABLES `jobs` WRITE;
/*!40000 ALTER TABLE `jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `likes`
--

DROP TABLE IF EXISTS `likes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `likes` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `usuario_id` bigint unsigned NOT NULL,
  `obra_id` bigint unsigned NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `likes_usuario_obra_unique` (`usuario_id`,`obra_id`),
  KEY `likes_obra_id_index` (`obra_id`),
  CONSTRAINT `fk_likes_obra` FOREIGN KEY (`obra_id`) REFERENCES `obras` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_likes_usuario` FOREIGN KEY (`usuario_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `likes`
--

LOCK TABLES `likes` WRITE;
/*!40000 ALTER TABLE `likes` DISABLE KEYS */;
INSERT INTO `likes` VALUES (1,3,1),(4,11,8),(3,11,10),(2,11,16),(5,11,21);
/*!40000 ALTER TABLE `likes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'0001_01_01_000000_create_users_table',1),(2,'0001_01_01_000001_create_cache_table',1),(3,'0001_01_01_000002_create_jobs_table',1);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `obras`
--

DROP TABLE IF EXISTS `obras`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `obras` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `usuario_id` bigint unsigned NOT NULL,
  `categoria_id` bigint unsigned NOT NULL,
  `titulo` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `descripcion` text COLLATE utf8mb4_unicode_ci,
  `herramientas` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `archivo_imagen` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `creado_en` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `obras_archivo_imagen_unique` (`archivo_imagen`),
  KEY `obras_usuario_id_index` (`usuario_id`),
  KEY `obras_categoria_id_index` (`categoria_id`),
  KEY `obras_titulo_index` (`titulo`),
  CONSTRAINT `fk_obras_categoria` FOREIGN KEY (`categoria_id`) REFERENCES `categorias` (`id`),
  CONSTRAINT `fk_obras_usuario` FOREIGN KEY (`usuario_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `obras`
--

LOCK TABLES `obras` WRITE;
/*!40000 ALTER TABLE `obras` DISABLE KEYS */;
INSERT INTO `obras` VALUES (1,2,2,'Caracol a mano','Esto es un representacion de un caracol a mano','Lapiz y papel','1791655723_6aca7f2b6a9e2.jpeg','2026-10-10 13:08:44'),(2,4,5,'Prueba','zzzz','zzzz','1791729932_6acba10ca7876.PNG','2026-10-11 16:45:32'),(3,5,3,'gato','gato en pixel art',NULL,'1791731375_6acba6af5d367.jpg','2026-10-11 17:09:35'),(4,7,4,'Dios de la sangre','Es una criatura vampírica con piel grisácea, orejas puntiagudas, alas de murciélago y garras largas teñidas de rojo','Photoshop, Clip Studio Paint','1791756550_6acc09064e236.png','2026-10-12 00:09:10'),(5,8,5,'Camino de aparición','Paisaje postapocalíptico donde dos manos mecánicas colosales cubiertas de vegetación y encadenadas se alzan del suelo','Source Filmmaker, Photoshop, Clip Studio Paint','1791757094_6acc0b26f3427.png','2026-10-12 00:18:15'),(6,9,1,'Cruce','Escena de ciencia ficción y postapocalíptico, donde una persona en motocicleta transita por un camino rural con un robot caminante gigante de diseño industrial.','Photoshop, 3ds Max','1791758159_6acc0f4f2c433.png','2026-10-12 00:35:59'),(7,10,4,'Demonio del apocalipsis','Esta obra fue realizada para el juego de cartas Magic: The Gathering','Photoshop, Alchemy','1791759824_6acc15d0e7867.png','2026-10-12 01:03:44'),(8,11,5,'Apotlas','Un gigantesco dinosaurio o criatura de cuello largo con armadura y ornamentos dorados en la cabeza y el lomo.','Photoshop, Krita, Wacom','1791761008_6acc1a706320e.png','2026-10-12 01:23:28'),(9,12,6,'paisaje',NULL,NULL,'1791861787_6acda41bea994.jpeg','2026-10-13 05:23:07'),(10,12,4,'fnf bf',NULL,NULL,'1791861830_6acda44679483.jpeg','2026-10-13 05:23:50'),(11,13,4,'Diseño Reflejado','Diseño visual de doble color reflejado en una persona','Photoshop','1791865700_6acdb3649832b.JPG','2026-10-13 06:28:20'),(12,13,4,'Pensamiento en rueda','Silla con rueda unidos','Materiales reales','1791865807_6acdb3cf5204d.jpg','2026-10-13 06:30:07'),(13,13,2,'Casas invertidas','Casas mezcladas con fondo marino','Photoshop','1791865971_6acdb473a32b8.jpg','2026-10-13 06:32:51'),(14,13,2,'Ciudad con miradas','El diseño de una ciudad que observa sin que nadie lo pueda observar a ella','Photoshop,Dibujo a mano','1791866199_6acdb5575bdf5.jfif','2026-10-13 06:36:39'),(15,13,6,'Textura de papel','Textura de papel variado de colores','Papel,Tijeras','1791866377_6acdb609d75b0.jpg','2026-10-13 06:39:37'),(16,7,6,'El Ungido (El Alejado por Dios)','Tras realizar grandes contribuciones a los Archidemonios, los Ungidos son ordenados por sus amos en el Infierno para peregrinar al Lago de Fuego. Allí, en sus orillas apestosas y cubiertas de petróleo, meditan y cantan, realizando ritos repugnantes en los templos quemados que salpican sus riberas.','Photoshop, Custom Textures','1791871384_6acdc998564b2.png','2026-10-13 08:03:04'),(17,8,2,'Heraldo de Belcebú','Son la vanguardia en cualquier asalto del Culto del Grial Negro, y el zumbido ensordecedor de sus alas infunde terror en cualquier defensor.','Clip Studio Paint, Photoshop','1791871772_6acdcb1c33481.png','2026-10-13 08:09:32'),(18,9,6,'Observador','Gracias a su singular casco y entrenamiento, puede percibir presagios y augurios, lo que le otorga clarividencia limitada y temibles habilidades de combate.','Procreate, Photoshop','1791872208_6acdccd02cb10.png','2026-10-13 08:16:48'),(19,9,3,'Batería Antiaérea','Esta es una de las innumerables posiciones aisladas. La guerra de trincheras es un conflicto tan extenso y prolongado que se sabe que divisiones enteras han desaparecido sin dejar rastro, ejércitos enteros se han perdido y olvidado, generaciones enteras han quedado sepultadas en el fango.','Verve Painter, Photoshop','1791872769_6acdcf0103275.png','2026-10-13 08:26:09'),(20,10,1,'El Heresiarca (La Primera Herejía)','Este ser fue en su día un humano, pero con el tiempo ha crecido debido a la acumulación de blasfemias. Está rodeado por los edificios de sus creencias, que proclaman sus sermones sin cesar.','ZBrush, Photoshop','1791873357_6acdd14d67f9c.png','2026-10-13 08:35:57'),(21,11,2,'Señor de las Bestias Larvales','El Señor Bestia Larval que se ve aquí aún está en su etapa infantil; solo se ha visto uno en su etapa adulta, y el equipo de reconocimiento que lo avistó no sobrevivió.','Photoshop, Procreate, Lapiz y Papel','1791873859_6acdd34358b87.png','2026-10-13 08:44:19'),(22,4,4,'Conejo-Perro','Un conejo que se cree perro, tiene la apariencia, pero no las ganas.','Belnder','1791929177_6aceab59b1bbf.jpeg','2026-10-14 00:06:17'),(23,4,4,'Corvus','Corvus es un general del ejercito que libro tantas batallas en campo, ahora dirige a sus tropas desde el mando sin arriesgar su vida....o eso cree.','Paint','1791929256_6aceaba8add51.PNG','2026-10-14 00:07:36'),(24,4,2,'Somos lo que somos','Somos y no vemos como somos, solo buscamos como encajar.','Blender','1791929484_6aceac8ca6b0f.jpg','2026-10-14 00:11:24'),(25,4,5,'Rey que observa','Mientras los perro ladran el león observa, no quiero demostrar que es mejor, porque sabe que no necesita demostrarlo.',NULL,'1791929563_6aceacdbeaed1.jpg','2026-10-14 00:12:43'),(26,4,3,'Atrapado','La vida baja el temor sube, los ojos se apagan el corazón se detiene.','ChatGpt','1791929678_6acead4e094a2.jpeg','2026-10-14 00:14:38');
/*!40000 ALTER TABLE `obras` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_reset_tokens`
--

DROP TABLE IF EXISTS `password_reset_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `password_reset_tokens`
--

LOCK TABLES `password_reset_tokens` WRITE;
/*!40000 ALTER TABLE `password_reset_tokens` DISABLE KEYS */;
INSERT INTO `password_reset_tokens` VALUES ('991573068gem@gmail.com','$2y$12$y8IV8XRPi2oqXsG/zuhocuq7qfO.phc/bAcSeKhAeCRYSTj0Z27Ba','2026-10-10 18:04:40'),('mauricio@espinoza.com','$2y$12$po0oJStUDBpuwkbAOy1TbuYc37YifhvfvYcmb..V5HMOo86ydRcxC','2026-10-10 18:02:08');
/*!40000 ALTER TABLE `password_reset_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pedidos`
--

DROP TABLE IF EXISTS `pedidos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `pedidos` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `cliente_id` bigint unsigned NOT NULL,
  `artista_id` bigint unsigned NOT NULL,
  `servicio_id` bigint unsigned DEFAULT NULL,
  `instrucciones` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `archivo_referencia` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `precio_acordado` decimal(10,2) DEFAULT NULL,
  `comision_plataforma` decimal(10,2) NOT NULL DEFAULT '0.00',
  `fecha_limite` date DEFAULT NULL,
  `archivo_entrega_final` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `motivo_rechazo` text COLLATE utf8mb4_unicode_ci,
  `resolucion_admin` text COLLATE utf8mb4_unicode_ci,
  `estado` enum('solicitado','cotizado','pagado_custodia','entregado','completado','en_disputa','reembolsado','cancelado') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'solicitado',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_pedidos_cliente` (`cliente_id`),
  KEY `fk_pedidos_artista` (`artista_id`),
  KEY `fk_pedidos_servicio` (`servicio_id`),
  CONSTRAINT `fk_pedidos_artista` FOREIGN KEY (`artista_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_pedidos_cliente` FOREIGN KEY (`cliente_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_pedidos_servicio` FOREIGN KEY (`servicio_id`) REFERENCES `servicios` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pedidos`
--

LOCK TABLES `pedidos` WRITE;
/*!40000 ALTER TABLE `pedidos` DISABLE KEYS */;
/*!40000 ALTER TABLE `pedidos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `servicios`
--

DROP TABLE IF EXISTS `servicios`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `servicios` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `titulo` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `descripcion` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `precio_base` decimal(10,2) NOT NULL,
  `dias_entrega` int NOT NULL DEFAULT '3',
  `activo` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_servicios_user` (`user_id`),
  CONSTRAINT `fk_servicios_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `servicios`
--

LOCK TABLES `servicios` WRITE;
/*!40000 ALTER TABLE `servicios` DISABLE KEYS */;
/*!40000 ALTER TABLE `servicios` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sessions`
--

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

--
-- Dumping data for table `sessions`
--

LOCK TABLES `sessions` WRITE;
/*!40000 ALTER TABLE `sessions` DISABLE KEYS */;
/*!40000 ALTER TABLE `sessions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `es_publico` tinyint(1) NOT NULL DEFAULT '1',
  `saldo_disponible` decimal(10,2) NOT NULL DEFAULT '0.00',
  `saldo_retenido` decimal(10,2) NOT NULL DEFAULT '0.00',
  `email_verified_at` datetime DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `es_anonimo` tinyint(1) NOT NULL DEFAULT '0',
  `bio` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `contacto_url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `es_admin` tinyint(1) NOT NULL DEFAULT '0',
  `creado_en` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'Mauricio','mauricio@espinoza.com',1,0.00,0.00,NULL,'$2y$12$B7Ju1H4JBPTwM3XOA0za6.rdySW1V5/u6SZCaFWMCLqb9kD7DAsjW','C0Q6nk5FQwz7rd579SGRH5OpQrpayW1a02HelqE4Bp1M3UdCCpOaMmJhyXOB',0,NULL,NULL,0,'2026-10-10 13:00:58'),(2,'Mauricio','991573068gem@gmail.com',1,0.00,0.00,NULL,'$2y$12$c7qkuxGdVxbIUlZYb67eW.6CfBJ/F90MiGrtHeJACJlLUiEK0bwv2',NULL,0,'Ilustrador','https://github.com/mati10111010/tarea-1-git-Mauricio-Espinoza',0,'2026-10-10 13:04:25'),(3,'Javier','javier@sanchez.com',1,0.00,0.00,NULL,'$2y$12$6i.CYrn6l/0eUaLnAh2SIedPZK6WiDm1L0FUEyBjTTgdDnvarSKn.',NULL,0,NULL,NULL,0,'2026-10-10 13:10:37'),(4,'Jesus','jesus@gmail.com',1,0.00,0.00,NULL,'$2y$12$1aA6R0kQz80VMHP080MsIeUTF9o9rZMIJ6dUeFPhFccwykL4pW.h2',NULL,0,NULL,NULL,1,'2026-10-11 16:41:26'),(5,'nose','nose@gmail.com',1,0.00,0.00,NULL,'$2y$12$ZnHgV5eEPH/ESKGGAXppfuq97YTuYfSxLVk0BzExa6TuU9a2/uqBG',NULL,0,NULL,NULL,0,'2026-10-11 17:04:20'),(6,'mario','mario@gmail.com',1,0.00,0.00,NULL,'$2y$12$lUQUldTCEDzKg2XdC5otzu8lu12g4eSzVFWkpYwEBHE1OQGZ1KcIi',NULL,0,NULL,NULL,0,'2026-10-11 17:23:43'),(7,'Lucia','lucia@gmail.com',1,0.00,0.00,NULL,'$2y$12$K3CxghabdUgnB/Ld8YQX2OOLAxisraboNxYqHsdulYcbvvDZuhVpa',NULL,0,NULL,NULL,0,'2026-10-11 23:26:49'),(8,'Diego','diego@gmail.com',1,0.00,0.00,NULL,'$2y$12$LsYLQI1xeQpa8WreZLoUUegf.AoEAAPP1o/v.qGoeYLOHz.0BGsLm',NULL,0,NULL,NULL,0,'2026-10-12 00:15:26'),(9,'Valentina','valentina@gmail.com',1,0.00,0.00,NULL,'$2y$12$f674OlxHfQffRVD1fWGQlOmro7S0Cx/pEjRJGGkRrrjTtsL8z.Spi',NULL,0,NULL,NULL,0,'2026-10-12 00:29:36'),(10,'Mateo','mateo@gmail.com',1,0.00,0.00,NULL,'$2y$12$RZN/1q1cN.Lo0NGyRUutC.3/4CBzMZ5wKpq/mEcg/9dhPnx6U8ITG',NULL,0,NULL,NULL,0,'2026-10-12 00:49:12'),(11,'Camila','camila@gmail.com',1,0.00,0.00,NULL,'$2y$12$QkjT4eHOrr7bWpReX.Fm/eKHwW57CTBGeLSL3jpZgDoYVZ5lhJePi',NULL,0,NULL,NULL,0,'2026-10-12 01:08:40'),(12,'1234','1234@gmail.com',1,0.00,0.00,NULL,'$2y$12$mNoDbq1G4Sk1eieMTnnipOpYsSHIhr5j5sn0dEn4hwoHmm1C1e.oK',NULL,0,NULL,NULL,0,'2026-10-13 05:22:02'),(13,'Hugo','hugo@gmail.com',1,0.00,0.00,NULL,'$2y$12$oCF5l5KTvjjKm1F1DnathuYNaTtBcpaNU.iibSsbvKBOL9p8Xh49S',NULL,0,NULL,NULL,0,'2026-10-13 06:19:43');
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

-- Dump completed on 2026-10-14  0:21:19
