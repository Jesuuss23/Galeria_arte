SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

-- --------------------------------------------------------
-- 1. Tabla categorias
-- --------------------------------------------------------
CREATE TABLE IF NOT EXISTS `categorias` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `categorias` (`id`, `nombre`) VALUES
(1, 'Modelado 3D'),
(2, 'Ilustraciones'),
(3, 'Pixel Art'),
(4, 'Arte conceptual'),
(5, 'Diseño de mundos'),
(6, 'Texturas')
ON DUPLICATE KEY UPDATE `nombre` = VALUES(`nombre`);

-- --------------------------------------------------------
-- 2. Tabla users
-- --------------------------------------------------------
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `email` varchar(120) NOT NULL,
  `es_anonimo` tinyint(1) NOT NULL DEFAULT 0,
  `contacto_url` varchar(255) DEFAULT NULL,
  `bio` varchar(255) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `creado_en` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `users` (`id`, `name`, `email`, `es_anonimo`, `contacto_url`, `bio`, `password`, `creado_en`) VALUES
(1, 'Jesus Carhuancho', 'jesus@gmail.com', 1, NULL, NULL, '$2y$12$VXmJloG1/Ysrdc.PDyJNQu/qqypXtrL2yY33lTN1rc1oXgAC.qSse', '2026-10-06 17:15:24'),
(2, 'Oscar', 'oscar@gmail.com', 0, NULL, NULL, '$2y$12$BikNsOodtrF0UGrwnc943OD4BpbfPRRGfNBvhYLJW8PuCuWHzxcLy', '2026-10-06 17:17:06'),
(3, 'pedro', 'pedro@gmail.com', 0, 'https://www.youtube.com/', 'Haqer', '$2y$12$RialnmR5xcVodwgtZsZA.uXJStc4aa2H4LzUloRufoKq4rw.Cjngq', '2026-10-06 17:23:26')
ON DUPLICATE KEY UPDATE `name` = VALUES(`name`);

-- --------------------------------------------------------
-- 3. Tabla obras
-- --------------------------------------------------------
CREATE TABLE IF NOT EXISTS `obras` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `usuario_id` int(11) NOT NULL,
  `categoria_id` int(11) NOT NULL,
  `titulo` varchar(150) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `herramientas` varchar(255) DEFAULT NULL,
  `archivo_imagen` varchar(255) NOT NULL,
  `creado_en` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `categoria_id` (`categoria_id`),
  KEY `fk_obras_users` (`usuario_id`),
  CONSTRAINT `fk_obras_users` FOREIGN KEY (`usuario_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `obras_ibfk_2` FOREIGN KEY (`categoria_id`) REFERENCES `categorias` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `obras` (`id`, `usuario_id`, `categoria_id`, `titulo`, `descripcion`, `herramientas`, `archivo_imagen`, `creado_en`) VALUES
(2, 3, 1, 'Prueba', 's', NULL, '1791307694_6ac52fae2f961.PNG', '2026-10-06 17:28:14'),
(3, 3, 3, 'Prueba', 's', 'ChatGPT, Gemini, Cloude', '1791309241_6ac535b9c1043.PNG', '2026-10-06 17:54:01')
ON DUPLICATE KEY UPDATE `titulo` = VALUES(`titulo`);

-- --------------------------------------------------------
-- 4. Tabla comentarios
-- --------------------------------------------------------
CREATE TABLE IF NOT EXISTS `comentarios` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `usuario_id` int(11) NOT NULL,
  `obra_id` int(11) NOT NULL,
  `comentario` text NOT NULL,
  `tipo` enum('critica','pregunta','positiva') NOT NULL DEFAULT 'positiva',
  `creado_en` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `obra_id` (`obra_id`),
  KEY `fk_comentarios_users` (`usuario_id`),
  CONSTRAINT `comentarios_ibfk_2` FOREIGN KEY (`obra_id`) REFERENCES `obras` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_comentarios_users` FOREIGN KEY (`usuario_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `comentarios` (`id`, `usuario_id`, `obra_id`, `comentario`, `tipo`, `creado_en`) VALUES
(1, 3, 2, 'basura', 'critica', '2026-10-06 17:28:36'),
(2, 3, 2, 'que asco', 'pregunta', '2026-10-06 17:39:33'),
(3, 1, 2, 'dedícate a otra cosa', 'positiva', '2026-10-06 17:42:28')
ON DUPLICATE KEY UPDATE `comentario` = VALUES(`comentario`);

-- --------------------------------------------------------
-- 5. Tabla likes
-- --------------------------------------------------------
CREATE TABLE IF NOT EXISTS `likes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `usuario_id` int(11) NOT NULL,
  `obra_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `unico_like` (`usuario_id`,`obra_id`),
  KEY `obra_id` (`obra_id`),
  CONSTRAINT `fk_likes_users` FOREIGN KEY (`usuario_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `likes_ibfk_2` FOREIGN KEY (`obra_id`) REFERENCES `obras` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `likes` (`id`, `usuario_id`, `obra_id`) VALUES
(4, 3, 2)
ON DUPLICATE KEY UPDATE `usuario_id` = VALUES(`usuario_id`);

COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;