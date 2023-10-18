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
  `ligne` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `alerte_date` datetime NOT NULL,
  `sens` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_id` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_3AE753AA76ED395` (`user_id`),
  CONSTRAINT `FK_3AE753AA76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=45 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table tramstras.alerte : ~22 rows (environ)
INSERT INTO `alerte` (`id`, `ligne`, `alerte_date`, `sens`, `user_id`) VALUES
	(21, 'Ligne D', '2023-07-24 14:44:53', 'Kehl Rathaus', 1),
	(22, 'Ligne B', '2023-07-24 14:48:49', 'Hoenheim Gare', 1),
	(23, 'Ligne D', '2023-07-24 14:52:08', 'Poteries', 1),
	(24, 'Ligne C', '2023-07-24 14:56:06', 'Neuhof Rodolphe Reuss', 1),
	(25, 'Ligne E', '2023-07-24 14:56:22', 'Robertsau L\'Escale', 1),
	(26, 'Ligne B', '2023-07-31 12:20:08', 'Lingolsheim Tiergaertel', 2),
	(27, 'Ligne B', '2023-08-02 09:32:53', 'Hoenheim Gare', 1),
	(28, 'Ligne B', '2023-08-24 13:16:48', 'Lingolsheim Tiergaertel', 1),
	(29, 'Ligne C', '2023-08-24 15:05:26', 'Neuhof Rodolphe Reuss', 1),
	(30, 'Ligne D', '2023-08-25 07:26:42', 'Kehl Rathaus', 1),
	(31, 'Ligne D', '2023-08-25 07:27:17', 'Kehl Rathaus', 1),
	(32, 'Ligne F', '2023-08-25 07:33:41', 'Place d\'Islande', 1),
	(33, 'Ligne F', '2023-08-25 07:33:52', 'Place d\'Islande', 1),
	(34, 'Ligne F', '2023-08-25 07:34:17', 'Place d\'Islande', 1),
	(35, 'Ligne F', '2023-08-25 07:35:00', 'Place d\'Islande', 1),
	(36, 'Ligne F', '2023-08-25 07:35:12', 'Place d\'Islande', 1),
	(37, 'Ligne E', '2023-08-31 17:32:07', 'Robertsau L\'Escale', 3),
	(38, 'Ligne C', '2023-09-12 07:18:47', 'Neuhof Rodolphe Reuss', 6),
	(39, 'Ligne D', '2023-09-12 07:33:12', 'Kehl Rathaus', 1),
	(40, 'Ligne E', '2023-09-12 07:33:58', 'Robertsau L\'Escale', 6),
	(41, 'Ligne D', '2023-09-26 12:25:14', 'Kehl Rathaus', 1),
	(42, 'Ligne D', '2023-10-02 21:22:23', 'Poteries', 1),
	(43, 'Ligne D', '2023-10-11 12:55:16', 'Kehl Rathaus', NULL),
	(44, 'Ligne A', '2023-10-15 15:12:02', 'Illkirch-Graffenstaden', 1);

-- Listage de la structure de table tramstras. categorie
CREATE TABLE IF NOT EXISTS `categorie` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nom_categorie` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `data_card` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table tramstras.categorie : ~9 rows (environ)
INSERT INTO `categorie` (`id`, `nom_categorie`, `data_card`) VALUES
	(1, 'Generale', 'general'),
	(2, 'Alertes', 'help'),
	(3, 'Ligne A', 'A'),
	(4, 'Ligne B', 'B'),
	(5, 'Ligne C', 'C'),
	(6, 'Ligne D', 'D'),
	(7, 'Ligne E', 'E'),
	(8, 'Ligne F', 'F'),
	(9, 'Bus', 'Bus');

-- Listage de la structure de table tramstras. contact_message
CREATE TABLE IF NOT EXISTS `contact_message` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `message` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table tramstras.contact_message : ~2 rows (environ)
INSERT INTO `contact_message` (`id`, `name`, `email`, `message`, `phone`) VALUES
	(1, 'pierre arthura', 'pademengel@gmail.com', 'pazodjozaija', '0695413025'),
	(2, 'pierre', 'pademengel@gmail.com', 'daiouhbdauibu', '0695413025');

-- Listage de la structure de table tramstras. doctrine_migration_versions
CREATE TABLE IF NOT EXISTS `doctrine_migration_versions` (
  `version` varchar(191) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `executed_at` datetime DEFAULT NULL,
  `execution_time` int DEFAULT NULL,
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

-- Listage des données de la table tramstras.doctrine_migration_versions : ~24 rows (environ)
INSERT INTO `doctrine_migration_versions` (`version`, `executed_at`, `execution_time`) VALUES
	('DoctrineMigrations\\Version20230512095921', '2023-06-06 15:52:17', 2890),
	('DoctrineMigrations\\Version20230512143751', '2023-06-06 15:52:20', 45),
	('DoctrineMigrations\\Version20230606190331', '2023-06-06 19:03:44', 722),
	('DoctrineMigrations\\Version20230712210955', '2023-07-12 21:11:53', 2179),
	('DoctrineMigrations\\Version20230712212341', '2023-07-12 21:24:02', 468),
	('DoctrineMigrations\\Version20230715210545', '2023-07-15 21:05:56', 1720),
	('DoctrineMigrations\\Version20230716111827', '2023-07-16 11:18:42', 663),
	('DoctrineMigrations\\Version20230716145205', '2023-07-16 14:52:23', 674),
	('DoctrineMigrations\\Version20230716150926', '2023-07-16 15:09:46', 1790),
	('DoctrineMigrations\\Version20230731074025', '2023-07-31 07:41:04', 60),
	('DoctrineMigrations\\Version20230731080344', '2023-07-31 08:03:49', 17),
	('DoctrineMigrations\\Version20230731125703', '2023-07-31 12:57:23', 302),
	('DoctrineMigrations\\Version20230731132512', '2023-07-31 13:26:01', 107),
	('DoctrineMigrations\\Version20230802071447', '2023-08-02 07:14:59', 81),
	('DoctrineMigrations\\Version20230802074608', '2023-08-02 07:46:12', 36),
	('DoctrineMigrations\\Version20230802091503', '2023-08-02 09:15:09', 171),
	('DoctrineMigrations\\Version20230802124404', '2023-08-02 12:44:13', 41),
	('DoctrineMigrations\\Version20230824145847', '2023-08-24 14:59:05', 583),
	('DoctrineMigrations\\Version20230824151237', '2023-08-24 15:12:44', 91),
	('DoctrineMigrations\\Version20230912091732', '2023-09-12 09:18:14', 202),
	('DoctrineMigrations\\Version20230912140819', '2023-09-12 14:08:29', 49),
	('DoctrineMigrations\\Version20230912143423', '2023-09-12 14:34:29', 16),
	('DoctrineMigrations\\Version20230913122606', '2023-09-13 12:26:21', 23),
	('DoctrineMigrations\\Version20230927144737', '2023-09-27 14:47:53', 42),
	('DoctrineMigrations\\Version20231007185938', '2023-10-07 19:01:00', 1119);

-- Listage de la structure de table tramstras. favoris
CREATE TABLE IF NOT EXISTS `favoris` (
  `id` int NOT NULL AUTO_INCREMENT,
  `arret` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `sens` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `ligne` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table tramstras.favoris : ~0 rows (environ)

-- Listage de la structure de table tramstras. images_users
CREATE TABLE IF NOT EXISTS `images_users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `image_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `image_size` int NOT NULL,
  `updated_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  `created_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table tramstras.images_users : ~8 rows (environ)
INSERT INTO `images_users` (`id`, `image_name`, `image_size`, `updated_at`, `created_at`) VALUES
	(1, '20456790-650185055413d514943402-6501853fdb0b7460716066.png', 63067, '2023-09-13 09:47:43', '2023-09-12 12:09:44'),
	(2, 'DOA6Mm79qWKBq9KFGjOjp_.png', 63067, '2023-09-13 11:34:12', '2023-09-13 11:34:13'),
	(3, 'chat-drole-tete.jpg', 63067, '2023-09-13 11:36:26', '2023-09-13 11:36:26'),
	(4, '1200x680-the-child-star-wars-gallery-5e3204bdad395-6521c7a02e799547878047-2-6522c86b0e71f005509843.jpg', 30067, '2023-10-08 15:19:07', '2023-09-13 11:36:46'),
	(5, '650187d5c6bf8.jpg', 50117, '2023-09-13 09:58:45', '2023-09-13 09:58:45'),
	(6, '65143db4a3eaa.jpg', 278522, '2023-09-27 14:35:32', '2023-09-27 14:35:32'),
	(7, '651c957ead5a7.png', 247236, '2023-10-03 22:28:14', '2023-10-03 22:28:14'),
	(8, '651c964a65801.png', 247236, '2023-10-03 22:31:38', '2023-10-03 22:31:38'),
	(9, 'agent-securite-coup-moyen-posant-studio_23-2150275722.avif', 63067, '2023-10-12 11:38:17', '2023-10-12 11:38:21');

-- Listage de la structure de table tramstras. invoice
CREATE TABLE IF NOT EXISTS `invoice` (
  `id` int NOT NULL AUTO_INCREMENT,
  `subscription_id` int NOT NULL,
  `stripe_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `amount_paid` int NOT NULL,
  `number` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `hosted_invoice_url` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_906517449A1887DC` (`subscription_id`),
  CONSTRAINT `FK_906517449A1887DC` FOREIGN KEY (`subscription_id`) REFERENCES `subscription` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table tramstras.invoice : ~0 rows (environ)

-- Listage de la structure de table tramstras. marker
CREATE TABLE IF NOT EXISTS `marker` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int DEFAULT NULL,
  `latitude` double NOT NULL,
  `longitude` double NOT NULL,
  `creation_date` datetime NOT NULL,
  `text` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  PRIMARY KEY (`id`),
  KEY `IDX_82CF20FEA76ED395` (`user_id`),
  CONSTRAINT `FK_82CF20FEA76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=49 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table tramstras.marker : ~38 rows (environ)
INSERT INTO `marker` (`id`, `user_id`, `latitude`, `longitude`, `creation_date`, `text`) VALUES
	(1, 1, 48.584492830042, 7.8006362915039, '2023-07-12 23:07:37', NULL),
	(2, 1, 48.562003631331, 7.7716255187988, '2023-07-12 23:08:07', NULL),
	(3, 1, 48.58517416476, 7.7867317199707, '2023-07-12 23:08:14', NULL),
	(4, 1, 48.582108086198, 7.7941131591797, '2023-07-12 23:08:20', NULL),
	(6, 1, 48.573177605036, 7.7985119819641, '2023-07-12 23:17:30', NULL),
	(7, 1, 48.574157240062, 7.7990913391113, '2023-07-12 23:17:31', NULL),
	(8, 1, 48.573049825155, 7.7998208999634, '2023-07-12 23:17:32', NULL),
	(9, 1, 48.571593644119, 7.7746725082397, '2023-07-12 23:31:02', NULL),
	(10, 1, 48.571204967136, 7.7463912963867, '2023-07-12 23:31:54', NULL),
	(13, 1, 48.575180335003, 7.6981544494629, '2023-07-15 21:25:38', NULL),
	(14, 1, 48.574498865567, 7.6875114440918, '2023-07-15 21:25:47', NULL),
	(15, 1, 48.574612444444, 7.6933479309082, '2023-07-15 21:25:58', NULL),
	(16, 1, 48.575114672983, 7.7874612808228, '2023-07-15 22:16:03', NULL),
	(17, 1, 48.575420799239, 7.782096862793, '2023-07-15 22:16:11', NULL),
	(18, 1, 48.575761528891, 7.785165309906, '2023-07-15 22:16:12', NULL),
	(19, 1, 48.574313412008, 7.7822470664978, '2023-07-15 22:16:14', NULL),
	(20, 1, 48.574498865567, 7.7033042907715, '2023-07-15 22:20:46', NULL),
	(21, 1, 48.587899411778, 7.7239036560059, '2023-07-15 22:27:50', NULL),
	(22, 1, 48.585741936675, 7.7886199951172, '2023-07-15 22:27:52', NULL),
	(23, 1, 48.570296267736, 7.7860450744629, '2023-07-15 22:41:10', NULL),
	(24, 1, 48.571659310712, 7.7321434020996, '2023-07-15 22:41:12', NULL),
	(25, 1, 48.573249481078, 7.8066444396973, '2023-07-15 22:41:15', NULL),
	(26, 1, 48.570750619477, 7.8071594238281, '2023-07-15 22:41:16', NULL),
	(27, 1, 48.568819596383, 7.8064727783203, '2023-07-15 22:41:19', NULL),
	(28, 1, 48.574385286435, 7.822437286377, '2023-07-15 23:14:58', NULL),
	(29, 1, 48.573262315243, 7.6662167039423, '2023-07-19 10:06:42', NULL),
	(30, 1, 48.56155850823, 7.8064432561265, '2023-07-19 10:06:45', NULL),
	(31, 1, 48.566966596806, 7.7958297729492, '2023-07-24 09:03:10', NULL),
	(32, 1, 48.594238236214, 7.7999496459961, '2023-07-24 09:11:55', NULL),
	(33, 1, 48.558121315667, 7.7963447570801, '2023-07-24 09:28:10', NULL),
	(34, 1, 48.558689391438, 7.7815818786621, '2023-07-24 13:53:15', NULL),
	(35, 1, 48.585041092295, 7.7829551696777, '2023-07-24 14:04:16', NULL),
	(36, 2, 48.558575776794, 7.7254486083984, '2023-07-31 12:18:28', 'dfbdfbdf'),
	(37, 1, 48.549713048375, 7.7824401855469, '2023-08-02 07:16:48', 'gqvdhsegcsc'),
	(38, 1, 48.573002794979, 7.6763534545898, '2023-08-02 09:31:37', 'Accident de voiture'),
	(39, 1, 48.576160374877, 7.7757024765015, '2023-08-07 16:04:53', 'fdvbsdfvdfvf'),
	(40, 5, 48.574098009951, 7.7949929237366, '2023-09-13 11:30:25', 'Controlleur'),
	(41, 1, 48.607747053572, 7.8037261962891, '2023-09-26 12:27:12', 'aaaaaaaaaaaaaaaaaaaa'),
	(42, 1, 48.590718539359, 7.7972030639648, '2023-10-08 15:17:16', 'Marker 17/17'),
	(43, 1, 48.585268202424, 7.7954864501953, '2023-10-08 15:17:25', 'marker2 17/17'),
	(44, 1, 48.572280698807, 7.7927398681641, '2023-10-09 20:36:22', 'Attention il y a des travaux'),
	(45, 1, 48.573235727028, 7.7902507781982, '2023-10-09 20:38:56', 'J\'ai été en retard à cause des travaux, merci la CTS'),
	(46, 1, 48.575393735978, 7.7533864974976, '2023-10-15 16:28:34', 'Attention il y a des travaux !'),
	(47, 1, 48.57224187614, 7.7658748626709, '2023-10-15 16:28:48', 'Manifestation jusqu\'à 16h'),
	(48, 1, 48.574237100777, 7.7580642700195, '2023-10-15 16:38:04', 'Mon nouveau marker');

-- Listage de la structure de table tramstras. messenger_messages
CREATE TABLE IF NOT EXISTS `messenger_messages` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `body` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `headers` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue_name` varchar(190) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL,
  `available_at` datetime NOT NULL,
  `delivered_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_75EA56E0FB7336F0` (`queue_name`),
  KEY `IDX_75EA56E0E3BD61CE` (`available_at`),
  KEY `IDX_75EA56E016BA31DB` (`delivered_at`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table tramstras.messenger_messages : ~2 rows (environ)
INSERT INTO `messenger_messages` (`id`, `body`, `headers`, `queue_name`, `created_at`, `available_at`, `delivered_at`) VALUES
	(1, 'O:36:\\"Symfony\\\\Component\\\\Messenger\\\\Envelope\\":2:{s:44:\\"\\0Symfony\\\\Component\\\\Messenger\\\\Envelope\\0stamps\\";a:1:{s:46:\\"Symfony\\\\Component\\\\Messenger\\\\Stamp\\\\BusNameStamp\\";a:1:{i:0;O:46:\\"Symfony\\\\Component\\\\Messenger\\\\Stamp\\\\BusNameStamp\\":1:{s:55:\\"\\0Symfony\\\\Component\\\\Messenger\\\\Stamp\\\\BusNameStamp\\0busName\\";s:21:\\"messenger.bus.default\\";}}}s:45:\\"\\0Symfony\\\\Component\\\\Messenger\\\\Envelope\\0message\\";O:51:\\"Symfony\\\\Component\\\\Mailer\\\\Messenger\\\\SendEmailMessage\\":2:{s:60:\\"\\0Symfony\\\\Component\\\\Mailer\\\\Messenger\\\\SendEmailMessage\\0message\\";O:39:\\"Symfony\\\\Bridge\\\\Twig\\\\Mime\\\\TemplatedEmail\\":4:{i:0;s:41:\\"registration/confirmation_email.html.twig\\";i:1;N;i:2;a:3:{s:9:\\"signedUrl\\";s:175:\\"http://127.0.0.1:8000/verify/email?expires=1686089012&signature=0luU97f%2F57NI4G3XF6dgJDNEqMZ5b6MNCnTLbQHrO%2Fc%3D&token=%2Bu%2BAuGlnbnH17Fdz8b5YoxTOu9yhALKkTB1z%2BaFt%2FfE%3D\\";s:19:\\"expiresAtMessageKey\\";s:26:\\"%count% hour|%count% hours\\";s:20:\\"expiresAtMessageData\\";a:1:{s:7:\\"%count%\\";i:1;}}i:3;a:6:{i:0;N;i:1;N;i:2;N;i:3;N;i:4;a:0:{}i:5;a:2:{i:0;O:37:\\"Symfony\\\\Component\\\\Mime\\\\Header\\\\Headers\\":2:{s:46:\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\Headers\\0headers\\";a:3:{s:4:\\"from\\";a:1:{i:0;O:47:\\"Symfony\\\\Component\\\\Mime\\\\Header\\\\MailboxListHeader\\":5:{s:50:\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0name\\";s:4:\\"From\\";s:56:\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0lineLength\\";i:76;s:50:\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0lang\\";N;s:53:\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0charset\\";s:5:\\"utf-8\\";s:58:\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\MailboxListHeader\\0addresses\\";a:1:{i:0;O:30:\\"Symfony\\\\Component\\\\Mime\\\\Address\\":2:{s:39:\\"\\0Symfony\\\\Component\\\\Mime\\\\Address\\0address\\";s:26:\\"symfonytramstras@proton.me\\";s:36:\\"\\0Symfony\\\\Component\\\\Mime\\\\Address\\0name\\";s:9:\\"TramStras\\";}}}}s:2:\\"to\\";a:1:{i:0;O:47:\\"Symfony\\\\Component\\\\Mime\\\\Header\\\\MailboxListHeader\\":5:{s:50:\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0name\\";s:2:\\"To\\";s:56:\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0lineLength\\";i:76;s:50:\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0lang\\";N;s:53:\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0charset\\";s:5:\\"utf-8\\";s:58:\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\MailboxListHeader\\0addresses\\";a:1:{i:0;O:30:\\"Symfony\\\\Component\\\\Mime\\\\Address\\":2:{s:39:\\"\\0Symfony\\\\Component\\\\Mime\\\\Address\\0address\\";s:20:\\"pademengel@gmail.com\\";s:36:\\"\\0Symfony\\\\Component\\\\Mime\\\\Address\\0name\\";s:0:\\"\\";}}}}s:7:\\"subject\\";a:1:{i:0;O:48:\\"Symfony\\\\Component\\\\Mime\\\\Header\\\\UnstructuredHeader\\":5:{s:50:\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0name\\";s:7:\\"Subject\\";s:56:\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0lineLength\\";i:76;s:50:\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0lang\\";N;s:53:\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0charset\\";s:5:\\"utf-8\\";s:55:\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\UnstructuredHeader\\0value\\";s:25:\\"Please Confirm your Email\\";}}}s:49:\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\Headers\\0lineLength\\";i:76;}i:1;N;}}}s:61:\\"\\0Symfony\\\\Component\\\\Mailer\\\\Messenger\\\\SendEmailMessage\\0envelope\\";N;}}', '[]', 'default', '2023-06-06 21:03:32', '2023-06-06 21:03:32', NULL),
	(2, 'O:36:\\"Symfony\\\\Component\\\\Messenger\\\\Envelope\\":2:{s:44:\\"\\0Symfony\\\\Component\\\\Messenger\\\\Envelope\\0stamps\\";a:1:{s:46:\\"Symfony\\\\Component\\\\Messenger\\\\Stamp\\\\BusNameStamp\\";a:1:{i:0;O:46:\\"Symfony\\\\Component\\\\Messenger\\\\Stamp\\\\BusNameStamp\\":1:{s:55:\\"\\0Symfony\\\\Component\\\\Messenger\\\\Stamp\\\\BusNameStamp\\0busName\\";s:21:\\"messenger.bus.default\\";}}}s:45:\\"\\0Symfony\\\\Component\\\\Messenger\\\\Envelope\\0message\\";O:51:\\"Symfony\\\\Component\\\\Mailer\\\\Messenger\\\\SendEmailMessage\\":2:{s:60:\\"\\0Symfony\\\\Component\\\\Mailer\\\\Messenger\\\\SendEmailMessage\\0message\\";O:39:\\"Symfony\\\\Bridge\\\\Twig\\\\Mime\\\\TemplatedEmail\\":4:{i:0;s:41:\\"registration/confirmation_email.html.twig\\";i:1;N;i:2;a:3:{s:9:\\"signedUrl\\";s:167:\\"http://127.0.0.1:8000/verify/email?expires=1687199303&signature=ZfvFaR8yXuCWsHGkk8tH5DQ%2FLPHED6ZkeK39SJzQimA%3D&token=tTUefgbBTeKQ978Jq2%2F5NRCjeOB0e4WaK3HZKeNcNjs%3D\\";s:19:\\"expiresAtMessageKey\\";s:26:\\"%count% hour|%count% hours\\";s:20:\\"expiresAtMessageData\\";a:1:{s:7:\\"%count%\\";i:1;}}i:3;a:6:{i:0;N;i:1;N;i:2;N;i:3;N;i:4;a:0:{}i:5;a:2:{i:0;O:37:\\"Symfony\\\\Component\\\\Mime\\\\Header\\\\Headers\\":2:{s:46:\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\Headers\\0headers\\";a:3:{s:4:\\"from\\";a:1:{i:0;O:47:\\"Symfony\\\\Component\\\\Mime\\\\Header\\\\MailboxListHeader\\":5:{s:50:\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0name\\";s:4:\\"From\\";s:56:\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0lineLength\\";i:76;s:50:\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0lang\\";N;s:53:\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0charset\\";s:5:\\"utf-8\\";s:58:\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\MailboxListHeader\\0addresses\\";a:1:{i:0;O:30:\\"Symfony\\\\Component\\\\Mime\\\\Address\\":2:{s:39:\\"\\0Symfony\\\\Component\\\\Mime\\\\Address\\0address\\";s:26:\\"symfonytramstras@proton.me\\";s:36:\\"\\0Symfony\\\\Component\\\\Mime\\\\Address\\0name\\";s:9:\\"TramStras\\";}}}}s:2:\\"to\\";a:1:{i:0;O:47:\\"Symfony\\\\Component\\\\Mime\\\\Header\\\\MailboxListHeader\\":5:{s:50:\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0name\\";s:2:\\"To\\";s:56:\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0lineLength\\";i:76;s:50:\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0lang\\";N;s:53:\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0charset\\";s:5:\\"utf-8\\";s:58:\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\MailboxListHeader\\0addresses\\";a:1:{i:0;O:30:\\"Symfony\\\\Component\\\\Mime\\\\Address\\":2:{s:39:\\"\\0Symfony\\\\Component\\\\Mime\\\\Address\\0address\\";s:23:\\"jupiter116699@gmail.com\\";s:36:\\"\\0Symfony\\\\Component\\\\Mime\\\\Address\\0name\\";s:0:\\"\\";}}}}s:7:\\"subject\\";a:1:{i:0;O:48:\\"Symfony\\\\Component\\\\Mime\\\\Header\\\\UnstructuredHeader\\":5:{s:50:\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0name\\";s:7:\\"Subject\\";s:56:\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0lineLength\\";i:76;s:50:\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0lang\\";N;s:53:\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0charset\\";s:5:\\"utf-8\\";s:55:\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\UnstructuredHeader\\0value\\";s:25:\\"Please Confirm your Email\\";}}}s:49:\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\Headers\\0lineLength\\";i:76;}i:1;N;}}}s:61:\\"\\0Symfony\\\\Component\\\\Mailer\\\\Messenger\\\\SendEmailMessage\\0envelope\\";N;}}', '[]', 'default', '2023-06-19 17:28:24', '2023-06-19 17:28:24', NULL);

-- Listage de la structure de table tramstras. plan
CREATE TABLE IF NOT EXISTS `plan` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `price` int NOT NULL,
  `slug` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `stripe_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `payment_link` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table tramstras.plan : ~0 rows (environ)
INSERT INTO `plan` (`id`, `name`, `price`, `slug`, `stripe_id`, `payment_link`, `created_at`) VALUES
	(1, 'Premium', 199, 'Premium', 'price_1NZvZHGIsSSnwsGXWODageZ1', 'https://buy.stripe.com/7sIdTx6hd2yVcKY000', '2023-07-31 15:27:10');

-- Listage de la structure de table tramstras. post
CREATE TABLE IF NOT EXISTS `post` (
  `id` int NOT NULL AUTO_INCREMENT,
  `topic_id` int DEFAULT NULL,
  `text` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_post` datetime NOT NULL,
  `user_id` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_5A8A6C8D1F55203D` (`topic_id`),
  KEY `IDX_5A8A6C8DA76ED395` (`user_id`),
  CONSTRAINT `FK_5A8A6C8D1F55203D` FOREIGN KEY (`topic_id`) REFERENCES `topic` (`id`),
  CONSTRAINT `FK_5A8A6C8DA76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table tramstras.post : ~10 rows (environ)
INSERT INTO `post` (`id`, `topic_id`, `text`, `date_post`, `user_id`) VALUES
	(1, 1, 'C\'est vraiement dommage', '2023-06-08 22:41:20', 1),
	(10, 15, 'Blablabbla', '2023-06-19 18:58:36', 2),
	(11, 18, 'C\'est mon Premier message en B', '2023-06-19 17:47:34', 1),
	(15, 1, 'C\'est trop bien ce Forum', '2023-08-06 16:37:18', 2),
	(17, 1, 'C\'est vraiement une super manière de partager autour d\'un intéret commun', '2023-08-06 19:05:21', 2),
	(24, 1, 'Oui je suis d\'accord', '2023-08-31 17:30:32', 3),
	(25, 1, 'J\'ai retrouvé ton sac, rendez-vous ce soir 16h à homme de fer', '2023-09-12 13:00:59', 4),
	(26, 1, 'Super, je serai là. Merci beaucoup', '2023-09-26 12:23:13', 1);

-- Listage de la structure de table tramstras. reset_password_request
CREATE TABLE IF NOT EXISTS `reset_password_request` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `selector` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `hashed_token` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `requested_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  `expires_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  PRIMARY KEY (`id`),
  KEY `IDX_7CE748AA76ED395` (`user_id`),
  CONSTRAINT `FK_7CE748AA76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table tramstras.reset_password_request : ~0 rows (environ)
INSERT INTO `reset_password_request` (`id`, `user_id`, `selector`, `hashed_token`, `requested_at`, `expires_at`) VALUES
	(1, 1, 'xOgRFecpZPtkt1EepP4I', 'it6k9sta4ypjd2g/l2mtaNjq4pON5yTDt0KzLNZF9Do=', '2023-10-07 19:23:42', '2023-10-07 20:23:42');

-- Listage de la structure de table tramstras. subscription
CREATE TABLE IF NOT EXISTS `subscription` (
  `id` int NOT NULL AUTO_INCREMENT,
  `plan_id` int NOT NULL,
  `user_id` int NOT NULL,
  `current_period_start` datetime NOT NULL,
  `current_period_end` datetime NOT NULL,
  `is_active` tinyint(1) NOT NULL,
  `stripe_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_A3C664D3E899029B` (`plan_id`),
  KEY `IDX_A3C664D3A76ED395` (`user_id`),
  CONSTRAINT `FK_A3C664D3A76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`),
  CONSTRAINT `FK_A3C664D3E899029B` FOREIGN KEY (`plan_id`) REFERENCES `plan` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table tramstras.subscription : ~0 rows (environ)

-- Listage de la structure de table tramstras. topic
CREATE TABLE IF NOT EXISTS `topic` (
  `id` int NOT NULL AUTO_INCREMENT,
  `categorie_id` int DEFAULT NULL,
  `titre` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `creation_date` datetime NOT NULL,
  `user_id` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_9D40DE1BBCF5E72D` (`categorie_id`),
  KEY `IDX_9D40DE1BA76ED395` (`user_id`),
  CONSTRAINT `FK_9D40DE1BA76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`),
  CONSTRAINT `FK_9D40DE1BBCF5E72D` FOREIGN KEY (`categorie_id`) REFERENCES `categorie` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=34 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table tramstras.topic : ~7 rows (environ)
INSERT INTO `topic` (`id`, `categorie_id`, `titre`, `creation_date`, `user_id`) VALUES
	(1, 3, 'Je me suis fais voler mon sac', '2023-06-08 19:56:05', 1),
	(15, 3, 'Mon premier nouveauTopic', '2023-06-15 18:23:13', 1),
	(18, 4, 'C\'est un Topic de carégorie B', '2023-06-19 18:59:05', 2),
	(19, 3, 'C\'est mon troisième topic A', '2023-06-19 17:54:58', 1),
	(20, 3, 'Mon dernier Topic', '2023-07-24 09:26:14', 1),
	(21, 3, 'Nouveau test', '2023-08-31 17:30:21', 3),
	(33, 3, 'MonEmaildeTest', '2023-09-27 14:54:39', 7);

-- Listage de la structure de table tramstras. user
CREATE TABLE IF NOT EXISTS `user` (
  `id` int NOT NULL AUTO_INCREMENT,
  `email` varchar(180) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `pseudo` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `roles` json NOT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_verified` tinyint(1) NOT NULL,
  `stripe_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `images_users_id` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_8D93D649E7927C74` (`email`),
  UNIQUE KEY `UNIQ_8D93D649C490C957` (`images_users_id`),
  CONSTRAINT `FK_8D93D649C490C957` FOREIGN KEY (`images_users_id`) REFERENCES `images_users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table tramstras.user : ~9 rows (environ)
INSERT INTO `user` (`id`, `email`, `pseudo`, `roles`, `password`, `is_verified`, `stripe_id`, `images_users_id`) VALUES
	(1, 'pademengel@gmail.com', 'ipoucht', '["ROLE_ADMIN"]', '$2y$13$H4Lxz2DvE7XPkGdKz6VKvuS1PqqguMo7RkRJZhcXEnrtyGMYBFY76', 1, '651651', 4),
	(2, 'jupiter116699@gmail.com', 'jupiter169', '["ROLE_ADMIN"]', '$2y$13$brTRM2F5Bb3SlRanZncmb.XfzEiTXDLGTpE05V35HSp1BvEZgknvS', 1, '', 3),
	(3, 'adminTramStras@proton.me', 'admin', '["ROLE_USER", "ROLE_ADMIN"]', '$2y$13$bo4jBrC8Eg5ukf1N8jl4KOoPg.LMC9XiUuKJ8hVROuInSQcq1SG76', 0, '', 2),
	(4, 'newUser2@gmail.com', 'newUser2', '[]', '$2y$13$w2gEuZL33T4tVcZMCP08juPTvShJn2Z2BCMmLH32pPrDSWy50cttm', 0, NULL, 1),
	(5, 'newUser3@gmail.com', 'newUser3', '[]', '$2y$13$0XMYEVIktwnpD.AuByd5..2GrIlth/QBg0qd5j.QhUMlE89WlylC.', 0, NULL, 5),
	(6, 'gvsSecu@gmail.com', 'GSV', '["ROLE_SECU"]', '$2y$13$bo4jBrC8Eg5ukf1N8jl4KOoPg.LMC9XiUuKJ8hVROuInSQcq1SG76', 1, NULL, 9),
	(7, 'MonEmaildeTest@gmail.com', 'MonEmaildeTest', '[]', '$2y$13$diwRU9QAdd/hgmMKCvPdtuy3VmagE6MspZk.LSvi7Fznw3eA8QC9G', 0, NULL, 6),
	(8, 'ipoucht@gmail.com', 'ipoucht67', '["ROLE_USER"]', '$2y$13$psfAD4t59MASAibsQTQLlOH4cXMJ7n1AZ8tpkbTgX44XZwYNTQMza', 0, NULL, 7),
	(9, 'Melanch@gmail.com', 'Melanch', '["ROLE_USER"]', '$2y$13$t7WGgAfbbdFpV78p.kRJYOo7gUwM/otlC5isqNluy9MCMN9qVxSQ2', 0, NULL, 8);

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
