-- --------------------------------------------------------
-- Hôte:                         127.0.0.1
-- Version du serveur:           8.0.30 - MySQL Community Server - GPL
-- SE du serveur:                Win64
-- HeidiSQL Version:             12.1.0.6537
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Listage de la structure de la base pour tramstras
CREATE DATABASE IF NOT EXISTS `tramstras` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `tramstras`;

-- Listage de la structure de table tramstras. alerte
CREATE TABLE IF NOT EXISTS `alerte` (
  `id` int NOT NULL AUTO_INCREMENT,
  `ligne` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `alerte_date` datetime NOT NULL,
  `sens` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_id` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_3AE753AA76ED395` (`user_id`),
  CONSTRAINT `FK_3AE753AA76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table tramstras.alerte : ~9 rows (environ)
INSERT INTO `alerte` (`id`, `ligne`, `alerte_date`, `sens`, `user_id`) VALUES
	(1, '6', '2023-07-16 14:55:38', 'Port du Rhin', NULL),
	(2, '6', '2023-07-16 15:13:18', 'Port du Rhin', NULL),
	(3, '4', '2023-07-16 15:32:34', NULL, NULL),
	(4, 'Ligne D', '2023-07-16 15:43:54', 'Kehl Rathaus', NULL),
	(5, 'Ligne B', '2023-07-16 15:45:20', 'Lingolsheim Tiergaertel', NULL),
	(6, 'Ligne B', '2023-07-16 15:46:42', 'Lingolsheim Tiergaertel', NULL),
	(7, 'Ligne D', '2023-07-16 15:46:58', 'Kehl Rathaus', NULL),
	(8, 'Ligne D', '2023-07-16 15:48:07', 'Kehl Rathaus', NULL),
	(9, 'Ligne D', '2023-07-16 15:56:29', 'Kehl Rathaus', NULL),
	(10, 'Ligne D', '2023-07-16 18:53:07', 'Poteries', 1),
	(11, 'Ligne C', '2023-07-19 10:03:52', 'Neuhof Rodolphe Reuss', 1);

-- Listage de la structure de table tramstras. alerte_perturbation
CREATE TABLE IF NOT EXISTS `alerte_perturbation` (
  `id` int NOT NULL AUTO_INCREMENT,
  `alerte_date` datetime NOT NULL,
  `arret` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ligne` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `deux_sens` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table tramstras.alerte_perturbation : ~0 rows (environ)

-- Listage de la structure de table tramstras. categorie
CREATE TABLE IF NOT EXISTS `categorie` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nom_categorie` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table tramstras.categorie : ~8 rows (environ)
INSERT INTO `categorie` (`id`, `nom_categorie`) VALUES
	(1, 'Generale'),
	(2, 'Alertes'),
	(3, 'Ligne A'),
	(4, 'Ligne B'),
	(5, 'Ligne C'),
	(6, 'Ligne D'),
	(7, 'Ligne E'),
	(8, 'Ligne F'),
	(9, 'Bus');

-- Listage de la structure de table tramstras. doctrine_migration_versions
CREATE TABLE IF NOT EXISTS `doctrine_migration_versions` (
  `version` varchar(191) COLLATE utf8mb3_unicode_ci NOT NULL,
  `executed_at` datetime DEFAULT NULL,
  `execution_time` int DEFAULT NULL,
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

-- Listage des données de la table tramstras.doctrine_migration_versions : ~8 rows (environ)
INSERT INTO `doctrine_migration_versions` (`version`, `executed_at`, `execution_time`) VALUES
	('DoctrineMigrations\\Version20230512095921', '2023-06-06 15:52:17', 2890),
	('DoctrineMigrations\\Version20230512143751', '2023-06-06 15:52:20', 45),
	('DoctrineMigrations\\Version20230606190331', '2023-06-06 19:03:44', 722),
	('DoctrineMigrations\\Version20230712210955', '2023-07-12 21:11:53', 2179),
	('DoctrineMigrations\\Version20230712212341', '2023-07-12 21:24:02', 468),
	('DoctrineMigrations\\Version20230715210545', '2023-07-15 21:05:56', 1720),
	('DoctrineMigrations\\Version20230716111827', '2023-07-16 11:18:42', 663),
	('DoctrineMigrations\\Version20230716145205', '2023-07-16 14:52:23', 674),
	('DoctrineMigrations\\Version20230716150926', '2023-07-16 15:09:46', 1790);

-- Listage de la structure de table tramstras. favoris
CREATE TABLE IF NOT EXISTS `favoris` (
  `id` int NOT NULL AUTO_INCREMENT,
  `arret` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sens` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ligne` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table tramstras.favoris : ~0 rows (environ)

-- Listage de la structure de table tramstras. marker
CREATE TABLE IF NOT EXISTS `marker` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `latitude` double NOT NULL,
  `longitude` double NOT NULL,
  `creation_date` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_82CF20FEA76ED395` (`user_id`),
  CONSTRAINT `FK_82CF20FEA76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table tramstras.marker : ~22 rows (environ)
INSERT INTO `marker` (`id`, `user_id`, `latitude`, `longitude`, `creation_date`) VALUES
	(1, 1, 48.584492830042, 7.8006362915039, '2023-07-12 23:07:37'),
	(2, 1, 48.562003631331, 7.7716255187988, '2023-07-12 23:08:07'),
	(3, 1, 48.58517416476, 7.7867317199707, '2023-07-12 23:08:14'),
	(4, 1, 48.582108086198, 7.7941131591797, '2023-07-12 23:08:20'),
	(6, 1, 48.573177605036, 7.7985119819641, '2023-07-12 23:17:30'),
	(7, 1, 48.574157240062, 7.7990913391113, '2023-07-12 23:17:31'),
	(8, 1, 48.573049825155, 7.7998208999634, '2023-07-12 23:17:32'),
	(9, 1, 48.571593644119, 7.7746725082397, '2023-07-12 23:31:02'),
	(10, 1, 48.571204967136, 7.7463912963867, '2023-07-12 23:31:54'),
	(13, 1, 48.575180335003, 7.6981544494629, '2023-07-15 21:25:38'),
	(14, 1, 48.574498865567, 7.6875114440918, '2023-07-15 21:25:47'),
	(15, 1, 48.574612444444, 7.6933479309082, '2023-07-15 21:25:58'),
	(16, 1, 48.575114672983, 7.7874612808228, '2023-07-15 22:16:03'),
	(17, 1, 48.575420799239, 7.782096862793, '2023-07-15 22:16:11'),
	(18, 1, 48.575761528891, 7.785165309906, '2023-07-15 22:16:12'),
	(19, 1, 48.574313412008, 7.7822470664978, '2023-07-15 22:16:14'),
	(20, 1, 48.574498865567, 7.7033042907715, '2023-07-15 22:20:46'),
	(21, 1, 48.587899411778, 7.7239036560059, '2023-07-15 22:27:50'),
	(22, 1, 48.585741936675, 7.7886199951172, '2023-07-15 22:27:52'),
	(23, 1, 48.570296267736, 7.7860450744629, '2023-07-15 22:41:10'),
	(24, 1, 48.571659310712, 7.7321434020996, '2023-07-15 22:41:12'),
	(25, 1, 48.573249481078, 7.8066444396973, '2023-07-15 22:41:15'),
	(26, 1, 48.570750619477, 7.8071594238281, '2023-07-15 22:41:16'),
	(27, 1, 48.568819596383, 7.8064727783203, '2023-07-15 22:41:19'),
	(28, 1, 48.574385286435, 7.822437286377, '2023-07-15 23:14:58'),
	(29, 1, 48.573262315243, 7.6662167039423, '2023-07-19 10:06:42'),
	(30, 1, 48.56155850823, 7.8064432561265, '2023-07-19 10:06:45');

-- Listage de la structure de table tramstras. messenger_messages
CREATE TABLE IF NOT EXISTS `messenger_messages` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `body` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `headers` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue_name` varchar(190) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL,
  `available_at` datetime NOT NULL,
  `delivered_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_75EA56E0FB7336F0` (`queue_name`),
  KEY `IDX_75EA56E0E3BD61CE` (`available_at`),
  KEY `IDX_75EA56E016BA31DB` (`delivered_at`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table tramstras.messenger_messages : ~0 rows (environ)
INSERT INTO `messenger_messages` (`id`, `body`, `headers`, `queue_name`, `created_at`, `available_at`, `delivered_at`) VALUES
	(1, 'O:36:\\"Symfony\\\\Component\\\\Messenger\\\\Envelope\\":2:{s:44:\\"\\0Symfony\\\\Component\\\\Messenger\\\\Envelope\\0stamps\\";a:1:{s:46:\\"Symfony\\\\Component\\\\Messenger\\\\Stamp\\\\BusNameStamp\\";a:1:{i:0;O:46:\\"Symfony\\\\Component\\\\Messenger\\\\Stamp\\\\BusNameStamp\\":1:{s:55:\\"\\0Symfony\\\\Component\\\\Messenger\\\\Stamp\\\\BusNameStamp\\0busName\\";s:21:\\"messenger.bus.default\\";}}}s:45:\\"\\0Symfony\\\\Component\\\\Messenger\\\\Envelope\\0message\\";O:51:\\"Symfony\\\\Component\\\\Mailer\\\\Messenger\\\\SendEmailMessage\\":2:{s:60:\\"\\0Symfony\\\\Component\\\\Mailer\\\\Messenger\\\\SendEmailMessage\\0message\\";O:39:\\"Symfony\\\\Bridge\\\\Twig\\\\Mime\\\\TemplatedEmail\\":4:{i:0;s:41:\\"registration/confirmation_email.html.twig\\";i:1;N;i:2;a:3:{s:9:\\"signedUrl\\";s:175:\\"http://127.0.0.1:8000/verify/email?expires=1686089012&signature=0luU97f%2F57NI4G3XF6dgJDNEqMZ5b6MNCnTLbQHrO%2Fc%3D&token=%2Bu%2BAuGlnbnH17Fdz8b5YoxTOu9yhALKkTB1z%2BaFt%2FfE%3D\\";s:19:\\"expiresAtMessageKey\\";s:26:\\"%count% hour|%count% hours\\";s:20:\\"expiresAtMessageData\\";a:1:{s:7:\\"%count%\\";i:1;}}i:3;a:6:{i:0;N;i:1;N;i:2;N;i:3;N;i:4;a:0:{}i:5;a:2:{i:0;O:37:\\"Symfony\\\\Component\\\\Mime\\\\Header\\\\Headers\\":2:{s:46:\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\Headers\\0headers\\";a:3:{s:4:\\"from\\";a:1:{i:0;O:47:\\"Symfony\\\\Component\\\\Mime\\\\Header\\\\MailboxListHeader\\":5:{s:50:\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0name\\";s:4:\\"From\\";s:56:\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0lineLength\\";i:76;s:50:\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0lang\\";N;s:53:\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0charset\\";s:5:\\"utf-8\\";s:58:\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\MailboxListHeader\\0addresses\\";a:1:{i:0;O:30:\\"Symfony\\\\Component\\\\Mime\\\\Address\\":2:{s:39:\\"\\0Symfony\\\\Component\\\\Mime\\\\Address\\0address\\";s:26:\\"symfonytramstras@proton.me\\";s:36:\\"\\0Symfony\\\\Component\\\\Mime\\\\Address\\0name\\";s:9:\\"TramStras\\";}}}}s:2:\\"to\\";a:1:{i:0;O:47:\\"Symfony\\\\Component\\\\Mime\\\\Header\\\\MailboxListHeader\\":5:{s:50:\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0name\\";s:2:\\"To\\";s:56:\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0lineLength\\";i:76;s:50:\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0lang\\";N;s:53:\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0charset\\";s:5:\\"utf-8\\";s:58:\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\MailboxListHeader\\0addresses\\";a:1:{i:0;O:30:\\"Symfony\\\\Component\\\\Mime\\\\Address\\":2:{s:39:\\"\\0Symfony\\\\Component\\\\Mime\\\\Address\\0address\\";s:20:\\"pademengel@gmail.com\\";s:36:\\"\\0Symfony\\\\Component\\\\Mime\\\\Address\\0name\\";s:0:\\"\\";}}}}s:7:\\"subject\\";a:1:{i:0;O:48:\\"Symfony\\\\Component\\\\Mime\\\\Header\\\\UnstructuredHeader\\":5:{s:50:\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0name\\";s:7:\\"Subject\\";s:56:\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0lineLength\\";i:76;s:50:\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0lang\\";N;s:53:\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0charset\\";s:5:\\"utf-8\\";s:55:\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\UnstructuredHeader\\0value\\";s:25:\\"Please Confirm your Email\\";}}}s:49:\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\Headers\\0lineLength\\";i:76;}i:1;N;}}}s:61:\\"\\0Symfony\\\\Component\\\\Mailer\\\\Messenger\\\\SendEmailMessage\\0envelope\\";N;}}', '[]', 'default', '2023-06-06 21:03:32', '2023-06-06 21:03:32', NULL),
	(2, 'O:36:\\"Symfony\\\\Component\\\\Messenger\\\\Envelope\\":2:{s:44:\\"\\0Symfony\\\\Component\\\\Messenger\\\\Envelope\\0stamps\\";a:1:{s:46:\\"Symfony\\\\Component\\\\Messenger\\\\Stamp\\\\BusNameStamp\\";a:1:{i:0;O:46:\\"Symfony\\\\Component\\\\Messenger\\\\Stamp\\\\BusNameStamp\\":1:{s:55:\\"\\0Symfony\\\\Component\\\\Messenger\\\\Stamp\\\\BusNameStamp\\0busName\\";s:21:\\"messenger.bus.default\\";}}}s:45:\\"\\0Symfony\\\\Component\\\\Messenger\\\\Envelope\\0message\\";O:51:\\"Symfony\\\\Component\\\\Mailer\\\\Messenger\\\\SendEmailMessage\\":2:{s:60:\\"\\0Symfony\\\\Component\\\\Mailer\\\\Messenger\\\\SendEmailMessage\\0message\\";O:39:\\"Symfony\\\\Bridge\\\\Twig\\\\Mime\\\\TemplatedEmail\\":4:{i:0;s:41:\\"registration/confirmation_email.html.twig\\";i:1;N;i:2;a:3:{s:9:\\"signedUrl\\";s:167:\\"http://127.0.0.1:8000/verify/email?expires=1687199303&signature=ZfvFaR8yXuCWsHGkk8tH5DQ%2FLPHED6ZkeK39SJzQimA%3D&token=tTUefgbBTeKQ978Jq2%2F5NRCjeOB0e4WaK3HZKeNcNjs%3D\\";s:19:\\"expiresAtMessageKey\\";s:26:\\"%count% hour|%count% hours\\";s:20:\\"expiresAtMessageData\\";a:1:{s:7:\\"%count%\\";i:1;}}i:3;a:6:{i:0;N;i:1;N;i:2;N;i:3;N;i:4;a:0:{}i:5;a:2:{i:0;O:37:\\"Symfony\\\\Component\\\\Mime\\\\Header\\\\Headers\\":2:{s:46:\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\Headers\\0headers\\";a:3:{s:4:\\"from\\";a:1:{i:0;O:47:\\"Symfony\\\\Component\\\\Mime\\\\Header\\\\MailboxListHeader\\":5:{s:50:\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0name\\";s:4:\\"From\\";s:56:\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0lineLength\\";i:76;s:50:\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0lang\\";N;s:53:\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0charset\\";s:5:\\"utf-8\\";s:58:\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\MailboxListHeader\\0addresses\\";a:1:{i:0;O:30:\\"Symfony\\\\Component\\\\Mime\\\\Address\\":2:{s:39:\\"\\0Symfony\\\\Component\\\\Mime\\\\Address\\0address\\";s:26:\\"symfonytramstras@proton.me\\";s:36:\\"\\0Symfony\\\\Component\\\\Mime\\\\Address\\0name\\";s:9:\\"TramStras\\";}}}}s:2:\\"to\\";a:1:{i:0;O:47:\\"Symfony\\\\Component\\\\Mime\\\\Header\\\\MailboxListHeader\\":5:{s:50:\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0name\\";s:2:\\"To\\";s:56:\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0lineLength\\";i:76;s:50:\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0lang\\";N;s:53:\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0charset\\";s:5:\\"utf-8\\";s:58:\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\MailboxListHeader\\0addresses\\";a:1:{i:0;O:30:\\"Symfony\\\\Component\\\\Mime\\\\Address\\":2:{s:39:\\"\\0Symfony\\\\Component\\\\Mime\\\\Address\\0address\\";s:23:\\"jupiter116699@gmail.com\\";s:36:\\"\\0Symfony\\\\Component\\\\Mime\\\\Address\\0name\\";s:0:\\"\\";}}}}s:7:\\"subject\\";a:1:{i:0;O:48:\\"Symfony\\\\Component\\\\Mime\\\\Header\\\\UnstructuredHeader\\":5:{s:50:\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0name\\";s:7:\\"Subject\\";s:56:\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0lineLength\\";i:76;s:50:\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0lang\\";N;s:53:\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0charset\\";s:5:\\"utf-8\\";s:55:\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\UnstructuredHeader\\0value\\";s:25:\\"Please Confirm your Email\\";}}}s:49:\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\Headers\\0lineLength\\";i:76;}i:1;N;}}}s:61:\\"\\0Symfony\\\\Component\\\\Mailer\\\\Messenger\\\\SendEmailMessage\\0envelope\\";N;}}', '[]', 'default', '2023-06-19 17:28:24', '2023-06-19 17:28:24', NULL);

-- Listage de la structure de table tramstras. post
CREATE TABLE IF NOT EXISTS `post` (
  `id` int NOT NULL AUTO_INCREMENT,
  `topic_id` int DEFAULT NULL,
  `text` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_post` datetime NOT NULL,
  `user_id` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_5A8A6C8D1F55203D` (`topic_id`),
  KEY `IDX_5A8A6C8DA76ED395` (`user_id`),
  CONSTRAINT `FK_5A8A6C8D1F55203D` FOREIGN KEY (`topic_id`) REFERENCES `topic` (`id`),
  CONSTRAINT `FK_5A8A6C8DA76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table tramstras.post : ~3 rows (environ)
INSERT INTO `post` (`id`, `topic_id`, `text`, `date_post`, `user_id`) VALUES
	(1, 1, 'Ca fait vraiement chier', '2023-06-08 22:41:20', 1),
	(10, 15, 'Blablabbla', '2023-06-19 18:58:36', 2),
	(11, 18, 'C\'est mon Premier message en B', '2023-06-19 17:47:34', 1);

-- Listage de la structure de table tramstras. topic
CREATE TABLE IF NOT EXISTS `topic` (
  `id` int NOT NULL AUTO_INCREMENT,
  `categorie_id` int DEFAULT NULL,
  `titre` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `creation_date` datetime NOT NULL,
  `user_id` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_9D40DE1BBCF5E72D` (`categorie_id`),
  KEY `IDX_9D40DE1BA76ED395` (`user_id`),
  CONSTRAINT `FK_9D40DE1BA76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`),
  CONSTRAINT `FK_9D40DE1BBCF5E72D` FOREIGN KEY (`categorie_id`) REFERENCES `categorie` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table tramstras.topic : ~4 rows (environ)
INSERT INTO `topic` (`id`, `categorie_id`, `titre`, `creation_date`, `user_id`) VALUES
	(1, 3, 'Je me suis fais voler mon sac', '2023-06-08 19:56:05', 1),
	(15, 3, 'Mon premier nouveauTopic', '2023-06-15 18:23:13', 1),
	(18, 4, 'C\'est un Topic de carégorie B', '2023-06-19 18:59:05', 2),
	(19, 3, 'C\'est mon troisième topic A', '2023-06-19 17:54:58', 1);

-- Listage de la structure de table tramstras. user
CREATE TABLE IF NOT EXISTS `user` (
  `id` int NOT NULL AUTO_INCREMENT,
  `email` varchar(180) COLLATE utf8mb4_unicode_ci NOT NULL,
  `pseudo` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `roles` json NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_verified` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_8D93D649E7927C74` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table tramstras.user : ~0 rows (environ)
INSERT INTO `user` (`id`, `email`, `pseudo`, `roles`, `password`, `is_verified`) VALUES
	(1, 'pademengel@gmail.com', 'ipoucht', '["ROLE_ADMIN"]', '$2y$13$bo4jBrC8Eg5ukf1N8jl4KOoPg.LMC9XiUuKJ8hVROuInSQcq1SG76', 1),
	(2, 'jupiter116699@gmail.com', 'jupiter169', '[]', '$2y$13$brTRM2F5Bb3SlRanZncmb.XfzEiTXDLGTpE05V35HSp1BvEZgknvS', 1);

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
